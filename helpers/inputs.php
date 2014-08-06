<?php
if(!function_exists('getPost'))
{
	function getPost($key = null)
	{
		if($key)
			if(isset($_POST[$key]))
			$post = $_POST[$key];
			else
			$post = false;
		else
			$post = $_POST;
		return $post;
	}
}

if(!function_exists('getParam'))
{
	function getParam($key = null)
	{
		if($key)
			if(isset($_GET[$key]))
			$get = $_GET[$key];
			else
			$get = false;
		else
			$get = $_GET;
		return $get;
	}
}