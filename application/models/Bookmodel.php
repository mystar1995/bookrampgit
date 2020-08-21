<?php 
	class Bookmodel extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		function check_valid($content)
		{
			$profinity = get_setting('profanity');
			$profinity_array = preg_split("\n", $profinity);

			if(!$profanity)
			{
				return false;
			}

			foreach ($profinity_array as $key => $item) {
				if(str_contains($content,$item))
				{
					return $item;
				}
			}

			return false;
		}

		public function add($data)
		{
			$profanity = $this->check_valid($data['book_content']);
			if($profanity)
			{
				return array('success'=>false,'message'=>"Book Content has profanity word " . $profanity);
			}

			if(isset($data['id']))
			{
				$this->db->where('id',$data['id']);
				$user = get_logged_user();

				if($user && $user['user_type'] == 'writer')
				{
					$this->db->where('author',$user['id']);
				}

				if($data['status'] == 'PUBLISHED')
				{
					$datetime = new DateTime('now');
					$data['created_at'] = $datetime->format('Y-m-d H:i:s');
					$data['updated_at'] = $datetime->format('Y-m-d H:i:s');
				}

				$this->db->update('content',$data);
			}
			else
			{
				$data['author'] = get_user_id();
				if(!isset($data['status']))
				{
					$data['status'] = 'UNDERREVIEW';	
				}
				$this->db->insert('content',$data);

				$data['id'] =  $this->db->insert_id();
			}

			if($data['status'] == 'PUBLISHED')
			{
				$insert_data = array('content_id'=>$data['id'],'noty_type'=>'New','type'=>'books','visible'=>'all','sender_id'=>0,'user_id'=>$data['author']);
				$insert_data['comment'] = $data['title'] . " Book is published";
				add_notification($insert_data);
			}
			else if($data['status'] == 'UNDERREVIEW')
			{
				$this->db->where('id',$data['author']);
				$user = $this->db->get('user')->row_array();
				sendmail(
					array(
						'from'=>'Bookramp <info@veryhorse.com>',
						'to'=>get_setting('content_server_email'),
						'subject'=>"Book is submited",
						'text_body'=>$user['username'] . ' has submitted book ' . $data['title'],
						'html_body'=>''
					)
				);
			}

			return array('success'=>true,'contentid'=>$data['id']);
		}

		public function get($id)
		{
			$this->db->where('id',$id);
			$user = get_logged_user();

			if($user && $user['user_type'] == 'writer')
			{
				$this->db->where('author',$user['id']);
			}

			return $this->db->get('content')->row_array();
		}

		public function get_content_by_status($status)
		{
			$query = 'Select content.*, user.username as username,category.category as category_name from content,user,category where content.category = category.id and content.author = user.id and content.status = "' . $status . '"';

			$user = get_logged_user();

			if($user && $user['user_type'] == 'writer')
			{
				$query .= ' and user.id = ' . $user['id'];
			}
			return $this->db->query($query)->result_array();
		}

		public function changestatus($id,$status)
		{
			$this->db->where('id',$id);
			$this->db->set('status',$status);

			if($status == 'PUBLISHED')
			{
				$time = new DateTime('now');
				$this->db->set('created_at',$time->format('Y-m-d H:i:s'));
				$this->db->set('updated_at',$time->format('Y-m-d H:i:s'));
			}

			$user = get_logged_user();

			if($user && $user['user_type'] == 'writer')
			{
				$this->db->where('author',$user['id']);
			}

			$this->db->update('content');

			$this->db->where('id',$id);
			$data = $this->db->get('content')->row_array();
			if($status == 'PUBLISHED')
			{
				$insert_data = array('content_id'=>$data['id'],'noty_type'=>'New','type'=>'books','visible'=>'all','sender_id'=>0,'user_id'=>$data['author']);
				$insert_data['comment'] = $data['title'] . " Book is published";
				add_notification($insert_data);
			}
			else if($status == 'UNDERREVIEW')
			{
				$this->db->where('id',$data['author']);
				$user = $this->db->get('user')->row_array();
				if($user)
				{
					sendmail(
						array(
							'from'=>'Bookramp <info@veryhorse.com>',
							'to'=>"jws19950122@outlook.com",
							'subject'=>"Book is submited",
							'text_body'=>$user['username'] . ' has submitted book ' . $data['title'],
							'html_body'=>''
						)
					);	
				}
			}
		}

		public function delete($id)
		{
			$this->db->where('id',$id);

			$user = get_logged_user();

			if($user && $user['user_type'] == 'writer')
			{
				$this->db->where('author',$user['id']);
			}
			$this->db->delete('content');
		}

		public function update_content($content)
		{
			$profanity = $this->check_valid($content['book_content']);

			if($profanity)
			{
				return array('success'=>false,'message'=>'Book Content has profanity word ' . $profanity);
			}
			$this->db->where('id',$content['id']);

			$this->db->update('content',$content);

			return array('success'=>true);
		}	
	}

?>