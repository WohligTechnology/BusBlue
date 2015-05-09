<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Facebookoauth {

    public function get_post($id)
    {
        $app_id = '887407984616987';
        $app_secret = 'b0821e8749a41ece272bd9fbc5e2a049';
    
        
        $app_access_token = file_get_contents(
          'https://graph.facebook.com/oauth/access_token?' .
          'client_id='.$app_id.'&client_secret='.$app_secret.'&' .
          'grant_type=client_credentials');
        $roles = json_decode(file_get_contents(
          'https://graph.facebook.com/'.$app_id.'/roles?' .
          $app_access_token
        ));
        //echo "https://graph.facebook.com/v2.2/921220457889147_923405451003981/likes?summary=1&$app_access_token";
        $new=new stdClass();
        $new->likes = file_get_contents("https://graph.facebook.com/v2.2/$id/likes?summary=1&$app_access_token");
        echo $new->likes;
        if(isset(json_decode($new->likes)->summary))
        {
            $new->likes=json_decode($new->likes)->summary->total_count;
        }
        else
        {
            $new->likes=0;
        }
       
        $new->shares = file_get_contents("https://graph.facebook.com/v2.2/$id/sharedposts?summary=1&$app_access_token");
        if(isset(json_decode($new->shares)->summary))
        {
            $new->shares=json_decode($new->shares)->summary->total_count;
        }
        else
        {
            $new->shares=0;
        }
        
        $new->comments = file_get_contents("https://graph.facebook.com/v2.2/$id/comments?summary=1&$app_access_token");
        if(isset(json_decode($new->comments)->summary))
        {
            $new->comments=json_decode($new->comments)->summary->total_count;
        }
        else
        {
            $new->comments=0;
        }
        print_r($new);
        print_r($id);
        return $new;
    }
}

/* End of file Someclass.php */