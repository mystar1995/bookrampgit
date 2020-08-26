<?php 
	
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Bookmark extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		function create_bookmark($data,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$data['reader_id'] = $user['id'];
				$this->db->insert('wishlist',$data);
				return true;
			}
			else
			{
				return false;
			}
		}

		function get_bookmark($credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$query = $this->db->query('Select bookmark.*, content.* from bookmark,content where bookmark.content_id = content.id and bookmark.reader_id = ' . $user['id']);
				return $query->result_array();
			}
			else
			{
				return false;
			}
		}

		function delete_bookmark($id,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$this->db->where('id',$id);
				$this->db->where('reader_id',$user['id']);
				$this->db->delete('bookmark');
				return true;
			}
			else
			{
				return false;
			}
		}

		function rewards_earned($credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$this->db->where('reader',$user['id']);
				$this->db->select('sum(rewards)');
				$this->db->get('transactions');
			}
			else
			{
				return false;
			}
		}


	}

?>