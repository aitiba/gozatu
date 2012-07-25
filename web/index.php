<!--
	javascript:q=(escape(document.location.href));(function(){window.open('http://localhost/elkartrukatu/web/index.php/gozatu?url='+q);})();
-->
<?php 
error_reporting(E_ALL);
ini_set('display_errors','On');

// Funcion de que se llama al hacer new del objeto __autoload()
// http://www.php.net/manual/es/function.spl-autoload-register.php
spl_autoload_register(function () {
    //require_once __DIR__."Hazi/Lib/Generator/gozatzen/model/gozatzen_model.php";
    require_once __DIR__."/../generator/gozatzen/links_model.php";
    require_once __DIR__."/../Hazi/Lib/Generator/generator.php";
    require_once __DIR__."/../Hazi/Lib/Generator/Template/templateModel.php";
    require_once __DIR__."/../Hazi/Lib/Generator/Template/template.php";
    require_once __DIR__."/../Hazi/Lib/Vendor/autoload.php";
});

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

// options
$app['debug'] = true;

// database configuration
// /elkartrukatu/vendor/silex/silex/src/Silex/Provider/DoctrineServiceProvider.php
// datuak BBDDtik atera edo sartzeko 
// /elkartrukatu/vendor/silex/dbal/lib/Doctrine/DBAL/Portability/Connection.php

// TODO: sartu hau database.php fitxategi baten barruan
// TODO: sartu titulu link bakoitzeko. Hortarako title-a scrapeatu
// TODO: sartu register guztiak bootstrap klase batetan. Hemen $app['bootstrap'] = 
// bootstrap klase metodoa. Register metodoa, routing, errorHandling,RegisterService eta horiek run metodo 
// publiko batetik
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
    'twig.path' => __DIR__.'/../App/Views',
));

$app->register(new Silex\Provider\SessionServiceProvider());

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
    
    	$app['db']->insert('links', $data);

     	//return new Response('Thank you for your feedback!', 201);
    	return new Response($app->redirect($_GET['url']));
    } 
    return $output;
})
->method('GET|POST');

