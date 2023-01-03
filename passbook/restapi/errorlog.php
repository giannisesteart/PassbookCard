<?php
  function get_payload() {
	   
	   x= file_get_contents('php://input');

	   echo "*********";
	   echo x;
       return json_decode(file_get_contents('php://input'), true);
  }
?>
 
 
 <?php 
 
    $auth_key = "test"; //str_replace('ApplePass ', '', $headers['Authorization']);
    // $auth_key = str_replace('ApplePass ', '', $headers['Authorization']);
	 
	
	ob_start();
	
	echo " Log this is atest" ;
	
	echo "Auth key:>" .$auth_key ;
    echo "<br/>Customer code >" . $_GET ['guest'];
	echo "<br/>Version>".$_GET ['version'];
	 
	 // $x = get_payload() ;
	// echo "mylog> >".$x->logs ;
	
	echo "********";
	
	$content  = ob_get_contents();
	$fp = fopen("log.txt", 'w');
    if($fp) {
      fwrite($fp, $content);
      fclose($fp);
	   
     }
	 
	 
     http_response_code(200);
	
	
	
?>