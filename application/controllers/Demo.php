<?php

class DemoController extends Yaf_Controller_Abstract {

	public function indexAction(){
		echo "This is Index request ....\n";	
		var_dump($this->getRequest()->getParams());
	}

} 
