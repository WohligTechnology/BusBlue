<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Enquiry_model extends CI_Model
{
    
    
//    enquiry function jagruti with extrafields
    
	
	public function enquiryuser($name,$listing,$email,$phone,$type,$comment)
	{
        $user=$this->user_model->frontendsignup($email,'');
        
		$data  = array(
			'name' => $name,
//			'listing' => $listing,
			'email' => $email,
			'phone' => $phone,
//            'type'=> $type,
            'enquiryfrom'=> 1,
//            'comment' => $comment
		);
		$query=$this->db->insert( 'enquiry', $data );
		$id=$this->db->insert_id();
		
        $queryenquirylistingcategory=$this->db->query("INSERT INTO `enquirylistingcategory`(`enquiryid`, `typeofenquiry`, `listing`, `comment`) VALUES ('$id','1','$listing','$comment')");
		
		if(!$query)
			return  0;
		else
			return  1;
	}
    
    
    public function create($name,$listing,$email,$phone,$category,$typeofenquiry,$comment)
	{
		$data  = array(
			'name' => $name,
			'email' => $email,
			'phone' => $phone,
			'enquiryfrom' => 2,
            'timestamp'=>NULL
		);
		$query=$this->db->insert( 'enquiry', $data );
		$enquiryid=$this->db->insert_id();
        
        $queryenquirylistingcategory=$this->db->query("INSERT INTO `enquirylistingcategory`(`enquiryid`, `typeofenquiry`, `listing`, `category`, `comment`) VALUES ('$enquiryid','$typeofenquiry','$listing','$category','$comment')");
		
		if(!$query)
			return  0;
		else
			return  1;
	}
    public function createlistingcategory($enquiryid,$listing,$category,$typeofenquiry,$comment)
	{
//		$data  = array(
//			'name' => $name,
//			'email' => $email,
//			'phone' => $phone,
//            'timestamp'=>NULL
//		);
//		$query=$this->db->insert( 'enquiry', $data );
//		$enquiryid=$this->db->insert_id();
//        
        $queryenquirylistingcategory=$this->db->query("INSERT INTO `enquirylistingcategory`(`enquiryid`, `typeofenquiry`, `listing`, `category`, `comment`) VALUES ('$enquiryid','$typeofenquiry','$listing','$category','$comment')");
		
		if(!$queryenquirylistingcategory)
			return  0;
		else
			return  1;
	}
    
	function viewenquiry()
	{
		$query="SELECT `enquiry`.`id`, `enquiry`.`name`, `enquiry`.`listing`, `enquiry`.`email`, `enquiry`.`phone`, `enquiry`.`user`, `enquiry`.`timestamp`, `enquiry`.`deletestatus`,`listing`.`name` AS `listingname`, `enquiry`.`type`, `category`.`name` AS `categoryname`
        FROM `enquiry` 
        LEFT OUTER JOIN `listing` ON `listing`.`id`=`enquiry`.`listing`
        LEFT OUTER JOIN `category` ON `category`.`id`=`enquiry`.`category`
        WHERE `enquiry`.`deletestatus`=1 ";
	   
		$query=$this->db->query($query)->result();
		return $query;
	}
	function viewenquirylistingcategory($id)
	{
		$query="SELECT `enquirylistingcategory`.`id`, `enquirylistingcategory`.`enquiryid`, `enquirylistingcategory`.`typeofenquiry`, `enquirylistingcategory`.`listing`, `enquirylistingcategory`.`category`,`enquirylistingcategory`. `comment`, `enquirylistingcategory`.`timestamp` ,`category`.`name` AS `categoryname`,`listing`.`name` AS `listingname`
        FROM `enquirylistingcategory` 
        LEFT OUTER JOIN `listing` ON `enquirylistingcategory`.`listing`=`listing`.`id`
        LEFT OUTER JOIN `category` ON `enquirylistingcategory`.`category`=`category`.`id`
        WHERE `enquirylistingcategory`.`enquiryid`='$id'";
	   
		$query=$this->db->query($query)->result();
		return $query;
	}
    
	public function getisverifieddropdown()
	{
		$isverified= array(
			 "1" => "Yes",
			 "0" => "No",
			);
		return $isverified;
	}
	public function gettypedropdown()
	{
		$type= array(
			 "1" => "Free",
			 "0" => "Paid",
			);
		return $type;
	}
    
	public function getstatusdropdown()
	{
		$status= array(
			 "1" => "Enabled",
			 "0" => "Disabled",
			);
		return $status;
	}
    
    public function getuserdropdown()
	{
		$query=$this->db->query("SELECT * FROM `user`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->firstname." ".$row->lastname;
		}
		
		return $return;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'enquiry' )->row();
		return $query;
	}
    
	public function getlogobylistingid($id)
	{
		$query=$this->db->query("SELECT `logo` FROM `listing` WHERE `id`='$id'")->row();
		return $query;
	}
	
	public function edit($id,$name,$email,$phone)
	{
		$data  = array(
			'name' => $name,
			'email' => $email,
			'phone' => $phone,
            'timestamp'=>NULL
		);
		
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'enquiry', $data );
		return 1;
	}
	function deleteenquiry($id)
	{
		$query=$this->db->query("DELETE FROM `enquiry` WHERE `id`='$id'");
	}
	function deleteenquirylistingcategory($id)
	{
		$query=$this->db->query("DELETE FROM `enquirylistingcategory` WHERE `id`='$id'");
	}
    
	public function gettypeofenquirydropdown()
	{
		$typeofenquiry= array(
			 "" => "SELECT TYPE",
			 "1" => "Listing",
			 "2" => "Category",
			);
		return $typeofenquiry;
	}
	function changepassword($id,$password)
	{
		$data  = array(
			'password' =>md5($password)
		);
		$this->db->where('id',$id);
		$query=$this->db->update( 'user', $data );
		if(!$query)
			return  0;
		else
			return  1;
	}
	public function getaccesslevels()
	{
		$return=array();
		$query=$this->db->query("SELECT * FROM `accesslevel` ORDER BY `id` ASC")->result();
		$accesslevel=$this->session->userdata('accesslevel');
			foreach($query as $row)
			{
				if($accesslevel==1)
				{
					$return[$row->id]=$row->name;
				}
				else if($accesslevel==2)
				{
					if($row->id > $accesslevel)
					{
						$return[$row->id]=$row->name;
					}
				}
				else if($accesslevel==3)
				{
					if($row->id > $accesslevel)
					{
						$return[$row->id]=$row->name;
					}
				}
				else if($accesslevel==4)
				{
					if($row->id == $accesslevel)
					{
						$return[$row->id]=$row->name;
					}
				}
			}
	
		return $return;
	}
	function changestatus($id)
	{
		$query=$this->db->query("SELECT `status` FROM `user` WHERE `id`='$id'")->row();
		$status=$query->status;
		if($status==1)
		{
			$status=0;
		}
		else if($status==0)
		{
			$status=1;
		}
		$data  = array(
			'status' =>$status,
		);
		$this->db->where('id',$id);
		$query=$this->db->update( 'user', $data );
		if(!$query)
			return  0;
		else
			return  1;
	}
	
	function saveuserlog($id,$action)
	{
		$fromuser = $this->session->userdata('id');
		$data2  = array(
			'onuser' => $id,
			'fromuser' => $fromuser,
			'description' => $action,
		);
		$query2=$this->db->insert( 'userlog', $data2 );
	}
    
     public function getdetailsorcreate($number)
	{
		$query="SELECT * FROM `enquiry` WHERE  `phone` ='$number'";
		$enquirypresentornot=$this->db->query($query);
         if($enquirypresentornot->num_rows()==0)
         {
             $queryinsert=$this->db->query("INSERT INTO `enquiry`(`phone`) VALUES('$number')");
             $enquiryid=$this->db->insert_id();
             $queryselect="SELECT `enquirylistingcategory`.`id`, `enquirylistingcategory`.`enquiryid`, `enquirylistingcategory`.`typeofenquiry`, `enquirylistingcategory`.`listing`, `enquirylistingcategory`.`category`,`enquirylistingcategory`. `comment`, `enquirylistingcategory`.`timestamp` ,IFNULL(`category`.`name`,'NA') AS `categoryname`,IFNULL(`listing`.`name`,'NA') AS `listingname`
        FROM `enquirylistingcategory` 
        LEFT OUTER JOIN `listing` ON `enquirylistingcategory`.`listing`=`listing`.`id`
        INNER JOIN `enquiry` ON `enquirylistingcategory`.`enquiryid`=`enquiry`.`id`
        LEFT OUTER JOIN `category` ON `enquirylistingcategory`.`category`=`category`.`id`
        WHERE `enquiry`.`phone`='$number'";
		     $queryselect=$this->db->query($queryselect);
             $data['allenquiries']=$queryselect->result();
             $userdetailsquery=$this->db->query("SELECT `id`, `name`, `email`, `phone`, `timestamp`, `deletestatus` FROM `enquiry` WHERE `phone`='$number'");
             $data['userdetail']=$userdetailsquery->row();
             return $data;
         }
         else
         {
             $userpresentornot=$enquirypresentornot->row();
             $enquiryid=$userpresentornot->id;
             $queryselect="SELECT `enquirylistingcategory`.`id`, `enquirylistingcategory`.`enquiryid`, `enquirylistingcategory`.`typeofenquiry`, `enquirylistingcategory`.`listing`, `enquirylistingcategory`.`category`,`enquirylistingcategory`. `comment`, `enquirylistingcategory`.`timestamp` ,IFNULL(`category`.`name`,'NA') AS `categoryname`,IFNULL(`listing`.`name`,'NA') AS `listingname`
        FROM `enquirylistingcategory` 
        LEFT OUTER JOIN `listing` ON `enquirylistingcategory`.`listing`=`listing`.`id`
        INNER JOIN `enquiry` ON `enquirylistingcategory`.`enquiryid`=`enquiry`.`id`
        LEFT OUTER JOIN `category` ON `enquirylistingcategory`.`category`=`category`.`id`
        WHERE `enquiry`.`phone`='$number'";
		     $queryselect=$this->db->query($queryselect);
             $data['allenquiries']=$queryselect->result();
             $userdetailsquery=$this->db->query("SELECT `id`, `name`, `email`, `phone`, `timestamp`, `deletestatus` FROM `enquiry` WHERE `phone`='$number'");
             $data['userdetail']=$userdetailsquery->row();
             return $data;
         }
	}
    
     public function addenquiryoflistingfromfrontend($listingid,$name,$email,$phone,$comment)
	{
		$query="SELECT * FROM `enquiry` WHERE  `phone` ='$phone'";
		$enquirypresentornot=$this->db->query($query);
         if($enquirypresentornot->num_rows()==0)
         {
                $data  = array(
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'timestamp'=>NULL
                );
                $query=$this->db->insert( 'enquiry', $data );
                $enquiryid=$this->db->insert_id();
                
                $queryenquirylistingcategory=$this->db->query("INSERT INTO `enquirylistingcategory`(`enquiryid`, `typeofenquiry`, `listing`, `comment`) VALUES ('$enquiryid',1,'$listingid','$comment')");
                $this->enquiryemail($listingid,$name,$email,$phone,$comment);
                if(!$query)
                    return  0;
                else
                    return  1;
         }
         else
         {
             $userpresentornot=$enquirypresentornot->row();
             $enquiryid=$userpresentornot->id;
             
             $queryenquirylistingcategory=$this->db->query("INSERT INTO `enquirylistingcategory`(`enquiryid`, `typeofenquiry`, `listing`, `comment`) VALUES ('$enquiryid',1,'$listingid','$comment')");
             
             $this->enquiryemail($listingid,$name,$email,$phone,$comment);
             return 1;
             
         }
	}
    
