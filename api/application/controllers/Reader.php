<?php 
	
	class Reader extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('contentmodel');
			$this->load->model('usermodel');
			$this->load->model('wishlist');
		}

		public function home()
		{
			$header = $this->input->request_headers();
			if(get_authorization($header))
			{
				$top_writer = $this->contentmodel->top_writers(get_authorization($header));
				$best_sellers = $this->contentmodel->best_sellers(get_authorization($header));
				$recently_added = $this->contentmodel->get_recently_added(get_authorization($header));
				$recommended = $this->contentmodel->get_recommended_books(get_authorization($header));
				$continue_reading = $this->contentmodel->get_continue_reading(get_authorization($header));
				
				echo json_encode(array('top_writers'=>$top_writer,'best_sellers'=>$best_sellers,'recently_added'=>$recently_added,'recommended'=>$recommended,'continue_reading'=>$continue_reading,'success'=>true));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		public function add_wishlist()
		{
			$header = $this->input->request_headers();
			$contentid = $this->input->post('contentid');
			if(get_authorization($header))
			{
				$result = $this->wishlist->create_wishitems($contentid,get_authorization($header));

				if($result)
				{
					echo json_encode(array('success'=>true));
				}
				else
				{
					echo json_encode(array('success'=>false));
				}
			}
		}

		public function get_wishitem()
		{
			$header = $this->input->request_headers();

			if(get_authorization($header))
			{
				$wishitems = $this->wishlist->getwishitems(get_authorization($header));

				echo json_encode(array('success'=>true,'data'=>$wishitems));
			}
		}

		public function delete_wishlist($wishitem)
		{
			$header = $this->input->request_headers();

			if(get_authorization($header))
			{
				//var_dump($wishitem);
				$result = $this->wishlist->delete_wishitem($wishitem,get_authorization($header));

				echo json_encode(array('success'=>$result));
			}
		}

		public function get_fanlist()
		{
			$header = $this->input->request_headers();

			if(get_authorization($header))
			{
				$users = $this->usermodel->get_fanlist(get_authorization($header));

				echo json_encode(array('success'=>true,'data'=>$users));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}
	}

?>