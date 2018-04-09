<?php

namespace Customers\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{
	public function initialize(){
		parent::initialize();
		define('DATE_DISPLAY_FORMAT', 'd/m/Y');
	}
}
