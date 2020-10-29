<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Writer extends CI_Controller {

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
		$writer = $this->user->get_user('writer','all');
		$this->load->view('admin/user/writer',array('writer'=>$writer));
		$this->load->view('footer',array('custom_js'=>array('/assets/js/jquery.datatables.min.js','/assets/js/datatables.bootstrap4.min.js','/assets/script/writer.js')));
	}

	public function approved()
	{
		redirect_is_login();
		$this->load->view('header',array('css'=>array('/assets/css/datatables.bootstrap4.min.css')));
		$writer = $this->user->get_user('writer','all');
		$this->load->view('admin/user/writer',array('writer'=>$writer));
		$this->load->view('footer',array('custom_js'=>array('/assets/js/jquery.datatables.min.js','/assets/js/datatables.bootstrap4.min.js','/assets/script/writer.js')));
	}

	public function rejected()
	{
		redirect_is_login();
		$this->load->view('header',array('css'=>array('/assets/css/datatables.bootstrap4.min.css')));
		$writer = $this->user->get_user('writer','all');
		$this->load->view('admin/user/writer',array('writer'=>$writer,'type'=>'Rejected'));
		$this->load->view('footer',array('custom_js'=>array('/assets/js/jquery.datatables.min.js','/assets/js/datatables.bootstrap4.min.js','/assets/script/writer.js')));	
	}


	public function underreview()
	{
		redirect_is_login();
		$this->load->view('header',array('css'=>array('/assets/css/datatables.bootstrap4.min.css')));
		$writer = $this->user->get_user('writer','all');
		$this->load->view('admin/user/writer',array('writer'=>$writer,'type'=>'UNDERREVIEW'));
		$this->load->view('footer',array('custom_js'=>array('/assets/js/jquery.datatables.min.js','/assets/js/datatables.bootstrap4.min.js','/assets/script/writer.js')));		
	}

	public function is_exist()
	{
		$data = $this->input->post();
		$exist = $this->user->is_exist($data);

		echo json_encode($exist);
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
		$user = $this->user->get_user('writer',$status);

		echo json_encode($user);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		$this->user->delete($id);
	}
}
