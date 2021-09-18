<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if ( ! $this->session->userdata('logged_in'))
        { 
            redirect(base_url().'login');
        }
    }

    public function index()
    {
        $staff=$this->session->userdata('userid');
		
        $this->load->view('admin/header');
        $this->load->view('admin/add-staff');
        $this->load->view('admin/footer');
    }
	 


    public function manage()
    {
		$staff=$this->session->userdata('userid');
		
		//echo $staff;exit;
        $data['content']=$this->Staff_model->select_staff();
		$data['address']=$this->Staff_model->select_address();
        $this->load->view('admin/header');
        $this->load->view('admin/manage-staff',$data);
		//echo $data;exit;
        $this->load->view('admin/footer');
		
    }

 
    public function insert()
    {
		
        $this->form_validation->set_rules('txtname', 'Full Name', 'required');
        $this->form_validation->set_rules('txtaddress', 'Address', 'required');
	    $this->form_validation->set_rules('txtemail', 'Email', 'trim|required|valid_email');
        $staff=$this->session->userdata('userid');
        $name=$this->input->post('txtname');
        $address=$this->input->post('txtaddress');
        $email=$this->input->post('txtemail');
		
		

        if($this->form_validation->run() !== false)
        {
            
              $data=$this->Staff_model->insert_staff(array('user_name'=>$name,'address'=>$address,'email'=>$email));
			 $id= $data['id']=$this->Staff_model->select_id($name);
			 //echo $id;exit;
			  //$id as $data['id'];
			  //$data1=$this->Staff_model->insert_address(array('user_id'=>$id,'address'=>$address,));
            
            
            if($data==true)
            {
                
                $this->session->set_flashdata('success', "New Employee Added Succesfully"); 
            }else{
                $this->session->set_flashdata('error', "Sorry, New Employee Adding Failed.");
            }
            redirect(base_url()."manage-staff");
        }
        else{
            $this->index();
            return false;

        } 
    }

    public function update()
    {
        $this->load->helper('form');
        $this->form_validation->set_rules('txtname', 'Full Name', 'required');
        
        $this->form_validation->set_rules('txtaddress', 'Address', 'required');
        $this->form_validation->set_rules('txtemail', 'Email', 'trim|required|valid_email');
        
        $id=$this->input->post('txtid');
        $name=$this->input->post('txtname');
       
        $address=$this->input->post('txtaddress');
         $email=$this->input->post('txtemail');
        if($this->form_validation->run() !== false)
        {
			
          
           $data=$this->Staff_model->update_staff(array('user_name'=>$name,'address'=>$address,'email'=>$email),$id);
            
           if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('success', "Employee Updated Succesfully"); 
            }else{
                $this->session->set_flashdata('error', "Sorry, Employee Updated Failed.");
            }
            redirect(base_url()."manage-staff");
        }
        else{
            $this->index();
            return false;

        } 
    }


    function edit($id)
    {
        //$data['department']=$this->Department_model->select_departments();
        $data['content']=$this->Staff_model->select_staff_byID($id);
		//$data['content']=$this->Staff_model->select_staff();
		//$data['address']=$this->Staff_model->select_address();
        $this->load->view('admin/header');
        $this->load->view('admin/edit-staff',$data);
        $this->load->view('admin/footer');
    }


    function delete($id)
    {
        $this->Home_model->delete_login_byID($id);
        $data=$this->Staff_model->delete_staff($id);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Employee Deleted Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Employee Delete Failed.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

	
}