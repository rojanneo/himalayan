<?php
if(!function_exists('getPost'))
{
	function getPost($key = null)
	{
		if($key)
			$post = $_POST[$key];
		else
			$post = $_POST;
		return $post;
	}
}