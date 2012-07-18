<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

require_once __DIR__."/../../generator/gozatzen/links_model.php";
require_once __DIR__."/../../Hazi/Lib/Vendor/autoload.php";

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
   private $app;
   private $table;
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param   array   $parameters     context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
        $this->app = new Silex\Application();

        $this->app->register(new Silex\Provider\DoctrineServiceProvider(), array(
                'db.options' => array(
                    'dbname' => 'elkartrukatu',
                    'user' => 'root',
                    'password' => 'aitiba',
                    'host' => 'localhost',
                    'driver'   => 'pdo_mysql',
                ),
        ));
    }

    /**
     * @Given /^la siguiente lista de generator$/
     */
    public function laSiguienteListaDeGenerator(TableNode $table)
    {
        $this->table = $table;
    }

    /**
     * @Given /^los guarda en la base de datos/
     */
    public function losGuardaEnLaBaseDeDatos()
    {
        $gozatzen_model = new Gozatzen\Model\gozatzen_model($this->app);
     
        foreach ($this->table->getHash() as $generatorHash) {
            if ($gozatzen_model->addLinks($generatorHash)) {
        
            } else {
                throw new PendingException();
            }
        }
    }

}
