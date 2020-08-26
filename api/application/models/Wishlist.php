<?php 
	
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Wishlist extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		function getwishitems($credentials)
		{
			$user = check_user($credentials);
			if($user)
			{
				$query = 'Select content.*, wishlist.*,user.username as authorName from wishlist,content,user where wishlist.content_id = content.id and wishlist.reader_id = ' . $user['id'] . ' and user.id = content.author';

				$contents = $this->db->query($query)->result_array();

				$ratings = $this->db->get('rating')->result_array();
				$rating_content = array();
				foreach ($ratings as $key => $rating) {
					if(!isset($rating_content[$rating['content_id']]))
					{
						$rating_content[$rating['content_id']] = array('rating'=>0,'review'=>0);
					}

					$rating_content[$rating['content_id']]['rating'] += $rating['rating'];
					$rating_content[$rating['content_id']]['review'] ++;
				}

				foreach ($contents as $key => $content) {
					$contents[$key]['rating'] = 0;
					$contents[$key]['review'] = 0;

					if(isset($rating_content[$content['id']]))
					{
						$contents[$key]['rating'] = $rating_content[$content['id']]['rating'];
						$contents[$key]['review'] = $rating_content[$content['id']]['review'];
					}
				}

				return $contents;
			}
			else
			{
				return false;
			}
		}

		function create_wishitems($contentid,$credentials)
		{
			$user = check_user($credentials);
			if($user)
			{
				$this->db->where('content',$contentid);
				$amountdata = $this->db->get('settlement')->row_array();

				$data = array(
					'content_id'=>$contentid,
					'reader_id'=>$user['id']
				);

				$this->db->insert('wishlist',$data);
				return true;

			}
			else
			{
				return false;
			}
		}

		function delete_wishitem($wishid,$credentials)
		{
			$user = check_user($credentials);
			if($user)
			{
				$this->db->where('content_id',$wishid);
				$this->db->where('reader_id',$user['id']);
				$this->db->delete('wishlist');
				return true;
			}
			else
			{
				return false;
			}
		}
	}
?>