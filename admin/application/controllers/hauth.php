<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HAuth extends CI_Controller {

	public function index()
	{
		$this->load->view('hauth/home');
	}

	public function login($provider)
	{
		log_message('debug', "controllers.HAuth.login($provider) called");

		try
		{
			log_message('debug', 'controllers.HAuth.login: loading HybridAuthLib');
			$this->load->library('HybridAuthLib');

			if ($this->hybridauthlib->providerEnabled($provider))
			{
				log_message('debug', "controllers.HAuth.login: service $provider enabled, trying to authenticate.");
				$service = $this->hybridauthlib->authenticate($provider);

				if ($service->isUserConnected())
				{
					log_message('debug', 'controller.HAuth.login: user authenticated.');

					$user_profile = $service->getUserProfile();
                    
                    $fullname=$user_profile->firstName.' '.$user_profile->lastName;
                    $firstname=$user_profile->firstName;
                    $lastname=$user_profile->lastName;
                    $dob=$user_profile->birthYear.'-'.$user_profile->birthMonth.'-'.$user_profile->birthDay;
                    $newid=$user_profile->identifier;
                    $photo=$user_profile->photoURL;
                    $email=$user_profile->email;
                    $phone=$user_profile->phone;
                    $address=$user_profile->address;
                    $country=$user_profile->country;
                    $region=$user_profile->region;
                    $city=$user_profile->city;
                    $zip=$user_profile->zip;
//                    $this->load->helper('url'); 
                    $checkfacebook=$this->db->query("SELECT count(*) as `count1` FROM `user` WHERE `facebookuserid`='$newid'")->row();
                    if($checkfacebook->count1=='0')
                    {
                        $insertuserquery=$this->db->query("INSERT INTO `user`(`firstname`, `lastname`, `email`, `contact`, `address`, `city`, `pincode`, `dob`, `accesslevel`, `timestamp`, `facebookuserid`, `status`, `photo`, `phoneno`, `state`, `country`, `deletestatus`) VALUES ('$firstname','$lastname','$email','$phone','$address','$city','$zip','$dob',3,NULL,'$newid',1,'$photo','$phone','$state','$country',1)");
                        $userid=$this->db->insert_id();
                    $newdata = array(
                        'email'     => $email,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'logged_in' => true,
                        'id'=> $userid
                        );

                        $this->session->set_userdata($newdata);
                        redirect('http://mafiawarloots.com/anyinform');
                    }
                    else
                    {
                        $selectquery=$this->db->query("SELECT * FROM `user` WHERE `facebookuserid`='$newid'")->row();
                        $userid=$selectquery->id;
                        $email=$selectquery->email;
                        $firstname=$selectquery->firstname;
                        $lastname=$selectquery->lastname;
                        
                        $newdata = array(
                        'email'     => $email,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'logged_in' => true,
                        'id'=> $userid
                        );
                        
                        $this->session->set_userdata($newdata);
                        redirect('http://mafiawarloots.com/anyinform');
                    }
					log_message('info', 'controllers.HAuth.login: user profile:'.PHP_EOL.print_r($user_profile, TRUE));

//					$data['user_profile'] = $user_profile;
//
//					$this->load->view('hauth/done',$data);
				}
				else // Cannot authenticate user
				{
					show_error('Cannot authenticate user');
				}
			}
			else // This service is not enabled.
			{
				log_message('error', 'controllers.HAuth.login: This provider is not enabled ('.$provider.')');
				show_404($_SERVER['REQUEST_URI']);
			}
		}
		catch(Exception $e)
		{
			$error = 'Unexpected error';
			switch($e->getCode())
			{
				case 0 : $error = 'Unspecified error.'; break;
				case 1 : $error = 'Hybriauth configuration error.'; break;
				case 2 : $error = 'Provider not properly configured.'; break;
				case 3 : $error = 'Unknown or disabled provider.'; break;
				case 4 : $error = 'Missing provider application credentials.'; break;
				case 5 : log_message('debug', 'controllers.HAuth.login: Authentification failed. The user has canceled the authentication or the provider refused the connection.');
				         //redirect();
				         if (isset($service))
				         {
				         	log_message('debug', 'controllers.HAuth.login: logging out from service.');
				         	$service->logout();
				         }
				         show_error('User has cancelled the authentication or the provider refused the connection.');
				         break;
				case 6 : $error = 'User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.';
				         break;
				case 7 : $error = 'User not connected to the provider.';
				         break;
			}

			if (isset($service))
			{
				$service->logout();
			}

			log_message('error', 'controllers.HAuth.login: '.$error);
			show_error('Error authenticating user.');
		}
	}

	public function endpoint()
	{

		log_message('debug', 'controllers.HAuth.endpoint called.');
		log_message('info', 'controllers.HAuth.endpoint: $_REQUEST: '.print_r($_REQUEST, TRUE));

		if ($_SERVER['REQUEST_METHOD'] === 'GET')
		{
			log_message('debug', 'controllers.HAuth.endpoint: the request method is GET, copying REQUEST array into GET array.');
			$_GET = $_REQUEST;
		}

		log_message('debug', 'controllers.HAuth.endpoint: loading the original HybridAuth endpoint script.');
		require_once APPPATH.'/third_party/hybridauth/index.php';

	}
}

/* End of file hauth.php */
/* Location: ./application/controllers/hauth.php */