$app->match('/gozatzen', function () use ($app){

/*    function __autoload($class_name) {
    echo 'AAAA'.$class_name;
    include $class_name . '.php';
}*/




    $gozatzen_model = new Gozatzen\Model\gozatzen_model($app);
    $data = $gozatzen_model->getLinks();
    //$sql = "SELECT * FROM links";
    //$data = $app['db']->fetchAll($sql);

    //var_dump($app['session']->get('schema'));

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
->method('GET');

$app->match('/generator', function () use ($app){
    
    /*foreach ($app['session']->get('schema') as $schema) {
        $data = array(
            "field" => $schema["Field"],
            "type" => $schema["Type"],
            "null" => $schema["Null"],
            "key" => $schema["Key"],
            "default" => $schema["Default"],
            "extra" => $schema["Extra"]);
        var_dump($data);

    }*/

    $generator = new Hazi\Lib\Generator\generator($app);
    $data = array (
                   "type" => "model",
                   "table" => "links"
                   );
    
    $generator->generate($data);

    $data = array (
                   "type" => "controller",
                   "table" => "links"
                   );
    $generator->generate($data);

    $data = array (
                   "type" => "view",
                   "table" => "links"
                   );
    $generator->generate($data);
    /*
    $data = array (
                   "type" => null,
                   "table" => "null"
                   );
    $generator->generate($data);*/
})
->method('GET');

$app->match('/test/gozatzen_model', function () use ($app){
    $gozatzen_model = new Gozatzen\Model\gozatzen_model($app);
    
    if ($gozatzen_model->getById(array((string) 1))) {
        echo "<p style='color:green'>gozatzen_model_getById SUCCESS</p>\n\n";
    } else {
        echo "<p style='color:red'>gozatzen_model_getById ERROR</p>";
    }

    $gozatzen_model = new Gozatzen\Model\gozatzen_model($app);
    if ($gozatzen_model->getByUrl(array((string) "http://www.20minutos.es/noticia/1454100/0/"))) {
        echo "<p style='color:green'>gozatzen_model_getByUrl SUCCESS</p>\n\n";
    } else {
        echo "<p style='color:red'>gozatzen_model_getByUrl ERROR</p>";
    }

    $gozatzen_model = new Gozatzen\Model\gozatzen_model($app);
    if ($gozatzen_model->getByIp(array((string) "127.0.0.1"))) {
        echo "<p style='color:green'>gozatzen_model_getByIp SUCCESS</p>\n\n";
    } else {
        echo "<p style='color:red'>gozatzen_model_getByIp ERROR</p>";
    }

    $gozatzen_model = new Gozatzen\Model\gozatzen_model($app);
    if ($gozatzen_model->addLinks() == 1) {
        echo "<p style='color:green'>gozatzen_model_Add SUCCESS</p>\n\n";
    } else {
        echo "<p style='color:red'>gozatzen_model_Add ERROR</p>";
    }  

    $gozatzen_model = new Gozatzen\Model\gozatzen_model($app);
    if ($gozatzen_model->editLinks(array("id" => 1)) == 1) {
        echo "<p style='color:green'>gozatzen_model_Edit SUCCESS</p>\n\n";
    } else {
        echo "<p style='color:red'>gozatzen_model_Edit ERROR</p>";
    } 

    $gozatzen_model = new Gozatzen\Model\gozatzen_model($app);
    if ($gozatzen_model->deleteLinks(array("id" => 1)) == 1) {
        echo "<p style='color:green'>gozatzen_model_Delete SUCCESS</p>\n\n";
    } else {
        echo "<p style='color:red'>gozatzen_model_Delete ERROR</p>";
    }   
})
->method('GET');



$app->match('/links/add', function () use ($app){
  

   
     $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
var_dump($_POST);
      if ($_POST){
       if ($gozatzen_model->addLinks()) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        require_once __DIR__.'/../generator/gozatzen/view/links/add.php';
      }
})
->method('GET|POST');

$app->match('/links/edit/{id}', function ($id) use ($app){
   $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
     if ($_POST){
       if ($gozatzen_model->editLinks($id)) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        $data = $gozatzen_model->getById($id);
        require_once __DIR__.'/../generator/gozatzen/view/links/edit.php';
      }
})
->method('GET|POST');

$app->match('/links/delete/{id}', function ($id) use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($gozatzen_model->deleteLinks(array('id' => $id))) {
     echo 'BORRADO';
   } else {
      echo 'ERROR!';
   }
})
->method('GET|POST');

$app->match('/links/list', function () use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($data = $gozatzen_model->getLinks()) {
     require_once __DIR__.'/../generator/gozatzen/view/links/list.php';
   } else {
      echo 'ERROR!';
   }
})
->method('GET');


$app->match('/links/add', function () use ($app){
  

   
     $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
var_dump($_POST);
      if ($_POST){
       if ($gozatzen_model->addLinks()) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        require_once __DIR__.'/../generator/gozatzen/view/links/add.php';
      }
})
->method('GET|POST');

$app->match('/links/edit/{id}', function ($id) use ($app){
   $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
     if ($_POST){
       if ($gozatzen_model->editLinks($id)) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        $data = $gozatzen_model->getById($id);
        require_once __DIR__.'/../generator/gozatzen/view/links/edit.php';
      }
})
->method('GET|POST');

$app->match('/links/delete/{id}', function ($id) use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($gozatzen_model->deleteLinks(array('id' => $id))) {
     echo 'BORRADO';
   } else {
      echo 'ERROR!';
   }
})
->method('GET|POST');

$app->match('/links/list', function () use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($data = $gozatzen_model->getLinks()) {
     echo 'LISTADO';
     var_dump($data);
   } else {
      echo 'ERROR!';
   }
})
->method('GET');


$app->match('/links/add', function () use ($app){
  

   
     $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
var_dump($_POST);
      if ($_POST){
       if ($gozatzen_model->addLinks()) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        require_once __DIR__.'/../generator/gozatzen/view/links/add.php';
      }
})
->method('GET|POST');

$app->match('/links/edit/{id}', function ($id) use ($app){
   $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
     if ($_POST){
       if ($gozatzen_model->editLinks($id)) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        $data = $gozatzen_model->getById($id);
        require_once __DIR__.'/../generator/gozatzen/view/links/edit.php';
      }
})
->method('GET|POST');

$app->match('/links/delete/{id}', function ($id) use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($gozatzen_model->deleteLinks(array('id' => $id))) {
     echo 'BORRADO';
   } else {
      echo 'ERROR!';
   }
})
->method('GET|POST');

