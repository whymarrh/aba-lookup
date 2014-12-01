<?php

namespace AbaLookupTest;

use RuntimeException;
use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

class Bootstrap
{
	protected static function findParentPath($path)
	{
		$dir = __DIR__;
		$previousDir = '.';
		while (!is_dir($dir . '/' . $path)) {
			$dir = dirname($dir);
			if ($previousDir === $dir) {
				return false;
			}
			$previousDir = $dir;
		}
		return $dir . '/' . $path;
	}

	public static function init()
	{
		static::initAutoloader();

		$config = array(
			'module_listener_options' => array(
				'config_glob_paths' => array(
					'../../../config/autoload/{,*.}{global,local}.php',
				),
				'module_paths' => array(
					static::findParentPath('vendor'),
					static::findParentPath('module'),
				),
			),
			'modules' => array(
				'AbaLookup',
			),
		);
		$serviceManager = new ServiceManager(new ServiceManagerConfig());
		$serviceManager->setService('ApplicationConfig', $config);
		$serviceManager->get('ModuleManager')->loadModules();
	}

	protected static function initAutoloader()
	{
		include static::findParentPath('vendor') . '/../autoloader.php';
		AutoloaderFactory::factory(array(
			'Zend\Loader\StandardAutoloader' => array(
				'autoregister_zf' => TRUE,
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/' . __NAMESPACE__,
				),
			),
		));
	}
}

Bootstrap::init();
