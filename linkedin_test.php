<?php

/* 
 * Test Linkedin.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



//$oauth = new OAuth("750f8wbrxd35z2", "pmLeubPRbY5brPNd");
//$oauth->setToken("78b0d37d-0c44-4543-bdfb-0febf50b8b94", "b1f894f4-4129-4c07-85e4-563d19776b0f");
// 
//$params = array();
//$headers = array();
//$method = OAUTH_HTTP_METHOD_GET;
//  
//// Specify LinkedIn API endpoint to retrieve your own profile
//$url = "https://api.linkedin.com/v1/people/~?format=json";
// 
//// By default, the LinkedIn API responses are in XML format. If you prefer JSON, simply specify the format in your call
//// $url = "https://api.linkedin.com/v1/people/~?format=json";
// 
//// Make call to LinkedIn to retrieve your own profile
//$oauth->fetch($url, $params, $method, $headers);
//  
//echo $oauth->getLastResponse();

// Change these
define('API_KEY',      '750f8wbrxd35z2'                                          );
define('API_SECRET',   'pmLeubPRbY5brPNd'                                       );
// You must pre-register your redirect_uri at https://www.linkedin.com/secure/developer
define('REDIRECT_URI', "https://grupo_45.proyecto2014.linti.unlp.edu.ar/linkedin_test.php");
define('SCOPE',        'r_basicprofile r_emailaddress'                              );
 
// You'll probably use a database
session_name('linkedin');
session_start();
 
// OAuth 2 Control Flow
if (isset($_GET['error'])) {
    // LinkedIn returned an error
    print $_GET['error'] . ': ' . $_GET['error_description'];
    exit;
} elseif (isset($_GET['code'])) {
    // User authorized your application
    if ($_SESSION['state'] == $_GET['state']) {
        // Get token so you can make API calls
        getAccessToken();
    } else {
        // CSRF attack? Or did you mix up your states?
        exit;
    }
} else {
    if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
        // Token has expired, clear the state
        $_SESSION = array();
    }
    if (empty($_SESSION['access_token'])) {
        // Start authorization process
        getAuthorizationCode();
    }
}
 
// Congratulations! You have a valid token. Now fetch your profile
$user = fetch('GET', '/v1/people/~:(firstName,lastName)');
print "Hello $user->firstName $user->lastName.";
exit;
 
function getAuthorizationCode() {
    $params = array(
        'response_type' => 'code',
        'client_id' => API_KEY,
        'scope' => SCOPE,
        'state' => uniqid('', true), // unique long string
        'redirect_uri' => REDIRECT_URI,
    );
 
    // Authentication request
    $url = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);
     
    // Needed to identify request when it returns to us
    $_SESSION['state'] = $params['state'];
 
    // Redirect user to authenticate
    header("Location: $url");
    exit;
}
     
function getAccessToken() {
    $params = array(
        'grant_type' => 'authorization_code',
        'client_id' => API_KEY,
        'client_secret' => API_SECRET,
        'code' => $_GET['code'],
        'redirect_uri' => REDIRECT_URI,
    );
     
    // Access Token request
    $url = 'https://www.linkedin.com/uas/oauth2/accessToken?' . http_build_query($params);
     
    // Tell streams to make a POST request
    $context = stream_context_create(
        array('http' =>
            array('method' => 'POST',
            )
        )
    );
 
    // Retrieve access token information
    $response = file_get_contents($url, false, $context);
 
    // Native PHP object, please
    $token = json_decode($response);
 
    // Store access token and expiration time
    $_SESSION['access_token'] = $token->access_token; // guard this!
    $_SESSION['expires_in']   = $token->expires_in; // relative time (in seconds)
    $_SESSION['expires_at']   = time() + $_SESSION['expires_in']; // absolute time
     
    return true;
}
 
function fetch($method, $resource, $body = '') {
    print $_SESSION['access_token'];
 
    $opts = array(
        'http'=>array(
            'method' => $method,
            'header' => "Authorization: Bearer " . $_SESSION['access_token'] . "\r\n" . "x-li-format: json\r\n"
        )
    );
 
    // Need to use HTTPS
    $url = 'https://api.linkedin.com' . $resource;
 
    // Append query parameters (if there are any)
    if (count($params)) { $url .= '?' . http_build_query($params); }
 
    // Tell streams to make a (GET, POST, PUT, or DELETE) request
    // And use OAuth 2 access token as Authorization
    $context = stream_context_create($opts);
 
    // Hocus Pocus
    $response = file_get_contents($url, false, $context);
 
    // Native PHP object, please
    return json_decode($response);
}