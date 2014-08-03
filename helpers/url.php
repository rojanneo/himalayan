<?php

if(!function_exists('redirect'))
{
	function redirect($urlpath = '')
	{
		header("Location: ".URL.$urlpath);
	}
}