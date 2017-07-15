<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meta extends CI_Controller {

	public function index()
	{
		$response = array(
			'id' => 'scaleway',
			'name' => 'Scaleway',
			'server_nick_name' => 'Server',
			'default_region' => 'par1',
			'default_size' => '2GB',
			'default_plan' => 'VC1S',
			'can_reboot' => true,
			'can_rename' => true,
			'internal_iface' => 'eth1',
			'external_iface' => 'eth0',
			'ssh_user' => 'root',
			'ssh_auth_method' => 'key',
			'ssh_key_method' => 'reference',
			'bootstrap_script' => 'https://s3.amazonaws.com/tools.nanobox.io/bootstrap/ubuntu.sh',
			'credentials_fields' => array(
				array('key' => 'access-token', 'label' => 'Auth Token')
			),
			'instructions' => 'For instructions on how to retrieve a Scaleway access token, visit the repository.'
		);

		$this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();
		exit;
	}
}
