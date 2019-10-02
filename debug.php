<?php 

header("Access-Control-Allow-Origin: *");
if( empty($_POST) && empty($_GET)){
	    http_response_code(409);
	        echo 'FAILD!';
	        die(409);
}


$basedir = __dir__.'/../logs/'.date('Y.m.d').'/';
if(!file_exists($basedir)){
mkdir($basedir,0770,true);
}

$content = array();
$content['date'] = time();
$content['POST'] = $_POST;
$content['GET'] = $_GET;
$content['SERVER'] = $_SERVER;


$content = json_encode($content);
$return = file_put_contents($basedir.time().'_'.uniqid().'.log',$content);

if($return > 0){
	    http_response_code(200);
	        echo 'OK';
} else {
	    http_response_code(400);
	        echo 'FAILD';
}

