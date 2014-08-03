<?php

if(!function_exists('loadHelper'))
{
	function loadHelper($filename)
	{
		include 'helpers/'.$filename.'.php';
	}
}
if(!function_exists('getModel'))
{
	function getModel($filename)
	{
		require_once('models/'.$filename.'Model.php');
		$modelName = $filename.'Model';
		$model = new $modelName();
		return $model;
	}
}
?>