<?php

namespace \Model;

class _model
{
   protected $app;

   public function __construct($app)
   {
       $this->app = $app;
   }

   public function get()
   {
       $sql = 'SELECT * FROM ';
       return $this->app['db']->fetchAll($sql);
   }
}