<?php 

namespace App\Controllers;

use App\Services\HomeService;

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
			"data"   => []
		];

		try {
			$response["status"] = 1;
			$response["data"] = HomeService::handle(
				$this->request->getPost('emailFrom', FILTER_SANITIZE_EMAIL), 
				$this->request->getPost('emailTo', FILTER_SANITIZE_EMAIL), 
				$this->request->getPost('message', FILTER_DEFAULT), 
				$this->request->getFiles('files')
			);
			
		} catch (\Exception $except) {
			$response["data"] = $except->getMessage();
		}
		
        $this->response
            ->setStatusCode($response['code'])
            ->setJSON($response)
            ->send();
	}
}
