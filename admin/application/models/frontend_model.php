<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Frontend_model extends CI_Model
{
    
    public function type()
	{
		$status= array(
            array(
                'id' => '1',
                'name' => 'Free'
            ),array(
                'id' => '0',
                'name' => 'Paid'
            )
        );
		return $status;
	}
    
    public function saveprofile($id,$firstname,$lastname,$email,$contact,$phoneno,$dob,$website,$address,$city,$pincode,$state,$country,$google,$facebookuserid){
        
        $data  = array(
			'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'contact' => $contact,
            'phoneno' => $phoneno,
            'dob' => $dob,
            'website' => $website,
            'address' => $address,
            'city' => $city,
            'pincode' => $pincode,
            'state' => $state,
            'country' => $country,
            'google' => $google,
            'facebookuserid' => $facebookuserid
		);
		$this->db->where('id',$id);
		$query=$this->db->update( 'user', $data );
		if(!$query)
			return  0;
		else
			return  1;
        
    }
    
    public function isverified()
	{
		$status= array(
            array(
                'id' => '1',
                'name' => 'Yes'
            ),array(
                'id' => '0',
                'name' => 'No'
            )
        );
		return $status;
	}
    
	public function getdaysofoperation()
	{
		$query=$this->db->query("SELECT * FROM `daysofoperation`  ORDER BY `id` ASC")->result();
		
		return $query;
	}
    
    public function createlisting($name,$user,$lat,$long,$address,$area,$city,$pincode,$state,$country,$description,$contact,$email,$website,$facebookuserid,$googleplus,$twitter,$yearofestablishment,$timeofoperation_start,$timeofoperation_end,$type,$credits,$video,$logo,$category,$modeofpayment,$daysofoperation)
	{
		$data  = array(
			'name' => $name,
			'user' => $user,
			'lat' => $lat,
			'long' => $long,
            'address'=>$address,
            'area' =>$area,
            'city'=>$city,
            'pincode'=>$pincode,
            'state' => $state,
            'country' => $country,
            'description' => $description,
			'contactno' => $contact,
			'email' => $email,
            'website'=> $website,
			'facebook' => $facebookuserid,
            'googleplus' => $googleplus,
            'twitter' => $twitter,
            'yearofestablishment' => $yearofestablishment,
            'timeofoperation_start' => $timeofoperation_start,
            'timeofoperation_end' => $timeofoperation_end,
            'type' => $type,
            'credits' => $credits,
            'video' => $video,
            'logo' => $logo
		);
		$query=$this->db->insert( 'listing', $data );
		$listingid=$this->db->insert_id();
        foreach($category AS $key=>$value)
        {
           $this->listing_model->createcategorybylisting($value,$listingid);
        }
        foreach($modeofpayment AS $key=>$value)
        {
           $this->listing_model->createmodeofpaymentbylisting($value,$listingid);
        }
        foreach($daysofoperation AS $key=>$value)
        {
           $this->listing_model->createdaysofoperationbylisting($value,$listingid);
        }
		if(!$query)
			return  0;
		else
			return  1;
	}
// All frontends dropdown or other functions
    
}
?>