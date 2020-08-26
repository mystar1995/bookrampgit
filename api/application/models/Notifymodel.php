<?php 
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Notifymodel extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		function get_notification($credential)
		{
			$user = check_user($credential);
			if($user['id'])
			{
				$query = 'Select * from notification where ((visible = "all" or visible = "' . $user['user_type'] . '") or user_id = ' . $user['id'] . ') and id Not in (select noti_id from notification_read where reader_id = ' . $user['id'] .')';
				
				
				$result =  $this->db->query($query)->result_array();

				$content = $this->db->get('content')->result_array();
				$user = $this->db->get('user')->result_array();

				$content_history = array();

				foreach ($content as $key => $contentitem) {
					$content_history[$contentitem['id']] = $contentitem;
				}

				$userhistory = array();
				foreach ($user as $key => $useritem) {
					$userhistory[$useritem['id']] = $useritem;
				}


				foreach ($result as $key => $item) {
					if($item['type'] == 'books' && isset($content_history[$item['content_id']]))
					{
						$result[$key]['image'] = $content_history[$item['content_id']]['cover_image'];
					}
					else if(isset($userhistory[$item['sender_id']]))
					{
						$result[$key]['image'] = $userhistory[$item['sender_id']]['profile_pic'];
					}
				}

				return $result;
			}
			else
			{
				return false;
			}
		}

		function read($notify_id,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$data = array(
					'reader_id'=>$user['id'],
					'noti_id'=>$notify_id
				);

				$this->db->insert('notification_read',$data);
				return true;
			}
			else
			{
				return false;
			}
		}
	}

?>