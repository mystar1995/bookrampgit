<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books extends CI_Controller {

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
		$this->load->model('bookmodel');
		$this->load->model('user');
		$this->load->model('categorymodel');
		$this->load->model('transaction');
	}

	public function published()
	{
		redirect_is_login();
		$content = $this->bookmodel->get_content_by_status('PUBLISHED');
		
		$this->load->view('header',array('css'=>array('/assets/css/datatables.bootstrap4.min.css')));
		$this->load->view('admin/books/published',array('content'=>$content));
		$this->load->view('footer',array('custom_js'=>array('/assets/js/jquery.datatables.min.js','/assets/js/datatables.bootstrap4.min.js','/assets/script/book.js')));
	}

	public function under_review()
	{
		redirect_is_login();
		$content = $this->bookmodel->get_content_by_status('UNDERREVIEW');
		$this->load->view('header',array('css'=>array('/assets/css/datatables.bootstrap4.min.css')));
		$this->load->view('admin/books/under_review',array('content'=>$content));
		$this->load->view('footer',array('custom_js'=>array('/assets/js/jquery.datatables.min.js','/assets/js/datatables.bootstrap4.min.js','/assets/script/book.js')));
	}

	public function rejected()
	{
		redirect_is_login();
		$content = $this->bookmodel->get_content_by_status('REJECTED');
		$this->load->view('header',array('css'=>array('/assets/css/datatables.bootstrap4.min.css')));
		$this->load->view('admin/books/rejected',array('content'=>$content));
		$this->load->view('footer',array('custom_js'=>array('/assets/js/jquery.datatables.min.js','/assets/js/datatables.bootstrap4.min.js','/assets/script/book.js')));
	}

	public function draft()
	{
		redirect_is_login();
		$user = get_logged_user();

		if($user && $user['user_type'] != 'writer')
		{
			redirect('books/published');
		}	

		$content = $this->bookmodel->get_content_by_status('DRAFT');
		$this->load->view('header',array('css'=>array('/assets/css/datatables.bootstrap4.min.css')));
		$this->load->view('admin/books/draft',array('content'=>$content));
		$this->load->view('footer',array('custom_js'=>array('/assets/js/jquery.datatables.min.js','/assets/js/datatables.bootstrap4.min.js','/assets/script/book.js')));
	}

	public function add($id = false)
	{
		redirect_is_login();
		$book = array();

		if($id)
		{
			$book = $this->bookmodel->get($id);
		}

		$this->load->view('header');
		$user = $this->user->get_user("writer","all");
		$category = $this->categorymodel->get();
		$this->load->view('admin/books/add',array('user'=>$user,'category'=>$category,'book'=>$book));
		$this->load->view('footer',array('custom_js'=>array('/assets/script/book.js')));
	}

	public function add_book()
	{
		redirect_is_login();
		$data = $this->input->post();

		$config_coverimage['upload_path'] = './uploads/books/';
		$config_coverimage['allowed_types'] = '*';
		$config_coverimage['max_size']             = 10000;
        $config_coverimage['max_width']            = 10240;
        $config_coverimage['max_height']           = 7680;
        $config_coverimage['file_name']			= "user_" . time() ;

        $this->load->library('upload',$config_coverimage);
        $this->upload->initialize($config_coverimage);
        $uploaded = $this->upload->do_upload('cover_image');
        if($uploaded)
        {
        	$file_name = $this->upload->data('file_name');
        	$data['cover_image'] = $config_coverimage['upload_path'] . $file_name;
        }
        else
        {
        	//var_dump($this->upload->display_errors());
        }

        $config['upload_path'] = './uploads/docs/';
		$config['allowed_types'] = '*';
		$config['max_size']             = 100000;
        $config['max_width']            = 10240;
        $config['max_height']           = 7680;
        $config['file_name']			= "user_" . time() ;

        $this->load->library('upload',$config);
        $this->upload->initialize($config);
        $upload_content = $this->upload->do_upload('content_file');
        if($upload_content)
        {
        	$file_name = $this->upload->data('file_name');
        	$data['content_file'] = $config['upload_path'] . $file_name;
        }
        else
        {
        	//var_dump($this->upload->display_errors());
        }

        $result = $this->bookmodel->add($data);

        if($result['success'])
        {
        	$id = $result['contentid'];
        	if($data['status'] == 'DRAFT')
	        {
	        	echo json_encode(array('success'=>true,'redirecturl'=>base_url(). '/books/content/' . $id));
	        }
	        else
	        {
	        	echo json_encode(array('success'=>true,'message'=>'You have successfully registered'));	
	        }
        }
        else
        {
        	echo json_encode($result);
        }
        
	}

	public function changestatus()
	{
		$status = $this->input->post('status');
		$id = $this->input->post('id');
		$this->bookmodel->changestatus($id,$status);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		$this->bookmodel->delete($id);
	}

	public function download()
	{
		$id = $this->input->post('id');
		$download = $this->bookmodel->get($id);

		if($download['content_file'])
		{
			echo json_encode(array('success'=>true,'url'=>$download['content_file']));	
		}
		else
		{
			echo json_encode(array('success'=>false,'id'=>$download['id']));
		}
	}

	public function content($id)
	{
		$content = $this->bookmodel->get($id);
		$this->load->view('header',array('css'=>array('/assets/global/bootstrap-summernote/summernote.css')));
		$this->load->view('admin/books/content',array('content'=>$content));
		$this->load->view('footer',array('custom_js'=>array('/assets/global/bootstrap-summernote/summernote.js','/assets/script/content.js')));
	}

	public function save_content()
	{
		$content = $this->input->post();

		$result = $this->bookmodel->update_content($content);

		if($result['success'])
		{
			if($content['status'] == 'UNDERREVIEW')
			{
				echo json_encode(array('success'=>true,'redirect_url'=>base_url() . '/books/published'));
			}
			else
			{
				echo json_encode(array('success'=>true));
			}	
		}
		else
		{
			echo json_encode($result);
		}
		
	}

	public function payment()
	{
		$id = $this->input->post('contentid');

		$data = $this->transaction->get_settle_by_id($id);

		$config = array();
		$config['business'] = 'sb-kbo5m1356970@business.example.com';
		$config['return'] = base_url() . 'books/notify_payment';
        $config['cancel_return'] = base_url() . 'books/cancel_payment';
        $config['notify_url'] = 'books/process_payment';
        $config['production'] = FALSE;
        $config['currency'] = 'USD';
        $config["invoice"] = random_string(8);

        $this->load->library('paypal',$config);

        $this->paypal->add($data['contenttitle'],$data['amount'],1,$id);

        $this->paypal->pay();
	}

	public function notify_payment()
	{
		$data = $this->input->post();
		$item_number = $data['item_number_1'];
		$data_transfer = $this->transaction->get_settle_by_id($item_number);

		$transaction = array('transaction_id'=>$data['txn_id'],'status'=>$data['status'],'content'=>$data_transfer['content'],'amount'=>$data['amount'],'reader'=>get_user_id());
		
		$this->transaction->add($transaction);
		redirect('payment/writer');
	}

	public function process_payment()
	{
		redirect('payment/writer');
	}

	public function cancel_payment()
	{
		redirect('payment/writer');
	}
}
