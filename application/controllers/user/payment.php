<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(BASEPATH . '../application/libraries/Conekta/Conekta.php');

class payment extends CI_Controller {

public function checkout()
{

Conekta::setApiKey('key_Fq5U8GUU28hTqgxy4md4TQ');
try {
  $charge = Conekta_Charge::create(array(
    "amount"=> 510.00,
    "currency"=> "MXN",
    "description"=> "Tlahui",
    "reference_id"=> "Tlaui100",
    "card"=>$this->input->post("token")
    //"tok_a4Ff0dD2xYZZq82d9"
  ));

var_dump($charge);
	
} catch (Conekta_Error $e) {
  echo $e->getMessage();
  //El pago no pudo ser procesado
}

}

public function confirm_payment()
{
	// Analizar la información del evento en forma de json
$body = @file_get_contents('php://input');
$event_json = json_decode($body);

if ($event_json->type == 'charge.paid'){
	echo $event_json->data->object->id;
//Hacer algo con la información como actualizar los atributos de la orden en tu base de datos
 //charge = $this->Charge->find('first', array(
 // 'conditions' => array('Charge.id' => $event_json->object->id)
 //))
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
    "cards"=>  array()   //"tok_a4Ff0dD2xYZZq82d9"
  ));

$card = $customer->createCard(array('token' =>  $this->input->post('token')));

echo $card->id;

}catch (Conekta_Error $e){
  echo $e->getMessage();
 //el cliente no pudo ser creado
}
//$customer = Conekta_Customer::find("cus_k2D9DxlqdVTagmEd400001");
}


public function subscribe()
{

Conekta::setApiKey("key_Fq5U8GUU28hTqgxy4md4TQ");

try{
$plan = Conekta_Plan::create(array(
	'id' => "tlahui-plan".time(),
	'name' => "tlahui Plan",
	'amount' => 10000,
	'currency' => "MXN",
	'interval' => "month",
	'frequency' => 1,
	'trial_period_days' => 15,
	'expiry_count' => 12
));

  $customer = Conekta_Customer::create(array(
    "name"=> "Lews Therin",
    "email"=> "lews.therin@gmail.com",
    "phone"=> "55-5555-5555",
    "cards"=>  array()   //"tok_a4Ff0dD2xYZZq82d9"
  ));

$card = $customer->createCard(array('token' =>  $this->input->post('token')));
$subscription = $customer->createSubscription(
  array(
    'plan' => 'tlahui-plan'
  )
);
var_dump($subscription);

} catch (Conekta_Error $e) {
  echo $e->getMessage();
  //El pago no pudo ser procesado
}

}


}
