<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verify extends CI_Controller {

	public function index()
	{
		$accessToken = $this->input->get_request_header('Auth-Access-Token', TRUE);

		if ($accessToken === NULL) {
			$response = array('errors', array('You must provide the access token header'));
			$this->output
	        ->set_status_header(400)
	        ->set_content_type('application/json', 'utf-8')
	        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
	        ->_display();
			exit;
		} else {
			$response = $this->scaleway->verifytoken($accessToken);

			if (!$response) {
				$response = array('errors', array('Access token unauthorized'));

				$this->output
		        ->set_status_header(401)
		        ->set_content_type('application/json', 'utf-8')
		        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
		        ->_display();
				exit;
			} else {
				$this->output
		        ->set_status_header(200)
		        ->set_content_type('application/json', 'utf-8')
		        ->_display();
				exit;
			}
		}
	}
}
