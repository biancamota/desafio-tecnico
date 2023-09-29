<?php
namespace Bm\Store\Util;

class JsonResponse
{
    public static function send($data, $code = 200)
    {
        http_response_code($code);
        header('Content-Type: application/json');

        echo json_encode($data);
    }
}