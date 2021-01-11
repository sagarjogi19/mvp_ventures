<?php
namespace App\Macros\Http;
use Illuminate\Support\Facades\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
/**
 *
 */
class Response
{
    public static function registerMacros()
    {
        HttpResponse::macro('success', function ($message,$data=NULL,$token=NULL) {
            return response()->json([
                'status' => SymfonyResponse::HTTP_OK,
                'token' => is_null($token) ? '': $token,
                'message' => $message,
                'data' => is_null($data) ? (object)[]: $data
              ], SymfonyResponse::HTTP_OK);
        });
        HttpResponse::macro('error', function ($message,$status,$token=NULL) {
            
            return response()->json([
                'status' => $status,
                'token' => is_null($token) ? '': $token,
                'message' => $message,
                'data' => (object)[]
              ], $status);
        });
    }
}