$app->match('/links/list', function () use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($data = $gozatzen_model->getLinks()) {
     echo 'LISTADO';
     var_dump($data);
   } else {
      echo 'ERROR!';
   }
})
->method('GET');


$app->match('/links/add', function () use ($app){
  

   
     $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
var_dump($_POST);
      if ($_POST){
       if ($gozatzen_model->addLinks()) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        require_once __DIR__.'/../generator/gozatzen/view/links/add.php';
      }
})
->method('GET|POST');

$app->match('/links/edit/{id}', function ($id) use ($app){
   $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
     if ($_POST){
       if ($gozatzen_model->editLinks($id)) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        $data = $gozatzen_model->getById($id);
        require_once __DIR__.'/../generator/gozatzen/view/links/edit.php';
      }
})
->method('GET|POST');

$app->match('/links/delete/{id}', function ($id) use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($gozatzen_model->deleteLinks(array('id' => $id))) {
     echo 'BORRADO';
   } else {
      echo 'ERROR!';
   }
})
->method('GET|POST');

$app->match('/links/list', function () use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($data = $gozatzen_model->getLinks()) {
     require_once __DIR__.'/../generator/gozatzen/view/links/list.php';
   } else {
      echo 'ERROR!';
   }
})
->method('GET');


$app->match('/links/add', function () use ($app){
  

   
     $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
var_dump($_POST);
      if ($_POST){
       if ($gozatzen_model->addLinks()) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        require_once __DIR__.'/../generator/gozatzen/view/links/add.php';
      }
})
->method('GET|POST');

$app->match('/links/edit/{id}', function ($id) use ($app){
   $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
     if ($_POST){
       if ($gozatzen_model->editLinks($id)) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        $data = $gozatzen_model->getById($id);
        require_once __DIR__.'/../generator/gozatzen/view/links/edit.php';
      }
})
->method('GET|POST');

$app->match('/links/delete/{id}', function ($id) use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($gozatzen_model->deleteLinks(array('id' => $id))) {
     echo 'BORRADO';
   } else {
      echo 'ERROR!';
   }
})
->method('GET|POST');

$app->match('/links/list', function () use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($data = $gozatzen_model->getLinks()) {
     require_once __DIR__.'/../generator/gozatzen/view/links/list.php';
   } else {
      echo 'ERROR!';
   }
})
->method('GET');


$app->match('/links/add', function () use ($app){
  

   
     $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
var_dump($_POST);
      if ($_POST){
       if ($gozatzen_model->addLinks()) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        require_once __DIR__.'/../generator/gozatzen/view/links/add.php';
      }
})
->method('GET|POST');

$app->match('/links/edit/{id}', function ($id) use ($app){
   $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
     if ($_POST){
       if ($gozatzen_model->editLinks($id)) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        $data = $gozatzen_model->getById($id);
        require_once __DIR__.'/../generator/gozatzen/view/links/edit.php';
      }
})
->method('GET|POST');

$app->match('/links/delete/{id}', function ($id) use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($gozatzen_model->deleteLinks(array('id' => $id))) {
     echo 'BORRADO';
   } else {
      echo 'ERROR!';
   }
})
->method('GET|POST');

$app->match('/links/list', function () use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($data = $gozatzen_model->getLinks()) {
     require_once __DIR__.'/../generator/gozatzen/view/links/list.php';
   } else {
      echo 'ERROR!';
   }
})
->method('GET');


$app->match('/links/add', function () use ($app){
  

   
     $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
var_dump($_POST);
      if ($_POST){
       if ($gozatzen_model->addLinks()) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        require_once __DIR__.'/../generator/gozatzen/view/links/add.php';
      }
})
->method('GET|POST');

$app->match('/links/edit/{id}', function ($id) use ($app){
   $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
     if ($_POST){
       if ($gozatzen_model->editLinks($id)) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        $data = $gozatzen_model->getById($id);
        require_once __DIR__.'/../generator/gozatzen/view/links/edit.php';
      }
})
->method('GET|POST');

$app->match('/links/delete/{id}', function ($id) use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($gozatzen_model->deleteLinks(array('id' => $id))) {
     echo 'BORRADO';
   } else {
      echo 'ERROR!';
   }
})
->method('GET|POST');

$app->match('/links/list', function () use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($data = $gozatzen_model->getLinks()) {
     require_once __DIR__.'/../generator/gozatzen/view/links/list.php';
   } else {
      echo 'ERROR!';
   }
})
->method('GET');


