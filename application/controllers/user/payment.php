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




	public function register_card() {

		Conekta::setApiKey("key_Fq5U8GUU28hTqgxy4md4TQ");

		// Con éstos datos, creamos un customer...
		try{
		  $customer = Conekta_Customer::create(array(
		    "name"=> "Marcos Valencia",
		    "email"=> "marcos.valencia@gmail.com",
		    "phone"=> "55-5555-5555",
		    "cards"=>  array()
		  ));


			$card = $customer->createCard(array('token' => $this->input->post("token") ));
			
			//echo $card->id;
			echo print_r( $card );

		}catch (Conekta_Error $e){
		  echo $e->getMessage();
		 //el cliente no pudo ser creado
		}		

	}




	public function subscribe() {

		Conekta::setApiKey("key_Fq5U8GUU28hTqgxy4md4TQ");

		// Creamos un plan
// primero creamos un plan
/*		
		$plan = Conekta_Plan::create(array(
			'id' => "tlahui-plan-mensual",
			'name' => "Gold Plan",
			'amount' => 10000,
			'currency' => "MXN",
			'interval' => "month",
			'frequency' => 1,
			'trial_period_days' => 15,
			'expiry_count' => 12
		));
*/

// luego ya podemos vincularlo a un cliente, pero PRIMERO
// debemos crear el plan		

		// creamos un cliente
		$customer = Conekta_Customer::create(array(
		"name"=> "Marcos Valencia",
		"email"=> "marcos.valencia@gmail.com",
		"phone"=> "55-5555-5555",
		"cards"=>  array()
		));

		$card = $customer->createCard(array('token' => $this->input->post("token") ));

		$subscription = $customer->createSubscription(
		  array(
		    'plan' => 'tlahui-plan-mensual'
		  )
		);		

		echo print_r( $subscription );

	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

