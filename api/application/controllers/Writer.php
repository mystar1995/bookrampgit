<?php 
	
	class Writer extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('writermodel');
			$this->load->model('usermodel');
			$this->load->model('contentmodel');
		}

		public function index()
		{
			$header = $this->input->request_headers();
			if(get_authorization($header))
			{
				$content = $this->writermodel->get_home_data(get_authorization($header));
				$content['download'] = $this->contentmodel->get_download_content(get_authorization($header));

				$user = check_user(get_authorization($header));
				$author = $this->usermodel->get_profile($user['id'],get_authorization($header));

				$content['author'] = $author;

				$content['success'] = true;

				echo json_encode($content);

			}
			else
			{
				echo json_encode(array('success'=>false));
			}
			

		}
	}

?>