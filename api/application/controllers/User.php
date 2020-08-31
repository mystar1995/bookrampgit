<?php 

	
	require('vendor/autoload.php');

	use Twilio\Rest\Client;
	
	class User extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('usermodel');
			$this->load->model('contentmodel');
		}

		function send_verification($phone_number)
		{
			try
			{
				$sid = "ACf12e12a261df45a782f4352717246a7d";
				$token = "677a1f39efb8dae5aef825913c2cecb7";
				$serviceid = "VA6a78b5977f2a46c301a8d5580e036ea9";
				
				$twilio = new Client($sid, $token);
				$verification = $twilio->verify->v2->services($serviceid)
	                                   ->verifications
	                                   ->create($phone_number, "sms");	
	            return true;
			}
			catch(Exception $e)
			{
				var_dump($e->getMessage());
				return false;
			}

		}

		function createservice()
		{
			$sid = "ACf12e12a261df45a782f4352717246a7d";
			$token = "af05f6f7f51cc423ffe47842852adf41";
			$twilio = new Client($sid, $token);
			$service = $twilio->verify->v2->services->create('Your Bookramp Account');
			var_dump($service);
		}

		function check_verification($phone_number,$verify)
		{
			try
			{
				$sid = "ACf12e12a261df45a782f4352717246a7d";
				$token = "677a1f39efb8dae5aef825913c2cecb7";
				$serviceid = "VA6a78b5977f2a46c301a8d5580e036ea9";
				
				$twilio = new Client($sid, $token);

				$verification_check = $twilio->verify->v2->services($serviceid)
	                                         ->verificationChecks
	                                         ->create($verify, // code
	                                                  ["to" => $phone_number]
	                                         );

	            if($verification_check->status == 'approved')
	            {
	            	return true;
	            }
	            else
	            {
	            	return false;
	            }
			}
			catch(Exception $e)
			{
				var_dump($e->getMessage());
				return false;
			}
			
		}

		function valid_user()
		{
			$header = $this->input->request_headers();

			if(get_authorization($header))
			{
				$user = check_user(get_authorization($header));
				//var_dump($user);exit;
				if($user)
				{
					echo json_encode(array('success'=>true));
				}
				else
				{
					echo json_encode(array('success'=>false));
				}
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function switchuser()
		{
			$header = $this->input->request_headers();

			if(get_authorization($header))
			{
				$user = check_user(get_authorization($header));
				if($user)
				{
					$this->usermodel->switchuser($user['id']);
					echo json_encode(array('success'=>true));
				}
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function setlang()
		{
			$header = $this->input->request_headers();

			if(get_authorization($header))
			{
				$user = check_user(get_authorization($header));
				$lang = $this->input->post('lang');
				if($user)
				{
					$this->usermodel->setlang($user['id'],$lang);
					echo json_encode(array('success'=>true));
				}
				else
				{
					echo json_encode(array('success'=>false));
				}
			}
			else
			{
				echo json_encode(array('success'=>false));
			}

		}

		function validate_user($data,$credential = false)
		{
			$required_field = array('username','email','password1','phone_number','dob','country','city');

			$error = array();

			$insert_data = array();
			foreach ($required_field as $key => $field) {
				if(!isset($data[$field]) || !$data[$field])
				{
					array_push($error, array('error'=>ucfirst($field) . " is required"));		
				}
				else
				{
					if($field == 'password1')
					{
						$insert_data['password'] = md5($data[$field]);
					}
					else
					{
						$insert_data[$field] = $data[$field];	
					}
					
				}
			}

			if(count($error) > 0)
			{
				return array('success'=>false,'error'=>$error);	
			}
			else
			{
				if(!isset($data['password2']) || $data['password1'] != $data['password2'])
				{
					array_push($error,array('password1'=>'Password does not matched with Contirm Password'));
					return array('success'=>false,'error'=>$error);
				}
				else
				{
					if(isset($data['writer']) && $data['writer'] == "true")
					{
						$insert_data['user_type'] = 'writer';
					}
					else
					{
						$insert_data['user_type'] = 'reader';
					}


					$exist = $this->usermodel->is_exist($insert_data,$credential);

					$error_entity = array();

					
					if($exist['success'])
					{
						return array('success'=>true,'data'=>$insert_data);
					}
					else
					{
						$error_entity[$exist['type']] = $exist['message'];
						return array('success'=>false,'error'=>array($error_entity));
					}
				}
			}
		}

		function register()
		{
			$data = $this->input->post();
			
			$result = $this->validate_user($data);

			if($result['success'])
			{
				$data  = $result['data'];
				if($data['user_type'] == 'writer')
				{
					$data['status'] = 'UNDERREVIEW';
				}

				if($this->send_verification($data['phone_number']))
				{
					$this->usermodel->add_user($data);	
					echo json_encode(array('success'=>true,'phone'=>$data['phone_number']));
				}
				else
				{
					echo json_encode(array('error'=>array(['phone_number'=>'Phone Number is not valid'])));
				}
			}
			else
			{
				echo json_encode(array('error'=>$result['error']));
			}
		}

		function verify_user()
		{
			$phone_number = $this->input->post('phone_number');
			$verify = $this->input->post('verify');

			if(!$this->usermodel->get_user_by_phone($phone_number))
			{
				echo json_encode(array('success'=>false,'message'=>'User with this phone number is not registered'));
				return;
			}

			if($this->check_verification($phone_number,$verify))
			{
				$result = $this->usermodel->verify($phone_number);
				echo json_encode($result);
			}
			else
			{
				echo json_encode(array('success'=>false,'message'=>'Code is not valid'));
			}
		}

		function forget_password()
		{
			$phone_number = $this->input->post('phone_number');

			$user = $this->usermodel->get_user_by_phone($phone_number);

			if($user)
			{
				if($this->send_verification($phone_number))
				{
					echo json_encode(array('success'=>true));
				}
				else
				{
					echo json_encode(array('success'=>false,'message'=>"The Phone number is not valid"));
				}
			}
			else
			{
				echo json_encode(array('success'=>false,'message'=>"User is not exist"));
			}
		}

		function reset_password()
		{
			$data = $this->input->post();
			$user = $this->usermodel->get_user_by_phone($data['phone_number']);
			if($user)
			{
				if($this->check_verification($data['phone_number'],$data['verify_code']))
				{
					$token = $this->usermodel->resetpassword($user['id'],$data['password']);
					echo json_encode(array('success'=>true,'token'=>$token,'usertype'=>$user['user_type']));
				}
				else
				{
					echo json_encode(array('success'=>false,'message'=>'Verify Code is not valid'));
				}
			}
			else
			{
				echo json_encode(array('success'=>false,'message'=>'User is not exist'));
			}
		}


		function update_profile()
		{
			$header = $this->input->request_headers();

			$data = $this->input->post();
			if(get_authorization($header))
			{
				//$exist = $this->validate_user($data,get_authorization($header));

				$config['upload_path'] = '/opt/lampp/htdocs/bookrampgit/uploads/user';
				$config['allowed_types'] = '*';
				$config['max_size']             = 10000;
		        $config['max_width']            = 10240;
		        $config['max_height']           = 7680;
		        $config['file_name']			= "user_" . time() ;
		        $this->load->library('upload',$config);

		        $this->upload->initialize($config);

		        $uploaded = $this->upload->do_upload('profile_pic');

		        if($uploaded)
		        {
		        	$data['profile_pic'] ='uploads/user/' . $this->upload->data('file_name');
		        }
		        
		       

		        $result = $this->usermodel->add_user($data,get_authorization($header));

		        echo json_encode(array('success'=>true,'data'=>$result));
			}
			else
			{
				echo json_encode(array('error'=>array('error'=>'Credential is required')));
			}
		}

		function profile()
		{
			$header = $this->input->request_headers();

			$result = $this->usermodel->get_user(get_authorization($header));

			if($result)
			{
				echo json_encode(array('success'=>true,'data'=>$result));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function delete()
		{
			$header = $this->input->request_headers();
			$this->usermodel->delete_user(get_authorization($header));
		}

		function login()
		{
			$user = $this->input->post();
			$result = $this->usermodel->login_user($user);

			if(!$result['success'] && isset($result['phone']))
			{
				$this->send_verification($result['phone']);
			}
			echo json_encode($result);
		}	

		function logout()
		{
			$header = $this->input->request_headers();
			$this->usermodel->logout(get_authorization($header));
			echo json_encode(array('success'=>true));
		}

		function authorinfo()
		{
			$header = $this->input->request_headers();
			$authorid = $this->input->get('authorid');
			//echo $authorid;exit;
			if(get_authorization($header))
			{	
				$author = $this->usermodel->get_profile($authorid,get_authorization($header));
				echo json_encode(array('success'=>true,'author'=>$author));
			}
			else
			{
				echo json_encode(array('success'=>false,'message'=>''));
			}
		}

		function buy_rewards()
		{
			$header = $this->input->request_headers();

			$rewards = $this->input->post('rewards');
			if(get_authorization($header))
			{
				$this->usermodel->add_rewards($rewards,get_authorization($header));
			}
		}

		function earn_reward()
		{
			$contentid = $this->input->post('contentid');
			$page = $this->input->post('page');

			$header = $this->input->request_headers();

			if(get_authorization($header))
			{
				$user = check_user(get_authorization($header));

				if($user)
				{
					$result = $this->usermodel->create_rewards($contentid,$page,$user['id']);
					if($result)
					{
						$rewards = $this->contentmodel->get_rewards(get_authorization($header));
						echo json_encode(array('success'=>$result,'data'=>$rewards));	
					}
					else
					{
						echo json_encode(array('success'=>$result));
					}
				}
				else
				{
					echo json_encode(array('success'=>false));
				}
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function settlement()
		{
			$header = $this->input->request_headers();

			if(get_authorization($header))	
			{
				$data = $this->input->post();
				$result = $this->usermodel->add_settlement($data,get_authorization($header));
				echo json_encode(array('success'=>$result));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function getsettlement()
		{
			$header = $this->input->request_headers();

			if(get_authorization($header))
			{
				$result = $this->usermodel->get_settlement(get_authorization($header));
				echo json_encode(array('success'=>true,'data'=>$result));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function getearned()
		{
			$header = $this->input->request_headers();


			if(get_authorization($header))
			{
				$result = $this->usermodel->get_earned_history(get_authorization($header));

				if($result)
				{
					echo json_encode(array('success'=>true,'data'=>$result));
				}
				else
				{
					echo json_encode(array('success'=>false));
				}
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function send_mail()
		{
			echo json_encode(sendmail(
				array(
				'from'=>'Very Horse <info@veryhorse.com>',
				'to'=>'jws19950122@outlook.com',
				'subject'=>'Send email',
				"text_body"=>'',
				'html_body'=>'send email'
			)));
		}
	}

?>