$app->match('/links/add', function () use ($app){
  

   
     $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
var_dump($_POST);
      if ($_POST){
       if ($gozatzen_model->addLinks()) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        require_once __DIR__.'/../generator/gozatzen/view/links/add.php';
      }
})
->method('GET|POST');

$app->match('/links/edit/{id}', function ($id) use ($app){
   $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
     if ($_POST){
       if ($gozatzen_model->editLinks($id)) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        $data = $gozatzen_model->getById($id);
        require_once __DIR__.'/../generator/gozatzen/view/links/edit.php';
      }
})
->method('GET|POST');

$app->match('/links/delete/{id}', function ($id) use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($gozatzen_model->deleteLinks(array('id' => $id))) {
     echo 'BORRADO';
   } else {
      echo 'ERROR!';
   }
})
->method('GET|POST');

$app->match('/links/list', function () use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($data = $gozatzen_model->getLinks()) {
     require_once __DIR__.'/../generator/gozatzen/view/links/list.php';
   } else {
      echo 'ERROR!';
   }
})
->method('GET');


$app->match('/links/add', function () use ($app){
  

   
     $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
var_dump($_POST);
      if ($_POST){
       if ($gozatzen_model->addLinks()) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        require_once __DIR__.'/../generator/gozatzen/view/links/add.php';
      }
})
->method('GET|POST');

$app->match('/links/edit/{id}', function ($id) use ($app){
   $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
     if ($_POST){
       if ($gozatzen_model->editLinks($id)) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        $data = $gozatzen_model->getById($id);
        require_once __DIR__.'/../generator/gozatzen/view/links/edit.php';
      }
})
->method('GET|POST');

$app->match('/links/delete/{id}', function ($id) use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($gozatzen_model->deleteLinks(array('id' => $id))) {
     echo 'BORRADO';
   } else {
      echo 'ERROR!';
   }
})
->method('GET|POST');

$app->match('/links/list', function () use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($data = $gozatzen_model->getLinks()) {
     require_once __DIR__.'/../generator/gozatzen/view/links/list.php';
   } else {
      echo 'ERROR!';
   }
})
->method('GET');


$app->match('/links/add', function () use ($app){
  

   
     $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
var_dump($_POST);
      if ($_POST){
       if ($gozatzen_model->addLinks()) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        require_once __DIR__.'/../generator/gozatzen/view/links/add.php';
      }
})
->method('GET|POST');

$app->match('/links/edit/{id}', function ($id) use ($app){
   $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
     if ($_POST){
       if ($gozatzen_model->editLinks($id)) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        $data = $gozatzen_model->getById($id);
        require_once __DIR__.'/../generator/gozatzen/view/links/edit.php';
      }
})
->method('GET|POST');

$app->match('/links/delete/{id}', function ($id) use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($gozatzen_model->deleteLinks(array('id' => $id))) {
     echo 'BORRADO';
   } else {
      echo 'ERROR!';
   }
})
->method('GET|POST');

$app->match('/links/list', function () use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($data = $gozatzen_model->getLinks()) {
     require_once __DIR__.'/../generator/gozatzen/view/links/list.php';
   } else {
      echo 'ERROR!';
   }
})
->method('GET');


$app->match('/links/add', function () use ($app){
  

   
     $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
var_dump($_POST);
      if ($_POST){
       if ($gozatzen_model->addLinks()) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        require_once __DIR__.'/../generator/gozatzen/view/links/add.php';
      }
})
->method('GET|POST');

$app->match('/links/edit/{id}', function ($id) use ($app){
   $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
     if ($_POST){
       if ($gozatzen_model->editLinks($id)) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        $data = $gozatzen_model->getById($id);
        require_once __DIR__.'/../generator/gozatzen/view/links/edit.php';
      }
})
->method('GET|POST');

$app->match('/links/delete/{id}', function ($id) use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($gozatzen_model->deleteLinks(array('id' => $id))) {
     echo 'BORRADO';
   } else {
      echo 'ERROR!';
   }
})
->method('GET|POST');

$app->match('/links/list', function () use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($data = $gozatzen_model->getLinks()) {
     require_once __DIR__.'/../generator/gozatzen/view/links/list.php';
   } else {
      echo 'ERROR!';
   }
})
->method('GET');


