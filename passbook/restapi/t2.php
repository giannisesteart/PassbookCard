<?php

    $ts= @strtotime ("Sat, 29 Oct 1994 19:43:31 GMT");
	
    $dt  = new DateTime("@$ts"); 
	echo $dt->format('Y-m-d H:i:s')
	
?>