<?php

if(!function_exists('loadHelper'))
{
	function loadHelper($filename)
	{
		include 'helpers/'.$filename.'.php';
	}
}
?>