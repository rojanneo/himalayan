<?php
	//require_once 'config/config.php';
	require_once 'system/controller.php';
	require_once 'system/model.php';
	require_once 'helpers/Autoload.php';
	foreach (glob("config/*.php") as $configs)
	{
		include $configs;
	}
	
	
	foreach (glob("controllers/*.php") as $controllers)
	{
		include $controllers;
	}
	

	session_start();
	$url = isset($_GET['url']) ? $_GET['url'] : "home/home";
	$url = rtrim($url, '/');
	$url = explode('/', $url);
	
	if(isset($url[2]))
	{
		$control = $url[0].'Controller';
		if(!class_exists($control))
		{
		include('views/default/404.phtml');
		}
		else
		{
			$controller = new $control();
			$function = $url[1].'Action';
			if(!method_exists($controller, $function))
			{
				include('views/default/404.phtml');
			}
			else
			{
				$controller->$function($url[2]);
			}
		}
		
	}
	else
	{
		if(isset($url[1]))
		{
			$control = $url[0].'Controller';
			if(!class_exists($control))
			{
			include('views/default/404.phtml');
			}
			else
			{
				$controller = new $control();
				$function = $url[1].'Action';
				if(!method_exists($controller, $function))
				{
					include('views/default/404.phtml');
				}
				else
				{
					$controller->$function();
				}
			}
			
		}
		else 
		{
		
			if(isset($url[0]))
			{
				$control = $url[0].'Controller';
				if(!class_exists($control))
				{
					include('views/default/404.phtml');
				}
				else
				{
					$controller = new $control();
					$default_act = 'indexAction';
					if(!method_exists($controller, $default_act))
					{
						include('views/default/404.phtml');
					}
					else
					{
						$controller->$default_act();
					}
				}
				
			}
			else
			{
				$default_cont = DEFAULT_CONTORLLER.'Controller';
				$controller = new default_cont();
				$default_act = DEFAULT_ACTION.'Action';
				$controller->$default_act();
			}
		}
		
	}

?>
