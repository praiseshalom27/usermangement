<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_model extends CI_Model {


    function insert_staff($data)
    {
        $this->db->insert("user",$data);
        return $this->db->insert_id();
    }
	function insert_address($data1)
    {
        $this->db->insert("address",$data1);
        return $this->db->insert_id();
    }
	
	function select_id($name)
    {
		$this->db->where('user_name',$name);
        $this->db->select("user.id");
        $this->db->from("user");
       // $this->db->join("department_tbl",'department_tbl.id=staff_tbl.department_id');
        $qry=$this->db->get();
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
        
    }

    function select_staff()
    {
        $this->db->order_by('user.id','DESC');
        $this->db->select("user.*");
        $this->db->from("user");
        //$this->db->join("address",'address.user_id=user.id');
        $qry=$this->db->get();
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
			
        }
    }
	
	function select_staff11()
    {
		$query = $this->db->query('SELECT * FROM `user`order by id DESC;');
        //  $query = $this->db->query('SELECT COUNT(*) AS TOTAL, COUNT(IF(user_type="0" && role="2",1,null)) as customer,COUNT(IF(user_type="1",1,null)) as stdcorporate,COUNT(IF(user_type="2",1,null)) as codcorporate,COUNT(IF(role="4",1,null)) as deliveryboy, COUNT(IF(role="5",1,null)) as warehouse FROM users where role!=1');
        return $query;
		//$result=$this->db->get();
        //echo $this->db->last_query();exit;
        //return $result->result();
      // $query=SELECT * FROM user';
	  // return $query;
    }
	 
	 function select_address()
    {
        $qry=$this->db->get('address');
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }
	 
	function select_staff1()
    {
        $this->db->order_by('user.id','DESC');
        $this->db->select("user.*,address.address");
        $this->db->from("user");
        $this->db->join("address",'address.user_id=user.id');
        $qry=$this->db->get();
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
			
        }
    }

    function select_staff_byID($id)
    {
        $this->db->where('user.id',$id);
        $this->db->select("user.*");
        $this->db->from("user");
      
        $qry=$this->db->get();
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    

   


    function delete_staff($id)
    {
        $this->db->where('id', $id);
        $this->db->delete("user");
        $this->db->affected_rows();
    }

    
    function update_staff($data,$id)
    {
        $this->db->where('id', $id);
        $this->db->update('user',$data);
        $this->db->affected_rows();
    }
    

    
    




}
