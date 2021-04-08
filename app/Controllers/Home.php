<?php

namespace App\Controllers;

use App\Services\HomeService;
use App\Enum\ResponseEnum;

class Home extends BaseController
{

	public function index()
	{
		return view('index');
	}

	public function sendFiles()
	{
		$response = [
			"status" => 0,
			"data"   => [],
			"code"   => ResponseEnum::HTTP_OK
		];

		try {

			$resultData = HomeService::create($this->request);

			if (is_array($resultData)) {
				$response["data"] = implode(", ", $resultData);
				$response["code"] = ResponseEnum::HTTP_BAD_REQUEST;

				$this->response
					->setStatusCode($response['code'])
					->setJSON($response)
					->send();
				return;
			}

			$response["status"] = 1;
			$response["data"] = $resultData;
		} catch (\Exception $except) {
			$response["code"] = ResponseEnum::HTTP_INTERNAL_SERVER_ERROR;
			$response["data"] = $except->getMessage();
		}

		$this->response
			->setStatusCode($response['code'])
			->setJSON($response)
			->send();
	}
}
