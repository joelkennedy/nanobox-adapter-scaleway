<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Servers extends REST_Controller {

	public function index_post()
	{
		$accessToken = $this->input->get_request_header('Auth-Access-Token', TRUE);

		$name = $this->post('name');
		$region = $this->post('region');
		$size = $this->post('size');
		$ssh_key = $this->post('ssh_key');

		if ($accessToken === NULL) {
			$this->set_response(['errors' => array("You must provide the access token header")], 400);
		} else {
			// Get organisation name
			$response = $this->scaleway->listorganisations($accessToken);
			$organisationID = $response->organizations[0]->id;

			$response = $this->scaleway->createserver($accessToken, $organisationID, $name, $this->config->item('install_image_id'), $size);

			if (!$response) {
				$this->set_response(['errors' => array("Access token unauthorized")], 401);
			} else {
				$serverID = $response->server->id;
				// Power on the server
				$response = $this->scaleway->serveraction($accessToken, $serverID, "poweron");

				$response = array('id' => $serverID);
				$this->set_response(null, 201);
			}
		}
	}

	public function query_get()
	{
		$accessToken = $this->input->get_request_header('Auth-Access-Token', TRUE);

		$serverID = $this->uri->segment(2);

		$response = $this->scaleway->serverdetails($accessToken, $serverID);

		if ($response->server->state == "running") {
			$status = "active";
		} else {
			$status = $response->server->state;
		}

		if (isset($response->server->public_ip->address)) {
			$publicIP = $response->server->public_ip->address;
		} else {
			$publicIP = null;
		}

		if (isset($response->server->private_ip)) {
			$privateIP = $response->server->private_ip;
		} else {
			$privateIP = null;
		}

		$finalResponse = array(
			'id' => $response->server->id,
			'status' => $response->server->state,
			'name' => $response->server->name,
			'external_ip' => $publicIP,
			'internal_ip' => $privateIP
		);

		$this->set_response($finalResponse, 201);
	}

	public function reboot_patch()
	{
		$accessToken = $this->input->get_request_header('Auth-Access-Token', TRUE);

		$serverID = $this->uri->segment(2);

		$response = $this->scaleway->serveraction($accessToken, $serverID, "reboot");

		$this->set_response(null, 200);
	}
}
