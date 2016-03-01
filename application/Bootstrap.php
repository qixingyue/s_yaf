<?php

class Bootstrap extends Yaf_Bootstrap_Abstract {

	private $app;
	private $config;

	public function _initUTF8(){
		header("Content-type:text/html;charset=utf-8");
	}

	public function _initObjectIntern(Yaf_Dispatcher $dispatcher){
		$this->app = $dispatcher->getApplication();	
		$this->config = $this->app->getConfig();
	}

	public function _initErrorReport(Yaf_Dispatcher $dispatcher){
		if($this->config->application->debug)	{
			error_reporting(E_ALL);	
			ini_set("display_errors","On");	
		} else {
			error_reporting(E_STRICT);	
			ini_set("display_errors","Off");	
		}
	}

	public function _initPlugin(Yaf_Dispatcher $dispatcher){
		foreach($this->_getPlugins() as $plugin){
			$dispatcher->registerPlugin($plugin);
		}
	}


	public function _initCliDisableView(Yaf_Dispatcher $dispatcher){
		if($dispatcher->getRequest()->isCli()) {
			$dispatcher->disableView();
		}
	}

	private function _getPlugins(){
		return array(new UserPlugin());	
	}
}
