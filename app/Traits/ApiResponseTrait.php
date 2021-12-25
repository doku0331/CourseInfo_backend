<?php
namespace App\Traits;

/**
 * 定義統一例外回應
 * @parm mixed $message 錯誤訊息
 * @parm mixed $status Http狀態馬
 * @parm mixed\null $code 選定一錯誤馬
 * @return \Illuminate\Http\Response
 */
trait ApiResponseTrait
{
    public function errorResponse($message, $status, $code = null)
    {
        $code = $code ?? $status; // if code is null default status
        return response()->json(
            [
                'message' => $message,
                'code' => $code,
            ], $status
        );
    }
}
