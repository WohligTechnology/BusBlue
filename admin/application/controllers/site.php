<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller 
{
	public function __construct( )
	{
		parent::__construct();
		
		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
            $this->session->sess_destroy();
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
	function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
	}
	public function index()
	{
		//$access = array("1","2");
//		$access = array("1","2");
//		$this->checkaccess($access);
        $data['category']=$this->category_model->getcategorydropdown();
		$data[ 'listing' ] =$this->listing_model->getlistingdropdown();
		$data[ 'page' ] = 'dashboard';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );	
	}
	public function createuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'page' ] = 'createuser';
		$data[ 'title' ] = 'Create User';
		$this->load->view( 'template', $data );	
	}
	function createusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('firstname','First Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('lastname','Last Name','trim|max_length[30]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('contact','contactno','trim');
		$this->form_validation->set_rules('phoneno','phoneno','trim');
//		$this->form_validation->set_rules('website','Website','trim|max_length[50]');
//		$this->form_validation->set_rules('description','Description','trim|');
		$this->form_validation->set_rules('address','Address','trim|');
		$this->form_validation->set_rules('city','City','trim|max_length[30]');
		$this->form_validation->set_rules('pincode','Pincode','trim|max_length[20]');
		$this->form_validation->set_rules('state','state','trim|max_length[20]');
		$this->form_validation->set_rules('country','country','trim|max_length[20]');
		$this->form_validation->set_rules('facebookuserid','facebookuserid','trim|max_length[20]');
		$this->form_validation->set_rules('google','google','trim|max_length[20]');
		$this->form_validation->set_rules('email','Email','trim|valid_email');
		$this->form_validation->set_rules('status','Status','trim');
		$this->form_validation->set_rules('dob','DOB','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
			$data['page']='createuser';
			$data['title']='Create New User';
			$this->load->view('template',$data);
		}
		else
		{
            $website=$this->input->post('website');
            $dob=$this->input->post('dob');
            $description=$this->input->post('description');
            $address=$this->input->post('address');
            $city=$this->input->post('city');
            $pincode=$this->input->post('pincode');
			$password=$this->input->post('password');
			if($dob != "")
			{
				$dob = date("Y-m-d",strtotime($dob));
			}
			$accesslevel=$this->input->post('accesslevel');
			$email=$this->input->post('email');
			$contact=$this->input->post('contact');
			$phoneno=$this->input->post('phoneno');
			$google=$this->input->post('google');
			$state=$this->input->post('state');
			$country=$this->input->post('country');
			$status=$this->input->post('status');
			$facebookuserid=$this->input->post('facebookuserid');
			$firstname=$this->input->post('firstname');
			$lastname=$this->input->post('lastname');
			if($this->user_model->create($firstname,$lastname,$dob,$password,$accesslevel,$email,$contact,$status,$facebookuserid,$website,$description,$address,$city,$pincode,$phoneno,$google,$state,$country)==0)
			$data['alerterror']="New user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			
			$data['table']=$this->user_model->viewusers();
			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
//	function viewusers()
//	{
//		$access = array("1");
//		$this->checkaccess($access);
//		$data['table']=$this->user_model->viewusers();
//		$data['page']='viewusers';
//		$data['title']='View Users';
//		$this->load->view('template',$data);
//	}
    
    
    function viewusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewusers';
        
        
        $data['base_url'] = site_url("site/viewuserjson");
        
        
		$data['title']='View user';
		$this->load->view('template',$data);
	} 
    
    function viewuserjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
//        SELECT DISTINCT `user`.`id` as `id`,`user`.`firstname` as `firstname`,`user`.`lastname` as `lastname`,`accesslevel`.`name` as `accesslevel`	,`user`.`email` as `email`,`user`.`contact` as `contact`,`user`.`status` as `status`,`user`.`accesslevel` as `access`
//		FROM `user`
//	   INNER JOIN `accesslevel` ON `user`.`accesslevel`=`accesslevel`.`id` 
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`user`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`user`.`firstname`";
        $elements[1]->sort="1";
        $elements[1]->header="First Name";
        $elements[1]->alias="firstname";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`user`.`lastname`";
        $elements[2]->sort="1";
        $elements[2]->header="Last Name";
        $elements[2]->alias="lastname";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`accesslevel`.`name`";
        $elements[3]->sort="1";
        $elements[3]->header="Accesslevel";
        $elements[3]->alias="accesslevel";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`user`.`email`";
        $elements[4]->sort="1";
        $elements[4]->header="Email";
        $elements[4]->alias="email";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`contact`";
        $elements[5]->sort="1";
        $elements[5]->header="Contact";
        $elements[5]->alias="contact";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` INNER JOIN `accesslevel` ON `user`.`accesslevel`=`accesslevel`.`id`","WHERE `user`.`accesslevel`=1");
        
		$this->load->view("json",$data);
	} 
    
    
	function edituser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='edituser';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('template',$data);
	}
	function editusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('contact','contactno','trim');
		$this->form_validation->set_rules('phoneno','phoneno','trim');
		$this->form_validation->set_rules('google','google','trim');
		$this->form_validation->set_rules('state','state','trim');
		$this->form_validation->set_rules('country','country','trim');
		$this->form_validation->set_rules('website','Website','trim|max_length[50]');
//		$this->form_validation->set_rules('description','Description','trim|');
		$this->form_validation->set_rules('address','Address','trim|');
		$this->form_validation->set_rules('city','City','trim|max_length[30]');
		$this->form_validation->set_rules('pincode','Pincode','trim|max_length[20]');
        
		$this->form_validation->set_rules('fname','First Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('lname','Last Name','trim|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|valid_email');
		$this->form_validation->set_rules('status','Status','trim');
		$this->form_validation->set_rules('dob','DOB','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='edituser';
			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{
            $website=$this->input->post('website');
            $description=$this->input->post('description');
            $address=$this->input->post('address');
            $city=$this->input->post('city');
            $pincode=$this->input->post('pincode');
			$id=$this->input->post('id');
			$password=$this->input->post('password');
			$dob=$this->input->post('dob');
			if($dob != "")
			{
				$dob = date("Y-m-d",strtotime($dob));
			}
			$accesslevel=$this->input->post('accesslevel');
			$contact=$this->input->post('contact');
			$phoneno=$this->input->post('phoneno');
			$google=$this->input->post('google');
			$state=$this->input->post('state');
			$country=$this->input->post('country');
			$status=$this->input->post('status');
			$facebookuserid=$this->input->post('facebookuserid');
			$fname=$this->input->post('fname');
			$lname=$this->input->post('lname');
			if($this->user_model->edit($id,$fname,$lname,$dob,$password,$accesslevel,$contact,$status,$facebookuserid,$website,$description,$address,$city,$pincode,$phoneno,$google,$state,$country)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";
			
			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="User Deleted Successfully";
		$data['page']='viewusers';
		$data['title']='View Users';
		$this->load->view('template',$data);
	}
	function changeuserstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewusers";
        $data['other']="template=$template";
        $this->load->view("redirect",$data);
	}
    
    
    
    /*-----------------User/Organizer Finctions added by avinash for frontend APIs---------------*/
    public function update()
	{
        $id=$this->input->get('id');
        $firstname=$this->input->get('firstname');
        $lastname=$this->input->get('lastname');
        $password=$this->input->get('password');
        $password=md5($password);
        $email=$this->input->get('email');
        $website=$this->input->get('website');
        $description=$this->input->get('description');
        $eventinfo=$this->input->get('eventinfo');
        $contact=$this->input->get('contact');
        $address=$this->input->get('address');
        $city=$this->input->get('city');
        $pincode=$this->input->get('pincode');
        $dob=$this->input->get('dob');
       // $accesslevel=$this->input->get('accesslevel');
        $accesslevel=2;
        $timestamp=$this->input->get('timestamp');
        $facebookuserid=$this->input->get('facebookuserid');
        $newsletterstatus=$this->input->get('newsletterstatus');
        $status=$this->input->get('status');
        $logo=$this->input->get('logo');
        $showwebsite=$this->input->get('showwebsite');
        $eventsheld=$this->input->get('eventsheld');
        $topeventlocation=$this->input->get('topeventlocation');
        $data['json']=$this->user_model->update($id,$firstname,$lastname,$password,$email,$website,$description,$eventinfo,$contact,$address,$city,$pincode,$dob,$accesslevel,$timestamp,$facebookuserid,$newsletterstatus,$status,$logo,$showwebsite,$eventsheld,$topeventlocation);
        print_r($data);
		//$this->load->view('json',$data);
	}
	public function finduser()
	{
        $data['json']=$this->user_model->viewall();
        print_r($data);
		//$this->load->view('json',$data);
	}
    public function findoneuser()
	{
        $id=$this->input->get('id');
        $data['json']=$this->user_model->viewone($id);
        print_r($data);
		//$this->load->view('json',$data);
	}
    public function deleteoneuser()
	{
        $id=$this->input->get('id');
        $data['json']=$this->user_model->deleteone($id);
		//$this->load->view('json',$data);
	}
    public function login()
    {
        $email=$this->input->get("email");
        $password=$this->input->get("password");
        $data['json']=$this->user_model->login($email,$password);
        //$this->load->view('json',$data);
    }
    public function authenticate()
    {
        $data['json']=$this->user_model->authenticate();
        //$this->load->view('json',$data);
    }
    public function signup()
    {
        $email=$this->input->get_post("email");
        $password=$this->input->get_post("password");
        $data['json']=$this->user_model->signup($email,$password);
        //$this->load->view('json',$data);
        
    }
    public function logout()
    {
        $this->session->sess_destroy();
        $data['json']=true;
        //$this->load->view('json',$data);
    }
    
    
    
    /*-----------------End of User/Organizer functions----------------------------------*/
    
    
    
	//category
    
	function viewcategoryold()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->category_model->viewcategory();
		$data['page']='viewcategory';
		$data['title']='View category';
		$this->load->view('template',$data);
	}
	function viewsubcategory()
	{
		$access = array("1");
		$this->checkaccess($access);
		//$data['table']=$this->category_model->viewsubcategory();
        $brandid=$this->input->get('brandid');
        $categoryid=$this->input->get('id');
        $data['check']=$this->category_model->selectedcategory($brandid,$categoryid);
        $data['brandcategoryid']=$this->category_model->getbrandcategoryid($brandid,$categoryid);
		$data['page']='viewsubcategory';
		$data['title']='View Sub-category';
		$this->load->view('template',$data);
	}
     function editsubcategorysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('brandcategoryid','brandcategoryid','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$brandid=$this->input->get('brandid');
        $categoryid=$this->input->get('id');
        $data['check']=$this->category_model->selectedcategory($brandid,$categoryid);
        $data['brandcategoryid']=$this->category_model->getbrandcategoryid($brandid,$categoryid);
		$data['page']='viewsubcategory';
		$data['title']='View Sub-category';
		$this->load->view('template',$data);
		}
		else
		{
			$brandcategoryid=$this->input->post('brandcategoryid');
			$men=$this->input->post('men');
			$women=$this->input->post('women');
			$kids=$this->input->post('kids');
            echo "men=".$men;
            if($men=="1")
               {
                $this->category_model->editsubcategorysubmit($brandcategoryid,$men);
                
               }
               else
               {
                   echo "else";
               $this->category_model->deletesubcategorysubmit($brandcategoryid,1);
               }
               
            if($women=="2")
               {
                $this->category_model->editsubcategorysubmit($brandcategoryid,$women);
               }
               else
               {
               $this->category_model->deletesubcategorysubmit($brandcategoryid,2);
               }
            if($kids=="3")
               {
                $this->category_model->editsubcategorysubmit($brandcategoryid,$kids);
               }
               else
               {
               $this->category_model->deletesubcategorysubmit($brandcategoryid,3);
               }
			$brandid=$this->input->get('brandid');
        $categoryid=$this->input->get('id');
        $data['check']=$this->category_model->selectedcategory($brandid,$categoryid);
        $data['brandcategoryid']=$this->category_model->getbrandcategoryid($brandid,$categoryid);
		$data['page']='viewsubcategory';
		$data['title']='View Sub-category';
		$this->load->view('template',$data);
			//$data['other']="template=$template";
			//$this->load->view("redirect",$data);
			/*$data['page']='viewusers';
			$data['title']='View Users';
			$this->load->view('template',$data);*/
		}
	}
	public function createcategory()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->category_model->getstatusdropdown();
		$data['category']=$this->category_model->getcategorydropdown();
		$data['typeofimage']=$this->category_model->gettypeofimagedropdown();
		$data[ 'page' ] = 'createcategory';
		$data[ 'title' ] = 'Create category';
		$this->load->view( 'template', $data );	
	}
   
	function createcategorysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('parent','parent','trim|');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('logo','logo','trim|');
		$this->form_validation->set_rules('typeofimage','typeofimage','trim|');
		$this->form_validation->set_rules('startdateofbanner','startdateofbanner','trim|');
		$this->form_validation->set_rules('enddateofbanner','enddateofbanner','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->category_model->getstatusdropdown();
			$data['category']=$this->category_model->getcategorydropdown();
            $data['typeofimage']=$this->category_model->gettypeofimagedropdown();
			$data[ 'page' ] = 'createcategory';
			$data[ 'title' ] = 'Create category';
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			$parent=$this->input->post('parent');
			$typeofimage=$this->input->post('typeofimage');
			$startdateofbanner=$this->input->post('startdateofbanner');
			$enddateofbanner=$this->input->post('enddateofbanner');
			$status=$typeofimage;
			$logo=$this->input->post('logo');
            
            $config['upload_path'] = './lib/images/png/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './lib/images/png/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
                
			}
            
            $config['upload_path'] = './lib/images/png/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="banner";
			$banner="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$banner=$uploaddata['file_name'];
                
                $config_r['source_image']   = './lib/images/png/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 1140;
                $config_r['height'] = 160;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $banner=$this->image_lib->dest_image;
                    //return false;
                }
                
                
			}
            
			if($this->category_model->createcategory($name,$parent,$status,$logo,$image,$typeofimage,$banner,$startdateofbanner,$enddateofbanner)==0)
			$data['alerterror']="New category could not be created.";
			else
			$data['alertsuccess']="category  created Successfully.";
			$data['table']=$this->category_model->viewcategory();
			$data['redirect']="site/viewcategory";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
	function editcategory()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->category_model->beforeeditcategory($this->input->get('id'));
		$data['category']=$this->category_model->getcategorydropdown();
		$data[ 'status' ] =$this->category_model->getstatusdropdown();
		$data['typeofimage']=$this->category_model->gettypeofimagedropdown();
		$data['page']='editcategory';
		$data['title']='Edit category';
		$this->load->view('template',$data);
	}
	function editcategorysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('parent','parent','trim|');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('logo','logo','trim|');
		$this->form_validation->set_rules('typeofimage','typeofimage','trim|');
		$this->form_validation->set_rules('startdateofbanner','startdateofbanner','trim|');
		$this->form_validation->set_rules('enddateofbanner','enddateofbanner','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->category_model->getstatusdropdown();
			$data['category']=$this->category_model->getcategorydropdown();
            $data['typeofimage']=$this->category_model->gettypeofimagedropdown();
			$data['before']=$this->category_model->beforeeditcategory($this->input->post('id'));
			$data['page']='editcategory';
			$data['title']='Edit category';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$name=$this->input->post('name');
			$parent=$this->input->post('parent');
			$typeofimage=$this->input->post('typeofimage');
			$startdateofbanner=$this->input->post('startdateofbanner');
			$enddateofbanner=$this->input->post('enddateofbanner');
			$status=$typeofimage;
			$logo=$this->input->post('logo');
			
            $config['upload_path'] = './lib/images/png/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
//			}
            
                
                $config_r['source_image']   = './lib/images/png/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
            }
            
            if($image=="")
            {
                $image=$this->category_model->getcategoryimagebyid($id);
                $image=$image->image;
            }
            
            $config['upload_path'] = './lib/images/png/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="banner";
			$banner="";
			if (  $this->upload->do_upload($filename))
			{
                
				$uploaddata = $this->upload->data();
				$banner=$uploaddata['file_name'];
                
                $config_r['source_image']   = './lib/images/png/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 1140;
                $config_r['height'] = 160;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $banner=$this->image_lib->dest_image;
                    //return false;
                }
                
                
			}
            if($banner=="")
            {
                
                $banner=$this->category_model->getcategorybannerbyid($id);
                $banner=$banner->banner;
                
            }
			if($this->category_model->editcategory($id,$name,$parent,$status,$logo,$image,$typeofimage,$banner,$startdateofbanner,$enddateofbanner)==0)
			$data['alerterror']="category Editing was unsuccesful";
			else
			$data['alertsuccess']="category edited Successfully.";
//			$data['table']=$this->category_model->viewcategory();
			$data['redirect']="site/viewcategory";
////			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			/*$data['page']='viewusers';
			$data['title']='View Users';
			$this->load->view('template',$data);*/
		}
	}
   
	function deletecategory()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->category_model->deletecategory($this->input->get('id'));
		$data['table']=$this->category_model->viewcategory();
		$data['alertsuccess']="category Deleted Successfully";
		$data['page']='viewcategory';
		$data['title']='View category';
		$this->load->view('template',$data);
	}
	
	
    
	//City
    
    function viewcity()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->city_model->viewcity();
		$data['page']='viewcity';
		$data['title']='View City';
		$this->load->view('template',$data);
	} 
    function viewonecitylocations()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->city_model->viewonecitylocations($this->input->get('cityid'));
		$data['page']='viewonecitylocations';
		$data['title']='View Locations';
		$this->load->view('template',$data);
	}
	public function createcity()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createcity';
		$data[ 'title' ] = 'Create city';
//		$data['location']=$this->location_model->getlocation();
//        $data['category']=$this->category_model->getcategory();
//        $data['topic']=$this->topic_model->gettopic();
//		$data['listingtype']=$this->event_model->getlistingtype();
//		$data['remainingticket']=$this->event_model->getremainingticket();
		$this->load->view( 'template', $data );	
	}
    function createcitysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createcity';
			$data['title']='Create New City';
//			$data['organizer']=$this->organizer_model->getorganizer();
//			$data['listingtype']=$this->event_model->getlistingtype();
//			$data['remainingticket']=$this->event_model->getremainingticket();
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			if($this->city_model->create($name)==0)
			$data['alerterror']="New City could not be created.";
			else
			$data['alertsuccess']="City created Successfully.";
			
			$data['table']=$this->city_model->viewcity();
			$data['redirect']="site/viewcity";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    public function createlocation()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data['cityid']=$this->input->get('cityid');
		$data[ 'page' ] = 'createlocation';
		$data[ 'title' ] = 'Create Location';
//		$data['location']=$this->location_model->getlocation();
//        $data['category']=$this->category_model->getcategory();
//        $data['topic']=$this->topic_model->gettopic();
//		$data['listingtype']=$this->event_model->getlistingtype();
//		$data['remainingticket']=$this->event_model->getremainingticket();
		$this->load->view( 'template', $data );	
	}
    function createlocationsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('pincode','Pincode','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createlocation';
			$data['title']='Create New Location';
//			$data['organizer']=$this->organizer_model->getorganizer();
//			$data['listingtype']=$this->event_model->getlistingtype();
//			$data['remainingticket']=$this->event_model->getremainingticket();
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			$pincode=$this->input->post('pincode');
			$cityid=$this->input->get_post('cityid');
			if($this->city_model->createlocation($name,$cityid,$pincode)==0)
			$data['alerterror']="New Location could not be created.";
			else
			$data['alertsuccess']="Location created Successfully.";
			
			$data['table']=$this->city_model->viewonecitylocations($cityid);
			$data['redirect']="site/viewonecitylocations?cityid=".$cityid;
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
    function editcity()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->city_model->beforeedit($this->input->get('id'));
//		$data['organizer']=$this->organizer_model->getorganizer();
//		$data['listingtype']=$this->event_model->getlistingtype();
//		$data['remainingticket']=$this->event_model->getremainingticket();
//		$data['page2']='block/eventblock';
		$data['page']='editcity';
		$data['title']='Edit City';
		$this->load->view('template',$data);
	}
	function editcitysubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
//			$data['organizer']=$this->organizer_model->getorganizer();
//			$data['listingtype']=$this->event_model->getlistingtype();
//			$data['remainingticket']=$this->event_model->getremainingticket();
			$data['before']=$this->city_model->beforeedit($this->input->post('id'));
//			$data['page2']='block/eventblock';
			$data['page']='editcity';
			$data['title']='Edit City';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$name=$this->input->post('name');
			if($this->city_model->edit($id,$name)==0)
			$data['alerterror']="City Editing was unsuccesful";
			else
			$data['alertsuccess']="City edited Successfully.";
			
			$data['redirect']="site/viewcity";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	function editlocation()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->city_model->beforeeditlocation($this->input->get('id'));
//		$data['organizer']=$this->organizer_model->getorganizer();
//		$data['listingtype']=$this->event_model->getlistingtype();
//		$data['remainingticket']=$this->event_model->getremainingticket();
//		$data['page2']='block/eventblock';
		$data['page']='editlocation';
		$data['title']='Edit Location';
		$this->load->view('template',$data);
	}
	function editlocationsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('pincode','Pincode','trim|required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
//			$data['organizer']=$this->organizer_model->getorganizer();
//			$data['listingtype']=$this->event_model->getlistingtype();
//			$data['remainingticket']=$this->event_model->getremainingticket();
			$data['before']=$this->city_model->beforeedit($this->input->post('id'));
//			$data['page2']='block/eventblock';
			$data['page']='editcity';
			$data['title']='Edit City';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->get_post('id');
			$cityid=$this->input->get_post('cityid');
			$name=$this->input->post('name');
			$pincode=$this->input->post('pincode');
			if($this->city_model->editlocation($id,$cityid,$name,$pincode)==0)
			$data['alerterror']="Location Editing was unsuccesful";
			else
			$data['alertsuccess']="Location edited Successfully.";
			
			$data['redirect']="site/viewonecitylocations?cityid=".$cityid;
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
    
	function deletecity()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->city_model->deletecity($this->input->get('id'));
		$data['table']=$this->city_model->viewcity();
		$data['alertsuccess']="City Deleted Successfully";
		$data['page']='viewcity';
		$data['title']='View City';
		$this->load->view('template',$data);
	}
     
	function deletelocation()
	{
		$access = array("1");
		$this->checkaccess($access);
        $cityid=$this->input->get('cityid');
		$this->city_model->deletelocation($this->input->get('id'));
		$data['table']=$this->city_model->viewonecitylocations($cityid);
		$data['alertsuccess']="City Deleted Successfully";
		$data['page']='viewonecitylocations';
		$data['title']='View Location';
		$this->load->view('template',$data);
	}
    
  //listing
    
   
    
     //$ret = array();
     public function getarray($data,$parents)
    {
        $ret = array();
        if($parents=="")
        {
            $name=$data->name;
        }
        else
        {
            $name=$parents." :: ".ucfirst($data->name);
        }
        $childrens=$data->children;
        $num=sizeof($childrens); 
        if($num>0)
        {
            for($i=0;$i<sizeof($data->children);$i++)
            {
                $newret=$this->getarray($data->children[$i],$name);
                $ret=array_merge($ret,$newret);   
            }
            
            return $ret;
        }
        else
        {
            $sinret=array();
            $sinret[$data->id]=$name;
            
            array_push($ret,$sinret);
            return $ret;
        }
    }
    
    
    
   
    public function cattt()
    {
    $data[ 'category' ] =$this->category_model->getcategoryforlistingdropdown();
        print_r($data[ 'category' ]);
    }
	public function createbilling()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'paymenttype' ] =$this->paymenttype_model->getpaymenttypedropdown();
		$data[ 'period' ] =$this->paymenttype_model->getperioddropdown();
		$data[ 'user' ] =$this->listing_model->getuserdropdown();
		$data[ 'listing' ] =$this->listing_model->getlistingdropdown();
		$data[ 'page' ] = 'createbilling';
		$data[ 'title' ] = 'Create billing';
		$this->load->view( 'template', $data );	
	}
    
	function createbillingsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('listing','Listing','trim');
		$this->form_validation->set_rules('user','User','trim');
		$this->form_validation->set_rules('paymenttype','paymenttype','trim|');
		$this->form_validation->set_rules('amount','amount','trim');
		$this->form_validation->set_rules('period','period','trim');
		$this->form_validation->set_rules('credits','credits','trim');
		$this->form_validation->set_rules('payedto','payedto','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'paymenttype' ] =$this->paymenttype_model->getpaymenttypedropdown();
            $data[ 'period' ] =$this->paymenttype_model->getperioddropdown();
            $data[ 'user' ] =$this->listing_model->getuserdropdown();
            $data[ 'listing' ] =$this->listing_model->getlistingdropdown();
            $data[ 'page' ] = 'createbilling';
            $data[ 'title' ] = 'Create billing';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $listing=$this->input->post('listing');
			$user=$this->input->post('user');
			$paymenttype=$this->input->post('paymenttype');
			$amount=$this->input->post('amount');
            $period=$this->input->post('period');
            $credits=$this->input->post('credits');
            $payedto=$this->input->post('payedto');
            
			if($this->billing_model->create($listing,$user,$paymenttype,$amount,$period,$credits,$payedto)==0)
			$data['alerterror']="New billing could not be created.";
			else
			$data['alertsuccess']="billing created Successfully.";
			
			$data['table']=$this->billing_model->viewbilling();
			$data['redirect']="site/viewbilling";
			$this->load->view("redirect",$data);
		}
	}
    
	function editbilling()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data[ 'paymenttype' ] =$this->paymenttype_model->getpaymenttypedropdown();
        $data[ 'period' ] =$this->paymenttype_model->getperioddropdown();
        $data[ 'user' ] =$this->listing_model->getuserdropdown();
        $data[ 'listing' ] =$this->listing_model->getlistingdropdown();
		$data['before']=$this->billing_model->beforeedit($this->input->get('id'));
		$data['page']='editbilling';
		$data['title']='Edit billing';
		$this->load->view('template',$data);
	}
       
	function editbillingsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('listing','Listing','trim');
		$this->form_validation->set_rules('user','User','trim');
		$this->form_validation->set_rules('paymenttype','paymenttype','trim|');
		$this->form_validation->set_rules('amount','amount','trim');
		$this->form_validation->set_rules('period','period','trim');
		$this->form_validation->set_rules('credits','credits','trim');
		$this->form_validation->set_rules('payedto','payedto','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'paymenttype' ] =$this->paymenttype_model->getpaymenttypedropdown();
            $data[ 'period' ] =$this->paymenttype_model->getperioddropdown();
            $data[ 'user' ] =$this->listing_model->getuserdropdown();
            $data[ 'listing' ] =$this->listing_model->getlistingdropdown();
            $data['before']=$this->billing_model->beforeedit($this->input->get('id'));
            $data['page']='editbilling';
            $data['title']='Edit billing';
            $this->load->view('template',$data);
		}
		else
		{
            $id=$this->input->post('id');
            $listing=$this->input->post('listing');
			$user=$this->input->post('user');
			$paymenttype=$this->input->post('paymenttype');
			$amount=$this->input->post('amount');
            $period=$this->input->post('period');
            $credits=$this->input->post('credits');
            $payedto=$this->input->post('payedto');
            
			if($this->billing_model->edit($id,$listing,$user,$paymenttype,$amount,$period,$credits,$payedto)==0)
			$data['alerterror']="billing Editing was unsuccesful";
			else
			$data['alertsuccess']="billing edited Successfully.";
			
			$data['redirect']="site/viewbilling";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deletebilling()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->billing_model->deletebilling($this->input->get('id'));
		$data['table']=$this->billing_model->viewbilling();
		$data['alertsuccess']="billing Deleted Successfully";
		$data['page']='viewbilling';
		$data['title']='View billing';
		$this->load->view('template',$data);
	}
    
    //position
    
	function viewposition()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->position_model->viewposition();
		$data['page']='viewposition';
		$data['title']='View position';
		$this->load->view('template',$data);
	}
    
	public function createposition()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createposition';
		$data[ 'title' ] = 'Create position';
		$this->load->view( 'template', $data );	
	}
    
	function createpositionsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('height','height','trim');
		$this->form_validation->set_rules('width','width','trim');
		
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'page' ] = 'createposition';
            $data[ 'title' ] = 'Create position';
            $this->load->view( 'template', $data );
		}
		else
		{
            $name=$this->input->post('name');
            $height=$this->input->post('height');
            $width=$this->input->post('width');
			
			if($this->position_model->create($name,$height,$width)==0)
			$data['alerterror']="New Mode of payment could not be created.";
			else
			$data['alertsuccess']="position created Successfully.";
			
			$data['table']=$this->position_model->viewposition();
			$data['redirect']="site/viewposition";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
    function editposition()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->position_model->beforeedit($this->input->get('id'));
		$data['page']='editposition';
		$data['title']='Edit position';
		$this->load->view('template',$data);
	}
	function editpositionsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('height','height','trim');
		$this->form_validation->set_rules('width','width','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->position_model->beforeedit($this->input->get('id'));
            $data['page']='editposition';
            $data['title']='Edit position';
            $this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$name=$this->input->post('name');
            $height=$this->input->post('height');
            $width=$this->input->post('width');
			if($this->position_model->edit($id,$name,$height,$width)==0)
			$data['alerterror']="position Editing was unsuccesful";
			else
			$data['alertsuccess']="position edited Successfully.";
			
			$data['redirect']="site/viewposition";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deleteposition()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->position_model->deleteposition($this->input->get('id'));
		$data['table']=$this->position_model->viewposition();
		$data['alertsuccess']="position Deleted Successfully";
		$data['page']='viewposition';
		$data['title']='View position';
		$this->load->view('template',$data);
	}
    
    //add
    
//	function viewadd()
//	{
//		$access = array("1");
//		$this->checkaccess($access);
//		$data['table']=$this->add_model->viewadd();
//		$data['page']='viewadd';
//		$data['title']='View add';
//		$this->load->view('template',$data);
//	}
    
    
    function viewadd()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewadd';
        
        
        $data['base_url'] = site_url("site/viewaddjson");
        
        
		$data['title']='View add';
		$this->load->view('template',$data);
	} 
    
    function viewaddjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
//        SELECT `specialoffer`.`id`, `specialoffer`.`name`, `specialoffer`.`category`, `specialoffer`.`email`, `specialoffer`.`phone`, `specialoffer`.`timestamp`, `specialoffer`.`deletestatus`,`category`.`name` AS `categoryname` 
//        FROM `specialoffer` 
//        LEFT OUTER JOIN `category` ON `category`.`id`=`specialoffer`.`category`
            
//        SELECT `add`.`id`, `add`.`name`, `add`.`image`, `add`.`position`, `add`.`timestamp`, `add`.`fromtimestamp`, `add`.`totimestamp`, `add`.`details`, `add`.`deletestatus`,`position`.`name`as `positionname` 
//        FROM `add`
//        INNER JOIN `position` ON `position`.`id`=`add`.`position`
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`add`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`add`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Add Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`position`.`name`";
        $elements[2]->sort="1";
        $elements[2]->header="Position";
        $elements[2]->alias="positionname";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`add`.`fromtimestamp`";
        $elements[3]->sort="1";
        $elements[3]->header="fromtimestamp";
        $elements[3]->alias="fromtimestamp";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`add`.`totimestamp`";
        $elements[4]->sort="1";
        $elements[4]->header="ToTimestamp";
        $elements[4]->alias="totimestamp";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`add`.`details`";
        $elements[5]->sort="1";
        $elements[5]->header="Details";
        $elements[5]->alias="details";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"  FROM `add` INNER JOIN `position` ON `position`.`id`=`add`.`position`");
        
		$this->load->view("json",$data);
	} 
    
    
	public function createadd()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data[ 'position' ] =$this->position_model->getpositiondropdown();
		$data[ 'page' ] = 'createadd';
		$data[ 'title' ] = 'Create add';
		$this->load->view( 'template', $data );	
	}
    
	function createaddsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('position','position','trim');
		$this->form_validation->set_rules('fromtimestamp','fromtimestamp','trim');
		$this->form_validation->set_rules('totimestamp','totimestamp','trim');
		$this->form_validation->set_rules('details','details','trim');
		
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'position' ] =$this->position_model->getpositiondropdown();
            $data[ 'page' ] = 'createadd';
            $data[ 'title' ] = 'Create add';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $position=$this->input->post('position');
            $fromtimestamp=$this->input->post('fromtimestamp');
            $totimestamp=$this->input->post('totimestamp');
            $details=$this->input->post('details');
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
			if($this->add_model->create($name,$position,$fromtimestamp,$totimestamp,$details,$image)==0)
			$data['alerterror']="New Add could not be created.";
			else
			$data['alertsuccess']="add created Successfully.";
			
			$data['table']=$this->add_model->viewadd();
			$data['redirect']="site/viewadd";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
    function editadd()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data[ 'position' ] =$this->position_model->getpositiondropdown();
		$data['before']=$this->add_model->beforeedit($this->input->get('id'));
		$data['page']='editadd';
		$data['title']='Edit add';
		$this->load->view('template',$data);
	}
	function editaddsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('position','position','trim');
		$this->form_validation->set_rules('fromtimestamp','fromtimestamp','trim');
		$this->form_validation->set_rules('totimestamp','totimestamp','trim');
		$this->form_validation->set_rules('details','details','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'position' ] =$this->position_model->getpositiondropdown();
            $data['before']=$this->add_model->beforeedit($this->input->get('id'));
            $data['page']='editadd';
            $data['title']='Edit add';
            $this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
            $name=$this->input->post('name');
            $position=$this->input->post('position');
            $fromtimestamp=$this->input->post('fromtimestamp');
            $totimestamp=$this->input->post('totimestamp');
            $details=$this->input->post('details');
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
            if($image=="")
            {
            $image=$this->add_model->getaddimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }
			if($this->add_model->edit($id,$name,$position,$fromtimestamp,$totimestamp,$details,$image)==0)
			$data['alerterror']="add Editing was unsuccesful";
			else
			$data['alertsuccess']="add edited Successfully.";
			
			$data['redirect']="site/viewadd";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deleteadd()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->add_model->deleteadd($this->input->get('id'));
		$data['table']=$this->add_model->viewadd();
		$data['alertsuccess']="add Deleted Successfully";
		$data['page']='viewadd';
		$data['title']='View add';
		$this->load->view('template',$data);
	}
    
     //email
    
    public function sendmailtoavi()
    {
        $email='avinash@wohlig.com';
        $this->load->library('email');
        //$email='patiljagruti181@gmail.com,jagruti@wohlig.com';
        $this->email->from('avinash@wohlig.com', 'For Any Information');
        $this->email->to($email);
        $this->email->subject('Email Test');
        $data['link']='google.com';
        $this->email->message($this->load->view('emailmsg',$data,true));

        $this->email->send();

        echo $this->email->print_debugger();
    }
    
    public function sendemail()
    {
        $userid=$this->input->get('userid');
        $listingid=$this->input->get('listingid');
        $user=$this->user_model->getallinfoofuser($userid);
//        print_r($user);
        $touser=$user->email;
        $listing=$this->listing_model->getallinfooflisting($listingid);
//        print_r($user);
        $tolisting= $listing->email;
        $listingname= $listing->name;
        $listingaddress= $listing->address;
        $listingstate= $listing->state;
        $listingcontactno= $listing->contactno;
        $listingemail= $listing->email;
        $listingyearofestablishment= $listing->yearofestablishment;
        $usermsg="<h3>All Details Of Listing</h3><br>Listing Name:'$listingname' <br>Listing address:'$listingaddress' <br>Listing state:'$listingstate' <br>Listing contactno:'$listingcontactno' <br>Listing email:'$listingemail' <br>Listing yearofestablishment:'$listingyearofestablishment' <br>";
//        echo $msg;
        //to user
        $this->load->library('email');
        $this->email->from('avinash@wohlig.com', 'For Any Information To User');
        $this->email->to($touser);
        $this->email->subject('Listing Details');
        $this->email->message($usermsg);

        $this->email->send();
        
        //to listing
        $firstname=$user->firstname;
        $lastname=$user->lastname;
        $email=$user->email;
        $contact=$user->contact;
        $listingmsg="<h3>All Details Of user</h3><br>user Name:'$firstname' <br>user Last Name:'$lastname' <br>user Email:'$email' <br>user contact:'$contact'";
        
        $this->load->library('email');
        $this->email->from('avinash@wohlig.com', 'For Any Information Listing');
        $this->email->to($tolisting);
        $this->email->subject('User Details');
        $this->email->message($listingmsg);

        $this->email->send();

        echo $this->email->print_debugger();
    }
    public function submitnumber()
    {
        $number=$this->input->get_post("number");
        $data1=$this->enquiry_model->getdetailsorcreate($number);
        $data["message"]=$data1;
//        print_r($data);
        $this->load->view("json",$data);
    }
    public function submitcategoryenquiry()
    {
        $category=$this->input->get_post("categoryvalue");
        $enquiryid=$this->input->get_post("userid");
//        echo $category;
//        echo $userid;
        $data1=$this->enquiry_model->addcategorytoenquiry($enquiryid,$category);
        $data["message"]=$data1;
//        print_r($data);
        $this->load->view("json",$data);
    }
    public function submitlistingenquiry()
    {
        $listing=$this->input->get_post("listingvalue");
        $enquiryid=$this->input->get_post("userid");
//        echo $listing;
//        echo $userid;
        $data1=$this->enquiry_model->addlistingtoenquiry($enquiryid,$listing);
        $data["message"]=$data1;
//        print_r($data);
        $this->load->view("json",$data);
    }
    
    public function submituserdetails()
    {
        $enquiryid=$this->input->get_post("userid");
        $name=$this->input->get_post("username");
        $phone=$this->input->get_post("userphone");
        $email=$this->input->get_post("useremail");
//        echo $listing;
//        echo $userid;
        $data1=$this->enquiry_model->adduserdetails($enquiryid,$name,$phone,$email);
        $data["message"]=$data1;
//        print_r($data);
        $this->load->view("json",$data);
    }
    
	function viewtree()
	{
		$access = array("1");
		$this->checkaccess($access);
//		$data['table']=$this->add_model->viewadd();
		$data['page']='viewtree';
		$data['title']='View Tree';
		$this->load->view('template',$data);
	}
	function viewcategory()
	{
		$access = array("1");
		$this->checkaccess($access);
//		$data['table']=$this->add_model->viewadd();
		$data['table']=$this->category_model->viewparentcategory();
		$data['page']='viewcategorytree';
		$data['title']='View Tree';
		$this->load->view('template',$data);
	}
    
    public function getsubcategorybyparent()
    {
        $categoryid=$this->input->get_post("categoryid");
        $data1=$this->category_model->getsubcategorybyparent($categoryid);
        $data["message"]=$data1;
//        print_r($data);
        $this->load->view("json",$data);
    }
    
    
    public function getlistingbycategory($id)
    {
   $data1=$this->listing_model->getlistingbycategorydropdown($id);
        
        
            $data["message"]=$data1;
//        print_r($data);
            $this->load->view("json",$data);
  
            
        
    }
    
    function uploadlistingcsv()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data[ 'category' ] =$this->category_model->getcategoryforlistingdropdown();
		$data[ 'page' ] = 'uploadlistingcsv';
		$data[ 'title' ] = 'Upload Listing';
		$this->load->view( 'template', $data );
	} 
    
    function uploadlistingcsvsubmit()
	{
        $access = array("1");
		$this->checkaccess($access);
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);
        $filename="file";
        $file="";
        if (  $this->upload->do_upload($filename))
        {
            $uploaddata = $this->upload->data();
            $file=$uploaddata['file_name'];
            $filepath=$uploaddata['file_path'];
        }
        $fullfilepath=$filepath."".$file;
        $file = $this->csvreader->parse_file($fullfilepath);
        $category=$this->input->get_post('category');
        $id1=$this->listing_model->createbycsv($file,$category);
//        echo $id1;
        
        if($id1==0)
        $data['alerterror']="New listings could not be Uploaded.";
		else
		$data['alertsuccess']="listings Uploaded Successfully.";
        
        $data['redirect']="site/viewlisting";
        $this->load->view("redirect",$data);
    }
    
    
    function viewnormalusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewnormalusers';
        
        
        $data['base_url'] = site_url("site/viewnormaluserjson");
        
        
		$data['title']='View user';
		$this->load->view('template',$data);
	} 
    
    function viewnormaluserjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
//        SELECT DISTINCT `user`.`id` as `id`,`user`.`firstname` as `firstname`,`user`.`lastname` as `lastname`,`accesslevel`.`name` as `accesslevel`	,`user`.`email` as `email`,`user`.`contact` as `contact`,`user`.`status` as `status`,`user`.`accesslevel` as `access`
//		FROM `user`
//	   INNER JOIN `accesslevel` ON `user`.`accesslevel`=`accesslevel`.`id` 
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`user`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        $elements[1]=new stdClass();
        $elements[1]->field="`user`.`firstname`";
        $elements[1]->sort="1";
        $elements[1]->header="First Name";
        $elements[1]->alias="firstname";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`user`.`lastname`";
        $elements[2]->sort="1";
        $elements[2]->header="Last Name";
        $elements[2]->alias="lastname";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`accesslevel`.`name`";
        $elements[3]->sort="1";
        $elements[3]->header="Accesslevel";
        $elements[3]->alias="accesslevel";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`user`.`email`";
        $elements[4]->sort="1";
        $elements[4]->header="Email";
        $elements[4]->alias="email";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`contact`";
        $elements[5]->sort="1";
        $elements[5]->header="Contact";
        $elements[5]->alias="contact";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` INNER JOIN `accesslevel` ON `user`.`accesslevel`=`accesslevel`.`id`","WHERE `user`.`accesslevel`=3");
        
		$this->load->view("json",$data);
	} 
    public function createnormaluser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'page' ] = 'createnormaluser';
		$data[ 'title' ] = 'Create Frontend User';
		$this->load->view( 'template', $data );	
	}
	function createnormalusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('firstname','First Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('lastname','Last Name','trim|max_length[30]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
//		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('contact','contactno','trim');
		$this->form_validation->set_rules('phoneno','phoneno','trim');
//		$this->form_validation->set_rules('website','Website','trim|max_length[50]');
//		$this->form_validation->set_rules('description','Description','trim|');
		$this->form_validation->set_rules('address','Address','trim|');
		$this->form_validation->set_rules('city','City','trim|max_length[30]');
		$this->form_validation->set_rules('pincode','Pincode','trim|max_length[20]');
		$this->form_validation->set_rules('state','state','trim|max_length[20]');
		$this->form_validation->set_rules('country','country','trim|max_length[20]');
		$this->form_validation->set_rules('facebookuserid','facebookuserid','trim|max_length[20]');
		$this->form_validation->set_rules('google','google','trim|max_length[20]');
		$this->form_validation->set_rules('email','Email','trim|valid_email');
		$this->form_validation->set_rules('status','Status','trim');
		$this->form_validation->set_rules('dob','DOB','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data[ 'page' ] = 'createnormaluser';
            $data[ 'title' ] = 'Create Frontend User';
            $this->load->view( 'template', $data );		
		}
		else
		{
            $website=$this->input->post('website');
            $dob=$this->input->post('dob');
            $description=$this->input->post('description');
            $address=$this->input->post('address');
            $city=$this->input->post('city');
            $pincode=$this->input->post('pincode');
			$password=$this->input->post('password');
			if($dob != "")
			{
				$dob = date("Y-m-d",strtotime($dob));
			}
//			$accesslevel=$this->input->post('accesslevel');
			$accesslevel=3;
			$email=$this->input->post('email');
			$contact=$this->input->post('contact');
			$phoneno=$this->input->post('phoneno');
			$google=$this->input->post('google');
			$state=$this->input->post('state');
			$country=$this->input->post('country');
			$status=$this->input->post('status');
			$facebookuserid=$this->input->post('facebookuserid');
			$firstname=$this->input->post('firstname');
			$lastname=$this->input->post('lastname');
			if($this->user_model->create($firstname,$lastname,$dob,$password,$accesslevel,$email,$contact,$status,$facebookuserid,$website,$description,$address,$city,$pincode,$phoneno,$google,$state,$country)==0)
			$data['alerterror']="Normal user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			
//			$data['table']=$this->user_model->viewusers();
			$data['redirect']="site/viewnormalusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
   
	function editnormaluser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='editnormaluser';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('template',$data);
	}
	function editnormalusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
//		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('contact','contactno','trim');
		$this->form_validation->set_rules('phoneno','phoneno','trim');
		$this->form_validation->set_rules('google','google','trim');
		$this->form_validation->set_rules('state','state','trim');
		$this->form_validation->set_rules('country','country','trim');
		$this->form_validation->set_rules('website','Website','trim|max_length[50]');
//		$this->form_validation->set_rules('description','Description','trim|');
		$this->form_validation->set_rules('address','Address','trim|');
		$this->form_validation->set_rules('city','City','trim|max_length[30]');
		$this->form_validation->set_rules('pincode','Pincode','trim|max_length[20]');
        
		$this->form_validation->set_rules('fname','First Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('lname','Last Name','trim|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|valid_email');
		$this->form_validation->set_rules('status','Status','trim');
		$this->form_validation->set_rules('dob','DOB','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data['accesslevel']=$this->user_model->getaccesslevels();
            $data['before']=$this->user_model->beforeedit($this->input->get_post('id'));
            $data['page']='editnormaluser';
            $data['page2']='block/userblock';
            $data['title']='Edit User';
            $this->load->view('template',$data);
		}
		else
		{
            $website=$this->input->post('website');
            $description=$this->input->post('description');
            $address=$this->input->post('address');
            $city=$this->input->post('city');
            $pincode=$this->input->post('pincode');
			$id=$this->input->post('id');
			$password=$this->input->post('password');
			$dob=$this->input->post('dob');
			if($dob != "")
			{
				$dob = date("Y-m-d",strtotime($dob));
			}
			$accesslevel=3;
			$contact=$this->input->post('contact');
			$phoneno=$this->input->post('phoneno');
			$google=$this->input->post('google');
			$state=$this->input->post('state');
			$country=$this->input->post('country');
			$status=$this->input->post('status');
			$facebookuserid=$this->input->post('facebookuserid');
			$fname=$this->input->post('fname');
			$lname=$this->input->post('lname');
			if($this->user_model->edit($id,$fname,$lname,$dob,$password,$accesslevel,$contact,$status,$facebookuserid,$website,$description,$address,$city,$pincode,$phoneno,$google,$state,$country)==0)
			$data['alerterror']="Frontend User Editing was unsuccesful";
			else
			$data['alertsuccess']="Frontend User edited Successfully.";
			
			$data['redirect']="site/viewnormalusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletenormaluser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
		$data['alertsuccess']="Frontend User Deleted Successfully";
		$data['redirect']="site/viewnormalusers";
		$this->load->view("redirect",$data);
	}
     
	function viewnotification()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['monthbefore']=$this->category_model->getmonthbeforenotifications();
		$data['fivedaysbefore']=$this->category_model->getfivedaysbeforenotifications();
		$data['page']='viewnotification';
		$data['title']='View Notifications';
		$this->load->view('template',$data);
	}
    
	function editnotification()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->category_model->beforeeditcategory($this->input->get('id'));
		$data['category']=$this->category_model->getcategorydropdown();
		$data[ 'status' ] =$this->category_model->getstatusdropdown();
		$data['typeofimage']=$this->category_model->gettypeofimagedropdown();
		$data['page']='editnotification';
		$data['title']='Edit Notification';
		$this->load->view('template',$data);
	}
	function editnotificationsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('startdateofbanner','startdateofbanner','trim|');
		$this->form_validation->set_rules('enddateofbanner','enddateofbanner','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->category_model->getstatusdropdown();
			$data['category']=$this->category_model->getcategorydropdown();
            $data['typeofimage']=$this->category_model->gettypeofimagedropdown();
			$data['before']=$this->category_model->beforeeditcategory($this->input->post('id'));
			$data['page']='editcategory';
			$data['title']='Edit category';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			
			$startdateofbanner=$this->input->post('startdateofbanner');
			$enddateofbanner=$this->input->post('enddateofbanner');
			
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="banner";
			$banner="";
			if (  $this->upload->do_upload($filename))
			{
                
				$uploaddata = $this->upload->data();
				$banner=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $banner=$this->image_lib->dest_image;
                    //return false;
                }
                
                
			}
            if($banner=="")
            {
                
                $banner=$this->category_model->getcategorybannerbyid($id);
                $banner=$banner->banner;
                
            }
			if($this->category_model->editnotification($id,$banner,$startdateofbanner,$enddateofbanner)==0)
			$data['alerterror']="Notification Dates Editing was unsuccesful";
			else
			$data['alertsuccess']="Notification Dates edited Successfully.";
			$data['redirect']="site/viewnotification";
			$this->load->view("redirect",$data);
		}
	}
    
