 <?php

function get_payload() {
    return json_decode(file_get_contents('php://input'), true);
}

function send_response($data) {
    $response = json_encode($data, JSON_FORCE_OBJECT);
    header('Content-Type: application/json');
    header('Content-Length: ' . strlen($response));
    echo $response;
    exit;
}

 function apache_request_header() {
        foreach($_SERVER as $key=>$value) {
            if (substr($key,0,5)=="HTTP_") {
                $key=str_replace(" ","-",ucwords(strtolower(str_replace("_"," ",substr($key,5)))));
                $out[$key]=$value;
            }else{
                $out[$key]=$value;
            }
        }
        return $out;
    }

  

?>
 
  
 <?php 
 
    
	
	 var_dump ( apache_request_header () );
	
	 
	
	 
	
	
	 // ob_end_clean(); */
?>