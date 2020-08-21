<?php 
	class Usermodel extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		public function is_exist($data,$credential = false)
		{
			$query = 'Select * from user where ';
			if($credential)
			{
				$query .= 'credential != "' . $credential . '" and (';
			}

			$query .= 'username = "' . $data['username'] . '" or email = "' . $data['email'] . '" or (phone_number = "' . $data['phone_number'] . '" and country = "' . $data['country'] . '")';

			if($credential)
			{
				$query .= ')';
			}
			$query = $this->db->query($query);



			$user= $query->row_array();

			if($user && count($user) > 0)
			{
				if($user['username'] == $data['username'])
				{
					return array('success'=>false,'message'=>"The user that has same username is already exist",'type'=>'username');
				}
				else if($data['email'] == $user['email'])
				{
					return array('success'=>false,'message'=>'The user that has same email is already exist','type'=>'email');
				}
				else if($data['country'] == $user['country'] && $data['phone_number'] == $user['phone_number'])
				{
					return array('success'=>false,'message'=>'The user that has same phone number is already exist','type'=>'phone_number');
				}	
			}
			else
			{
				return array('success'=>true);
			}
			
		}

		public function add_rewards($rewards,$credential = false)
		{
			$user = check_user($credential);
			if($user)
			{
				$this->db->where('id',$user['id']);
				$this->db->set("rewards","rewards + " . $rewards);
				$this->db->update('user');
				return true;
			}
			else
			{
				return false;
			}
		}

		public function switchuser($id)
		{
			$this->db->where('id',$id);
			$this->db->set('user_type',"writer");
			$this->db->update('user');
		}

		public function add_user($user,$credential = false)
		{
			if($credential)
			{
				$this->db->where('credential',$credential);
				$this->db->update('user',$user);
				return $this->get_user($credential);
			}
			else
			{
				$user['status'] = 'INACTIVE';
				$this->db->insert('user',$user);
			}
		}

		public function get_user($credential)
		{
			$this->db->where('credential',$credential);
			$query = $this->db->get('user');

			return $query->row_array();
		}

		public function delete_user($credential)
		{
			$this->db->where('credential',$credential);
			$this->db->delete('user');
		}

		public function login_user($user)
		{
			$query = $this->db->query('Select * from user where email = "' . $user['email'] . '"');
			$user_login = $query->row_array();

			if($user_login)
			{
				if($user_login['password'] == md5($user['password']))
				{
					if($user_login['status'] == 'INACTIVE')
					{
						return array('success'=>false,'phone'=>$user_login['phone_number']);
					}
					else if($user_login['status'] == 'REJECTED')
					{
						return array('success'=>false,'error'=>"Your Account is canceled By Admin");	
					}
					else
					{
						$time = time();
						$this->db->where('email',$user['email']);
						$this->db->set('credential',md5($time));
						$this->db->update('user');
						return array('success'=>true,'token'=>md5($time),'usertype'=>$user_login['user_type']);	
					}
					
				}
				else
				{
					return array('success'=>false,'error'=>'Password is not valid');
				}
			}
			else
			{
				return array('success'=>false,'error'=>'Email is not valid');
			}
		}

		public function setlang($userid,$lang)
		{
			$this->db->where('id',$userid);
			$this->db->set('language',$lang);
			$this->db->update('user');
		}

		public function create_rewards($contentid,$page,$userid)
		{
			$this->db->where('id',$contentid);
			$result = $this->db->get('content')->row_array();

			if($result)
			{
				$this->db->where('content_id',$result['id']);
				$this->db->where('user_id',$userid);
				$query_result = $this->db->get('rewards_history')->row_array();

				if(!$query_result)
				{
					$insert_data = array(
						'content_id'=>$contentid,
						'user_id'=>$userid,
						'comment'=>"Read " . $result['title'],
						'content_type'=>$result['content_file']?'books':'article',
						'page'=>$page,
						'type'=>'Earned',
						'rewards'=>get_setting('reward_points')
					);

					$this->db->insert('rewards_history',$insert_data);

					$this->db->query('update user set rewards = rewards + ' . get_setting('reward_points') . ' where id = ' . $userid);
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		public function verify($phone_number)
		{
			$this->db->where('phone_number',$phone_number);
			$result = $this->db->get('user')->row_array();
			if($result['status'] == 'INACTIVE')
			{
				$this->db->where('phone_number',$phone_number);
				
				if($result['user_type'] == 'writer')
				{
					$this->db->set('status','UNDERREVIEW');
				}
				else
				{	
					$this->db->set('status','ACTIVE');
				}

				$this->db->update('user');

				$time = time();
				$this->db->where('phone_number',$phone_number);
				$this->db->set('credential',md5($time));
				$this->db->update('user');
				return array('success'=>true,'token'=>md5($time),'usertype'=>$result['user_type']);	
			}
		}

		public function get_profile($id,$credential)
		{
			$user = $this->get_user($credential);
			
			if($user)
			{
				$this->db->where('id',$id);
				$author =  $this->db->get('user')->row_array();

				$query = $this->db->query('Select count(*) as review, sum(rating.author_rating) as totalrating from rating,content where rating.content_id = content.id and content.author = ' . $id);

				$rating_author = $query->row_array();

				if($rating_author)
				{
					$author['review'] = $rating_author['review'];
					if($rating_author['review'])
					{
						$author['rating'] = $rating_author['totalrating'] / $rating_author['review'];
					} 
					else
					{
						$author['rating'] = 0;
					}
				}
				else
				{
					$author['review'] = 0;
					$author['rating'] = 0;
				}

				return $author;
			}
			else
			{
				return array();
			}
		}

		public function logout($credential)
		{
			$user = $this->get_user($credential);

			if($user)
			{
				$this->db->where('credential',$credential);
				$this->db->set('credential','');
				$this->db->update('user');
				return true;
			}
			else
			{
				return false;
			}
		}

		public function get_user_by_phone($phone)
		{
			$this->db->where('phone_number',$phone);
			$user = $this->db->get('user')->row_array();
			return $user;
		}

		public function resetpassword($id,$password)
		{
			$time = time();
			$this->db->where('id',$id);
			$this->db->set('password',md5($password));
			$this->db->set('credential',md5($time));
			$this->db->update("user");

			return md5($time);
		}

		public function get_fanlist($credential)
		{
			$user = check_user($credential);
			if($user)
			{
				$query = "Select user.* from user,transaction,content where user.id = transaction.reader and transaction.content = content.id and content.author = " . $user['id'];
				$result = $this->db->query($query)->result_array();
				return $result;
			}
			else
			{
				return array();
			}
		}

		public function add_settlement($data,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$data['author'] = $user['id'];
				$data['status'] = "PENDING";

				$title = $user['username'] . ' have settled successfully';
				$body = $user['username'] . ' have settled ' . $data['amount'] . ' USD successfully';

				sendmail(
					array(
						'from'=>'Bookramp <info@veryhorse.com>',
						'to'=>get_setting('content_server_email'),
						'subject'=>$title,
						'text_body'=>$body,
						'html_body'=>''
					)
				);

 				$this->db->insert('settlement',$data);
				return true;
			}
			else
			{
				return false;
			}
		}

		public function get_settlement($credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$this->db->where('author',$user['id']);
				$query = $this->db->get('settlement');
				return $query->result_array();
			}
			else
			{
				return false;
			}
		}

		function get_earned_history($credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$query = "Select content.title as title,content.cover_image as cover_image, transaction.* from content,transaction where content.id = transaction.content and content.author = " . $user['id'];
				$result = $this->db->query($query)->result_array();

				return $result;
			}
			else
			{
				return false;
			}
		}
	}

?>