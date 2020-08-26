<?php 

	class Notification extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('notifymodel');
		}

		function index()
		{
			$header = $this->input->request_headers();
			if(get_authorization($header))
			{
				$notification = $this->notifymodel->get_notification(get_authorization($header));

				echo json_encode(array('success'=>true,'data'=>$notification));
			}
			else
			{
				echo json_encode(array('success'=>false));
			}
		}

		function read()
		{
			$header = $this->input->request_headers();
			$notify_id = $this->input->get('notify_id');
			if(get_authorization($header))
			{
				$result = $this->notifymodel->read($notify_id,get_authorization($header));

				if($result)
				{
					$notification = $this->notifymodel->get_notification(get_authorization($header));

					echo json_encode(array('success'=>true,'data'=>$notification));
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