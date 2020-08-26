<?php 
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Contentmodel extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		function check_valid($content)
		{
			$profinity = get_setting('profanity');
			$profinity_array = preg_split("/\n/", $profinity);

			if(!$profinity)
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

		function getcontent($credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$query = 'Select content.*, user.username as authorName from content,user where content.author = user.id and content.status = "PUBLISHED" order by created_at DESC';
				$contents =  $this->db->query($query)->result_array();

				$age_group = explode('~', $user['age_group']);
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

				$content_array = array();

				foreach ($contents as $key => $content) {
					$content['rating'] = 0;
					$content['review'] = 0;

					$content_age = $content['age_group'];

					if(!$this->is_content_included($user,$content_age))
					{
						continue;
					}

					
					if(isset($rating_content[$content['id']]))
					{
						$content['review'] = $rating_content[$content['id']]['review'];
						$content['rating'] = $rating_content[$content['id']]['rating'] / $rating_content[$content['id']]['review'];
						
					}

					array_push($content_array,$content);
				}

				return $content_array;

			}
			else
			{
				return false;
			}
		}

		function getratings()
		{
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

			return $rating_content;
		}

		function get_continue_reading($credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$query = "Select bookmark.*,content.title as title, content.description as description,content.cover_image as cover_image, content.content_file as content_file, content.story from bookmark,content where bookmark.content_id = content.id and bookmark.reader_id = " . $user['id'] . ' order by bookmark.created_at DESC';
				$query = $this->db->query($query);

				return $query->result_array();
			}
			else
			{
				return false;
			}
		}

		function get_recently_added($credential)
		{	
			$user = check_user($credential);

			if($user)
			{
				$datenow = new DateTime('now');
				$datebirth = new DateTime($user['dob']);
				$age = $datenow->format('Y') - $datebirth->format('Y');
				$query = "select * from content where status = 'PUBLISHED' and age_group <= " . $age . " order by created_at DESC limit 5";
				return $this->db->query($query)->result_array();
			}
			else
			{
				return false;
			}
		}

		function content_search($search,$category,$credential)
		{
			$user = check_user($credential);
			if($user)
			{	
				$age_group = explode('~', $user['age_group']);
				$query = 'Select content.*,user.username as authorName from content,user where content.title like "%' . $search . '%" and content.status = "PUBLISHED" and content.author = user.id';
				if($category)
				{
					$query .= " and content.category = " . $category;
				}

				$query .= ' order by content.updated_at DESC';
				$contents = $this->db->query($query)->result_array();

				$ratings = $this->getratings();

				$content_array = array();
				foreach ($contents as $key => $content) {
					$content['rating'] = 0;
					$content['review'] = 0;

					$content_age = $content['age_group'];

					if(!$this->is_content_included($user,$content_age))
					{
						continue;
					}


					if(isset($ratings[$content['id']]))
					{
						$content['review'] = $ratings[$content['id']]['review'];
						$content['rating'] = $ratings[$content['id']]['rating']/$ratings[$content['id']]['review'];
						
					}

					array_push($content_array,$content);
					
				}
				return $content_array;
			}
			else
			{
				return false;	
			}
		}

		function createreward($content,$user)
		{
			$this->db->where('content_id',$content['id']);
			$this->db->where('reader_id',$user['id']);
			$result = $this->db->get('reader_history')->row_array();

			if(!$result)
			{
				$author = $this->db->query('Select * from user where id = ' . $content['author'])->row_array();

				if($author)
				{
					$this->db->query('update user set point = point + 1 where id = ' . $author['id']);	
				}
				
				$this->db->query('update content set point = point + 1 where id = ' . $content['id']);

				$read = array('reader_id'=>$user['id'],'content_id'=>$content['id']);
				$transaction = array('reader'=>$user['id'],'content'=>$content['id'],'status'=>'APPROVED','amount'=>0,'rewards'=>0);
				$this->db->insert('reader_history',$read);

				$this->db->where('content',$content['id']);
				$this->db->where('reader',$user['id']);

				if(!$this->db->get('transaction')->row_array())
				{
					$this->db->insert('transaction',$transaction);
				}
			}
			
		}

		function get_content_by_id($id,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				
				$this->db->where('id',$id);
				$content =  $this->db->get('content')->row_array();
				if($content)
				{
					$this->db->where('content',$id);
					$settle = $this->db->get('settlement')->row_array();
					$content['amount'] = get_setting('content_price');
					$rating = $this->db->query('Select sum(rating) as rating,count(*) as review from rating where content_id = ' . $id)->row_array();
					$this->db->where('id',$content['author']);
					$author = $this->db->get('user')->row_array();
					$content['authorName'] = $author['username'];
					$content['rating'] = 0; $content['review'] = 0;

					if($rating)
					{
						$content['review'] = $rating['review'];
						$content['rating'] = $content['review'] == 0?0:$rating['rating']/$content['review'];
					}

					return $content;
				}

				return $content;
			}
			else
			{
				return false;
			}
		}

		function new_content($data,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$profinity = $this->check_valid($data['book_content']);
				if($profinity)
				{
					return array('success'=>false,'message'=>'Book Content has profanity word ' . $profinity);
				}

				if($user['usertype'] == 'writer')
				{
					$data['author'] = $user['id'];

					if($data['status'] == 'UNDERREVIEW')
					{
						$emaildata = array(
							'from' 		=>	'Bookramp <info@veryhorse.com>',
							"to" 		=>	get_setting('content_server_email'),
							'subject'	=>	'New Book is submitted',
							"html_body"	=>	'',
							'text_body'	=>	$user['username'] . ' has submitted new books with title ' . $data['title']
						);

						sendmail($emaildata);
					}
					
					$this->db->insert('content',$data);
					return array('success'=>true);
				}
				else
				{
					return array('success'=>false,'message'=>'User is not writer');
				}
			}
			else
			{
				return array('success'=>false,'message'=>'Authentication Error');
			}
		}

		function update_content($data,$contentid,$credential)
		{
			$user = check_user($credential);
			if($user && $user['usertype'] == 'writer')
			{
				$profinity = $this->check_valid($data['book_content']);
				if($profinity)
				{
					return array('success'=>false,'message'=>'Book Content has profanity word ' . $profinity);
				}

				$this->db->where('id',$contentid);

				if($data['status'] == 'UNDERREVIEW')
				{
					$emaildata = array(
						'from' 		=>	'Bookramp <info@veryhorse.com>',
						"to" 		=>	get_setting('content_server_email'),
						'subject'	=>	'New Book is submitted',
						"html_body"	=>	'',
						'text_body'	=>	$user['username'] . ' has submitted new books with title ' . $data['title']
					);

					sendmail($emaildata);
				}
				$this->db->update('content',$data);
				return array('success'=>true);
			}
			else
			{
				return array('success'=>false,'message'=>'Authentication Error');
			}
		}

		function get_content_by_user($status,$credential)
		{
			$user = check_user($credential);

			if($user && $user['usertype'] == 'writer')
			{
				$this->db->where('status',$status);
				$this->db->where('author',$user['id']);
				return $this->db->get('content')->result_array();
			}
			else
			{
				return false;
			}
		}

		function get_categories()
		{
			$categories = $this->db->get('category')->result_array();

			$categorylist = array();
			foreach ($categories as $key => $category) {
				$categorylist[$category['id']] = $category['category'];
			}

			return $categorylist;
		}

		function get_content_by_userid($userid,$credential)
		{
			$user = check_user($credential);
			if($user)
			{
				$query = 'Select content.*, user.username as username from content,user where content.author = user.id and content.author = ' . $userid . ' order by content.created_at DESC';
				$contents = $this->db->query($query)->result_array();
				$ratings = $this->getratings();
				$categories = $this->get_categories();
				foreach ($contents as $key => $content) {
					$contents[$key]['categoryname'] = $categories[$content['category']];
					if(isset($ratings[$content['id']]))
					{
						$contents[$key]['review'] = $ratings[$content['id']]['review'];
						$contents[$key]['rating'] = $ratings[$content['id']]['rating'] / $ratings[$content['id']]['review'];
					}
					else
					{
						$contents[$key]['review'] = 0;
						$contents[$key]['rating'] = 0;	
					}
				}

				return $contents;
			}
			else
			{
				return false;
			}
		}

		function get_content_by_category($category,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$datenow = new DateTime('now');
				$datebirth = new DateTime($user['dob']);
				$age = $datenow->format('Y') - $datebirth->format('Y');

				$this->db->where('category',$category);
				$this->db->where('status','PUBLISHED');
				$this->db->where('age_group <= ',$age);
				$contents = $this->db->get('content')->result_array();
				$ratings = $this->getratings();
				$categories = $this->get_categories();
				foreach ($contents as $key => $content) {
					$contents[$key]['categoryname'] = $categories[$content['category']];
					if(isset($ratings[$content['id']]))
					{
						$contents[$key]['review'] = $ratings[$content['id']]['review'];
						$contents[$key]['rating'] = $ratings[$content['id']]['rating'] / $ratings[$content['id']]['review'];
					}
					else
					{
						$contents[$key]['review'] = 0;
						$contents[$key]['rating'] = 0;	
					}
				}

				return $contents;

			}
			else
			{
				return false;
			}

		}

		function get_download_content($credential)
		{
			$user = check_user($credential);

			if($user && $user['user_type'] == 'writer')
			{
				$datenow = new DateTime('now');
				$datebirth = new DateTime($user['dob']);
				$age = $datenow->format('Y') - $datebirth->format('Y');
				$query = 'Select content.* from content,transaction where content.id = transaction.content and content.author = ' . $user['id'] . ' and transaction.status = "APPROVED"  group by content.id  order by transaction.created_at DESC';
				$contents =  $this->db->query($query)->result_array();

				$rating= $this->getratings();
				$categories = $this->get_categories();
				foreach ($contents as $key => $content) {
					$contents[$key]['categoryname'] = $categories[$content['category']];
					if(isset($ratings[$content['id']]))
					{
						$contents[$key]['review'] = $ratings[$content['id']]['review'];
						$contents[$key]['rating'] = $ratings[$content['id']]['rating'] / $ratings[$content['id']]['review'];
					}
					else
					{
						$contents[$key]['review'] = 0;
						$contents[$key]['rating'] = 0;	
					}
				}

				return $contents;
			}
			else
			{
				return false;
			}
		}

		function get_sold_content($credential)
		{
			$user = check_user($credential);

			if($user && $user['user_type'] == 'writer')
			{
				$datenow = new DateTime('now');
				$datebirth = new DateTime($user['dob']);
				$age = $datenow->format('Y') - $datebirth->format('Y');
				$query = 'Select content.* from content,transaction where content.id = transaction.content and content.author = ' . $user['id'] . ' and transaction.status = "APPROVED" and transaction.rewards > 0 group by content.id  order by transaction.created_at DESC';
				$contents =  $this->db->query($query)->result_array();

				$rating= $this->getratings();
				$categories = $this->get_categories();
				foreach ($contents as $key => $content) {
					$contents[$key]['categoryname'] = $categories[$content['category']];
					if(isset($ratings[$content['id']]))
					{
						$contents[$key]['review'] = $ratings[$content['id']]['review'];
						$contents[$key]['rating'] = $ratings[$content['id']]['rating'] / $ratings[$content['id']]['review'];
					}
					else
					{
						$contents[$key]['review'] = 0;
						$contents[$key]['rating'] = 0;	
					}
				}

				return $contents;
			}
			else
			{
				return false;
			}
		}

		public function best_sellers($credential)
		{
			$user = check_user($credential);
			if($user)
			{
				$date_birth = new DateTime($user['dob']);
				$date_now = new DateTime('now');

				$age = $date_now->format('Y') - $date_birth->format('Y');
				$query = 'Select sum(rating.rating) as rating,content.* from rating,content where rating.content_id = content.id and content.age_group <= ' . $age . ' group by rating.content_id';
				$query = $this->db->query($query);
				return $query->result_array();

			}
			else
			{
				return false;
			}
		}

		public function top_writers($credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$date_birth = new DateTime($user['dob']);
				$date_now = new DateTime('now');

				$age = $date_now->format('Y') - $date_birth->format('Y');
				$query = 'Select content.*,rating.rating as rating from rating,content where rating.content_id = content.id and content.age_group <= ' .$age . ' group by rating.content_id';
				return $this->db->query($query)->result_array();
			}
			else
			{
				return false;
			}
		}

		function get_my_books($credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$query = "select content.* from content,reader_history where reader_history.content_id = content.id and content.author = " . $user['id'] . ' order by content.created_at DESC' ;

				$contents = $this->db->query($query)->result_array();

				$ratings = $this->getratings();

				foreach ($contents as $key => $content) {
					$contents[$key]['review'] = isset($ratings[$content['id']]['review'])?$ratings[$content['id']]['review']:0;
					$contents[$key]['rating'] = ($contents[$key]['review'] && isset($ratings[$content['id']]['rating']))?$ratings[$content['id']]['rating']/$contents[$key]['review']:0;
				}

				return $contents;
			}
			else
			{
				return false;
			}
		}

		function get_purchase_content($credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$query = 'select content.* from content,transaction where content.id = transaction.content and transaction.status = "APPROVED" and transaction.reader = ' . $user['id'] . ' order by transaction.created_at DESC';

				$contents = $this->db->query($query)->result_array();

				$ratings = $this->getratings();

				foreach ($contents as $key => $content) {
					$contents[$key]['review'] = isset($ratings[$content['id']]['review'])?$ratings[$content['id']]['review']:0;
					$contents[$key]['rating'] = ($contents[$key]['review'] && isset($ratings[$content['id']]['rating']))?$ratings[$content['id']]['rating']/$contents[$key]['review']:0;	
				}

				return $contents;
			}
			else
			{
				return false;
			}
		}

		function create_book_mark($data,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$data['reader_id'] = $user['id'];

				$this->db->where('reader_id',$user['id']);
				$this->db->where('content_id',$data['content_id']);
				$this->db->where('page',$data['page']);

				$bookmark = $this->db->get('bookmark')->row_array();

				if($bookmark)
				{
					$this->db->where('id',$bookmark['id']);
					$this->db->delete('bookmark');
				}
				else
				{
					$this->db->insert('bookmark',$data);
				}

				
				return true;
			}
			else
			{
				return false;
			}
		}

		function deletebookmark($contentid,$page,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$this->db->where('content_id',$contentid);
				$this->db->where('reader_id',$user['id']);
				$this->db->where('page',$page);

				$this->db->delete('bookmark');
				return true;
			}
			else
			{
				return false;
			}
		}

		function get_recommended_books($credential)
		{

			$user = check_user($credential);

			if(!$user)
			{
				return false;
			}

			$date_birth = new DateTime($user['dob']);
			$date_now = new DateTime('now');

			$age = $date_now->format('Y') - $date_birth->format('Y');

			$query = 'Select content.*,user.username as authorName from content,user where content.author = user.id and content.recommended = 1 and content.status = "PUBLISHED" and content.age_group <= ' . $age . ' order by content.created_at DESC';
			$contents = $this->db->query($query)->result_array();

			$ratings = $this->getratings();

			foreach ($contents as $key => $content) {
				$contents[$key]['review'] = isset($ratings[$content['id']]['review'])?$ratings[$content['id']]['review']:0;
				$contents[$key]['rating'] = ($contents[$key]['review'] && isset($ratings[$content['id']]['rating']))?$ratings[$content['id']]['rating']/$contents[$key]['review']:0;
			}

			return $contents;
		}

		function get_book_mark($credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$query = "Select bookmark.*, content.language as language,content.title as title,content.cover_image as cover_image,content.author as author_id, user.username as authorName from bookmark,content,user where bookmark.content_id = content.id and content.author = user.id and bookmark.reader_id = " . $user['id'] .' order by bookmark.created_at DESC';

				$contents = $this->db->query($query)->result_array();

				$ratings = $this->getratings();

				foreach($contents as $key =>$content)
				{
					if(isset($ratings[$content['content_id']]))
					{
						$contents[$key]['review'] = $ratings[$content['content_id']]['review'];
						$contents[$key]['rating'] = $ratings[$content['content_id']]['rating'] / $ratings[$content['content_id']]['review'];
					}
					else
					{
						$contents[$key]['review'] = 0;
						$contents[$key]['rating'] = 0;	
					}
				}

				return $contents;
			}
			else
			{
				return false;
			}
		}

		function add($data,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$data['status'] = isset($data['status'])?$data['status']:'UNDERREVIEW';

				$profanity = $this->check_valid($data['book_content']);
				if($profanity)
				{
					return array('success'=>false,'message'=>'Book Content has profanity word ' . $profanity);
				}

				if(isset($data['id']))
				{
					$this->db->where('id',$data['id']);
					$this->db->update('content',$data);
				}
				else
				{
					$data['author'] = $user['id'];
					$this->db->insert('content',$data);
				}

				return array('success'=>true);
			}
			else
			{
				return false;
			}	
			
		}

		function create_payment($data,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$data['reader'] = $user['id'];
				$data['amount'] = get_setting('purchase_points') * $data['rewards'] / 100;

				$this->db->insert('transaction',$data);

				if($data['rewards'] > 0)
				{
					$query = 'update user set rewards = rewards - ' . $data['rewards'] . ' where id = ' . $user['id'];
					$this->db->query($query);
					$this->db->where('id',$data['content']);
					$content = $this->db->get('content')->row_array();

					if($content)
					{
						$query = 'update user set balance = balance + ' . $data['rewards'] . ' where id = '  . $content['author'];
						$this->db->query($query);
					}
				}

				$this->db->where('id',$data['content']);
				$content = $this->db->get('content')->row_array();

				$history = array('content_id'=>$data['content'],'user_id'=>$user['id'],'comment'=>'Buy ' . $content['title'],'type'=>'Burned');

				$this->db->insert('rewards_history',$history);

				return true;
			}
			else
			{
				return false;
			}
		}

		function get_content_by_status($status,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$this->db->where('status',$status);
				$this->db->where('author',$user['id']);
				return $this->db->get('content')->result_array();
			}
			else
			{
				return false;
			}
		}

		function get_free_books($id)
		{
			$this->db->where('id',$id);
			$content = $this->db->get('content')->row_array();

			$this->db->where('category',$content['category']);
			$this->db->where('status','PUBLISHED');
			$related = $this->db->get('content')->result_array();

			$ratings = $this->getratings();

			$this->db->where('id',$content['author']);
			$user = $this->db->get('user')->row_array();

			if(isset($ratings[$content['id']]))
			{
				$content['review'] = $ratings[$content['id']]['review'];
				$content['rating'] = $ratings[$content['id']]['rating'	] / $ratings[$content['id']]['review'];
			}
			else
			{
				$content['review'] = 0;
				$content['rating'] = 0;
			}

			foreach ($related as $key => $item) {
				if(isset($ratings[$item['id']]))
				{
					$related[$key]['review'] = $ratings[$item['id']]['review'];
					$related[$key]['rating'] = $ratings[$item['id']]['rating'] / $ratings[$item['id']]['review'];
				}
				else
				{
					$related[$key]['review'] = 0;
					$related[$key]['rating'] = 0;	
				}
			}

			$content['author'] = $user;

			$content['related'] = $related;

			return $content;
		}

		function get_rewards($credential)
		{
			$user = check_user($credential);
			$this->db->where('user_id',$user['id']);
			return $this->db->get('rewards_history')->result_array();
		}

		function get_draft_by_id($id)
		{
			$this->db->where('id',$id);
			$query = $this->db->get('content');
			return $query->row_array();
		}

		function delete($id,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$this->db->where('author',$user['id']);
				$this->db->where('id',$id);
				$this->db->delete('content');
			}
			else
			{
				return false;
			}
		}

		function get_config()
		{
			$data = array(
				'content_service_number'=>get_setting('content_service_number'),
				'purchase_points'=>get_setting('purchase_points'),
				'point_cents'=>get_setting('point_cents'),
				'terms_condition'=>get_setting('terms_condition'),
				'how_to_use'=>get_setting('how_to_use'),
				'faqs'=>get_setting('faqs'),
				'content_server_email'=>get_setting('content_server_email'),
				'pofanity'=>get_setting('pofanity')
			);

			return $data;
		}

		function search_key($key)
		{
			$query = $this->db->query('Select * from available_keywords where keywords like "%' . $key . '%"');
			return $query->result_array();
		}

		function get_keywords_for_user($credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$query = $this->db->query('Select keywords.*,available_keywords.keywords as text from keywords,available_keywords where keywords.keyword = available_keywords.id and keywords.user_id = ' . $user['id']);
				$result = $query->result_array();	
				return $result;
			}
			else
			{
				return false;
			}

		}

		function add_keywords($text,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$this->db->where('keywords',$text);
				$keywords = $this->db->get('available_keywords')->row_array();

				$id = null;
				if($keywords)
				{
					$id = $keywords['id'];
				}
				else
				{
					$data = array(
						'keywords'=>$text
					);

					$this->db->insert('available_keywords',$data);

					$id = $this->db->insert_id();
				}

				$this->db->where('keyword',$id);
				$this->db->where('user_id',$user['id']);

				$query_check = $this->db->get('keywords');

				if($query_check->row_array())
				{
					return false;
				}

				$data = array(
					'keyword'=>$id,
					'user_id'=>$user['id']
				);

				$this->db->insert('keywords',$data);
				return true;
			}
			else
			{
				return false;
			}
		}

		function delete_keywords($id,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$this->db->where('id',$id);
				$this->db->where('user_id',$user['id']);
				$this->db->delete('keywords');
				return true;
			}
			else
			{
				return false;
			}
		}

		function update_keywords($updateid,$text,$credential)
		{
			$user = check_user($credential);

			if($user)
			{
				$this->db->where('keywords',$text);
				$keywords = $this->db->get('available_keywords')->row_array();

				$id = null;
				if($keywords)
				{
					$id = $keywords['id'];
				}
				else
				{
					$data = array(
						'keywords'=>$text
					);

					$this->db->insert('available_keywords',$data);

					$id = $this->db->insert_id();
				}

				$this->db->where('keyword',$id);
				$this->db->where('user_id',$user['id']);

				$query_check = $this->db->get('keywords');

				if($query_check->row_array())
				{
					return false;
				}

				$data = array(
					'keyword'=>$id,
					'user_id'=>$user['id']
				);

				$this->db->where('id',$updateid);
				$this->db->update('keywords',$data);
				return true;
			}
			else
			{
				return false;
			}
		}

		function is_content_included($user,$agecontent)
		{
			//$age_list = explode('-', $agegroup);

			$date = new DateTime($user['dob']);
			$datenow = new DateTime('now');

			$dobyear = $date->format('Y');

			$date_year = $datenow->format('Y');
			
			$age = $date_year - $dobyear;
			

			if($age >= $agecontent)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		function search_content_with_key($keyword,$credential)
		{
			$user = check_user($credential);

			if(!$user)
			{
				return array();
			}


			$keywordlist = array(); $contentid = array();

			$keywordsearch = array();
			foreach ($keyword as $key => $value) {
				array_push($keywordsearch, 'title like "%' . $value . '%"');
			}

			$query = 'Select * from content where (' . join(' or ',$keywordsearch) . ') and status = "PUBLISHED" order by created_at DESC';
			$contents = $this->db->query($query)->result_array();

			$keywordlist = array();

			foreach ($contents as $content) {
				$agecontent = $content['age_group'];

				if($this->is_content_included($user,$agecontent))
				{
					array_push($keywordlist, $content);
				}
				
			}

			$ratings = $this->getratings();
			$categories = $this->get_categories();
			foreach ($keywordlist as $key => $content) {
				$keywordlist[$key]['categoryname'] = $categories[$content['category']];
				if(isset($ratings[$content['id']]))
				{
					$keywordlist[$key]['review'] = $ratings[$content['id']]['review'];
					$keywordlist[$key]['rating'] = $ratings[$content['id']]['rating'] / $ratings[$content['id']]['review'];
				}
				else
				{
					$keywordlist[$key]['review'] = 0;
					$keywordlist[$key]['rating'] = 0;	
				}
			}

			return $keywordlist;
		}	
	}

?>