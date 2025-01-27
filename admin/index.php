<?php
	

if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) { //If the server connection is secured with HTTPS
        $uri = 'https://'; //Hyper Text Transfer Protocol Secure
} else {
        $uri = 'http://'; //Hyper Text Transfer Protocol
}
$uri .= $_SERVER['HTTP_HOST']; //Add the domain name through which the current request in beign fulfilled to $uri
echo $uri;
header('Location: '.$uri.'/petlovers/admin/login'); //Redirection to the login page
exit;
?>




