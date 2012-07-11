<?php

namespace Generator;

//use Generator\templateModel;
require_once ("../Generator/templateModel.php");

class generator extends templateModel
{
   /* La app en si misma. Necesaria al basarse en silex. En 
    * $this->app['session']->get('schema')
    *estan las columnas de la tabla elegida 
   */

   protected $app;

   /* Tipo de cosa a generar: model,controller,view,null(los tres) */

   protected $type;

   /* Tabla sobre la que se quieren generar cosas */

   protected $table;

   public function __construct($app)
   {
       $this->app = $app;
   }

   /**
   * generator. generate
   *
   * Public function to create the CRUD.Options:
   * model,controller,view,null
   *
   * @access public
   * @since 0.0
   *
   * @param string $type
   * @param string $table
   *
   * @return mixed
   */

   public function generate($type = null, $table = null)
   {
      // TODO: Si type o table null exception.
      $this->type = $type;
      $this->table = $table;
     if($this->_generate_schema()) {
        switch ($this->type) {
          case 'model':
            $this->_generate_model();
            break;

          case 'controller':
            $this->_generate_controller();
            break;
          
          case 'view':
            $this->_generate_view();
            break;

          default:  
            $this->_generate_model();
            $this->_generate_controller();
            $this->_generate_view();
            break;
        }
      }
   }

   /**
   * generator. _generate_schema
   *
   * Generador privado del schema
   *
   * @access private
   * @since 0.0
   *
   * @return bool
   */

    private function _generate_schema() {
      // TODO: konsola aplikazioa egiterakoan datu hau eskatuko da.
      $sql = "SHOW COLUMNS FROM links";
      $db_name = explode(" ", $sql);
      $db_name = $db_name[3];
    
      $this->app['session']->set('schema', $this->app["db"]->fetchAll($sql));

    //if($this->howManyColumns = count($this->app['session']->get('schema'))) {
      if($this->app['session']->get('schema')) {
        return true;
      } else {
        return false;
      }
    }

   /**
   * generator. _generate_model
   *
   * Generador privado del modelo
   *
   * @access private
   * @since 0.0
   *
   * @return mixed
   */

    private function _generate_model() {
      $app_name = "gozatzen";
      
      echo "MODEL<br />";
     // echo "App: ";var_dump($this->app);echo "<br />";
      echo "Type: ".$this->type."<br />";
      echo "Table: ".$this->table."<br />";

   
      //crea el fichero y le mete lo comun para todos los modelos
      //require("../generator/src/view/model_view.php");
      $templateModel = new templateModel($app_name, $this->table);
    //  $templateModel->_create()

echo "DATOS DE LA SESSION<br />";
   // print_r($app["session"]);
    /*if ($data) {
         return $app['twig']->render('gozatzen.twig', array(
        'data' => $data,
        ));
    }*/
}

    /**
   * generator. _generate_controller
   *
   * Generador privado del controllador
   *
   * @access private
   * @since 0.0
   *
   * @return mixed
   */

    private function _generate_controller() {
      echo "controller<br /><br />";
      echo "Type: ".$this->type."<br />";
      echo "Table: ".$this->table."<br />";
    }

    /**
   * generator. _generate_view
   *
   * Generador privado de las vistas
   *
   * @access private
   * @since 0.0
   *
   * @return mixed
   */

    private function _generate_view() {
      echo "view<br /><br />";
      echo "Type: ".$this->type."<br />";
      echo "Table: ".$this->table."<br />";
    }
}