$app->match('/links/add', function () use ($app){
  

   
     $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
var_dump($_POST);
      if ($_POST){
       if ($gozatzen_model->addLinks()) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        require_once __DIR__.'/../generator/gozatzen/view/links/add.php';
      }
})
->method('GET|POST');

$app->match('/links/edit/{id}', function ($id) use ($app){
   $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
     if ($_POST){
       if ($gozatzen_model->editLinks($id)) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        $data = $gozatzen_model->getById($id);
        require_once __DIR__.'/../generator/gozatzen/view/links/edit.php';
      }
})
->method('GET|POST');

$app->match('/links/delete/{id}', function ($id) use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($gozatzen_model->deleteLinks(array('id' => $id))) {
     echo 'BORRADO';
   } else {
      echo 'ERROR!';
   }
})
->method('GET|POST');

$app->match('/links/list', function () use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($data = $gozatzen_model->getLinks()) {
     require_once __DIR__.'/../generator/gozatzen/view/links/list.php';
   } else {
      echo 'ERROR!';
   }
})
->method('GET');


$app->match('/links/add', function () use ($app){
  

   
     $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
var_dump($_POST);
      if ($_POST){
       if ($gozatzen_model->addLinks()) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        require_once __DIR__.'/../generator/gozatzen/view/links/add.php';
      }
})
->method('GET|POST');

$app->match('/links/edit/{id}', function ($id) use ($app){
   $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
     if ($_POST){
       if ($gozatzen_model->editLinks($id)) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        $data = $gozatzen_model->getById($id);
        require_once __DIR__.'/../generator/gozatzen/view/links/edit.php';
      }
})
->method('GET|POST');

$app->match('/links/delete/{id}', function ($id) use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($gozatzen_model->deleteLinks(array('id' => $id))) {
     echo 'BORRADO';
   } else {
      echo 'ERROR!';
   }
})
->method('GET|POST');

$app->match('/links/list', function () use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($data = $gozatzen_model->getLinks()) {
     require_once __DIR__.'/../generator/gozatzen/view/links/list.php';
   } else {
      echo 'ERROR!';
   }
})
->method('GET');


$app->match('/links/add', function () use ($app){
  

   
     $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
var_dump($_POST);
      if ($_POST){
       if ($gozatzen_model->addLinks()) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        require_once __DIR__.'/../generator/gozatzen/view/links/add.php';
      }
})
->method('GET|POST');

$app->match('/links/edit/{id}', function ($id) use ($app){
   $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
     if ($_POST){
       if ($gozatzen_model->editLinks($id)) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        $data = $gozatzen_model->getById($id);
        require_once __DIR__.'/../generator/gozatzen/view/links/edit.php';
      }
})
->method('GET|POST');

$app->match('/links/delete/{id}', function ($id) use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($gozatzen_model->deleteLinks(array('id' => $id))) {
     echo 'BORRADO';
   } else {
      echo 'ERROR!';
   }
})
->method('GET|POST');

$app->match('/links/list', function () use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($data = $gozatzen_model->getLinks()) {
     require_once __DIR__.'/../generator/gozatzen/view/links/list.php';
   } else {
      echo 'ERROR!';
   }
})
->method('GET');


$app->match('/links/add', function () use ($app){
  

   
     $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
var_dump($_POST);
      if ($_POST){
       if ($gozatzen_model->addLinks()) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        require_once __DIR__.'/../generator/gozatzen/view/links/add.php';
      }
})
->method('GET|POST');

$app->match('/links/edit/{id}', function ($id) use ($app){
   $data = null;
   $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
     if ($_POST){
       if ($gozatzen_model->editLinks($id)) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        $data = $gozatzen_model->getById($id);
        require_once __DIR__.'/../generator/gozatzen/view/links/edit.php';
      }
})
->method('GET|POST');

$app->match('/links/delete/{id}', function ($id) use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($gozatzen_model->deleteLinks(array('id' => $id))) {
     echo 'BORRADO';
   } else {
      echo 'ERROR!';
   }
})
->method('GET|POST');

$app->match('/links/list', function () use ($app){
  $gozatzen_model = 
      new Gozatzen\Model\ gozatzen_model($app);
   if ($data = $gozatzen_model->getLinks()) {
     require_once __DIR__.'/../generator/gozatzen/view/links/list.php';
   } else {
      echo 'ERROR!';
   }
})
->method('GET');

$app->run();