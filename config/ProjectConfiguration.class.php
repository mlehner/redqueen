<?php

require_once dirname(__FILE__).'/../vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    // Integrate Zend Framework
    set_include_path(sfConfig::get('sf_root_dir').'/vendor'.PATH_SEPARATOR.get_include_path());
    require_once sfConfig::get('sf_root_dir').'/vendor/Zend/Loader/Autoloader.php';
    spl_autoload_register(array('Zend_Loader_Autoloader', 'autoload'));

    // for compatibility / remove and enable only the plugins you want
    $this->enableAllPluginsExcept(array('sfPropelPlugin'));
    
    sfWidgetFormSchema::setDefaultFormFormatterName('betterList'); 
  }
}
