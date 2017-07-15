<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {

	public function index()
	{
		if(!$this->input->is_cli_request())
		{
			exit();
		}

		$email = $this->uri->segment(2);
		$password = $this->uri->segment(3);

		if ($email == "" || $password == "") {
			echo "To setup the Nanobox Scaleway adapter, we need to create an auth token. To do that, pass in your Scaleway email and password.".PHP_EOL.
			"This script will return a token (that never expires) that you can enter into Nanobox.".PHP_EOL.
			"Run 'php index.php setup \"[email]\" \"[password]\"'".PHP_EOL;
		} else {
			$token = $this->scaleway->createtoken($email, $password, false);

			if ($token === false) {
				echo "The username or password you provided was incorrect".PHP_EOL;
			} else {
				echo $token;
			}
		}
	}
}
