<?php

namespace App\Helpers;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Helper
{
    public static function hash(string $val)
    {
        return Hash::make($val);
    }

    public static function formatError(Exception $exception)
    {
        return $exception->getMessage() . $exception->getLine() . $exception->getFile() . $exception;
    }

    public static function secondsToDuration(int $seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $seconds % 60;
        if ($hours > 0) {
            return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
        } else {
            return sprintf("%02d:%02d", $minutes, $seconds);
        }
    }

    public static function formatArrayToString(array $array)
    {
        $message = '';
        if (count($array) > 2)
            $message = implode(", ", array_slice($array, 0, count($array) - 1, false)) . ' and ' . end($array);
        if (count($array) == 2)
            $message = $array[0] . ' and ' . end($array);
        return $message;
    }

    public static function formatArrayToCsv(array $array)
    {
        $message = implode(",", $array);
        if (!$message)
            return "";
        return $message;
    }

    public static function toTimeStamp($datetime)
    {
        return '"'.Carbon::parse($datetime)->toDateString().'"';
    }


    public static function randomNumber($length)
    {
        return rand(pow(10, $length - 1), pow(10, $length) - 1);
    }

    public static function randomString($length)
    {
        return Str::random($length);
    }

    public static function exceptionResponse(Exception $e)
    {
        return response()->json([
            'status'    => 500,
            'success'   => false,
            'message'     => $e->getMessage() . $e->getLine() . $e->getFile() . $e
        ], 500);
    }

    public static function response($status, $success, $message)
    {
        return response()->json([
            'status'        => $status,
            'success'       => $success,
            'message'   => $message
        ], $status);
    }

    public static function responseWithData($status, $success, $message, $data)
    {
        return response()->json([
            'status'        => $status,
            'success'       => $success,
            'message'   => $message,
            'data' => $data
        ], $status);
    }

}
