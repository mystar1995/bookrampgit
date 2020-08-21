<?php 
	
	class Rating extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('ratingmodel');
		}

		public function content()
		{
			$header = $this->input->request_headers();
			$contentid = $this->input->get('contentid');
			if(get_authorization($header))
			{
				$ratings = $this->ratingmodel->get_content_rating($contentid,get_authorization($header));
				if($ratings)	
				{
					echo json_encode(array('success'=>true,'data'=>$ratings));
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

		public function add_content_rating()
		{
			$header = $this->input->request_headers();
			$data = $this->input->post();

			if(get_authorization($header))
			{
				$result = $this->ratingmodel->newrating($data,get_authorization($header));

				if($result)
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
	}

?>

