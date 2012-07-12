<?php

namespace Hazi\Lib\Generator\Template;

//require_once ("template.php");

//use Hazi\Lib\Template;

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
      //TODO: Meter el modelo basico que esta en 
      // /generator/src/view/model_view.php

      echo $this->app_name;
      echo $this->table;

      echo "TEMPLATEMODEL.FILL<br />";

      /*
      $app_name = "gozatzen";
$variables = "";
$functions = "";
//mkdir("../generator/".$app_name."/"); 

$model = fopen("../generator/".$app_name."/".$this->table."_model.php", "w");
if(!$model) die("unable to create model file");

foreach ($this->app['session']->get('schema') as $column) {
  $variables .= "    protected $".$column["Field"].";\n";
}
// var_dump($this->app);
// var_dump($this->app['session']->get('schema'));

$write = "<?php
namespace ".ucfirst($app_name)."\Model

class ".$app_name."_model
{
    protected \$app;\n"
    .$variables."

    public function __construct(\$app)
    {
        \$this->app = \$app;
    }

    public function get".ucfirst($this->table)."()
    {
        \$sql = 'SELECT * FROM ".$this->table."';
        return \$this->app['db']->fetchAll(\$sql);
    }
}";

fwrite($model, $write); 
*/
    }
}