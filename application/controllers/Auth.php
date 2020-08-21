<?php 

	class Auth extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('authmodel');
		}

		function index()
		{
			if(get_user_id())
			{
				redirect('');
			}
			$this->load->view('admin/auth');
		}

		public function login_user()
		{
			$user = $this->input->post();
			$result = $this->authmodel->get_user($user);

			if($result['success'])
			{
				$this->session->set_userdata('user',$result['user']);
				echo json_encode(array('success'=>true,'message'=>'You have successfully Logged In'));
			}
			else
			{
				echo json_encode($result);
			}
		}

		function logout()
		{
			$this->session->set_userdata('user','');
			redirect('auth');
		}
	}
?>