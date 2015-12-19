<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(BASEPATH . '../application/libraries/Conekta.php');
class Payment extends CI_Controller {
	public function checkout()
	{
		Conekta::setApiKey('key_BmZNHxcJvXgqmbv9qksrbw');
		try
		{
			$charge = Conekta_Charge::create(array(
				"amount"=> 12345,
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
}