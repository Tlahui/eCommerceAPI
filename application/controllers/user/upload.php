<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class upload extends CI_Controller {

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

	require_once(BASEPATH . '../application/libraries/S3.php');
​
//AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAJY42QCXN4NX4SHRQ');
if (!defined('awsSecretKey')) define('awsSecretKey', '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');


	public function upload_image()
	{
		$config = array(
            'allowed_types' => 'jpg|jpeg|gif|png',
            'upload_path'   => './temp',
            'max_size'		=> 3072,
            'overwrite'     => true
        );
​
        $this->load->library('upload', $config);
​
        $this->upload->overwrite = true;
​
        $response['responseStatus'] = "Not OK";
​
        if (!$this->upload->do_upload())
        {
            $response['responseStatus'] = "Your image could not be uploaded";
        }
        else
        {
            $data = $this->upload->data();
​
            //instantiate the class
            $s3 = new S3(awsAccessKey, awsSecretKey);
​
            $ext = pathinfo($data['full_path'], PATHINFO_EXTENSION);
            $imgName = ((string)time()).".".$ext;
​
            $input = S3::inputFile($data['full_path'], FALSE);
​
            if($s3->putObject(file_get_contents($data['full_path']), "tlahui-content", $imgName, S3::ACL_PUBLIC_READ))
            {
                $response['responseStatus'] = "OK";
                $response['url'] = "https://s3.amazonaws.com/tlahui-content/".$imgName;
                unlink($data['full_path']);
            }
            else
            {
                $response['responseStatus'] = "Your image could not be uploaded";
                unlink($data['full_path']);
            }
        }
​
        echo json_encode($response);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */