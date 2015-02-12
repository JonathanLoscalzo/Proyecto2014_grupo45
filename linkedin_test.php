<?php

/* 
 * Test Linkedin.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


try {
$oauth = new OAuth("750f8wbrxd35zJ", "pmLeubPRbY5brPNd");
$oauth->setToken("78b0d37d-0c44-4543-bdfb-0febf50b8b94", "b1f894f4-4129-4c07-85e4-563d19776b0f");
 
$params = array();
$headers = array();
$method = OAUTH_HTTP_METHOD_GET;
  
// Specify LinkedIn API endpoint to retrieve your own profile
$url = "https://api.linkedin.com/v1/people/~:(id,first-name,last-name,location:(name),summary,email-address,honors-awards)?format=json";
 
// By default, the LinkedIn API responses are in XML format. If you prefer JSON, simply specify the format in your call
// $url = "https://api.linkedin.com/v1/people/~?format=json";
 
// Make call to LinkedIn to retrieve your own profile
$oauth->fetch($url, $params, $method, $headers);
  
echo $oauth->getLastResponse();
}
 catch(Exception $E) {
    echo "Excepción atrapada!\n".$E;
}

