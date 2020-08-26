<?php 
	class Categorymodel extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		public function is_exist($data)
		{
			$this->db->where('category',$data['category']);
			if(isset($data['id']))
			{
				$this->db->where('id != ' , $data['id']);
			}

			$query = $this->db->get('category');

			if($query->row_array())
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		public function add($data)
		{
			if(isset($data['id']))
			{
				$this->db->where('id',$data['id']);
				$this->db->update('category',$data);
			}
			else
			{
				$this->db->insert('category',$data);
			}
		}

		public function get($id = false)
		{
			if($id)
			{
				$this->db->where('id',$id);
			}
			$query = $this->db->get('category');
			return $query->result_array();
		}

		public function delete($id)
		{
			$this->db->where('id',$id);
			$this->db->delete('category');
		}
	}

?>