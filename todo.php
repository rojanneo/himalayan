<h1> Choose a Folder</h1>
<ul>
	<li><a href="todo.php?request=views">Views</a></li>
	<li><a href="todo.php?request=controllers">Controllers</a></li>
	<li><a href="todo.php?request=models">Models</a></li>
	<li><a href="todo.php?request=system">System</a></li>
	<li><a href="todo.php?request=helpers">Helper</a></li>
</ul>
<?php
$search = '<!-- TODO';
if(isset($_GET['request']))
{
	if($_GET['request'] == 'views')
	{	
		echo '<h1>Views</h1>';
		$path = realpath('views');
		$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
		foreach($objects as $name => $object){
			$filename = explode('\\',$name);
			if($filename[count($filename)-1] != '.' and $filename[count($filename)-1] != '..')
			{
				$line_number = false;
				if(!is_dir($name))
				{
					if ($handle = fopen("$name", "r")) {
					   $count = 0;
					   while (($line = fgets($handle, 4096)) !== FALSE and !$line_number) {
					      $count++;
					      $line_number = (strpos($line, $search) !== FALSE) ? $count : $line_number;
					   }
					   fclose($handle);
					}
					if($line_number)
					{
						echo "$name<h4>First Occurrence in Line: $line_number</h4>";	
					    echo '<br>';
					}
				}
			}

		}
	}

	else if($_GET['request'] == 'controllers')
	{	
		echo '<h1>Controllers</h1>';
		$path = realpath('controllers');
		$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
		foreach($objects as $name => $object){
			$filename = explode('\\',$name);
			if($filename[count($filename)-1] != '.' and $filename[count($filename)-1] != '..')
			{
				$line_number = false;
				if(!is_dir($name))
				{
					if ($handle = fopen("$name", "r")) {
					   $count = 0;
					   while (($line = fgets($handle, 4096)) !== FALSE and !$line_number) {
					      $count++;
					      $line_number = (strpos($line, $search) !== FALSE) ? $count : $line_number;
					   }
					   fclose($handle);
					}
					if($line_number)
					{
						echo "$name<h4>First Occurrence in Line: $line_number</h4>";	
					    echo '<br>';
					}
				}
			}

		}
	}

	else if($_GET['request'] == 'models')
	{	

		echo '<h1>Models</h1>';
		$path = realpath('models');
		$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
		foreach($objects as $name => $object){
			$filename = explode('\\',$name);
			if($filename[count($filename)-1] != '.' and $filename[count($filename)-1] != '..')
			{
				$line_number = false;
				if(!is_dir($name))
				{
					if ($handle = fopen("$name", "r")) {
					   $count = 0;
					   while (($line = fgets($handle, 4096)) !== FALSE and !$line_number) {
					      $count++;
					      $line_number = (strpos($line, $search) !== FALSE) ? $count : $line_number;
					   }
					   fclose($handle);
					}
					if($line_number)
					{
						echo "$name<h4>First Occurrence in Line: $line_number</h4>";	
					    echo '<br>';
					}
				}
			}

		}
	}


	else if($_GET['request'] == 'system')
	{	

		echo '<h1>System</h1>';
		$path = realpath('system');
		$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
		foreach($objects as $name => $object){
			$filename = explode('\\',$name);
			if($filename[count($filename)-1] != '.' and $filename[count($filename)-1] != '..')
			{
				$line_number = false;
				if(!is_dir($name))
				{
					if ($handle = fopen("$name", "r")) {
					   $count = 0;
					   while (($line = fgets($handle, 4096)) !== FALSE and !$line_number) {
					      $count++;
					      $line_number = (strpos($line, $search) !== FALSE) ? $count : $line_number;
					   }
					   fclose($handle);
					}
					if($line_number)
					{
						echo "$name<h4>First Occurrence in Line: $line_number</h4>";	
					    echo '<br>';
					}
				}
			}

		}
	}


	else if($_GET['request'] == 'helpers')
	{	
		echo '<h1>Helpers</h1>';
		$path = realpath('helpers');
		$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
		foreach($objects as $name => $object){
			$filename = explode('\\',$name);
			if($filename[count($filename)-1] != '.' and $filename[count($filename)-1] != '..')
			{
				$line_number = false;
				if(!is_dir($name))
				{
					if ($handle = fopen("$name", "r")) {
					   $count = 0;
					   while (($line = fgets($handle, 4096)) !== FALSE and !$line_number) {
					      $count++;
					      $line_number = (strpos($line, $search) !== FALSE) ? $count : $line_number;
					   }
					   fclose($handle);
					}
					if($line_number)
					{
						echo "$name<h4>First Occurrence in Line: $line_number</h4>";	
					    echo '<br>';
					}
				}
			}

		}
	}
}