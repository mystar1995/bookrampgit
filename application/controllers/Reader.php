<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reader extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct()
	{
		parent::__construct();
		$this->load->model('user');
	}

	
	public function index()
	{
		redirect_is_login();
		$this->load->view('header',array('css'=>array('/assets/css/datatables.bootstrap4.min.css')));
		$reader = $this->user->get_user('reader','all');
		$this->load->view('admin/user/reader',array('reader'=>$reader));
		$this->load->view('footer',array('custom_js'=>array('/assets/js/jquery.datatables.min.js','/assets/js/datatables.bootstrap4.min.js','/assets/script/reader.js')));
	}

	public function add($id = false)
	{
		redirect_is_login();
		$this->load->view('header');
		$country = $this->user->get_country();
		$user = array();
		if($id)
		{
			$user = $this->user->getuserbyid($id);
		}
		$this->load->view('admin/user/reader_add',array('countries'=>$country,'user'=>$user));
		$this->load->view('footer',array('custom_js'=>array('/assets/script/reader.js')));	
	}

	public function is_exist()
	{
		$data = $this->input->post();
		$exist = $this->user->is_exist($data);

		echo json_encode($exist);
	}	

	public function add_user()
	{
		$user = $this->input->post();
		$config['upload_path'] = './uploads/user/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']             = 10000;
        $config['max_width']            = 10240;
        $config['max_height']           = 7680;
        $config['file_name']			= "user_" . time() ;

        $exist = $this->user->is_exist($user);
        
        if(!$exist['success'])
        {
        	echo json_encode($exist);
        	exit;
        }
        $this->load->library('upload',$config);

        $this->upload->initialize($config);
        $uploaded = $this->upload->do_upload('userfile');
       
        $data = $this->upload->data();

        if($uploaded)
        {
        	$filename = $this->upload->data('file_name');	
        	$user['profile_pic'] = $config['upload_path'] . $filename;
        }
        else
        {
        	
        }

        if(isset($user['password']))
        {
        	$user['password'] = md5($user['password']);
        }

		$this->user->add_user($user);

		echo json_encode(array('success'=>true,'message'=>'You have successfully registerd'));
	}

	public function get_phone_code()
	{
		$country = $this->input->post('country');
		if($country)
		{
			$countryitem = $this->user->get_country($country);
			echo $countryitem[0]['phonecode'];	
		}
		else
		{
			echo '';
		}
		
	}

	public function active()
	{
		$active = $this->input->post('active');
		$id = $this->input->post('id');
		$this->user->set_active($id,$active);
		echo json_encode(array('success'=>true));
	}

	public function get_user()
	{
		$status = $this->input->post('status');
		$user = $this->user->get_user('reader',$status);

		echo json_encode($user);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		$this->user->delete($id);
	}
}
