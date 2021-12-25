<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login', 'register']]);

    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $api_token = Str::random(80);
        $data = array_merge($request->all(), compact('api_token'));
        $this->create($data);

        return compact('api_token');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::forceCreate([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'api_token' => hash('sha256', $data['api_token']),
        ]);
    }

    public function logout()
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        $user->update(['api_token' => null]);

        return response()->json(['message' => '登出成功'], 200);
    }

    public function login()
    {
        $user = User::where('email', request('email'))
            ->first();
        //找不到使用者
        if (!$user) {
            return response()->json(['message' => '該使用者不存在'],
                404);

        }

        if (!password_verify(request('password'), $user->password)) {
            return response()->json(['message' => '帳號或密碼錯誤'],
                403);
        }

        $api_token = Str::random(80);
        $user->update(['api_token' => hash('sha256', $api_token)]);

        return compact('api_token');
    }

    public function refresh()
    {
        $api_token = Str::random(80);
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        $user->update(['api_token' => hash('sha256', $api_token)]);

        return compact('api_token');
    }
}
