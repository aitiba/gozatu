<?php

namespace Hazi\Lib\Generator\Template;

//require_once ("template.php");

//use Hazi\Lib\Template;
use Symfony\Component\HttpFoundation\Response;

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

      echo "DATA "; var_dump($this->table);
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
      echo $this->app_name;
      echo $this->table;

      echo "TEMPLATEMODEL.FILL<br />";

 // TODO: Metodo de add, edit($id), delete($id)

$variables = "";
$setgetters = "";
$getBy = "";
$crud = "";
$setgetters = "    // getters y setters\n";

foreach ($this->app['session']->get('schema') as $column) {
  $variables .= "    protected $".$column["Field"].";\n";

  $setgetters .= "    public function set".ucfirst($column['Field'])."(\$user)\n    {
        \$this->".$column['Field']." = $".$column['Field'].";
    }\n
    public function get".ucfirst($column['Field'])."()
    {
        return \$this->".$column['Field'].";
    }\n";

    $getBy .= "public function getBy".ucfirst($column['Field'])
    ."($".$column['Field'].")\n
    {\n
      \$sql='SELECT * FROM ".$this->table." WHERE ".$column['Field']." = ?';
      return \$this->app['db']->fetchAll(\$sql, $"
      .$column['Field'].");\n
    }\n";

    /* public function addLinks()
    {
        $data = array (
                    'url' => 'http://www.genbeta.com',
                    'created' => date('Y-m-d h:i:s'),
                    'ip' => '127.0.0.1'
                );
        var_dump($data);
        if (!$this->app['db']->insert('links', $data)) return false;

        return true; 
    }
    */
 }
 $setgetters .= "    // FIN getters y setters";

 /*
  public function editLinks($id)
            {
              //$link = $this->getById($id);
              $data = array (
                    'url' => 'http://www.azkena111.com',
                    'created' => date('Y-m-d H:i:s'),
                    'ip' => '127.0.0.1'
                );

              if (!$this->app['db']->update('links', $data, $id)) 
                return false;

              return true;
            }
    */
 $crud .= "// Añadir ".$this->table."
            public function add".ucfirst($this->table)."()
            {
              \$data = array (
                    'url' => \$_POST['url'],
                    'created' => date('Y-m-d H:i:s'),
                    'ip' => \$_POST['ip']
                );
            if (!\$this->app['db']->insert('links', \$data)) return false;

            return true;
            }\n\n";

        $crud .= "public function edit".ucfirst($this->table)."(\$id)
            {
              \$data = array (
                    'url' => 'http://www.azkena111.com',
                    'created' => date('Y-m-d H:i:s'),
                    'ip' => '127.0.0.1'
                );

              if (!\$this->app['db']->update('links', \$data, \$id)) 
                return false;

              return true;
            }\n\n";

        $crud .= "    public function delete".ucfirst($this->table)."(\$id)
    {
      if (!\$this->app['db']->delete('".$this->table."', \$id)) 
        return false;

      return true;
    }\n";
// var_dump($this->app);
// var_dump($this->app['session']->get('schema'));

$write = "<?php 
namespace ".ucfirst($this->app_name)."\Model;

class ".$this->app_name."_model
{
    protected \$app;\n"
    .$variables."

    // constructor
    public function __construct(\$app)
    {
        \$this->app = \$app;
    }\n\n"
    .$setgetters."\n"
    .$getBy."\n"
    .$crud."\n
    public function get".ucfirst($this->table)."()
    {
        \$sql = 'SELECT * FROM ".$this->table."';
        return \$this->app['db']->fetchAll(\$sql);
    }
}";

if (!fwrite($this->model, $write)) return false;
//return true;
fclose($this->model);
return new Response('html generado!');
    }
}