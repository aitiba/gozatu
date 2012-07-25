<?php

namespace Hazi\Lib\Generator\Template;

//require_once ("template.php");

//use Hazi\Lib\Template;
use Symfony\Component\HttpFoundation\Response;

class templateView extends template
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

    echo $this->_createViews();

    if ($res=$this->_createViews()) { 
    echo "HOLA";
    } else {
      echo "ERROR al crear el fichero de ".$res;
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

   public function _createViews()
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

   if (!$this->_createViewAdd()) return 'add';
   elseif (!$this->_createViewEdit()) return 'edit';
  // elseif (!$this->_createViewDelete()) return 'delete';
   elseif (!$this->_createViewList()) return 'list';
}

   public function _createViewAdd()
   {
    $file = __DIR__."/../../../../generator/".$this->app_name."/view/".$this->table."/add.php";
   
    $data = "  <html>
        <head>
            <title></title>
        </head>
        <body>";
        // $data = $head;
           $data .= "<form action='#' method='post'>\n";
         foreach ($this->app['session']->get('schema') as $column) {
      //    echo "pasa";  var_dump($column["Field"]);
            if ($column["Field"] != 'id' AND $column["Field"] != 'created') {
               $type = explode("(", $column["Type"]);
    //var_dump($type);
                  switch ($type[0]) {
                      case 'int':
                      case 'varchar':
                      case 'datetime':
                        $type_column = "string";
                        break;
                }
                $data .= ucfirst($column["Field"]).": <input type='".$type_column."' name='".$column["Field"]."'>
               ";
            }
//var_dump($column);
         }
        $data .= " <input type='submit' value='Aceptar' name='buttom' /></form>";

        $data .= "
        </body>
        </html>";
    $view = fopen($file, 'w') or die("can't open file");
    fwrite($view, $data);

    fclose($view);

    return true;
   }

   public function _createViewEdit() {
      $file = __DIR__."/../../../../generator/".$this->app_name."/view/".$this->table."/edit.php";
   
    $data = "  <html>
        <head>
            <title></title>
        </head>
        <body>";
        // $data = $head;
           $data .= "<form action='#' method='post'>\n";
         foreach ($this->app['session']->get('schema') as $column) {
      //    echo "pasa";  var_dump($column["Field"]);
            if ($column["Field"] != 'id' AND $column["Field"] != 'created') {
               $type = explode("(", $column["Type"]);
    //var_dump($type);
                  switch ($type[0]) {
                      case 'int':
                      case 'varchar':
                      case 'datetime':
                        $type_column = "string";
                        break;
                }
                $data .= ucfirst($column["Field"]).": <input type='".$type_column."' name='".$column["Field"]."' value=<?php echo \$data[0]['".$column["Field"]."'] ?>>
               ";
            }
//var_dump($column);
         }
        $data .= " <input type='hidden' value=<?php echo \$id ?> />
        <input type='submit' value='Aceptar' name='buttom' /></form>";

        $data .= "
        </body>
        </html>";
    $view = fopen($file, 'w') or die("can't open file");
    fwrite($view, $data);

    fclose($view);

    return true;
   }

   public function _createViewList() {
    $file = __DIR__."/../../../../generator/".$this->app_name."/view/".$this->table."/list.php";
   
    $data = "  <html>
        <head>
            <title></title>
        </head>
        <body>";

        $data .= "<table>
                  <tr>
                    <td><a href='add'>Nuevo ".$this->table."</a></td>
                  </tr>
                  <tr>";

        foreach ($this->app['session']->get('schema') as $column) {
          $data .= "<td>".ucfirst($column["Field"])."</td>";
        }
        $data .= "<td>&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                  <?php foreach (\$data as \$d) { ?>
                    <tr>";
        foreach ($this->app['session']->get('schema') as $column) {
       //      if ($column["Field"] != 'id' AND $column["Field"] != 'created') {
            $data .= "<td><?php echo \$d['".$column["Field"]."'] ?></td>";
           }
        //}
      $data .= "<td><a href='edit\<?php echo \$d['id'] ?>'>Editar</a></td>
                <td><a href='delete\<?php echo \$d['id'] ?>'>Borrar</a></td>
                </tr>
                <?php } ?>
              </table>";
         
    $view = fopen($file, 'w') or die("can't open file");
    fwrite($view, $data);

    fclose($view);

    return true;
   }
}