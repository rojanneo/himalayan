<?php
// for search distance
if(!function_exists('distance'))
{
	function distance($lat1, $lon1, $lat2, $lon2, $unit) 
	{
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		if(is_nan($miles)) $miles = 0;
		$unit = strtoupper($unit);
		if ($unit == "K")		{   return ($miles * 1.609344); } 
		else if ($unit == "N")  {	return ($miles * 0.8684);	} 
		else 					{ 	return $miles;				}

	}
}

if(!function_exists('zipForm'))
{
//zip code format. a spcae in the middle for canadian
	function zipForm($zip, $state)
	{
		$sql = mysql_query("SELECT * FROM state WHERE abb = '$state'");
		$state = mysql_fetch_array($sql);
		$country = $state['country'];
	
		if($country == 'can')
		{
			$zip = strtoupper(str_replace(" ", "", $zip));
			$zip = substr($zip, 0, 3) . " " . substr($zip, 3);
		}
	
	//echo "*** $zip ***";
	
	return $zip;
	}
}


if(!function_exists('ptelForm'))
{
	function ptelForm($tel)
	{
		$a = substr($tel, 0,3);
		if(strlen($tel) > 6)
		{
			$b = substr($tel, 3,3);
			$c = substr($tel, 6);
			return "($a) $b-$c";	
		}



		else 
		{
			$b = substr($tel, 3);
			return "$a-$b";

		}

	}
}