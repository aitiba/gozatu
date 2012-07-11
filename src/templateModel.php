<?php

namespace Generator\TemplateModel;

class templateModel extends template
{

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

    private function _fill() 
    {
      echo "TEMPLATEMODEL.FILL<br />";
    }
}