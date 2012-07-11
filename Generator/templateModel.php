<?php

namespace Generator;
//use Generator\Template;
require_once ("template.php");

class templateModel extends template
{
  protected $app_name;
  protected $table;

  public function __construct($app_name, $table) {
    $this->app_name = $app_name;
    $this->table = $table;

    parent::_create();
   // $this->_create();
    $this->_fill();
    //parent::_fill();
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

   public function _create()
   {
      // TODO: Se queda vacio por ahora
    
      echo "TEMPLATEMODEL.CREATE<br />";
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
      //TODO: Meter el modelo basico que esta en /src/gozazten/model/gozatzen_model.php

      echo $this->app_name;
      echo $this->table;

      echo "TEMPLATEMODEL.FILL<br />";
    }
}