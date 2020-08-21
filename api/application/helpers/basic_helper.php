<?php 
	define('POSTMARK_API_KEY', '289a1981-0839-49fa-afaa-98d98c975d68');
	if(!function_exists('get_setting'))
	{
		function get_setting($key)
		{
			global $CI;
			$CI->db->where('meta_key',$key);
			$result = $CI->db->get('setting')->row_array();

			if($result)
			{
				return $result['meta_value'];
			}
			else
			{
				return '';
			}
		}
	}

	if(!function_exists('set_setting'))
	{
		function set_setting($key,$value)
		{
			global $CI;
			$result = get_setting($key);

			if(!$result)
			{
				$insert_data = array('meta_key'=>$key,'meta_value'=>$value);
				$CI->db->insert('setting',$insert_data);
			}
			else
			{
				$CI->db->where('meta_key',$key);
				$CI->db->set('meta_value',$value);
				$CI->db->update('setting');
			}
		}
	}

	if(!function_exists('get_user_count'))
	{
		function get_user_count($type,$status = false)
		{
			global $CI;
			if($type != 'all')
			{
				$CI->db->where('user_type',$type);
			}

			if($status)
			{
				$CI->db->where('status',$status);
			}

			$query = $CI->db->get('user');

			return $query->num_rows();
		}
	}

	if(!function_exists('get_book_count'))
	{
		function get_book_count($status = 'all')
		{
			global $CI;
			$query = '';
			if($status != 'all')
			{
				$CI->db->where('status',$status);
				$query = $CI->db->get('content');
			}
			else
			{
				$query = 'Select * from content where status = "PUBLISHED" or status = "UNDERREVIEW" or status = "REJECTED"';
				$query = $this->db->query($query);
			}

			

			return $query->num_rows();
		}
	}

	if(!function_exists('get_user_logo'))
	{
		function get_user_logo()
		{
			global $CI;

			$user = $CI->session->get_userdata('user');

			if(isset($user['user']) && $user['user']['profile_pic'])
			{
				return base_url() . $user['user']['profile_pic'];
			}
			else
			{
				return base_url() . 'assets/jpg/default.jpg';
			}
		}
	}

	if(!function_exists('get_username'))
	{
		function get_username()
		{
			global $CI;

			$user = $CI->session->get_userdata('user');


			if(isset($user['user']) && $user['user']['username'])
			{
				return $user['user']['username'];
			}
			else
			{
				return '';
			}
		}
	}

	if(!function_exists('get_user_id'))
	{
		function get_user_id()
		{
			global $CI;

			$user = $CI->session->get_userdata('user');


			if(isset($user['user']) && isset($user['user']['id']))
			{
				return $user['user']['id'];
			}
			else
			{
				return '';
			}
		}	
	}

	if(!function_exists('redirect_is_login'))
	{
		function redirect_is_login()
		{
			$id = get_user_id();

			if(!$id)
			{
				redirect('auth');
			}
		}
	}

	if(!function_exists('random_string'))
	{
		function random_string($length = 10) {
		    $characters = '0123456789';
		    $charactersLength = strlen($characters);
		    $randomString = '';
		    for ($i = 0; $i < $length; $i++) {
		        $randomString .= $characters[rand(0, $charactersLength - 1)];
		    }
		    return $randomString;
		}
	}

	if(!function_exists('check_user'))
	{
		function check_user($credential)
		{
			global $CI;
			$CI->db->where('credential',$credential);
			return $CI->db->get('user')->row_array();
		}
	}

	if(!function_exists('sendmail'))
	{
		function sendmail($email)
		{
			$json = json_encode(array(
			    'From' => $email['from'],
			    'To' => $email['to'],
			    'Cc' => isset($email['cc'])?$email['cc']:'',
			    'Bcc' => isset($email['bcc'])?$email['bcc']:'',
			    'Subject' => $email['subject'],
			    'Tag' => isset($email['tag'])?$email['tag']:'',
			    'HtmlBody' => $email['html_body'],
			    'TextBody' => $email['text_body'],
			    'ReplyTo' => isset($email['reply_to'])?$email['reply_to']:'',
			    'Headers' => isset($email['headers'])?$email['headers']:'',
			    'Attachments' => isset($email['attachments'])?$email['attachments']:'',
			));

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'http://api.postmarkapp.com/email');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			    'Accept: application/json',
			    'Content-Type: application/json',
			    'X-Postmark-Server-Token: ' . POSTMARK_API_KEY
			));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
			$response = json_decode(curl_exec($ch), true);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
	
			return array("result" =>$http_code === 200);
		}
	}

	if(!function_exists('get_authorization'))
	{
		function get_authorization($header)
		{
			foreach ($header as $key => $value) {
				if(strtolower($key) == 'authorization')
				{
					return $value;
				}
			}

			return false;
		}
	}
?>