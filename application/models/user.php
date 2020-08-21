<?php 

	class User extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		public function is_exist($data)
		{
			$query = 'Select * from user where ';
			if(isset($data['id']))
			{
				$query .= 'id != ' . $data['id'] . ' and (';
			}

			$query .= 'username = "' . $data['username'] . '" or email = "' . $data['email'] . '" or (phone_number = "' . $data['phone_number'] . '" and country = "' . $data['country'] . '")';

			if(isset($data['id']))
			{
				$query .= ')';
			}
			$query = $this->db->query($query);

			$user= $query->row_array();

			if($user && count($user) > 0)
			{
				if($user['username'] == $data['username'])
				{
					return array('success'=>false,'message'=>"The user that has same username is already exist");
				}
				else if($data['email'] == $user['email'])
				{
					return array('success'=>false,'message'=>'The user that has same email is already exist');
				}
				else if($data['country'] == $user['country'] && $data['phone_number'] == $user['phone_number'])
				{
					return array('success'=>false,'message'=>'The user that has same phone number is already exist');
				}	
			}
			else
			{
				return array('success'=>true);
			}
			
		}

		public function get_country($country = null)
		{
			if($country)
			{
				$this->db->where('code',$country);
			}

			$query = $this->db->get('countries');

			return $query->result_array();
		}

		public function add_user($user)
		{
			if(isset($user['id']))
			{
				$this->db->where('id',$user['id']);
				$this->db->update('user',$user);
			}
			else
			{
				$user['status'] = 'UNVERIFIED';
				$this->db->insert('user',$user);
			}
		}

		public function get_user($usertype = 'reader',$status = 'ACTIVE')
		{
			$query = 'Select user.*,countries.name as country_name from user,countries where user.user_type = "' . $usertype . '" and user.country = countries.code ';

			if($status != 'all')
			{
				$query .= ' and user.status = "' . $status . '"';
			}

			
			$result_query = $this->db->query($query);

			return $result_query->result_array();
		}

		public function set_active($id,$status)
		{
			$this->db->where('id',$id);
			$this->db->set('status',$status);
			$this->db->update('user');
		}

		public function delete($id)
		{
			$this->db->where('id',$id);
			$this->db->delete('user');
		}

		public function getuserbyid($id)
		{
			$this->db->where('id',$id);
			return $this->db->get('user')->row_array();
		}
	}
?>