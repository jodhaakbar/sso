<?php
namespace App\Http\Controllers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Success
 *
 * @author KHAYATI
 */
class ResponseMessage
{
    public static function Report($message, $status = 1, $object = null, $code = 0)
    {
        $response = array(
            "status" => $status,
            "code" => $code,
            "message" => $message

        );
        if ($object != null) {
            $response['payload'] = $object;
        }
        return $response;
    }
}