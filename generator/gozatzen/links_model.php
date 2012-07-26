<?php 
namespace Gozatzen\Model;

class gozatzen_model
{
    protected $app;
    protected $id;
    protected $url;
    protected $created;
    protected $ip;


    // constructor
    public function __construct($app)
    {
        $this->app = $app;
    }

    // getters y setters
    public function setId($user)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setUrl($user)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }
    public function setCreated($user)
    {
        $this->created = $created;
    }

    public function getCreated()
    {
        return $this->created;
    }
    public function setIp($user)
    {
        $this->ip = $ip;
    }

    public function getIp()
    {
        return $this->ip;
    }
    // FIN getters y setters
public function getById($id)

    {

      $sql='SELECT * FROM links WHERE id ='.$id;
      return $this->app['db']->fetchAll($sql);

    }
public function getByUrl($url)

    {

      $sql='SELECT * FROM links WHERE url ='.$url;
      return $this->app['db']->fetchAll($sql);

    }
public function getByCreated($created)

    {

      $sql='SELECT * FROM links WHERE created ='.$created;
      return $this->app['db']->fetchAll($sql);

    }
public function getByIp($ip)

    {

      $sql='SELECT * FROM links WHERE ip ='.$ip;
      return $this->app['db']->fetchAll($sql);

    }

// Añadir links
            public function addLinks()
            {
              $data = array (
                    'url' => $_POST['url'],
                    'created' => date('Y-m-d H:i:s'),
                    'ip' => $_POST['ip']
                );
            if (!$this->app['db']->insert('links', $data)) return false;

            return true;
            }

public function editLinks($id)
            {
              $id = array('id' => $id);
              $data = array (
                    'url' => $_POST['url'],
                    'created' => date('Y-m-d H:i:s'),
                    'ip' => $_POST['ip']
                );

              if (!$this->app['db']->update('links', $data, $id)) 
                return false;

              return true;
            }

    public function deleteLinks($id)
    {
      if (!$this->app['db']->delete('links', $id)) 
        return false;

      return true;
    }


    public function getLinks()
    {
        $sql = 'SELECT * FROM links';
        return $this->app['db']->fetchAll($sql);
    }

    /* PAGINATOR */
    public function countLinks()
    {
        $sql = 'SELECT count(*) as howMany FROM links';
        $data = $this->app['db']->fetchAll($sql);
        
        return $data;
    }
    public function paginatorLinks($desde = 0, $cuantos = 10)
    {
        $sql = 'SELECT * FROM links ORDER BY id DESC LIMIT '.$desde.' , '.$cuantos;
        return $this->app['db']->fetchAll($sql);
    }
}