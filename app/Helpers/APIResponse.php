<?php

namespace App\Helpers;

use Exception;
use Illuminate\Http\Response;

class APIResponse
{
    private static function error(int $status, bool $success, Exception $exception)
    {
        return response()->json(['status'    => $status, 'success'   => $success, 'message'     => $exception->getMessage() . $exception->getLine() . $exception->getFile() . $exception], $status);
    }

    private static function errorWithMessage(int $status, bool $success, string $message)
    {
        return response()->json(['status'    => $status, 'success'   => $success, 'message'     => $message], $status);
    }

    private static function response(int $status, bool $success, string $message)
    {
        return response()->json(['status'    => $status, 'success'   => $success, 'message'     => $message], $status);
    }

    private static function responseWithData(int $status, bool $success, string $message, $data)
    {
        return response()->json(['status'    => $status, 'success'   => $success, 'message'     => $message, 'data' => $data], $status);
    }

    public static function NotFound(string $message)
    {
        return self::response(Response::HTTP_NOT_FOUND, false, $message);
    }

    public static function Unauthorized(string $message)
    {
        return self::response(Response::HTTP_UNAUTHORIZED, false, $message);
    }

    public static function Forbidden(string $message)
    {
        return self::response(Response::HTTP_FORBIDDEN, false, $message);
    }

    public static function BadRequest(string $message)
    {
        return self::response(Response::HTTP_BAD_REQUEST, false, $message);
    }

    public static function TooManyRequests(string $message)
    {
        return self::response(Response::HTTP_TOO_MANY_REQUESTS, false, $message);
    }

    public static function InternalServerError(Exception $ex)
    {
        return self::error(Response::HTTP_INTERNAL_SERVER_ERROR, false, $ex);
    }

    public static function UnknownInternalServerError(string $message)
    {
        return self::errorWithMessage(520, false, $message);
    }

    public static function ResourceCreated(string $message)
    {
        return self::response(Response::HTTP_CREATED, true, $message);
    }

    public static function Success(string $message)
    {
        return self::response(Response::HTTP_OK, true, $message);
    }

    public static function SuccessWithData(string $message, $data)
    {
        return self::responseWithData(Response::HTTP_OK, true, $message, $data);
    }

    public static function Conflict(string $message)
    {
        return self::response(Response::HTTP_CONFLICT,false,$message);
    }

    public static function Gone(string $message)
    {
        return self::response(Response::HTTP_GONE,false,$message);
    }

    public static function Fail(string $message)
    {
        return self::response(Response::HTTP_EXPECTATION_FAILED,false,$message);
    }
}
