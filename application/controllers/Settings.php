<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

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
	public function index()
	{
		redirect_is_login();
		$this->load->view('header');
		$this->load->view('admin/setting');
		$this->load->view('footer',array('custom_js'=>array('assets/script/setting.js')));
	}

	public function update()
	{
		$data = $this->input->post();
		foreach ($data as $key => $value) {
			set_setting($key,$value);
		}

		echo json_encode(array('success'=>true));
	}
}
