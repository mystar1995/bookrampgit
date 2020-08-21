<?php 
	

	class Content extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('contentmodel');
			$this->load->model('categorymodel');
			$this->load->model('notifymodel');
		}

		
		
		function index()
		{
			$header = $this->input->request_headers();
			$content = $this->contentmodel->getcontent(get_authorization($header));

			if($content)
			{
				echo json_encode(array('success'=>true,'data'=>$content));	
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function search()
		{
			$header = $this->input->request_headers();
			$search = $this->input->get('query');
			$category = $this->input->get('category');
			$result = $this->contentmodel->content_search($search,$category,get_authorization($header));
			if($result)
			{
				echo json_encode(array('success'=>true,'data'=>$result));	
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
			
		}

		function get_rewards()
		{
			$header = $this->input->request_headers();

			if(get_authorization($header))
			{
				$rewards = $this->contentmodel->get_rewards(get_authorization($header));
				echo json_encode(array('success'=>true,'data'=>$rewards));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function payment()
		{
			$header = $this->input->request_headers();
			$data = $this->input->post();

			if(get_authorization($header))
			{
				$this->contentmodel->create_payment($data,get_authorization($header));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function get_content_category()
		{
			$header = $this->input->request_headers();
			$category = $this->input->get('category');
			$content = $this->contentmodel->get_content_by_category($category,get_authorization($header));

			if($content)
			{
				echo json_encode(array('success'=>true,'data'=>$content));	
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function category()
		{
			$header = $this->input->request_headers();
			$category = $this->categorymodel->get_category(get_authorization($header));
			if($category)
			{
				echo json_encode(array('success'=>true,'data'=>$category));
			}	
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function get_content_by_id()
		{
			$header = $this->input->request_headers();
			$contentid = $this->input->get('contentid');
			$read = $this->input->get('read');
			
			if(get_authorization($header))
			{
				$content = $this->contentmodel->get_content_by_id($contentid,get_authorization($header));
				
				//$read = true;
				$user = check_user(get_authorization($header));

				if($read)
				{
					$this->contentmodel->createreward($content,$user);	
				}
				
				echo json_encode(array('success'=>true,'data'=>$content));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function get_draft_by_id()
		{
			$header = $this->input->request_headers();

			if(get_authorization($header))
			{
				$contentid = $this->input->get('contentid');
				$content = $this->contentmodel->get_draft_by_id($contentid);
				if($content)
				{
					echo json_encode(array('success'=>true,'data'=>$content));
				}
				else
				{
					echo json_encode(array('success'=>false));
				}
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function get_my_books()
		{
			$header = $this->input->request_headers();
			if(get_authorization($header))
			{
				$content = $this->contentmodel->get_my_books(get_authorization($header));
				echo json_encode(array('success'=>true,'data'=>$content));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function get_purchase_content()
		{
			$header = $this->input->request_headers();
			if(get_authorization($header))
			{
				$content = $this->contentmodel->get_purchase_content(get_authorization($header));
				if($content)
				{
					echo json_encode(array('success'=>true,'data'=>$content));		
				}
				else
				{
					echo json_encode(array('success'=>false));
				}
				
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
			

		}

		function get_content_by_author()
		{
			$header = $this->input->request_headers();
			$userid = $this->input->get('userid');

			if(get_authorization($header))
			{
				$content = $this->contentmodel->get_content_by_userid($userid,get_authorization($header));
				echo json_encode(array('success'=>true,'data'=>$content));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function get_recommended_books()
		{
			$header = $this->input->request_headers();
			
			if(get_authorization($header))
			{
				$content = $this->contentmodel->get_recommended_books();
				echo json_encode(array('success'=>true,'data'=>$content));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function create()
		{
			$header = $this->input->request_headers();

			if(get_authorization($header))
			{
				$data = $this->input->post();

				$config_coverimage['upload_path'] = 'C:\xampp\htdocs\bookramp\uploads\books';
				$config_coverimage['allowed_types'] = '*';
				$config_coverimage['max_size']             = 1000000;
		        $config_coverimage['max_width']            = 10240;
		        $config_coverimage['max_height']           = 7680;
		        $config_coverimage['file_name']			= "user_" . time() ;

		        $this->load->library('upload',$config_coverimage);
		        $this->upload->initialize($config_coverimage);
		        $uploaded = $this->upload->do_upload('cover_image');
		        if($uploaded)
		        {
		        	$file_name = $this->upload->data('file_name');
		        	$data['cover_image'] = 'uploads/books/' . $file_name;
		        }
		        else
		        {
		        	//var_dump($this->upload->display_errors());
		        }

		        $config['upload_path'] = 'C:\xampp\htdocs\bookramp\uploads\docs';
				$config['allowed_types'] = '*';
				$config['max_size']             = 1000000;
		        $config['max_width']            = 10240;
		        $config['max_height']           = 7680;
		        $config['file_name']			= "user_" . time() ;

		        $this->load->library('upload',$config);
		        $this->upload->initialize($config);
		        $upload_content = $this->upload->do_upload('content_file');
		        if($upload_content)
		        {
		        	$file_name = $this->upload->data('file_name');
		        	$data['content_file'] = 'uploads/docs/' . $file_name;
		        }
		        else
		        {
		        	//var_dump($this->upload->display_errors());
		        }

		        $result = $this->contentmodel->add($data,get_authorization($header));

		        if($result['success'])
		        {
		        	echo json_encode(array('success'=>true,'data'=>$this->contentmodel->get_content_by_status("DRAFT",get_authorization($header))));	
		        }
		        else
		        {
		        	echo json_encode($result);
		        }
		        
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function delete_content_by_id()
		{
			$id = $this->input->post('contentid');
			$header = $this->input->request_headers();

			if(get_authorization($header))
			{
				$result = $this->contentmodel->delete($id,get_authorization($header));
				echo json_encode(array('success'=>true));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function create_book_mark()
		{
			$header = $this->input->request_headers();

			if(get_authorization($header))
			{
				$data = $this->input->post();
				$content = $this->contentmodel->create_book_mark($data,get_authorization($header));
				if($content)
				{
					echo json_encode(array('success'=>true));
				}
				else
				{
					echo json_encode(array('success'=>false));
				}
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function delete_bookmark()
		{
			$header = $this->input->request_headers();
			if(get_authorization($header))
			{
				$contentid = $this->input->get('contentid');
				$page = $this->input->get('page');

				$result = $this->contentmodel->deletebookmark($contentid,$page,get_authorization($header));
				echo json_encode(array('success'=>$result));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}


		function get_book_mark()
		{
			$header = $this->input->request_headers();

			if(get_authorization($header))
			{
				$content = $this->contentmodel->get_book_mark(get_authorization($header));
				if($content)
				{
					echo json_encode(array('success'=>true,'data'=>$content));
				}
				else
				{
					echo json_encode(array('success'=>false));
				}
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function get_free_books()
		{
			$header = $this->input->request_headers();
			$id = $this->input->get('contentid');

			if(get_authorization($header))
			{
				$content = $this->contentmodel->get_free_books($id);
				if($content)
				{
					echo json_encode(array('success'=>true,'data'=>$content));
				}
				else
				{
					echo json_encode(array('success'=>false));
				}
			}
			else
			{
				echo json_encode(array('success'=>false));
			}	
		}

		function sold()
		{
			$header = $this->input->request_headers();

			if(get_authorization($header))
			{	
				$content = $this->contentmodel->get_sold_content(get_authorization($header));
				echo json_encode(array('success'=>true,'data'=>$content));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function download()
		{
			$header = $this->input->request_headers();

			if(get_authorization($header))
			{	
				$content = $this->contentmodel->get_download_content(get_authorization($header));
				echo json_encode(array('success'=>true,'data'=>$content));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function config()
		{
			$data = $this->contentmodel->get_config();
			echo json_encode(array('success'=>true,'data'=>$data));
		}

		function get_keywords()
		{
			$text = $this->input->get('key');
			echo json_encode(array('success'=>true,'data'=>$this->contentmodel->search_key($text)));
		}

		function get_keywords_for_user()
		{
			$header = $this->input->request_headers();
			if(get_authorization($header))
			{
				$keywords = $this->contentmodel->get_keywords_for_user(get_authorization($header));

				if($keywords)
				{
					echo json_encode(array('success'=>true,'data'=>$keywords));
				}
				else
				{
					echo json_encode(array('success'=>false));
				}
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function add_keywords()
		{
			$header = $this->input->request_headers();
			$text = $this->input->post('keyword');
			if(get_authorization($header))
			{
				$keywords = $this->contentmodel->add_keywords($text,get_authorization($header));

				echo json_encode(array('success'=>$keywords));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function delete_keywords()
		{
			$header = $this->input->request_headers();
			$id = $this->input->get('id');
			if(get_authorization($header))
			{
				$keywords = $this->contentmodel->delete_keywords($id,get_authorization($header));

				echo json_encode(array('success'=>$keywords));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function update_keywords()
		{
			$header = $this->input->request_headers();
			$text = $this->input->post('keyword');
			$id = $this->input->post('id');
			if(get_authorization($header))
			{
				$keywords = $this->contentmodel->update_keywords($id,$text,get_authorization($header));

				echo json_encode(array('success'=>$keywords));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function search_content_with_keyword()
		{
			$header = $this->input->request_headers();
			$keywords = $this->input->get();

			$contents = $this->contentmodel->search_content_with_key($keywords,get_authorization($header));

			echo json_encode(array('success'=>true,'data'=>$contents));
		}
	}
?>