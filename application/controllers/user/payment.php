<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(BASEPATH . '../application/libraries/Conekta.php');

class Payment extends CI_Controller {

	public function checkout()
	{
		Conekta::setApiKey('key_Fq5U8GUU28hTqgxy4md4TQ');
		try
		{
			$charge = Conekta_Charge::create(array(
				"amount"=> 51000,
				"currency"=> "MXN",
				"description"=> "Tlahui",
				"reference_id"=> "Tlahui100",
				"card"=> $this->input->post("token")
			));
			var_dump($charge);
		}
		catch (Conekta_Error $e)
		{
			echo $e->getMessage();
		}
	}

	public function confirm_payment()
	{
		$body = @file_get_contents('php://input');
		$event_json = json_decode($body);

		if ($event_json->type == 'charge.paid')
		{
			echo $event_json->data->object->id;
		}
	}

	public function register_card()
	{
		Conekta::setApiKey("key_Fq5U8GUU28hTqgxy4md4TQ");
		try{
			$customer = Conekta_Customer::create(array(
				"name"=> "Lews Therin",
				"email"=> "lews.therin@gmail.com",
				"phone"=> "55-5555-5555",
				"cards"=>  array()
			));
			$card = $customer->createCard(array('token' => $this->input->post("token")));
			echo $card->id;
		}catch (Conekta_Error $e){
		  echo $e->getMessage();
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */