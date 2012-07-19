<?php

namespace Hazi\Lib\Generator\Template;

//require_once ("template.php");

//use Hazi\Lib\Template;
use Symfony\Component\HttpFoundation\Response;

class templateController extends template
{
  protected $app;
  protected $app_name;
  protected $table;
  protected $controller;

  public function __construct($data = array()) {
    $this->app = $data["app"];
    $this->app_name = $data["app_name"];
    $this->table = $data["table"];

    parent::__construct($data);

    if ($this->_openController()) { 
    echo "HOLA";
    } else {
      echo "ERROR al crear el fichero";
    }
  }

   /**
   * template. create
   *
   *
   * @access public
   * @since 0.0
   *
   *
   * @return mixed
   */

   public function _openController()
   {
    $file = __DIR__."/../../../../web/index.php";
    $controller = fopen($file, 'r') or die("can't open file");
    $read_file = fread($controller, filesize($file));
    $read_file = substr($read_file, 0, -13);
    fclose($controller);

    $data = $read_file."\n";
    $data .= "\n\$app->match('/generator/add', function () use (\$app){
  echo 'add';
})
->method('GET|POST');

\$app->match('/generator/edit/{id}', function () use (\$app){
  echo \$id;
})
->method('GET|POST');

\$app->match('/generator/delete', function () use (\$app){
  echo 'delete';
})
->method('POST');

\$app->match('/generator/list', function () use (\$app){
  echo 'list';
})
->method('GET');\n\n";
    $data .= "\$app->run();";
    $controller = fopen($file, 'w') or die("can't open file");
    fwrite($controller, $data);

    fclose($controller);

    return true;
   }

  /**
   * template.fill
   *
   *
   * @access public
   * @since 0.0
   *
   *
   * @return mixed
   */

    public function _fill() 
    {
     
return new Response('html generado!');
    }
}