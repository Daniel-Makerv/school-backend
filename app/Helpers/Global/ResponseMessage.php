<?php

namespace App\Helpers\Global;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductLog;
use App\Models\Seller;
use App\Models\Team;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Redis;

class ResponseMessage
{
    /**
     *     //axioos messages
     */
    public static function sendErrorsValidator(Object $errors, String $dataName = '')
    {
        if ($dataName != '') {
            return response()->json(['errors' => [$dataName => $errors]], 422);
        } else {
            return response()->json(['errors' => $errors], 422);
        }
    }

    /**
     *  Retorna un mensaje
     */
    private function message($type,  $title,  $text, Int $statusCode, $success = false)
    {
        return response()->json(
            [
                'message' => [
                    'type'  => $type,
                    'title' => $title,
                    'text'  => $text,
                    'success' => $success ?? false,
                ]
            ],
            $statusCode
        );
    }

    /**
     *  Retorna un mensaje de tipo 'success 200'
     */
    public static function msgSuccess(String $text, String $title = 'Success')
    {
        return (new Self)->message('success', $title, $text, 200, true);
    }

    /**
     *  Retorna un mensaje de tipo 'success 201'
     */
    public static function msgSuccessStore(String $text, String $title = 'Success')
    {
        return (new Self)->message('success', $title, $text, 201, true);
    }

    /**
     *  Retorna un mensaje de tipo 'error 500'
     */
    public static function msgServerError($text, String $title = 'Oh no')
    {
        return (new Self)->message('error', $title, $text, 500, false);
    }

    /**
     *  Retorna un mensaje de validation
     */
    public static function msgErrorValidator($text, $title = 'Oh no')
    {
        return (new Self)->message('error', $title, $text, 500, false);
    }

    /**
     *  Retorna un mensaje de tipo 'error 422'
     */
    public static function msgClientError(String $text, String $title = 'Oh no')
    {
        return (new Self)->message('error', $title, $text, 500, false);
    }

    /**
     *  Retorna un mensaje de tipo 'error 404'
     */
    public static function msgNotFound(String $text, String $title = 'Oh no')
    {
        return (new Self)->message('error', $title, $text, 404, false);
    }

    /**
     *  Retorna un mensaje de tipo 'error 404'
     */
    public static function msgNotAuthorized(String $text, String $title = 'Oh no')
    {
        return (new Self)->message('error', $title, $text, 403, false);
    }

    /**
     *  Retorna un mensaje de tipo 'error 404'
     */
    public static function msgNotFoundRegister(String $text, String $title = 'Oh no')
    {
        return (new Self)->message('error', $title, $text, 404, false);
    }


    //Inertia messages
    /**
     *  Return a message of type '200' created ok
     */
    public static function msgCreateRegister($title, $subtitle, $description, $status)
    {
        $message = [
            'title' => $title,
            'subtitle' => $subtitle,
            'description' => $description,
            'status' => $status,
        ];

        return $message;
    }

    /**
     *  Returns a message of type '500' error
     */

    public static function msgErroCreateRegister($title, $subtitle, $description, $status)
    {
        $message = [
            'title' => $title,
            'subtitle' => $subtitle,
            'description' => $description,
            'status' => $status,
        ];

        return $message;
    }

    /**
     *  Returns an updated message of type '200'.
     */

    public static function msgUpdateRegister($title, $subtitle, $description, $status)
    {
        $message = [
            'title' => $title,
            'subtitle' => $subtitle,
            'description' => $description,
            'status' => $status,
        ];

        return $message;
    }

    /**
     *  Returns '500' error message when updating
     */

    public static function msgErrorUpdateRegister($title, $subtitle, $description, $status)
    {
        $message = [
            'title' => $title,
            'subtitle' => $subtitle,
            'description' => $description,
            'status' => $status,
        ];

        return $message;
    }

    public static function msgDeleteRegister($title, $subtitle, $description, $status)
    {
        $message = [
            'title' => $title,
            'subtitle' => $subtitle,
            'description' => $description,
            'status' => $status,
        ];

        return $message;
    }

    /**
     *  Returns '500' warning message when updating
     */

    public static function msgWarningUpdateRegister($title, $subtitle, $description, $status)
    {
        $message = [
            'title' => $title,
            'subtitle' => $subtitle,
            'description' => $description,
            'status' => $status,
        ];

        return $message;
    }

    /**
     *  Returns a message of type '500' error from vtex server
     */

    public static function msgErrorVtex($title, $subtitle, $description, $status)
    {
        $message = [
            'title' => $title,
            'subtitle' => $subtitle,
            'description' => $description,
            'status' => $status,
        ];

        return $message;
    }
}
