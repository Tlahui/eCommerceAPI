<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(BASEPATH . '../application/libraries/Conekta.php');


class Payment extends CI_Controller {

  public function checkout()
  {
        Conekta::setApiKey('key_Fq5U8GUU28hTqgxy4md4TQ');
        try {
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

                       if($event_json->type == 'charge.paid')
                       {
                               echo $event_json->data->object->id;
                       }

    }

    public function register_card()
    {
        Conekta::setApiKey('key_Fq5U8GUU28hTqgxy4md4TQ');

        try{
                $customer = Conekta_Customer::create(array(
                    "name"=>"Lews Therin",
                    "e-mail"=>"Lews Therin",
                    "phone"=>"Lews Therin",
                    "cards"=> array()
                
                ));
                $card = $customer->createCard(array('token'=>$this->input->post('token')));
                echo $card->id;
            }
            catch (Conekta_Error $e){
                                 echo $e->getMessage();
                                //el cliente no pudo ser creado
                       }
        }

    public function subscribe()
    {
        Conekta::setApiKey('key_Fq5U8GUU28hTqgxy4md4TQ');

        try{

                        $plan = Conekta_Plan::create(array(
                            'id' => "gold-plan".time(),
                            'name' => "Gold Plan",
                            'amount' => 10000,
                            'currency' => "MXN",
                            'interval' => "month",
                            'frequency' => 1,
                            'trial_period_days' => 15,
                            'expiry_count' => 12
                    ));
                        $customer = Conekta_Customer::create(array(
                            "name"=>"Lews Therin",
                            "e-mail"=>"Lews Therin",
                            "phone"=>"Lews Therin",
                            "cards"=> array()
                    ));

                $card = $customer->createCard(array('token'=>$this->input->post('token')));
                        $subscricion = $customer->createSubscription(
                            array(
                                'plan' => 'gold-plan'
                    ));
                    var_dump($subscricion);

                    
                          
            }
             catch (Conekta_Error $e)
                           {
                               echo $e->getMessage();
                           }

    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
