<?php
if(!function_exists('showPagination'))
{
	function showPagination($page, $pagination_num, $urlkey)
	{
		$nextPage = $page + 1;
		$prevPage = $page - 1;
		if($prevPage != 0)
			echo '<a href="'.URL.$urlkey.'?p='.$prevPage.'">Previous</a>';
		for($i = 1; $i<=$pagination_num; $i++)
			echo '<a href="'.URL.$urlkey.'?p='.$i.'">'.$i.'</a>';
		if($nextPage <= $pagination_num)
			echo '<a href="'.URL.$urlkey.'?p='.$nextPage.'">Next</a>';

	}
}