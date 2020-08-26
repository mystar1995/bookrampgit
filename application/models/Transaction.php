<?php 
	class Transaction extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		public function get_user($status = 'all')
		{
			$query = 'Select transaction.*,user.username as readername,content.title as contentname from transaction,user,content where transaction.reader = user.id and transaction.content = content.id';

			$user = get_logged_user();

			if($user['user_type'] == 'writer')
			{
				$query .= ' and content.author = ' . $user['id'];
			}

			if($status != 'all')
			{
				$query .= ' and transaction.status = "' . $status . '"';
			}

			return $this->db->query($query)->result_array();
		}

		public function get_settlement($status = 'all')
		{
			$query = 'Select settlement.*,user.username as authorname,user.profile_pic as profilepic,content.title as contenttitle,content.cover_image as coverurl from settlement,user,content where settlement.author = user.id and settlement.content = content.id';

			if($status != 'all')
			{
				$query .= ' and settlement.status = "' . $status . '"';
			}

			return $this->db->query($query)->result_array();	
		}

		public function get_settle_by_id($id)
		{
			$query = 'Select settlement.*,user.username as authorname,user.profile_pic as profilepic,content.title as contenttitle,content.cover_image as coverurl from settlement,user,content where settlement.author = user.id and settlement.content = content.id and settlement.id = ' . $id;

			return $this->db->query($query)->row_array();
		}

		public function add($data)
		{
			if($data['transaction_id'])
			{
				$this->db->where('transaction_id',$data['transaction_id']);
				$query = $this->db->get('transaction');

				if($query->num_rows() == 0)
				{
					$this->db->insert('transaction',$data);
				}
			}
		}
	}
?>