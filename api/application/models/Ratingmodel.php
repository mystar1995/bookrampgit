<?php 
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Ratingmodel extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		function get_content_rating($contentid,$credential)
		{
			$query = "Select rating.*,user.* from rating,content,user where rating.content_id = content.id and content.id = " . $contentid . ' and user.id = rating.reader';
			$user = check_user($credential);

			if($user)
			{
				$query = $this->db->query($query);
				return $query->result_array();
			}
			else
			{
				return false;
			}
		}

		function newrating($rating,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$rating['reader'] = $user['id'];

				$this->db->where('content_id',$rating['content_id']);
				$this->db->where('reader',$user['id']);

				if(!$this->db->get('rating')->row_array())
				{
					$this->db->insert('rating',$rating);
					$this->db->where('content_id',$rating['content_id']);

					$content = $this->db->get('content')->row_array();

					if($content)
					{
						$this->db->query('update user set rewards = rewards + ' . $rating['rating'] . ' where id = ' . $content['author']);	
					}
				}
				
				return true;
			}
			else
			{
				return false;
			}
		}

		function authorrating($authorid,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$this->db->where('author_id',$authorid);
				return $this->db->get('authorrating')->result_array();
			}
			else
			{
				return false;
			}
		}

		function create_new_author_rating($rating,$credential)
		{
			$user = check_user($credential);
			if($user)
			{
				$rating['reader'] = $user['id'];
				$this->db->insert('authorrating',$rating);
			}
			else
			{
				return false;
			}
		}	
	}
?>