<?php

namespace Gozatzen\Model;

class gozatzen_model
{
   protected $app;

   public function __construct($app)
   {
       $this->app = $app;
   }

   public function getLinks()
   {
       $sql = 'SELECT * FROM links';
       return $this->app['db']->fetchAll($sql);
   }
}