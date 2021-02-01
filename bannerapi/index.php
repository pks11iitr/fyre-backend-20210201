<?php
error_reporting(0);
require 'vendor/autoload.php';
 
 //setting
$config['displayErrorDetails'] = false;
$config['addContentLengthHeader'] = false;
$config['db']['host']   = "localhost";
$config['db']['user']   = "avaskmap_classify";
$config['db']['pass']   = "avaskmap_classify";
$config['db']['dbname'] = "avaskmap_classify";
$config['api']['key'] = "2509ncta709s2qo6p54zhewrfev467ha";
$config['upload']['path']='uploads/';
$config['http']['path']='http://Avaskmapp.Xyz/'.$config['upload']['path'];
$app = new Slim\App(['settings'=>$config]);
$container = $app->getContainer();

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('application');
    $logpath='logs/'.date('m-d-Y').'-api.log';
    $file_handler = new \Monolog\Handler\StreamHandler($logpath);
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
  	$dsn = 'mysql:host='.$db['host'].';dbname='.$db['dbname'].';charset=utf8';
	$pdo = new \Slim\PDO\Database($dsn, $db['user'], $db['pass']);
    return $pdo;
};

$app->add(function ($request, $response, $next) {
	$data = $request->getParsedBody();
       	if($data['key']!=$this->get('settings')['api']['key'])
	{
		$result['code']=400;
		$result['msg']='Invalid api key';
		$this->logger->addInfo('[Invalid key: '.json_encode($data).'] ['.$request->getServerParam('REMOTE_ADDR', '127.0.0.1').']');
		return $response->withStatus(201)->write(json_encode($result));
	}
	$response = $next($request, $response);
	return $response;
}); 


$app->post('/banner', function ($request, $response, $args) {
    $result=array();
	if($request->isPost())
	{
	$data = $request->getParsedBody();
		$this->logger->addInfo('Attendance list posted data:['.json_encode($data).']['.$request->getServerParam('REMOTE_ADDR', '127.0.0.1').']');


	$selectStatement = $this->db->select(array('id','mainCategoryId','title','createAt','removeAt','CONCAT("'.$this->settings['http']['path'].'",image) as image'))
                       ->from('category')
                       ->where('removeAt', '=', 0)
                       ->where('mainCategoryId', '=', 0);
                      
	$stmt = $selectStatement->execute();
	
		$selectStatementbanner = $this->db->select(array('id','status','CONCAT("'.$this->settings['http']['path'].'",image) as image'))
                       ->from('banner')
                       ->where('status', '=', 1);
                      
	$stmtb = $selectStatementbanner->execute();
	$result['error']='false';
	$result['error_code']='0';
	
	$result['banner'] = $stmtb->fetchAll();
	$result['items'] = $stmt->fetchAll();
	if($result['items'] || $result['banner'] ){
		return $response->withHeader('Content-Type', 'application/json')->withStatus(200)->write(json_encode($result)); 
		}
		else
		{
		$result['error']='true';
	    $result['error_code']='No record Founnd';
		
		} 
	
 }else {
	 $result['msg']='Invalid method type.only post method allowed!';
	 $result['code']='400';
	 } 
	
	return $response->withHeader('Content-Type', 'application/json')->withStatus(201)->write(json_encode($result));

	
});//end services API


$app->run();
?>
