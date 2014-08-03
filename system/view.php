<?php
	class View
	{
		function __construct()
		{
			
		}
		
		public function render($name, $data = false)
		{
			if($data)
			extract($data, EXTR_PREFIX_ALL, "view");
			include 'views/default/head.phtml';
			include 'views/default/header.phtml';
			include 'views/'.$name;
			include 'views/default/footer.phtml';
		}
	}
?>
