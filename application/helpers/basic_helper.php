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
				$query = $CI->db->query($query);
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

	if(!function_exists('get_logged_user'))
	{
		function get_logged_user()
		{
			global $CI;
			$user = $CI->session->get_userdata('user');

			if(isset($user['user']))
			{
				return $user['user'];	
			}
			else
			{
				return false;
			}
		}
	}

	if(!function_exists('redirect_is_login'))
	{
		function redirect_is_login()
		{
			global $CI;
			$id = get_user_id();

			$user = get_logged_user();

			if($user && $user['user_type'] == 'sub_admin' || $user['user_type'] == 'writer')
			{
				$routename = $CI->uri->segment(1);

				$routename2 = $CI->uri->segment(2);
				$routename3 = $CI->uri->segment(3);

				if($routename == 'reader' && $routename2 == 'add' && $routename3 == get_user_id())
				{
					return;
				}
				else if($routename == 'payments' && $routename != 'reader' && $user['user_type'] == 'writer')
				{
					redirect('books/published');
				}
				else if($routename != 'books')
				{
					redirect('/books/published');
				}
			}

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

	if(!function_exists('add_notification'))
	{
		function add_notification($data)
		{
			global $CI;
			$CI->db->insert('notification',$data);
		}
	}

	if(!function_exists('display_header'))
	{
		function display_header()
		{
			$user = get_logged_user();

			if($user && $user['user_type'] == 'sub_admin')
			{
				echo '
					<li class="pcoded-hasmenu">
						<a href="javascript:void(0)" class="waves-effect waves-dark">
							<span class="pcoded-micon"><i class="feather icon-book"></i></span>
							<span class="pcoded-mtext">Books</span>
						</a>
						<ul class="pcoded-submenu">
							<li class="">
								<a href="' . base_url() . 'books/published" class="waves-effect waves-dark">
									<span class="pcoded-mtext">Published</span>
								</a>
							</li>
							<li class="">
								<a href="' . base_url() . 'books/under_review" class="waves-effect waves-dark">
									<span class="pcoded-mtext">Under Review</span>
								</a>
							</li>
							<li class="">
								<a href="' . base_url() . 'books/rejected" class="waves-effect waves-dark">
									<span class="pcoded-mtext">Rejected</span>
								</a>
							</li>
						</ul>
					</li>
				';
			}
			else if($user && $user['user_type'] == 'writer')
			{
				$content =  '
					<li class="pcoded-hasmenu">
						<a href="javascript:void(0)" class="waves-effect waves-dark">
							<span class="pcoded-micon"><i class="feather icon-book"></i></span>
							<span class="pcoded-mtext">Books</span>
						</a>
						<ul class="pcoded-submenu">
							<li class="">
								<a href="' . base_url() . 'books/published" class="waves-effect waves-dark">
									<span class="pcoded-mtext">Published</span>
								</a>
							</li>
							<li class="">
								<a href="' . base_url() . 'books/under_review" class="waves-effect waves-dark">
									<span class="pcoded-mtext">Under Review</span>
								</a>
							</li>
							<li class="">
								<a href="' . base_url() . 'books/rejected" class="waves-effect waves-dark">
									<span class="pcoded-mtext">Rejected</span>
								</a>
							</li>
							<li class="">
								<a href="' . base_url() . 'books/draft" class="waves-effect waves-dark">
									<span class="pcoded-mtext">DRAFT</span>
								</a>
							</li>
							<li class="">
								<a href="' . base_url() . 'payments/reader" class="waves-effect waves-dark">
									<span class="pcoded-mtext">Payments</span>
								</a>
							</li>
						</ul>
					</li>
				';
				echo $content;
			}
			else if($user)
			{
				echo '
					<li class="pcoded-hasmenu active pcoded-trigger">
						<a href="' . base_url() . '" class="waves-effect waves-dark">
							<span class="pcoded-micon"><i class="feather icon-home"></i></span>
							<span class="pcoded-mtext">Dashboard</span>
						</a>
					</li>
					<li class="pcoded-hasmenu pcoded-trigger">
						<a href="' . base_url() . 'reader" class="waves-effect waves-dark">
							<span class="pcoded-micon"><i class="feather icon-user"></i></span>
							<span class="pcoded-mtext">Reader</span>
						</a>
					</li>
					<li class="pcoded-hasmenu pcoded-trigger">
						<a href="' . base_url() . 'writer" class="waves-effect waves-dark">
							<span class="pcoded-micon"><i class="feather icon-user"></i></span>
							<span class="pcoded-mtext">Writer</span>
						</a>
					</li>
					<li class="pcoded-hasmenu  pcoded-trigger">
						<a href="' . base_url() . 'category" class="waves-effect waves-dark">
							<span class="pcoded-micon"><i class="feather icon-codepen"></i></span>
							<span class="pcoded-mtext">Categories</span>
						</a>
					</li>
					<li class="pcoded-hasmenu">
						<a href="javascript:void(0)" class="waves-effect waves-dark">
							<span class="pcoded-micon"><i class="feather icon-book"></i></span>
							<span class="pcoded-mtext">Books</span>
						</a>
						<ul class="pcoded-submenu">
							<li class="">
								<a href="' . base_url() . 'books/published" class="waves-effect waves-dark">
									<span class="pcoded-mtext">Published</span>
								</a>
							</li>
							<li class="">
								<a href="' . base_url() . 'books/under_review" class="waves-effect waves-dark">
									<span class="pcoded-mtext">Under Review</span>
								</a>
							</li>
							<li class="">
								<a href="' . base_url() . 'books/rejected" class="waves-effect waves-dark">
									<span class="pcoded-mtext">Rejected</span>
								</a>
							</li>
						</ul>
					</li>
					<li class="pcoded-hasmenu">
						<a href="javascript:void(0)" class="waves-effect waves-dark">
							<span class="pcoded-micon"><i class="feather icon-shopping-cart"></i></span>
							<span class="pcoded-mtext">Payments</span>
						</a>
						<ul class="pcoded-submenu">
							<li class="">
								<a href="' . base_url() . 'payments/reader" class="waves-effect waves-dark">
									<span class="pcoded-mtext">Reader\'s payments</span>
								</a>
							</li>
							<li class="">
								<a href="' . base_url() . 'payments/writer" class="waves-effect waves-dark">
									<span class="pcoded-mtext">Writer\'s Settle Payments</span>
								</a>
							</li>
						</ul>
					</li>
					<li class="pcoded-hasmenu">
						<a href="' . base_url() . 'settings" class="waves-effect waves-dark">
							<span class="pcoded-micon"><i class="feather icon-settings"></i></span>
							<span class="pcoded-mtext">Setting</span>
						</a>
					</li>
					<li class="pcoded-hasmenu">
						<a href="' . base_url() . 'profanity" class="waves-effect waves-dark">
							<span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
							<span class="pcoded-mtext">Profanity Screening</span>
						</a>
					</li>
				';
			}
			
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
			
			var_dump($response);
			var_dump($http_code);
			return array("result" =>$http_code === 200);
		}
	}
?>