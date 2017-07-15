<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Scaleway
{
  public function __construct()
	{
		// To use CodeIgniter resources in libraries, we must use this instead of using '$this'
		$this->CI =& get_instance();
	}

	public function createtoken($email, $password, $expires = true)
	{
    $url = "https://account.scaleway.com/tokens";
		$data = array('email' => $email, 'password' => $password);
		$response = \Httpful\Request::post($url)
			->body(json_encode($data))
	    ->sendsJson()
	    ->send();

    if ($response->code == "401") {
			return false;
		} else {
		  echo $response->body->token->id;
    }
	}

  public function createserver($authToken, $organization, $name, $image, $type)
	{
    $url = "https://cp-par1.scaleway.com/servers";
    $data = array(
      'organization' => $organization,
      'name' => $name,
      'image' => $image,
      'commercial_type' => $type
      'tags' => array('nanobox'),
      'enable_ipv6' => true
    );
		$response = \Httpful\Request::post($url)
      ->xAuthToken($authToken)
			->body(json_encode($data))
	    ->sendsJson()
	    ->send();

    return $response->body;
	}

  public function listimages($authToken)
  {
    $url = "https://cp-par1.scaleway.com/images";
		$response = \Httpful\Request::get($url)
      ->xAuthToken($authToken)
	    ->expectsJson()
	    ->send();

    return $response->body->images;
  }

  public function listorganisations($authToken)
  {
    $url = "https://account.scaleway.com/organizations";
		$response = \Httpful\Request::get($url)
      ->xAuthToken($authToken)
	    ->expectsJson()
	    ->send();

    return $response->body->organizations;
  }
}
