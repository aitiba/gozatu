<?php
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