//    function viewnotification()
//	{
//		$access = array("1");
//		$this->checkaccess($access);
//		$data['page']='viewnotification';
//        
//        
//        $data['base_url'] = site_url("site/viewnotificationjson");
//        
//        
//		$data['title']='View Notifications';
//		$this->load->view('template',$data);
//	} 
//    
//    function viewnotificationjson()
//	{
//		$access = array("1");
//		$this->checkaccess($access);
//         
////        SELECT `id`, `name`, `parent`, `status`, `typeofimage`, `logo`, `image`, `banner`, `startdateofbanner`, `enddateofbanner` ,NOW() AS `today`,DATE(DATE_SUB(NOW(), INTERVAL 1 day)) AS `monthbefore`
////FROM `category` 
////HAVING `enddateofbanner`=`monthbefore`
//        
//        
//        $elements=array();
//        $elements[0]=new stdClass();
//        $elements[0]->field="`category`.`id`";
//        $elements[0]->sort="1";
//        $elements[0]->header="ID";
//        $elements[0]->alias="id";
//        
//        $elements[1]=new stdClass();
//        $elements[1]->field="`category`.`banner`";
//        $elements[1]->sort="1";
//        $elements[1]->header="Banner";
//        $elements[1]->alias="banner";
//        
//        $elements[2]=new stdClass();
//        $elements[2]->field="`category`.`startdateofbanner`";
//        $elements[2]->sort="1";
//        $elements[2]->header="Start Date";
//        $elements[2]->alias="startdateofbanner";
//        
//        $elements[3]=new stdClass();
//        $elements[3]->field="`category`.`enddateofbanner`";
//        $elements[3]->sort="1";
//        $elements[3]->header="End Date";
//        $elements[3]->alias="enddateofbanner";
//        
//        $elements[4]=new stdClass();
//        $elements[4]->field="DATE(DATE_SUB(NOW(), INTERVAL 1 day))";
//        $elements[4]->sort="1";
//        $elements[4]->header="monthbefore";
//        $elements[4]->alias="monthbefore";
//        
//        $search=$this->input->get_post("search");
//        $pageno=$this->input->get_post("pageno");
//        $orderby=$this->input->get_post("orderby");
//        $orderorder=$this->input->get_post("orderorder");
//        $maxrow=$this->input->get_post("maxrow");
//        if($maxrow=="")
//        {
//            $maxrow=20;
//        }
//        
//        if($orderby=="")
//        {
//            $orderby="id";
//            $orderorder="ASC";
//        }
//       
//        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `category`","","","HAVING `enddateofbanner`=`monthbefore`");
//        
//		$this->load->view("json",$data);
//	} 
    
}
?>