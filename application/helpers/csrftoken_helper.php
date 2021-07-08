<?php 
	if (!function_exists('token_csrf')) {
		function token_csrf(){
            $CI = & get_instance();
			$token =  "<input type='hidden' name='".$CI->security->get_csrf_token_name()."' value='".$CI->security->get_csrf_hash()."'>";
		    return $token;
		}
	}
?>