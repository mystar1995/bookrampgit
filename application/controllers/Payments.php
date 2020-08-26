<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {

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
		$this->load->model('transaction');
	}

	public function reader()
	{
		redirect_is_login();
		$transaction = $this->transaction->get_user();
		$this->load->view('header',array('css'=>array('/assets/css/datatables.bootstrap4.min.css')));
		$this->load->view('admin/payment/reader',array('transactions'=>$transaction));
		$this->load->view('footer',array('custom_js'=>array('/assets/js/jquery.datatables.min.js','/assets/js/datatables.bootstrap4.min.js','/assets/script/transaction.js')));
	}

	public function writer()
	{
		redirect_is_login();
		$data = $this->transaction->get_settlement();
		$this->load->view('header',array('css'=>array('/assets/css/datatables.bootstrap4.min.css')));
		$this->load->view('admin/payment/writer',array('settlements'=>$data));
		$this->load->view('footer',array('custom_js'=>array('/assets/js/jquery.datatables.min.js','/assets/js/datatables.bootstrap4.min.js','/assets/script/transaction.js')));	
	}

	public function reader_status()
	{
		$status = $this->input->post('status');
		$data = $this->transaction->get_user($status);

		echo json_encode($data);
	}

	public function writer_status()
	{
		$status = $this->input->post('status');
		$data = $this->transaction->get_settlement($status);

		echo json_encode($data);	
	}
}
