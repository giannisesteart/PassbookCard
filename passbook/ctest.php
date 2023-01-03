<?php 
     require_once ("crypt.php");
	 
	 
	for ($i=40000;$i<100000;$i++) {
		
	$num = "".$i;
    $cryptguest = crockford32_encode($num) ;
    $total=  crockford32_decode($cryptguest);
	 
	if ($num != $total ) echo " * ".$total." "; 
	else echo $num. " ".$total ;
	}
	
	 
?>