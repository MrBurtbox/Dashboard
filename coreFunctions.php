<?php
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getMetadata($description, $keywords, $author, $robots){
	if(!empty($description) && !empty($keywords) && !empty($author) && !empty($robots)){	
		echo '	
			<meta name="Description" content="'.$description.'">
			<meta name="keywords" content="'.$keywords.'" />
			<meta name="author" content="'.$author.'">
			<meta name="robots" content="'.$robots.'">
			<meta name="revisit-after" content="1 days">
		';
	}
}



//Returns IpAddress
function getIpAddress(){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		return $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		return $_SERVER['REMOTE_ADDR'];
	}
}
?>