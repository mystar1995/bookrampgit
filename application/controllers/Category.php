<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

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
		$this->load->model('categorymodel');
	}

	public function index()
	{
		redirect_is_login();
		$this->load->view('header',array('css'=>array('/assets/css/datatables.bootstrap4.min.css')));
		$category = $this->categorymodel->get();
		$this->load->view('admin/category',array('category'=>$category));
		$this->load->view('footer',array('custom_js'=>array('/assets/js/jquery.datatables.min.js','/assets/js/datatables.bootstrap4.min.js','/assets/script/category.js')));
	}

	public function add($id = false)
	{
		redirect_is_login();
		$category = array();
		if($id)
		{
			$category = $this->categorymodel->get($id)[0];
		}

		$this->load->view('header');
		$this->load->view('admin/category_add',array('category'=>$category));
		$this->load->view('footer',array('custom_js'=>array('/assets/script/category.js')));
	}

	public function delete()
	{
		$id = $this->input->post('id');
		$this->categorymodel->delete($id);
		echo json_encode(array('success'=>true));
	}

	public function add_category()
	{
		$config['upload_path'] = './uploads/category/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']             = 10000;
        $config['max_width']            = 10240;
        $config['max_height']           = 7680;
        $config['file_name']			= "category_" . time() ;

        $data = $this->input->post();
        $exist = $this->categorymodel->is_exist($data);

        if($exist)
        {
        	echo json_encode(array('success'=>false,'message'=>"The Category which has same name is already exist"));
        }
        else
        {
        	$this->load->library('upload',$config);

	        $this->upload->initialize($config);
	        $uploaded = $this->upload->do_upload('coverfile');
	       
	        if($uploaded)
	        {
	        	$data['cover_url'] = $config['upload_path'] . $this->upload->data('file_name');
	        }

        	$this->categorymodel->add($data);
        	echo json_encode(array('success'=>true,'message'=>'You have successfully Registered Category'));
        }
	}
}
