<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class CompanyProcess extends CI_Controller 


{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
    }
    
    
   public function index()
     {
      
         $this->load->model('Company_Model');
         $result['results']=$this->Company_Model->postsread();
          $this->load->view("index",$result);
    }
    public function contact()
    {
        $this->load->view('page-contact');
    }
        
    
    //////// Login/Register Page /////////////
    public function joinpage()
    {
    $this->load->view('joinpage');
    }
   

    public function login()
	{
        if($this->session->userdata('company_id'))
        {
            $this->load->view("companypanel/indexcompany");

        }

        else{
		$loginfo = $this->input->post(null, true);

		$email = $loginfo['email'];
        $password = $loginfo['password'];
        $this->load->model("Company_Model");
		$result = $this->Company_Model->login($email, $password);
		if ($result) {
			$this->session->set_userdata('company_id', $result['id']);
			$this->session->set_userdata('company_name', $result['company_name']);
            $this->load->view("companypanel/indexcompany");
			
        } 
        else {
			$error['logerror'] = "Wrong password or email";
			$this->load->view('joinpage', $error);
        }
    }
	}

        

    

    //////// Login/Register Page /////////////
  


    public function register()
    {
        $regInfo=$this->input->post(null, true);
        $this->load->library("form_validation");
        $this->form_validation->set_rules("name", "Company Name", "trim|required|alpha");
        $this->form_validation->set_rules("email", "email", "trim|required");
        $this->form_validation->set_rules("password", "password", "trim|required|min_length[6]");
        $this->form_validation->set_rules("confirmPassword", "Confirm Password", "required|matches[password]");
    
        if ($this->form_validation->run() == FALSE)
        {
        $validationError = validation_errors();
        $this->load->view('joinpage', array('errors' => $validationError));
        }

    
        else 
        {
        $this->load->model('Company_Model');
        $this->Company_Model->insertCompany($regInfo);
        $message='You are successfully registirated, Please Login';
        $this->load->view('joinpage', array('errors' => $message));
        }
    }
 
    ////////////// Login /////////////////
    
    
    ///////////////// END OF THE CLASS////////////////////////

 
 
    ////////////// Login /////////////////
    


    public function readpost()

    {
        $this->load->model('company_Model');
        $result=$this->company_Model->postsread();
        var_dump($result);
    } 





    ///////////////// END OF THE CLASS////////////////////////

 function company()
{
    $this->load->view("companypanel/indexcompany");
}

 

function addpost()
    {
        $postform = $this->input->post(null, true);
        $image=$_FILES['image']['name'];
        $this->load->model('company_Model');
        $this->company_Model->addPost($postform,$image);
        $config['upload_path']= 'uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('image'))

                {
                    $data=0;
                        
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());

                }
       
        $this->load->view('companypanel/manageposts');
        
    }

    public function manage()
    {
        $this->load->view('companypanel/manageposts');
    }

    function detailpost($id)
    {

                $this->load->model('Company_Model');
                $result['results']=$this->Company_Model->postsOneRead($id);
                $this->load->view('show',$result);


    }


    public function seeposts()
    {
        $this->load->model('Company_Model');
        $result['results']=$this->Company_Model->postsread();
        $this->load->view("companypanel/seeposts",$result);;

    }
 
}





?>