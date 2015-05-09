<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Json extends CI_Controller 
{
	
	function savequantity()
	{
		$product=$this->input->get_post('product');
		$quantity=$this->input->get_post('quantity');
		$data["message"]=$this->product_model->savequantity($product,$quantity);
		$this->load->view("json",$data);
	}
    function type ()
    {
        $data["message"]=$this->frontend_model->type();
		$this->load->view("json",$data);
    }
    public function getallparentcategories()
    {
        $data['message']=$this->category_model->getallparentcategories();
		$this->load->view('json',$data);
    }
    
    
    function saveprofile()
	{
        $data = json_decode(file_get_contents('php://input'), true);
//        print_r($data);
            $firstname=$data['firstname'];
			$lastname=$data['lastname'];
			$email=$data['email'];
			$contact=$data['contact'];
			$phoneno=$data['phoneno'];
            $dob=$data['dob'];
            $website=$data['website'];
            $address=$data['address'];
            $city=$data['city'];
            $pincode=$data['pincode'];
			$state=$data['state'];
            $country=$data['country'];
			$google=$data['google'];
			$facebookuserid=$data['facebookuserid'];
            $id=$data['id'];
            
			if($this->frontend_model->saveprofile($id,$firstname,$lastname,$email,$contact,$phoneno,$dob,$website,$address,$city,$pincode,$state,$country,$google,$facebookuserid)==0)
			$data['message']=0;
			else
			$data['message']=1;
        
        $this->load->view('json',$data);
		
	}
    
    
    function createlisting()
	{
        $data = json_decode(file_get_contents('php://input'), true);
        print_r($data);
            $name=$data['name'];
			$user=$data['user'];
			$lat=$data['latitude'];
			$long=$data['longitude'];
            $address=$data['address'];
            $area=$data['area'];
            $city=$data['city'];
            $pincode=$data['pincode'];
            $state=$data['state'];
			$country=$data['country'];
            $description=$data['description'];
			$contact=$data['contact'];
			$email=$data['email'];
            $website=$data['website'];
			$facebookuserid=$data['facebook'];
			$googleplus=$data['googleplus'];
			$twitter=$data['twitter'];
			$yearofestablishment=$data['yearofestablishment'];
			$timeofoperation_start=$data['timeofoperationstart'];
			$timeofoperation_end=$data['timeofoperationend'];
			$type=$data['type'];
			$credits=$data['credits'];
			$video=$data['video'];
            
            $category=$data['category'];
            $modeofpayment=$data['modeofpayment'];
            $daysofoperation=$data['daysofoperation'];
            $logo=$data['logo'];
            
			if($this->frontend_model->createlisting($name,$user,$lat,$long,$address,$area,$city,$pincode,$state,$country,$description,$contact,$email,$website,$facebookuserid,$googleplus,$twitter,$yearofestablishment,$timeofoperation_start,$timeofoperation_end,$type,$credits,$video,$logo,$category,$modeofpayment,$daysofoperation)==0)
			$data['message']="0";
			else
			$data['message']="1";
        
        $this->load->view('json',$data);
		
	}
    public function enquiryuser()
    {
        $name=$this->input->get_post("name");
        $listingid=$this->input->get_post("listing");
        $email=$this->input->get_post("email");
        $phone=$this->input->get_post("phone");
        $type=$this->input->get_post("type");
        $comment=$this->input->get_post("comment");
        
        
            $listing=$this->listing_model->getallinfooflisting($listingid);
            $tolisting= $listing->email;
            $listingname= $listing->name;
            $listingaddress= $listing->address;
            $listingstate= $listing->state;
            $listingcontactno= $listing->contactno;
            $listingemail= $listing->email;
            $listingyearofestablishment= $listing->yearofestablishment;
            
            $usermsg="<h3>All Details Of Listings which you makes an Enquiry</h3><br>Listing Name:'$listingname' <br>Listing address:'$listingaddress' <br>Listing state:'$listingstate' <br>Listing contactno:'$listingcontactno' <br>Listing email:'$listingemail' <br>Listing yearofestablishment:'$listingyearofestablishment' <br>";
            
            $this->load->library('email');
            $this->email->from('avinash@wohlig.com', 'For Any Information To User');
            $this->email->to($email);
            $this->email->subject('Listing Details');
            $this->email->message($usermsg);

            $this->email->send();
//            echo $usermsg."<br>";
            //to listing
//            $firstname=$user->firstname;
//            $lastname=$user->lastname;
//            $email=$user->email;
//            $contact=$user->contact;
            $listingmsg="<h3>All Details Of user</h3><br>user Name:'$name' <br>user Email:'$email' <br>user contact:'$phone'<br>user Comment:'$comment'";
//echo $listingmsg;
            $this->load->library('email');
            $this->email->from('avinash@wohlig.com', 'For Any Information Listing');
            $this->email->to($listingemail);
            $this->email->subject('User Details');
            $this->email->message($listingmsg);

            $this->email->send();

//            echo $this->email->print_debugger();
        
        $data['message']=$this->enquiry_model->enquiryuser($name,$listingid,$email,$phone,$type,$comment);
        $this->load->view('json',$data);
    }
    public function login()
    {
        $email=$this->input->get("email");
        $password=$this->input->get("password");
        $data['message']=$this->user_model->login($email,$password);
        $this->load->view('json',$data);
    }
    public function logout()
    {
        $this->session->sess_destroy();
        
		$this->load->view('json',true);
    }
    public function authenticate()
    {
        $data['message']=$this->user_model->authenticate();
		$this->load->view('json',$data);
    }
    public function signup()
    {
        $firstname=$this->input->get_post("firstname");
        $lastname=$this->input->get_post("lastname");
        $phoneno=$this->input->get_post("phoneno");
        $email=$this->input->get_post("email");
        $password=$this->input->get_post("password");
        $data['message']=$this->user_model->frontendsignup($firstname, $lastname, $phoneno, $email, $password);
        $this->load->view('json',$data);
        
    }
    
    public function getalllocationcityvise()
    {
        $id=$this->input->get_post('id');
        $data['message']=$this->city_model->getalllocationcityvise($id);
		$this->load->view('json',$data);
    }
    
    public function viewonecitylocations()
    {
        $id=$this->input->get_post('id');
        $data['message']=$this->city_model->viewonecitylocations($id);
		$this->load->view('json',$data);
    }

    public function getsubcategory()
    {
        $id=$this->input->get_post('id');
        $data['message']=$this->category_model->getsubcategory($id);
		$this->load->view('json',$data);
    }
    
    public function getcategory()
    {
        $data['message']=$this->category_model->getcategory();
		$this->load->view('json',$data);
    }
    
    public function getcategoryfront()
    {
        $data['message']=$this->category_model->getcategoryfront();
		$this->load->view('json',$data);
    }
    
    public function getfilter()
    {
        $id=$this->input->get_post('id');
        $data['message']=$this->category_model->getfilter($id);
		$this->load->view('json',$data);
    }
    public function getlistingbycategory()
    {
        $categoryid=$this->input->get_post('id');
        $data['message']=$this->listing_model->getlistingbycategory($categoryid);
		$this->load->view('json',$data);
    }
    public function getonelistingbyid()
    {
        $listingid=$this->input->get_post('id');
        $data['message']=$this->listing_model->getonelistingbyid($listingid);
		$this->load->view('json',$data);
    }
    public function getlistingbycity()
    {
        $cityid=$this->input->get_post('id');
        $data['message']=$this->listing_model->getlistingbycity($cityid);
		$this->load->view('json',$data);
    }
    //search
    
    public function searchcategory()
    {
        $category=$this->input->get_post('categoryname');
        $city=$this->input->get_post('cityname');
        $area=$this->input->get_post('area');
        $lat=$this->input->get_post('lat');
        $long=$this->input->get_post('long');
        $data['message']=$this->category_model->searchcategory($category,$city,$area,$lat,$long);
		$this->load->view('json',$data);
    }

    public function getcategoryinfo()
    {
        $id=$this->input->get_post('id');
        $data['message']=$this->category_model->getcategoryinfo($id);
        $this->load->view('json',$data);
    }
    
    public function getlistingarray()
    {
        
//        $eid=explode(",", $ids);
//        foreach($eid as $id)
//        {
//        $email= $this->db->query("SELECT `id`,`uid`, `eid`, `email` FROM `email` WHERE `id`='$id'")->row();
//        $query=$this->db->query("DELETE FROM `email` WHERE `id`='$id'");
//        }
//        return $email;
        
        $ids=$this->input->get_post('ids');
        $data['message']=$this->listing_model->getlistingarray($ids);
        $this->load->view('json',$data);
    }
    
    public function getallcity()
    {
        $data['message']=$this->city_model->viewcity();
		$this->load->view('json',$data);
    }
    public function alladd()
    {
        $position=$this->input->get_post('position');
        $data['message']=$this->add_model->alladd($position);
		$this->load->view('json',$data);
    }
     public function sendemail()
    {
        $userid=$this->input->get_post('userid');
        $listingid=$this->input->get_post('listingid');
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
    
    function getcategorytree() {
        $data["message"]=$this->category_model->getcategorytree(0);
		$this->load->view("json",$data);
    }
    
    function getcategorydemotree() {
        $data=$this->category_model->getcategorytreeforlisting(0);
        $this->getarray($data);
        
//        print_r($data);
    }
    public function getarray($data)
    {
        $ret = array();
        for($i=0;$i<sizeof($data->children);$i++)
        {
           
//            print_r($data->children[$i]->children);
            if(empty($data->children[$i]->children))
            {
//                print_r($data->children[$i]);
                array_push($ret,$data->children[$i]);
            }else{
                $this->getarray($data->children[$i]);
            }
        }
        return $ret;
    }
    
    
    public function getspecialoffersbycategory()
    {
        $id=$this->input->get_post('categoryid');
        $data['message']=$this->specialoffer_model->getspecialoffersbycategory($id);
        $this->load->view('json',$data);
    }
    public function getuser()
    {
        $id=$this->input->get_post('id');
        $data['message']=$this->user_model->getuser($id);
        $this->load->view('json',$data);
    }
    
    public function addenquiryoflistingfromfrontend()
    {
        $listingid=$this->input->get_post('listingid');
        $name=$this->input->get_post('name');
        $email=$this->input->get_post('email');
        $phone=$this->input->get_post('phone');
        $comment=$this->input->get_post('comment');
        $data['message']=$this->enquiry_model->addenquiryoflistingfromfrontend($listingid,$name,$email,$phone,$comment);
        $this->load->view('json',$data);
    }
    
    public function changepassword()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id=$data['id'];
        $oldpassword=$data['oldpassword'];
        $newpassword=$data['newpassword'];
        $data['message']=$this->user_model->changefrontendpassword($id,$oldpassword,$newpassword);
        $this->load->view('json',$data);
    
    }
    
}
?>