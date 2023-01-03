<?php
echo 'is nightsin ';


require 'AltoRouter.php';
$router = new AltoRouter();
 


$router->setBasePath('/ihotelweb/vadmnightsin/passbook/restapi');

$router->map('GET|POST','/[i:ci]/[i:ve]/devices/[i:di]/registrations/[i:pi]/[i:sn]', function( $ci,$ve,$di,$pi,$sn) { 
	echo ("nightsin Ci");
	require_once "register.php";
   });
   
$router->map( 'GET', '/', function() {
	 echo "is nightsin get ///";
});

   
$router->map( 'GET', '/users', function() {
	 echo "is user";
});



$match = $router->match();

echo "myvar="; var_dump($match);

if($match['target']) {
    if (! is_callable( $match['target'] )) require $match['target'];
 }
else {
   header("HTTP/1.0 404 Not Found");
   require '404.html';
} 


 // call closure or throw 404 status

if( $match && is_callable( $match['target'] )) {
	   echo 'nightsinside';
	   call_user_func_array( $match['target'], $match['params'] ); 
} else {
	// no route was matched
	header("HTTP/1.0 404 Not Found");
	require '404.html';
}
  




?>