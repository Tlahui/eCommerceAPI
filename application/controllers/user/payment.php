<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(BASEPATH . '../application/libraries/Conekta.php');


class Payment extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function checkout()
	{
		Conekta::setApiKey('key_Fq5U8GUU28hTqgxy4md4TQ');
			try {
			  $charge = Conekta_Charge::create(array(
			    "amount"=> 51000,
			    "currency"=> "MXN",
			    "description"=> "BlusaTlahui",
			    "reference_id"=> "Tlahui100",
			    "card"=> $this->input->post("token")
			  ));
			  var_dump($charge);
			} 
			catch (Conekta_Error $e) 
			{
			  echo $e->getMessage();
			  //El pago no pudo ser procesado
			}

		//$this->load->view('welcome_message');
	}
	public function confirm_checkout()
	{
		//$body=@file_get_contents(filename)
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */