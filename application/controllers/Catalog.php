<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Catalog extends REST_Controller {

	public function index_get()
	{
		$response = array(
			array(
				'id' => 'par1',
				'name' => 'Paris',
				'plans' => array(
					array(
						'id' => 'cloud',
						'name' => 'Cloud Server',
						'specs' => array(
							array(
								'id' => "VC1S",
								'ram' => 2048,
								'cpu' => 2,
								'disk' => 50,
								'transfer' => "Unlimited",
								'dollars_per_hr' => 0.006,
								'dollars_per_mo' => 2.99
							),
							array(
								'id' => "VC1M",
								'ram' => 4096,
								'cpu' => 4,
								'disk' => 100,
								'transfer' => "Unlimited",
								'dollars_per_hr' => 0.012,
								'dollars_per_mo' => 5.99
							),
							array(
								'id' => "VCL1",
								'ram' => 8192,
								'cpu' => 6,
								'disk' => 200,
								'transfer' => "Unlimited",
								'dollars_per_hr' => 0.02,
								'dollars_per_mo' => 9.99
							)
						)
					)
				)
			)
		);

		$this->set_response($response, 200);
	}
}
