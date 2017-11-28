<?php

namespace App\Services;

use Response;
use Result;

class ResultService
{
	/*
	 * Result
	 *
		Code Values
		-----------
		0 - null
		1 - success
		2 - error
	*/

	public static function response()
	{
		return [
			'success' => false,
			'result'  => Result::result()
		];
	}

	public static function result()
	{
		return [
			'code' => 0,
			'data' => null
		];
	}

	public static function build($success, $code, $data)
	{
		$response = Result::response();
		$response['success'] = $success;
		$response['result']['code'] = $code;
		$response['result']['data'] = $data;

		return Response::json($response, 200, ['Content-Type' => 'application/javascript']);
	}
}