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
      'commercial_type' => $type,
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

  public function serveraction($authToken, $serverID, $action)
	{
    $url = "https://cp-par1.scaleway.com/servers/".$serverID."/action";
    $data = array(
      'action' => $action
    );
		$response = \Httpful\Request::post($url)
      ->xAuthToken($authToken)
			->body(json_encode($data))
	    ->sendsJson()
	    ->send();

    return $response->body;
	}

  public function serverdelete($authToken, $serverID)
	{
    $url = "https://cp-par1.scaleway.com/servers/".$serverID;
		$response = \Httpful\Request::delete($url)
      ->xAuthToken($authToken)
	    ->sendsJson()
	    ->send();

    return $response->body;
	}

  public function serverdetails($authToken, $serverID)
	{
    $url = "https://cp-par1.scaleway.com/servers/".$serverID;
		$response = \Httpful\Request::get($url)
      ->xAuthToken($authToken)
	    ->sendsJson()
	    ->send();

    return $response->body;
	}

  public function serverrename($authToken, $serverID, $name)
	{
    // Get server details
    $details = $this->serverdetails($authToken, $serverID);

    $data = $details->server;

    $url = "https://cp-par1.scaleway.com/servers/".$serverID;
    $data->name = $name;
		$response = \Httpful\Request::put($url)
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

    return $response->body;
  }

  public function verifytoken($authToken)
  {
    $url = "https://account.scaleway.com/organizations";
		$response = \Httpful\Request::get($url)
      ->xAuthToken($authToken)
	    ->expectsJson()
	    ->send();

    if ($response->code != "200") {
			return false;
		} else {
		  return true;
    }
  }

  public function updatekeys($authToken, $userID, $keys)
  {
    $publicKeys = array('ssh_public_keys' => $keys);

    $url = "https://account.scaleway.com/users/".$userID;
		$response = \Httpful\Request::patch($url)
      ->xAuthToken($authToken)
      ->body(json_encode($publicKeys))
      ->sendsJson()
	    ->expectsJson()
	    ->send();

    if ($response->code != "200") {
			return false;
		} else {
		  return true;
    }
  }

  public function listkeys($authToken, $userID)
  {
    $url = "https://account.scaleway.com/users/".$userID;
		$response = \Httpful\Request::get($url)
      ->xAuthToken($authToken)
      ->body($key)
	    ->expectsJson()
	    ->send();

    if ($response->code != "200") {
			return false;
		} else {
		  return $response;
    }
  }
}
