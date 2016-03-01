<?php

class IndexController extends Yaf_Controller_Abstract {

	public function indexAction() {
		$this->getView()->assign("content", "我是中文页面的测试");
	}

}

