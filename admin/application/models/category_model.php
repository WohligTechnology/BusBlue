<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Category_model extends CI_Model
{
	//category
	public function createcategory($name,$parent,$status,$logo,$image,$typeofimage,$banner,$startdateofbanner,$enddateofbanner)
	{
		$data  = array(
			'name' => $name,
			'parent' => $parent,
			'status' => $status,
			'logo' => $logo,
			'image' => $image,
			'banner' => $banner,
			'startdateofbanner' => $startdateofbanner,
			'enddateofbanner' => $enddateofbanner,
			'typeofimage' => $typeofimage
		);
		$query=$this->db->insert( 'category', $data );
		
		return  1;
	}
	public function createbrandcategory($brandid,$categoryid)
	{
		$data  = array(
			'brandid' => $brandid,
			'categoryid' => $categoryid
		);
		$query=$this->db->insert( 'brandcategory', $data );
		
		return  1;
	}
        function getcategoryinfo($id)
        {
        	$query=$this->db->query("SELECT * FROM category WHERE `id`='$id'")->row();
		return $query;
        }
        
        function getmonthbeforenotifications()
        { 
        	$query=$this->db->query("SELECT `id`, `name`, `parent`, `status`, `typeofimage`, `logo`, `image`, `banner`, `startdateofbanner`, `enddateofbanner` ,NOW() AS `today`,DATE(NOW()+INTERVAL 30 DAY) AS `monthbefore`
FROM `category` 
HAVING `enddateofbanner`=`monthbefore`")->result();
		return $query;
        }
//        function getmonthbeforenotifications()
//        { 
//        	$query=$this->db->query("SELECT `id`, `name`, `parent`, `status`, `typeofimage`, `logo`, `image`, `banner`, `startdateofbanner`, `enddateofbanner` ,NOW() AS `today`,DATE(DATE_SUB(NOW(), INTERVAL 30 day)) AS `monthbefore`
//FROM `category` 
//HAVING `enddateofbanner`=`monthbefore`")->result();
//		return $query;
//        }
        function getfivedaysbeforenotifications()
        { 
        	$query=$this->db->query("SELECT `id`, `name`, `parent`, `status`, `typeofimage`, `logo`, `image`, `banner`, `startdateofbanner`, `enddateofbanner` ,NOW() AS `today`,DATE(NOW()+INTERVAL 5 DAY) AS `fivedaysbefore`
FROM `category` 
HAVING `enddateofbanner`=`fivedaysbefore`")->result();
		return $query;
        }
        
        function getfilter($id)
        {
        	$query=$this->db->query("SELECT `category`.`id`,`category`.`name`,`tab2`.`id` as `iid`,`tab2`.`name` as `name2`,`category`.`logo` FROM `category` LEFT JOIN `category` as `tab2` ON `tab2`.`parent`=`category`.`parent` WHERE `category`.`id`='$id'")->result();
        	return $query;
        }

	function viewonebrandcategories($id)
	{
		$query=$this->db->query("SELECT `category`.`id`,`category`.`name`,`category`.`image`,`category`.`logo`,`category`.`parent` as `parent`,`category`.`status` FROM `category`
        WHERE `category`.`id` IN(SELECT `brandcategory`.`categoryid` FROM `brandcategory` WHERE `brandcategory`.`brandid` IN(SELECT `brand`.`id` FROM `brand` WHERE `brand`.`id`='$id'))")->result();
		return $query;
	}
    function viewcategory()
	{
		$query=$this->db->query("SELECT `category`.`id`,`category`.`name`,`category`.`logo`,`category`.`image`,`tab2`.`name` as `parent` FROM `category` 
		LEFT JOIN `category` as `tab2` ON `tab2`.`id`=`category`.`parent`
		ORDER BY `category`.`id` ASC")->result();
		return $query;
	}
    function viewparentcategory()
	{
		$query=$this->db->query("SELECT `category`.`id`,`category`.`name`,`category`.`logo`,`category`.`image`
        FROM `category` 
        WHERE `category`.`parent`=0
		ORDER BY `category`.`id` ASC")->result();
		return $query;
	}
    function getsubcategorybyparent($id)
	{
		$query=$this->db->query("SELECT `category`.`id`,`category`.`name`,`category`.`logo`,`category`.`image`
        FROM `category` 
        WHERE `category`.`parent`='$id'
		ORDER BY `category`.`id` ASC")->result();
		return $query;
	}
    
	public function getstatusdropdown()
	{
		$status= array(
			 "1" => "Has Types",
			 "0" => "No Types",
			);
		return $status;
	}
	public function gettypeofimagedropdown()
	{
		$typeofimage= array(
			 "" => "SELECT TYPE",
			 "0" => "Tag",
			 "1" => "Image",
			);
		return $typeofimage;
	}
    public function getcategoryimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `category` WHERE `id`='$id'")->row();
		return $query;
	}
    public function getcategorybannerbyid($id)
	{
		$query=$this->db->query("SELECT `banner` FROM `category` WHERE `id`='$id'")->row();
		return $query;
	}
    function viewmaincategory()
	{
		$query=$this->db->query("SELECT `category`.`id`,`category`.`name`,`category`.`logo`,`category`.`status`,`tab2`.`name` as `parent` FROM `category` 
		LEFT JOIN `category` as `tab2` ON `tab2`.`id`=`category`.`parent` WHERE `category`.`parent`='0'
		ORDER BY `category`.`id` ASC")->result();
		return $query;
	}
    function viewallsubcategory()
	{
		$query=$this->db->query("SELECT `subcategory`.`id`,`subcategory`.`name` FROM `subcategory`")->result();
		return $query;
	}
    function viewcategorytypes()
	{
		$query=$this->db->query("SELECT `category`.`id`,`category`.`name`,`tab2`.`name` as `parent` FROM `category` 
		LEFT JOIN `category` as `tab2` ON `tab2`.`id`=`category`.`parent` WHERE `category`.`status`='0'
		ORDER BY `category`.`id` ASC")->result();
		return $query;
	}
    function viewsubcategory()
	{
		$query=$this->db->query("SELECT `categorysubcategory`.`categoryid`,`categorysubcategory`.`subcategoryid` FROM `categorysubcategory`
       ")->result();
		return $query;
	}
	public function beforeeditcategory( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'category' )->row();
		return $query;
	}
	
	public function editcategory( $id,$name,$parent,$status,$logo,$image,$typeofimage,$banner,$startdateofbanner,$enddateofbanner)
	{
        if($logo=="")
        {
            $logo=$image;
        }
		$data = array(
			'name' => $name,
			'parent' => $parent,
			'status' => $status,
			'logo' => $logo,
			'image' => $image,
			'banner' => $banner,
			'startdateofbanner' => $startdateofbanner,
			'enddateofbanner' => $enddateofbanner,
			'typeofimage' => $typeofimage
		
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'category', $data );
		
		return 1;
	}
	public function editnotification( $id,$banner,$startdateofbanner,$enddateofbanner)
	{
		$data = array(
			'banner' => $banner,
			'startdateofbanner' => $startdateofbanner,
			'enddateofbanner' => $enddateofbanner
		
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'category', $data );
		
		return 1;
	}
	function deletecategory($id)
	{
		$query=$this->db->query("DELETE FROM `category` WHERE `id`='$id'");
		
	}
	function deletebrandcategory($id,$brandid)
	{
		$query=$this->db->query("DELETE FROM `brandcategory` WHERE `categoryid`='$id' AND `brandid`='$brandid'");
		
	}
	public function getcategorydropdown()
	{
		$query=$this->db->query("SELECT * FROM `category`  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
	public function getcategoryforlistingdropdown()
	{
		$query=$this->db->query("SELECT `category`.`id`,`category`.`name`,`tab2`.`name` as `parent` FROM `category` 
		LEFT JOIN `category` as `tab2` ON `tab2`.`id`=`category`.`parent` WHERE `category`.`parent`<>'0' ")->result();
		$return=array(
		);
		foreach($query as $row)
		{
            if($row->parent=="")
            {
                $value=" -> ".$row->name;
            }
            else
            {
                $value=$row->parent." -> ".$row->name;
            }
			$return[$row->id]=$value;
		}
		
		return $return;
	}
    
     public function getselectedcategoryforlistingdropdown($id)
	{
         $return=array();
		$query=$this->db->query("SELECT `listing`,`category` FROM `listingcategory`  WHERE `listing`='$id'");
        if($query->num_rows() > 0)
        {
            $query=$query->result();
            foreach($query as $row)
            {
                $return[]=$row->category;
            }
        }
         return $return;
	}
	public function getmaincategorydropdown()
	{
		$query=$this->db->query("SELECT * FROM `category` WHERE `parent`='0'  ORDER BY `id` ASC")->result();
		$return=array(
		"" => ""
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
	public function getcategory()
	{
		$query=$this->db->query("SELECT * FROM `category`  ORDER BY `name` ASC")->result();
		return $query;
	}
	public function getcategoryfront()
	{
		$query['category']=$this->db->query("SELECT * FROM `category`  ORDER BY `name` ASC")->result();
		$query['modeofpayment']=$this->modeofpayment_model->viewmodeofpayment();
        $query['city']=$this->city_model->viewcity();
        $query['type']=$this->frontend_model->type();
        $query['isverified']=$this->frontend_model->isverified();
        $query['daysofoperations']=$this->frontend_model->getdaysofoperation();
		return $query;
	}
//	public function getstatusdropdown()
//	{
//		$status= array(
//			 "1" => "Enabled",
//			 "0" => "Disabled",
//			);
//		return $status;
//	}
    public function selectedcategory($brandid,$categoryid)
    {
        $subcategory=array();
//        $query3=$this->db->query("SELECT `id` FROM `brandcategory` where `brandid`='$brandid' and `categoryid`='$categoryid'")->row();
//       echo $query3->id;
        $qry="SELECT `subcategoryid` FROM `categorysubcategory` WHERE `brandcategoryid` IN (SELECT `id` FROM `brandcategory` where `brandid`='$brandid' and `categoryid`='$categoryid')";
      //  echo $qry;
    $query=$this->db->query($qry)->result();
       $query2=$this->db->query("SELECT `id`,`name` FROM `subcategory`")->result();
//		print_r($query);
//        echo "<br><br>";
//		print_r($query2);
//        echo "<br><br>";
        foreach($query2 as $row)
		{
        $flag="";
                    foreach($query as $row2)
                {
                        if($row->id==$row2->subcategoryid)
                        {
                        $flag="checked";
                        break;
                        }
                        
                }
            array_push($subcategory,$row->name,$row->id,$flag);
            
		}
		//print_r($subcategory);
        return $subcategory;
//		return $query;
    
    
    }
    public function getbrandcategoryid($brandid,$categoryid)
    {
    $query3=$this->db->query("SELECT `id` FROM `brandcategory` where `brandid`='$brandid' and `categoryid`='$categoryid'")->row();
       return $query3->id;
    }
    public function editsubcategorysubmit($brandcategoryid,$subcategoryid)
    {
        $data  = array(
			'brandcategoryid' => $brandcategoryid,
			'subcategoryid' => $subcategoryid
		);
        $querya=$this->db->query("SELECT * FROM `categorysubcategory` WHERE `brandcategoryid`='$brandcategoryid' AND `subcategoryid`='$subcategoryid'")->result();
        if( $this->db->affected_rows() == 0)
        {
		$query=$this->db->insert( 'categorysubcategory', $data );
        }
		
    }
    public function deletesubcategorysubmit($brandcategoryid,$subcategoryid)
    {
        $sql="DELETE FROM `categorysubcategory` WHERE `brandcategoryid`='$brandcategoryid' AND `subcategoryid`='$subcategoryid'";
        echo $sql;
		$query=$this->db->query($sql);
		
    }
    //frontendapis
    
    function getallparentcategories()
	{
		$query=$this->db->query("SELECT `category`.`id`,`category`.`name`,`category`.`status`,`category`.`banner`,`tab2`.`name` as `parent`,`category`.`logo` 
        FROM `category` 
		LEFT JOIN `category` as `tab2` ON `tab2`.`id`=`category`.`parent`
        WHERE `category`.`parent`=0")->result();
		return $query;
	}
    public function getsubcategory($id)
	{
		$query=$this->db->query("SELECT * FROM `category` WHERE `parent`='$id'  ORDER BY `id` ASC")->result();
		
		return $query;
	}
//    public function searchcategory($category)
//	{
//		$query=$this->db->query("SELECT `category`.`id`,`category`.`name`,`tab2`.`name` as `parent` 
//        FROM `category` 
//		LEFT JOIN `category` as `tab2` ON `tab2`.`id`=`category`.`parent`
//        WHERE `category`.`parent`!=0 AND `category`.`name`LIKE '$category%'
//        LIMIT 0 , 10")->result();
//		
//		return $query;
//	}
    
    public function searchcategory($category,$city,$area,$lat,$long)
	{
		$query=$this->db->query("SELECT `listingcategory`.`listing`, `listingcategory`.`category`,`listing`.`name`,`listing`.`id` AS `listingid`,ROUND(( 3959 * acos( cos( radians($lat) ) * cos( radians(`listing`. `lat` ) ) 
   * cos( radians(`listing`.`long`) - radians($long)) + sin(radians($lat)) 
   * sin( radians(`listing`. `lat`)))),2)
          AS `dist`, `listing`. `user`, `listing`.`lat`, `listing`.`long`, `listing`.`address`, `listing`.`area`, `listing`.`city`, `listing`.`pincode`, `listing`.`state`, `listing`.`country`, `listing`.`description`, `listing`.`logo`, `listing`.`contactno`, `listing`.`email`, `listing`.`website`, `listing`.`facebook`, `listing`.`twitter`, `listing`.`googleplus`, `listing`.`yearofestablishment`, `listing`.`timeofoperation_start`, `listing`.`timeofoperation_end`, `listing`.`type`, `listing`.`credits`, `listing`.`isverified`, `listing`.`video` ,`city`.`name` AS `cityname`,`category`.`name` AS `categoryname`,`category`.`banner` AS `banner`,`listing`.`deletestatus`
FROM `listingcategory`
LEFT OUTER JOIN `listing` ON `listing`.`id`=`listingcategory`.`listing`
LEFT OUTER JOIN `category` ON `category`.`id`=`listingcategory`.`category`
LEFT OUTER JOIN `city` ON `city`.`id`=`listing`.`city`
WHERE `category`.`name`LIKE '$category%' AND `city`.`id` = '$city' AND `listing`.`deletestatus`='1' AND `listing`.`area` LIKE '%$area%'
ORDER BY `dist` ASC
        LIMIT 0 , 10")->result();
		
		return $query;
	}
    
    public function getcategorytree($id) 
    {
        $return=new stdClass();
        if($id!=0)
        {
            $querymain=$this->db->query("SELECT * FROM `category` WHERE `id`='$id'")->row();
        }
        else
        {
            $querymain=new stdClass();
            $querymain->id=0;
            $querymain->name="Root";
        }
        $query=$this->db->query("SELECT * FROM `category` WHERE `parent`='$id'  ORDER BY `id` ASC");
        
        $return->id=$querymain->id;
        $return->name=$querymain->name;
        $return->children=array();
        
        if($query->num_rows()==0)
        {
               
        }
        else
        {
            $query=$query->result();
            foreach($query as $row)
            {
                array_push($return->children,$this->getcategorytree($row->id));
            }
        }
        return $return;
    }
    public function getcategorytreeforlisting($id) 
    {
        $return=new stdClass();
        if($id!=0)
        {
            $querymain=$this->db->query("SELECT `category`.`id`,`category`.`name`,`category`.`logo`,`category`.`image`,`tab2`.`name` as `parentname` FROM `category` 
		LEFT JOIN `category` as `tab2` ON `tab2`.`id`=`category`.`parent` WHERE `category`.`id`='$id'")->row();
        }
        else
        {
            $querymain=new stdClass();
            $querymain->id=0;
            $querymain->name="Root";
            $querymain->parentname="Parent";
        }
        $query=$this->db->query("SELECT `category`.`id`,`category`.`name`,`category`.`logo`,`category`.`image`,`tab2`.`name` as `parentname` FROM `category` 
		LEFT JOIN `category` as `tab2` ON `tab2`.`id`=`category`.`parent` WHERE `category`.`parent`='$id' ");
        
        $return->id=$querymain->id;
        $return->name=$querymain->name;
        $return->parentname=$querymain->parentname;
        $return->children=array();
        
        if($query->num_rows()==0)
        {
               
        }
        else
        {
            $query=$query->result();
            foreach($query as $row)
            {
                array_push($return->children,$this->getcategorytreeforlisting($row->id));
            }
        }
        return $return;
    }
    
     public function getarray($data)
    {
        $ret=array();
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
    
    
}
?>