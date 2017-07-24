<?php

namespace app\controllers;

use jupiter\Controller;
use app\models\UserTable;

class IndexController extends Controller
{
	
	function indexAction(){

		$userTable = new UserTable();

		$user = $userTable->findOne("login = ?", array("jean"));

		$this->render("Index:index", $user);
	}
}