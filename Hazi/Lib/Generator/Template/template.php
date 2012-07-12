<?php

namespace Hazi\Lib\Generator\Template;

class template
{
   public function __construct($data = array()) {
    $this->app = $data["app"];
    $this->app_name = $data["app_name"];
    $this->table = $data["table"];

    if ($this->_create()) { 
      if($this->_fill()){

      } else {
        echo "ERROR al rellenar la plantilla ";
      }
    } else {
      echo "ERROR al crear el fichero principal";
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

   public function _create()
   {
     echo "TEMPLATE.CREATE<br />";
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
      echo "TEMPLATE.FILL<br />";
      return true;
    }
}