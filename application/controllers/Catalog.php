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
					),
					array(
						'id' => 'baremetal',
						'name' => 'Baremetal Server',
						'specs' => array(
							array(
								'id' => "C2S",
								'ram' => 8192,
								'cpu' => 4,
								'disk' => 50,
								'transfer' => "Unlimited",
								'dollars_per_hr' => 0.024,
								'dollars_per_mo' => 11.99
							),
							array(
								'id' => "C2M",
								'ram' => 16384,
								'cpu' => 8,
								'disk' => 50,
								'transfer' => "Unlimited",
								'dollars_per_hr' => 0.036,
								'dollars_per_mo' => 17.99
							),
							array(
								'id' => "C2L",
								'ram' => 32768,
								'cpu' => 8,
								'disk' => 50,
								'transfer' => "Unlimited",
								'dollars_per_hr' => 0.048,
								'dollars_per_mo' => 23.99
							)
						)
					),
					array(
						'id' => 'workloadintensive',
						'name' => 'Workload Intensive',
						'specs' => array(
							array(
								'id' => "X64-15GB",
								'ram' => 15360,
								'cpu' => 6,
								'disk' => 200,
								'transfer' => "Unlimited",
								'dollars_per_hr' => 0.050,
								'dollars_per_mo' => 24.99
							),
							array(
								'id' => "X64-30GB",
								'ram' => 30720,
								'cpu' => 8,
								'disk' => 400,
								'transfer' => "Unlimited",
								'dollars_per_hr' => 0.100,
								'dollars_per_mo' => 49.99
							),
							array(
								'id' => "X64-60GB",
								'ram' => 61440,
								'cpu' => 10,
								'disk' => 700,
								'transfer' => "Unlimited",
								'dollars_per_hr' => 0.180,
								'dollars_per_mo' => 89.99
							),
							array(
								'id' => "X64-120GB",
								'ram' => 122880,
								'cpu' => 12,
								'disk' => 1000,
								'transfer' => "Unlimited",
								'dollars_per_hr' => 0.360,
								'dollars_per_mo' => 179.99
							)
						)
					)
				)
			)
		);

		$this->set_response($response, 200);
	}
}
