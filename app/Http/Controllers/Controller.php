<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function returnDefaultResponse($message = 'success', $code = 200): Response
    {
        return response([
            'message' => $message
        ], $code);
    }

    public function returnDefaultDataResponse($data = [], $code = 200): Response
    {
        return response([$data], $code);
    }
}
