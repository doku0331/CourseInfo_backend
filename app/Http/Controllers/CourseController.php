<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*檢查快取 設定查詢條件 產生快取*/
        $url = $request->url();
        //取得query
        $queryParm = $request->query();
        //排序
        ksort($queryParm);
        //利用http_build_query將查詢參數轉為字串
        $queryString = http_build_query($queryParm);
        //合併網址
        $fullurl = "{$url}?{$queryString}";

        //使用laravel的快取方法檢查是否有快取紀錄
        if (Cache::has($fullurl)) {
            return Cache::get($fullurl);
        }

        //設定預設筆數
        $limit = $request->limit ?? 10;

        //建立查詢建構器 分段寫SQL
        $query = Course::query();

        //參數範例 ?filters=teacher:陳,semester:109
        if (isset($request->filters)) {
            $filters = explode(',', $request->filters);
            foreach ($filters as $key => $filter) {
                list($key, $value) = explode(':', $filter);
                $query->where($key, 'like', "%$value%");
            }
        }

        // 頁數化並在生成其他頁數連接時加入當前篩選條件資料
        $courses = $query->paginate($limit)
            ->appends($request->query());

        //紀錄當下結果到快取，60秒過期，以url為命名
        return Cache::remember($fullurl, 60, function () use ($courses) {
            return response($courses, 200);
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $response = [
            'data' => $course,
        ];

        return response($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }

    public function CourseComment(Course $course, Request $request)
    {
        //設定預設筆數
        $limit = $request->limit ?? 10;
        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->where('course_id', $course->id)
            ->select(
                'users.id as authorId',
                'comments.id',
                "rating",
                'teaching',
                "grading",
                "assignment",
                "comment",
                "users.name as author"
            )
            ->get();

        $result = compact('course', 'comments');

        return response($result, 200);
    }
}
