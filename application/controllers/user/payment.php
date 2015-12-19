<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(BASEPATH . '../application/libraries/Conekta.php');

class Payment extends CI_Controller {

	public function checkout()
	{
		Conekta::setApiKey('key_Fq5U8GUU28hTqgxy4md4TQ');
		try
		{
			$charge = Conekta_Charge::create(array(
				"amount"=> 10000,
				"currency"=> "MXN",
				"description"=> "Tlahui",
				"reference_id"=> "Tlahui12345",
				"card"=> $this->input->post("token")
			));
			//var_dump($charge);

			echo print_r( $charge );

		}
		catch (Conekta_Error $e)
		{
			echo $e->getMessage();
		}
	}


	public function confirm_payment() {
		$body = @file_get_contents("php://input");
		$event_json = json_decode( $body );

		if ( $event_json->type == "charge.paid" ) {
			echo $event_json->data->object->id . "   " .
				$event_json->data->object->payment_method->name;
		}

	}




}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
