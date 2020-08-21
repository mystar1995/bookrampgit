<?php 
	class Authmodel extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		public function get_user($user_login)
		{
			$user_login['password'] = md5($user_login['password']);
			$query = 'Select * from user where email = "' . $user_login['email'] . '"';

			$user = $this->db->query($query)->row_array();

			if(!$user)
			{
				return array('success'=>false,'message'=>'User Email is not correct');
			}
			else
			{
				if($user['password'] == $user_login['password'])
				{
					return array('success'=>true,'user'=>$user);
				}
				else
				{
					return array('success'=>false,'message'=>'Password does not match');
				}
			}
		}
	}
?>