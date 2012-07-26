<?php 
namespace Gozatzen\Model;
 
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;

class gozatzen_model
{
	protected $app;

	public function __construct($app)
    {
        $this->app = $app;
        //echo __CLASS__;
    }

     

    public function getLinks()
    {
    	//echo "pasa";
        $sql = "SELECT * FROM links";
    	return $this->app['db']->fetchAll($sql);
    }
}