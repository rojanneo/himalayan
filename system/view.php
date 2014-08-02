<?php
	class View
	{
		function __construct()
		{
			
		}
		
		public function render($name, $data = false)
		{
			extract($data, EXTR_PREFIX_ALL, "view");
			include 'views/header.phtml';
			include 'views/'.$name;
			include 'views/footer.phtml';
		}
	}
?>
