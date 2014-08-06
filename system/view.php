<?php
	class View
	{
		function __construct()
		{
			
		}
		
		public function render($name, $data = false, $showHeader = true, $showFooter = true)
		{
			if($data)
			extract($data, EXTR_PREFIX_ALL, "view");
			if($showHeader)
			{
				include 'views/default/head.phtml';
				include 'views/default/header.phtml';
			}
			include 'views/'.$name;
			if($showFooter)
			include 'views/default/footer.phtml';
		}
	}
?>
