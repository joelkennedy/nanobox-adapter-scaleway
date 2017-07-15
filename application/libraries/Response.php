<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Response
{
  public function __construct()
	{
		// To use CodeIgniter resources in libraries, we must use this instead of using '$this'
		$this->CI =& get_instance();
	}

  public function output($response, $statuscode)
  {
    $this->CI->output
        ->set_status_header($statuscode)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();
    exit;
  }

  public function empty($statuscode)
  {
    $this->CI->output
        ->set_status_header($statuscode)
        ->set_content_type('application/json', 'utf-8')
        ->_display();
    exit;
  }

  public function error($errors, $statuscode)
  {
    $response = array('errors' => $errors);
    $this->CI->output
        ->set_status_header($statuscode)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        ->_display();
    exit;
  }
}
