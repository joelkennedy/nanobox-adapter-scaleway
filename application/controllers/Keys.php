<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Keys extends REST_Controller {

	public function index_post()
	{
		$accessToken = $this->input->get_request_header('Auth-Access-Token', TRUE);
		$name = $this->post('name');
		$key = $this->post('key');

		$name .= "nanobox-".rand(100000,999999);

		if ($accessToken === NULL) {
			$this->set_response(['errors' => array("You must provide the access token header")], 400);
		} else {
			// Find the user ID
			$response = $this->scaleway->listorganisations($accessToken);

			$userID = $response->organizations[0]->users[0]->id;
			$publicKeys = $response->organizations[0]->users[0]->ssh_public_keys;

			if (!is_array($publicKeys)) {
				$this->set_response(['errors' => array("Couldn't retrieve existing public keys")], 500);
			} else {
				$updatedKeys = array();

				foreach ($publicKeys as $publicKey) {
					$thisKey = new \stdClass();
					$thisKey->key = $publicKey->key;
					$updatedKeys[] = $thisKey;
				}

				$newKey = array('key' => $key." ".$name);
				$updatedKeys[] = $newKey;

				$response = $this->scaleway->updatekeys($accessToken, $userID, $updatedKeys);

				if (!$response) {
					$this->set_response(['errors' => array("Request failed")], 500);
				} else {
					$response = array('id' => $name);
					$this->set_response($response, 201);
				}
			}
		}
	}

	public function index_get($key)
	{
		$accessToken = $this->input->get_request_header('Auth-Access-Token', TRUE);

		$response = $this->scaleway->listorganisations($accessToken);

		$publicKeys = $response->organizations[0]->users[0]->ssh_public_keys;

		$publicKeyFound = false;
		foreach ($publicKeys as $publicKey) {
			if (strpos($publicKey->key, $key) !== false) {
				$publicKeyFound = $publicKey->key;
				$publicKeyFound = str_replace(" ".$key, "", $publicKeyFound);
			}
		}

		if ($publicKeyFound === false) {
			$this->set_response(['errors' => array("SSH key not found")], 404);
		} else {
			$response = array('id' => $key, 'name' => $key, 'public_key' => $publicKeyFound);
			$this->set_response($response, 201);
		}
	}

	public function index_delete($key)
	{
		if ($key == "") {
			$this->set_response(null, 200);
		} else {
			$accessToken = $this->input->get_request_header('Auth-Access-Token', TRUE);

			if ($accessToken === NULL) {
				$this->set_response(['errors' => array("You must provide the access token header")], 400);
			} else {
				// Find the user ID
				$response = $this->scaleway->listorganisations($accessToken);

				$userID = $response->organizations[0]->users[0]->id;
				$publicKeys = $response->organizations[0]->users[0]->ssh_public_keys;

				if (!is_array($publicKeys)) {
					$this->set_response(['errors' => array("Couldn't retrieve existing public keys")], 500);
				} else {
					$updatedKeys = array();

					$publicKeyFound = false;
					foreach ($publicKeys as $publicKey) {
						if (strpos($publicKey->key, $key) !== false) {
							$publicKeyFound = true;
						} else {
							$thisKey = new \stdClass();
							$thisKey->key = $publicKey->key;
							$updatedKeys[] = $thisKey;
						}
					}

					if (!$publicKeyFound) {
						$this->set_response(['errors' => array("Public key doesn't exist")], 404);
					} else {
						$response = $this->scaleway->updatekeys($accessToken, $userID, $updatedKeys);

						if (!$response) {
							$this->set_response(['errors' => array("Request failed")], 500);
						} else {
							$this->set_response(null, 200);
						}
					}
				}
			}
		}
	}
}
