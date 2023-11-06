<?php


namespace App\Traits;


trait FormRequestTrait
{
    protected function error($message, $code, $type = 'text'): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error' => [$type => $message], 'code' => $code], $code);
    }
}