//    
//     public function getdetailsorcreate($number)
//	{
//		$query="SELECT * FROM `user` WHERE  `contact` ='$number'";
//		$userpresentornot=$this->db->query($query);
//         if($userpresentornot->num_rows()==0)
//         {
//             $queryinsert=$this->db->query("INSERT INTO `user`(`contact`) VALUES('$number')");
//             $userid=$this->db->insert_id();
//             $queryselect="SELECT `enquiry`.`id`, `enquiry`.`name`, `enquiry`.`listing`, `enquiry`.`email`, `enquiry`.`phone`, `enquiry`.`timestamp`, `enquiry`.`deletestatus`,`enquiry`. `category`,`enquiry`. `type`, `enquiry`.`comment`,`category`.`name` AS `categoryname`,`listing`.`name` AS `listingname` ,`user`.`firstname`,`user`.`lastname`
//FROM `enquiry`
//LEFT OUTER JOIN `category` ON `category`.`id`=`enquiry`.`category`
//LEFT OUTER JOIN `listing` ON `listing`.`id`=`enquiry`.`listing` 
//LEFT OUTER JOIN `user` ON `user`.`id`=`enquiry`.`user` 
//WHERE  `enquiry`.`user` ='$userid'";
//		     $queryselect=$this->db->query($queryselect);
//             $data['allenquiries']=$queryselect->result();
//             $userdetailsquery=$this->db->query("SELECT * FROM `user` WHERE `id`='$userid'");
//             $data['userdetail']=$userdetailsquery->row();
//             return $data;
//         }
//         else
//         {
//             $userpresentornot=$userpresentornot->row();
//             $userid=$userpresentornot->id;
//             $queryselect="SELECT `enquiry`.`id`, `enquiry`.`name`, `enquiry`.`listing`, `enquiry`.`email`, `enquiry`.`phone`, `enquiry`.`timestamp`, `enquiry`.`deletestatus`,`enquiry`. `category`,`enquiry`. `type`, `enquiry`.`comment`,`category`.`name` AS `categoryname`,`listing`.`name` AS `listingname` ,`user`.`firstname`,`user`.`lastname`
//FROM `enquiry`
//LEFT OUTER JOIN `category` ON `category`.`id`=`enquiry`.`category`
//LEFT OUTER JOIN `listing` ON `listing`.`id`=`enquiry`.`listing` 
//LEFT OUTER JOIN `user` ON `user`.`id`=`enquiry`.`user` 
//WHERE  `enquiry`.`user` ='$userid'";
//		     $queryselect=$this->db->query($queryselect);
//             $data['allenquiries']=$queryselect->result();
//             $userdetailsquery=$this->db->query("SELECT * FROM `user` WHERE `id`='$userid'");
//             $data['userdetail']=$userdetailsquery->row();
//             return $data;
//         }
//	}
//    
//    
    public function addcategorytoenquiry($enquiryid,$category)
	{
		$data  = array(
			'category' => $category,
			'typeofenquiry' => 2,
			'enquiryid' => $enquiryid
		);
        $queryselect =$this->db->where($data);
        $queryselect = $this->db->get('enquirylistingcategory');
        $num = $queryselect->num_rows();
        if($num==0)
        {
		$query=$this->db->insert( 'enquirylistingcategory', $data );
        }
        
//		$id=$this->db->insert_id();
//		
//		if(!$query)
//			return  0;
//		else
			return  1;
	}
    
    public function addlistingtoenquiry($enquiryid,$listing)
	{
		$data  = array(
			'listing' => $listing,
			'typeofenquiry' => 1,
			'enquiryid' => $enquiryid
		);
        $queryselect =$this->db->where($data);
        $queryselect = $this->db->get('enquirylistingcategory');
        $num = $queryselect->num_rows();
        if($num==0)
        {
		$query=$this->db->insert( 'enquirylistingcategory', $data );
        }
        
//		$id=$this->db->insert_id();
//		
//		if(!$query)
//			return  0;
//		else
			return  1;
	}
    public function adduserdetails($enquiryid,$name,$phone,$email)
	{
		$data  = array(
			'name' => $name,
			'phone' => $phone,
			'email' => $email
		);
        
        $query=$this->db->where( 'id', $enquiryid );
		$query=$this->db->update( 'enquiry', $data );
       
		if(!$query)
			return  0;
		else
			return  1;
	}
    
    
