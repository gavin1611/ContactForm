<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT');
header("Access-Control-Allow-Headers: DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");
error_reporting(E_ERROR);

require 'templates/utility/dbConnection.php';

require 'Slim/Slim.php';


\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

function validateRequest($id,$token)
{
	$str = $id.'GavinsAPIs';
	$hash = 0;
    if (strlen($str) == 0) 
      return $hash;

	for ($i = 0; $i < strlen($str); $i++) {
		$char = ord($str[$i]);
		$hash = (($hash * 8 )-$hash)+$char; 
    }
    $hash = trim(substr($hash,0,8));
    $token = trim(substr($token, 0,8));
    
    if(strcasecmp($hash, $token)!=0){
 		http_response_code(500);
		$message['error']='You are not authorised';
		echo json_encode($message,true);
		exit();
    }
    else{
    	return true;
    }
}


$method=$_SERVER['REQUEST_METHOD'];
//For all POST responses
if($method=='POST'){

    $app->post('/contact_info', function($id,$token) use ($app) {
        //validateRequest($id,$token);
        $response['function_name']= 'contact_info';
        $app->render('mygalleryapplication/main.php', array(
                'data' => $response
            )
        );
    });
}

//For all GET responses
else if($method=='GET')
{
  // NO GET REQUEST LEFT THE ROUTE BLANK
}

//If no GET and POST methods found
else {
	$data['msg']='Invalid method passed';
	echo json_encode($data,true);
}

// run
$app->run();
