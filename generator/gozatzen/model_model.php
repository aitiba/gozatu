<?php
namespace Gozatzen\Model

class gozatzen_model
{
    protected $app;
    protected $id;
    protected $url;
    protected $created;
    protected $ip;


    public function __construct($app)
    {
        $this->app = $app;
    }

    public function getModel()
    {
        $sql = 'SELECT * FROM model';
        return $this->app['db']->fetchAll($sql);
    }
}