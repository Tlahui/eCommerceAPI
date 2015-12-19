<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(BASEPATH . '../application/libraries/Conekta.php');

class Payment extends CI_Controller {

  /*
    Funcion para implementar cobros con Conekta SDK
  */
  public function checkout() {
    //Clave privada de el panel de administracion de conekta
    Conekta::setApiKey('key_Fq5U8GUU28hTqgxy4md4TQ');

    try {
      $charge = Conekta_Charge::create(array(
        "amount"=> 510.00,
        "currency"=> "MXN",
        "description"=> "Raziel checkout",
        "reference_id"=> "tlahuiAPI-Conekta-SDK",
        "card"=> $this->input->post("token")
      ));

    } catch (Conekta_Error $e) {
      echo $e->getMessage();
      //El pago no pudo ser procesado
    }
    var_dump($charge);

  }

  public function confirm_payment() {
    // Analizar la información del evento en forma de json
    $body = @file_get_contents('php://input');
    $event_json = json_decode($body);

    if ($event_json->type == 'charge.paid'){
      echo $event_json->data->object->id;
    }

    if ($event_json->data->object == 'id'){
      echo $event_json->data->object->id;
    }

  }

}
