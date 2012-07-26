<?php

namespace Hazi\Lib\Generator\Template;

//require_once ("template.php");

//use Hazi\Lib\Template;
use Symfony\Component\HttpFoundation\Response;

class templateController extends template
{
  /* La app en si misma. Necesaria al basarse en silex. En 
    * $this->app['session']->get('schema')
    *estan las columnas de la tabla elegida 
  */
  protected $app;

  /* Nombre de la aplicación */
  protected $app_name;

  /* Tabla sobre la que se quieren generar cosas */
  protected $table;

  //protected $controller;

  public function __construct($data = array()) {
    $this->app = $data["app"];
    $this->app_name = $data["app_name"];
    $this->table = $data["table"];

    parent::__construct($data);

     if ($this->_backup()) { 
      if ($this->_openController()) { 
      echo "HOLA";
      } else {
        echo "ERROR al crear el fichero";
      }
     } else {
        echo "ERROR al crear el fichero";
     }
  }

   /**
   * templateController._backup
   * Make a copy of web/index.php on web/indexYYYYMMDDHHiiss.php
   *
   * @access public
   * @since 0.0
   *
   *
   * @return bool
   */

   public function _backup()
   {
    $file = __DIR__."/../../../../web/index.php";
    $file_backup = __DIR__."/../../../../web/index_".date('YmdHis').".php";
    if (copy($file, $file_backup)) {
      echo "<p style='color:green'>Copia de seguridad creada para web/index.php</p>";
      return true;
    } else {
      echo "<p style='color:red'>ERROR al copiar web/index.php</p>";
      return false;
    }
   }

   /**
   * templateController._openController
   *
   *
   * @access public
   * @since 0.0
   *
   *
   * @return bool
   */

   public function _openController()
   {
    $add = $edit = $delete = $list = false;
  // $actionsToOpen = array("add", "edit", "delete", "list");
    $file = __DIR__."/../../../../web/index.php";
    $controller = fopen($file, 'r') or die("can't open file");
    $read_file = fread($controller, filesize($file));
    $read_file = substr($read_file, 0, -13);

    /* To know if the action is setted. If not setted, is copied.If is setted, isnt copied */
    
    if (!strpos($read_file, $this->table."/add")) {
         $add = true;
    }

    if (!strpos($read_file, $this->table."/edit")) {
         $edit = true;
    }

    if (!strpos($read_file, $this->table."/delete")) {
         $delete = true;
    }

    if (!strpos($read_file, $this->table."/edit")) {
         $list = true;
    }
    //}
    fclose($controller);

    $data = $read_file."\n";

    if($add) {
    $data .= "\n\$app->match('/".$this->table."/add', function () use (\$app){
     \$data = null;
   \$".$this->app_name."_model = 
      new ".ucfirst($this->app_name)."\Model\ ".$this->app_name."_model(\$app);
var_dump(\$_POST);
      if (\$_POST){
       if (\$".$this->app_name."_model->add".ucfirst($this->table)."()) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        require_once __DIR__.'/../generator/gozatzen/view/links/add.php';
      }
})
->method('GET|POST');";
  }

 if($edit) {
$data .= "\$app->match('/".$this->table."/edit/{id}', function (\$id) use (\$app){
   \$data = null;
   \$".$this->app_name."_model = 
      new ".ucfirst($this->app_name)."\Model\ ".$this->app_name."_model(\$app);
     if (\$_POST){
       if (\$".$this->app_name."_model->edit".ucfirst($this->table)."(\$id)) {
          echo 'GUARDADO';
       } else {
          echo 'ERROR!';
       }
      } else {
        \$data = \$gozatzen_model->getById(\$id);
        require_once __DIR__.'/../generator/gozatzen/view/links/edit.php';
      }
})
->method('GET|POST');";
}

 if($delete) {
$data .= "\$app->match('/".$this->table."/delete/{id}', function (\$id) use (\$app){
  \$".$this->app_name."_model = 
      new ".ucfirst($this->app_name)."\Model\ ".$this->app_name."_model(\$app);
   if (\$".$this->app_name."_model->delete".ucfirst($this->table)."(array('id' => \$id))) {
     echo 'BORRADO';
   } else {
      echo 'ERROR!';
   }
})
->method('GET|POST');";
}

 if($list) {
$data .= "\$app->match('/".$this->table."/list/{desde}', function (\$desde) use (\$app){
   \$cuantos = 10;
  \$".$this->app_name."_model = 
      new ".ucfirst($this->app_name)."\Model\ ".$this->app_name."_model(\$app);
   if (\$data = \$".$this->app_name."_model->get".ucfirst($this->table)."()) {
     
     \$data = \$".$this->app_name."_model->paginator".ucfirst($this->table)."(\$desde, \$cuantos);
    \$paginator['total'] = \$".$this->app_name."_model->count".ucfirst($this->table)."();
    \$paginator['paginator'] = round(\$paginator['total'][0]['howMany'] / \$cuantos);
     require_once __DIR__.'/../generator/gozatzen/view/links/list.php';
   } else {
      echo 'ERROR!';
   }
})
->method('GET');\n\n";
}
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