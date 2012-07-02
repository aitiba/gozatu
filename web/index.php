<!--
	javascript:q=(escape(document.location.href));(function(){window.open('http://localhost/elkartrukatu/web/index.php/gozatu?url='+q);})();
-->
<?php 
error_reporting(E_ALL);
ini_set('display_errors','On');

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

// options
$app['debug'] = true;

// database configuration
// /elkartrukatu/vendor/silex/silex/src/Silex/Provider/DoctrineServiceProvider.php
// datuak BBDDtik atera edo sartzeko 
// /elkartrukatu/vendor/silex/dbal/linb/Doctrine/DBal/Portability/Connection.php

// TODO: sartu hau database.php fitxategi baten barruan
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
    	'dbname' => 'elkartrukatu',
	    'user' => 'root',
	    'password' => 'aitiba',
	    'host' => 'localhost',
        'driver'   => 'pdo_mysql',
    ),
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

// http://localhost/elkartrukatu/web/index.php/gozatu

// TODO: Gozatua sartzen dunaren IPa sartu
// TODO: created datetime bihurtu

$app->match('/gozatu', function () use ($app){
    $output = include "../gozatu.html";
    if($_GET) {
    	//botoia sakatu da
    	$data = array(
    		'url' => $_GET['url'],
    		'created' => date("Y-d-m H:i:s") ,
    		'ip' => '127.0.0.1'
    		);
    	//var_dump($data);

    	/*$sql = "INSERT INTO links (url, created, ip)
    			VALUES ('".$data['url']."','".$data['created']."','".$data['ip']."')";
    	$app['db']->executeQuery($sql);*/

    	$app['db']->insert('links', $data);

    	//echo $app['db']->lastInsertId();

    	//echo $sql;



    	//var_dump($post);
    	// conexion a MySQL
    	// subir datos
    	//return new Response('Thank you for your feedback!', 201);
    	return $app->redirect($_GET['url']);
    } 
    return $output;
})
->method('GET|POST');

$app->match('/gozatzen', function () use ($app){
 
    $sql = "SELECT * FROM links";
    $data = $app['db']->fetchAll($sql);

    if ($data) {
    	 return $app['twig']->render('gozatzen.twig', array(
        'data' => $data,
    ));
    	/*foreach ($data as $d) {
    		$id = $d['id'];
    		$url = $d['url'];
    		$created = $d['created'];
    		$ip = $d['ip'];

    		echo "ID: ".$id. "   URL: ".$url.
    		"   CREATED: ".$created."   IP:".$ip."<br />";
    	}*/
    }

    //return new Response('Thank you for your feedback!', 201);
})
->method('GET|POST');

$app->run();