<?php 
	
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Writermodel extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		function get_home_data($credential)
		{
			$user = check_user($credential);
			if($user)
			{
				$this->db->where('author',$user['id']);
				$this->db->where('status','PUBLISHED');
				$published = $this->db->get('content')->result_array();

				$this->db->where('author',$user['id']);
				$this->db->where('status','DRAFT');
				$draft = $this->db->get('content')->result_array();

				$query = 'Select content.* from content,rating where content.id = rating.content_id and content.author = ' . $user['id'] . ' and content.status = "PUBLISHED" group by content.id';
				$rating_content = $this->db->query($query)->result_array();

				$sold_query = 'Select content.*,count(transaction.content) as count from content,transaction where content.id = transaction.content and transaction.rewards > 0 and content.author = ' . $user['id'] . ' group by transaction.content order by count DESC';
				$sold_content = $this->db->query($sold_query)->result_array();

				$download_query = 'Select content.*,count(transaction.content) as count from content,transaction where content.id = transaction.content and content.author = ' . $user['id'] . ' group by transaction.content order by count DESC';

				if(count($sold_content) > 0 && !$sold_content[0]['id'])
				{
					$sold_content = [];
				}

				return array('published'=>$published,'draft'=>$draft,'rating'=>$rating_content,'sold'=>$sold_content);
			}
			else
			{
				return false;
			}
		}
	}

?>