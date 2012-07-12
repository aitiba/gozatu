<?php

namespace Hazi\Lib\Generator\Template;

//require_once ("template.php");

//use Hazi\Lib\Template;

class templateModel extends template
{
  protected $app;
  protected $app_name;
  protected $table;
  protected $model;

  public function __construct($data = array()) {
    $this->app = $data["app"];
    $this->app_name = $data["app_name"];
    $this->table = $data["table"];

    parent::__construct($data);

    if ($this->_create()) { 
      if($this->_fill()){

      } else {
        echo "ERROR al rellenar la plantilla";
      }
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

   public function _create()
   {
      // TODO: Se queda vacio por ahora
    
      echo "TEMPLATEMODEL.CREATE<br />";

      //mkdir("../generator/".$app_name."/"); 
      $this->model = fopen(__DIR__."/../../../../generator/".$this->app_name."/".$this->table."_model.php", "w");
      if(!$this->model) return false;

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
      //TODO: Meter el modelo basico que esta en 
      // /generator/src/view/model_view.php

      echo $this->app_name;
      echo $this->table;

      echo "TEMPLATEMODEL.FILL<br />";

      
$variables = "";
$functions = "";




foreach ($this->app['session']->get('schema') as $column) {
  $variables .= "    protected $".$column["Field"].";\n";
}
// var_dump($this->app);
// var_dump($this->app['session']->get('schema'));

$write = "<?php HOLANDO
namespace ".ucfirst($this->app_name)."\Model

class ".$this->app_name."_model
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

if (!fwrite($this->model, $write)) return false;
return true;

    }
}