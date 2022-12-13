<?php  
defined('BASEPATH') OR exit('No direct script access allowed');  

class validateSession {  

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function login_check()  
    {  
        if(isset($_SESSION['is_logged_in'])){
            if($_SESSION['is_logged_in'] === true){
                if($_SESSION['page_visit'] == false){
                    $_SESSION['page_visit'] = true;
                    redirect('home');
                }else{
                    $uri = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                    $log_in = base_url().'login';
                   
                    if($uri == $log_in || base_url() == $uri){
                        $_SESSION['page_visit'] = false;
                        
                        redirect('home');
                    } 
                }
            }
        }else{
            if((isset($_SESSION['page_visit']) && isset($_SESSION['login_attempt_failed'])) && ($_SESSION['page_visit'] === false && $_SESSION['login_attempt_failed'] === false)){
                $_SESSION['page_visit'] = true;
                
                redirect('login');
            }else{
                $_SESSION['page_visit'] = false;
                $_SESSION['login_attempt_failed'] = false;
            }
        }
        
    }
}  
?>  