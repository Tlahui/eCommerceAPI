<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(BASEPATH . '../application/libraries/Conekta.php');

class Charge extends CI_Controller {
            public function checkout()
            {

                        $response['responseStatus'] = "Not OK";

                        // private key of conekta dashboard
                        Conekta::setApiKey('key_Fq5U8GUU28hTqgxy4md4TQ');
                        try {
                                    $charge = Conekta_Charge::create(array(
                                            "amount"=> 125000,
                                            "currency"=> "MXN",
                                            "description"=> "Galileo Tlahui",
                                            "reference_id"=> "Tlahui001 Galileo",
                                            "card"=> $this->input->post("token")
                                            //"tok_a4Ff0dD2xYZZq82d9"
                                    ));
                                    
                                    var_dump($charge);
                                    //echo json_encode($charge);


                        } catch (Conekta_Error $e) {
                                    echo $e->getMessage();
                                    //El pago no pudo ser procesado
                        }

            }

            public function confirm_payment()
            {
                        $body = @file_get_contents('php://input');

                        $event_json = json_decode($body);

                        if($event_json->type == 'charge.paid')
                        {
                               echo $event_json->data->object->id;
                        }



            }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
