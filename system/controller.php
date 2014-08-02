<?php
	require_once 'system/view.php';
	class Controller
	{
		protected $view;
		protected $model;
		function __construct()
		{
			$this->view = new View();
		}
	}
