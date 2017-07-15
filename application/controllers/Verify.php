<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verify extends CI_Controller {

	public function index()
	{
		$accessToken = $this->input->get_request_header('Auth-Access-Token', TRUE);

		if ($accessToken === NULL) {
			$this->response->error(array("You must provide the access token header"), 400);
		} else {
			$response = $this->scaleway->verifytoken($accessToken);

			if (!$response) {
				$this->response->error(array("Access token unauthorized"), 401);
			} else {
				$this->response->empty(200);
			}
		}
	}
}