//     public function getdetailsorcreate($number)
//	{
//		$query="SELECT * FROM `enquiry` WHERE  `phone` ='$number'";
//		$enquirypresentornot=$this->db->query($query);
//         if($enquirypresentornot->num_rows()==0)
//         {
//             $queryinsert=$this->db->query("INSERT INTO `enquiry`(`phone`) VALUES('$number')");
//             $enquiryid=$this->db->insert_id();
//             $queryselect="SELECT `enquiry`.`id`, `enquiry`.`name`, `enquiry`.`listing`, `enquiry`.`email`, `enquiry`.`phone`, `enquiry`.`timestamp`, `enquiry`.`deletestatus`,`enquiry`. `category`,`enquiry`. `type`, `enquiry`.`comment`,`category`.`name` AS `categoryname`,`listing`.`name` AS `listingname` 
//FROM `enquiry`
//LEFT OUTER JOIN `category` ON `category`.`id`=`enquiry`.`category`
//LEFT OUTER JOIN `listing` ON `listing`.`id`=`enquiry`.`listing` WHERE  `enquiry`.`id` ='$enquiryid'";
//		     $queryselect=$this->db->query($queryselect);
//             $data['allenquiries']=$queryselect->result();
//             $data['oneenquirydetail']=$queryselect->row();
//             return $data;
//         }
//         else
//         {
//             $queryselect="SELECT `enquiry`.`id`, `enquiry`.`name`, `enquiry`.`listing`, `enquiry`.`email`, `enquiry`.`phone`, `enquiry`.`timestamp`, `enquiry`.`deletestatus`,`enquiry`. `category`,`enquiry`. `type`, `enquiry`.`comment`,`category`.`name` AS `categoryname`,`listing`.`name` AS `listingname` 
//FROM `enquiry`
//LEFT OUTER JOIN `category` ON `category`.`id`=`enquiry`.`category`
//LEFT OUTER JOIN `listing` ON `listing`.`id`=`enquiry`.`listing` WHERE  `enquiry`.`phone` ='$number'";
//		     $queryselect=$this->db->query($queryselect);
//             $data['allenquiries']=$queryselect->result();
//             $data['oneenquirydetail']=$queryselect->row();
//             return $data;
//         }
//	}
    
    public function enquiryemail($listingid,$name,$email,$phone,$comment)
    {
        $touser=$email;
        $listing=$this->listing_model->getallinfooflisting($listingid);
        $tolisting= $listing->email;
        $tolisting = explode(",", $tolisting);
        
        $listingname= $listing->name;
        $listingaddress= $listing->address;
        $listingstate= $listing->state;
        $listingcontactno= $listing->contactno;
        $listingemail= $listing->email;
        $listingyearofestablishment= $listing->yearofestablishment;
        $usermsg="<h3>All Details Of Listing</h3><br>Listing Name:'$listingname' <br>Listing address:'$listingaddress' <br>Listing state:'$listingstate' <br>Listing contactno:'$listingcontactno' <br>Listing email:'$listingemail' <br>Listing yearofestablishment:'$listingyearofestablishment' <br>";
        
        $this->load->library('email');
        $this->email->from('avinash@wohlig.com', 'For Any Information To User');
        $this->email->to($touser);
        $this->email->subject('Listing Details');
        $this->email->message($usermsg);
        $this->email->send();
        
        $listingmsg="<h3>All Details Of user</h3><br>user Name:'$name' <br>user Email:'$email' <br>user contact:'$contact'<br>Comment:'$comment'";
        
        $this->load->library('email');
        $this->email->from("avinash@wohlig.com", "For Any Information (User Information Who Enquiry For Listing '$listingname')");
        $this->email->to($tolisting);
        $this->email->subject('User Details');
        $this->email->message($listingmsg);

        $this->email->send();

//        echo $this->email->print_debugger();
    }
}
?>