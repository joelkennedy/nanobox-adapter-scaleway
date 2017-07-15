<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Verify extends CI_Controller {

	public function index_post()
	{
		$accessToken = $this->input->get_request_header('Auth-Access-Token', TRUE);

		if ($accessToken === NULL) {
			$this->set_response(['errors' => array("You must provide the access token header")], 400);
		} else {
			$response = $this->scaleway->verifytoken($accessToken);

			if (!$response) {
				$this->set_response(['errors' => array("Access token unauthorized")], 401);
			} else {
				$this->set_response(null, 200);
			}
		}
	}
}
