<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cron extends CI_Controller 
{
    function socialupdate() 
    {
        $this->load->library("facebookoauth");
        $this->load->library('twitteroauth');
    $userpostquery=$this->db->query("SELECT `id`,`returnpostid`,`posttype` FROM `userpost`")->result();
    foreach($userpostquery as $userpost)
    {
        $returnpostid=$userpost->returnpostid;
        $posttype=$userpost->posttype;
        $id=$userpost->id;
        if($posttype==1)
        {

            $facebookdet=$this->facebookoauth->get_post($returnpostid);
            
            $this->userpost_model->addfacebookcrondata($id,$facebookdet->likes,$facebookdet->shares,$facebookdet->comments);
        }
        else if($posttype==2)
        {
            
		// Loading twitter configuration.
		    $this->config->load('twitter');
            $this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('access_token'),  $this->session->userdata('access_token_secret'));
            $data["message"] = $this->twitteroauth->get('statuses/show.json?id='.$returnpostid);
            if(isset($data["message"]->retweet_count))
            {
                $retweet=$data["message"]->retweet_count;
            }
            else
            {
                $retweet=0;
            }
            if(isset($data["message"]->favorite_count))
            {
                $favourites=$data["message"]->favorite_count;
            }
            else
            {
                $favourites=0;
            }
            $this->userpost_model->addtwittercrondata($id,$retweet,$favourites);
        }
    }
        
        $this->user_model->assignranks();
        
	
	}
    
}
//EndOfFile
?>