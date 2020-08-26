<?php 
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Categorymodel extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		function get_category($credential = false)
		{
			$user = check_user($credential);

			if($user)
			{
				$query = $this->db->get('category');
				return $query->result_array();	
			}
			else
			{
				return false;
			}
		}

		
	}
?>