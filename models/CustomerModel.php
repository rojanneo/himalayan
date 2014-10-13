<?php
class CustomerModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getCustomerRole($customerId)
	{
		// $query = "SELECT * FROM members WHERE mid='$customerId'";
		// $customer = $this->connection->Query($query);
		$customer = $this->getCustomer($customerId);
		return $customer['mtype'];
	}

	public function getCustomer($customerId)
	{
		$query = "SELECT * FROM members WHERE mid = '$customerId'";
		$customer = $this->connection->Query($query);
		if($customer)
		return $customer[0];
		else return false;
	}

	public function editInformation($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$mdate = date('Y-m-d');
		$pass = md5($mpass);
		$query = "UPDATE `members` SET 
		`mname`='".mysql_real_escape_string($mname)."',
		`memail`='".mysql_real_escape_string($memail)."',
		`madd`='".mysql_real_escape_string($madd)."',
		`madd2`='".mysql_real_escape_string($madd2)."',
		`mcity`='".mysql_real_escape_string($mcity)."',
		`mstate`='".mysql_real_escape_string($mstate)."',
		`mzip`='".mysql_real_escape_string($mzip)."',
		`mtel`='".mysql_real_escape_string($mtel)."',
		`mfax`='".mysql_real_escape_string($mfax)."',
		`mein`='".mysql_real_escape_string($mein)."',
		`mcompany`='".mysql_real_escape_string($mcompany)."'
		WHERE `mid` = '$mid'";

		$query1 = "UPDATE `retailers` SET `rcompany`='$mcompany',`rwebsite`='$mwebsite' WHERE `rid`='3951'";


		return $this->connection->UpdateQuery($query) and $this->connection->UpdateQuery($query1);
	}

	public function checkPassword($customerId, $pass)
	{
		$customer = $this->getCustomer($customerId);
		if($customer['mpass'] == md5($pass))
		{
			return true;
		}
		else
			return false;
	}

	public function changePassword($customerId, $pass)
	{
		$pass=md5($pass);
		$query = "UPDATE `members` SET `mpass`='".$pass."' WHERE `mid`='$customerId'";
		return $this->connection->UpdateQuery($query);
	}

	public function getRetailers($first, $limit)
	{
		$sql = "SELECT * FROM members, retailers WHERE members.mid = retailers.rid ORDER BY retailers.rid DESC LIMIT $first,$limit";
		//$sql = "SELECT * FROM retailers WHERE rid = 103";
		return $this->connection->Query($sql);
	}

	public function getRetailersByStatus($status, $first, $limit)
	{
		$sql = null;
		switch($status)
		{
			case 'web':
				$sql = "SELECT * FROM members, retailers WHERE members.mid = retailers.rid AND retailers.regtype = 'web' LIMIT $first, $limit";
				break;
			case 'manual':
				$sql = "SELECT * FROM members, retailers WHERE members.mid = retailers.rid AND regtype = 'manual' LIMIT $first, $limit";
				break;
			case 'sellers':
				$sql = "SELECT * FROM members, retailers WHERE members.mid = retailers.rid AND members.mid IN (SELECT omid FROM orders) LIMIT $first, $limit";
				break;
			case 'authorized':
				$sql = "SELECT * FROM members, retailers WHERE members.mid = retailers.rid AND retailers.rauth LIKE '%pur%' LIMIT $first, $limit";
				break;
			case 'notauthorized':
				$sql = "SELECT * FROM members, retailers WHERE members.mid = retailers.rid AND retailers.rauth NOT LIKE '%pur%' LIMIT $first, $limit";
				break;
			case 'uncofirmed':
				$sql = "SELECT * FROM members, retailers WHERE members.mid = retailers.rid AND members.mconfirm = '0' LIMIT $first, $limit";
				break;
		}

		return $this->connection->Query($sql);
	}

	public function getRetailersByFilter($status, $state, $city,$first,$limit)
	{
		$query = null;
		switch($status)
		{
			case 'web':
				$query = "AND retailers.regtype = 'web'";
				break;
			case 'manual':
				$query = "AND retailers.regtype = 'manual'";
				break;
			case 'sellers':
				$query = "AND members.mid IN (SELECT omid FROM orders)";
				break;
			case 'authorized':
				$query = "AND retailers.rauth LIKE '%pur%'";
				break;
			case 'not-authorized':
				$query = "retailers.rauth NOT LIKE '%pur%'";
				break;
			case 'uncofirmed':
				$query = "AND members.mconfirm = '0'";
				break;
		}
		$sql = "SELECT * FROM members,retailers WHERE members.mid = retailers.rid ";
		if($status != 'all')
		{
			$sql .= $query;
		}
		if($state != 'all')
		{
			$sql .= " AND members.mstate = '$state'";
		}
		if($city != 'all')
		{
			$sql .= " AND members.mcity = '$city'";
		}

		$sql .= " ORDER BY retailers.rcompany LIMIT $first, $limit";

		return $this->connection->Query($sql);
	}

	public function getAllCities()
	{
		$sql = "SELECT DISTINCT mcity FROM members WHERE mtype = 'retailer' ORDER BY mcity ASC";
		return $this->connection->Query($sql);
	}

	public function getCitiesByState($state)
	{
		$sql = "SELECT DISTINCT mcity FROM members WHERE mstate = '$state' AND mtype = 'retailer'  ORDER BY mcity ASC";
		return $this->connection->Query($sql);
	}

	public function getAllStates()
	{
		$sql = "SELECT * FROM state ORDER BY abb";
		return $this->connection->Query($sql);
	}

	public function getRetailersByState($state)
	{
		$sql = "SELECT * FROM members, retailers WHERE members.mid = retailers.rid AND members.mstate = '$state'";
		return $this->connection->Query($sql);
	}

	public function getAllRetailers()
	{
		$sql = "SELECT * FROM members, retailers WHERE members.mid = retailers.rid ORDER BY retailers.rid ASC";
		return $this->connection->Query($sql);		
	}

	public function getRetailerCount()
	{
		return count($this->getAllRetailers());
	}

	public function confirm_reject($id)
	{
		$sql = "SELECT * FROM members WHERE mid = $id";
		$member = $this->connection->Query($sql);
		if($member)
		{
		if($member[0]['mconfirm'] ==  0) $sql = "UPDATE `members` SET `mconfirm` = '1' WHERE `mid` = $id";
		else $sql = "UPDATE members SET mconfirm = '0' WHERE mid = $id";			
		return $this->connection->UpdateQuery($sql);
		}
		return false;
	}

	public function disallowPurchase($id)
	{
		$sql = "SELECT * FROM retailers WHERE rid = $id";
		$retailer = $this->connection->Query($sql);
		if($retailer)
		{
				$sql1 = "UPDATE retailers SET rauth = '' WHERE rid = $id";
				$rshdc = 0;
				$sql2 = "UPDATE retstores SET rshdc = '$rshdc' WHERE rid = $id";
				$result1 = $this->connection->UpdateQuery($sql1);
				$result2 = $this->connection->UpdateQuery($sql2);

			return $result1 and $result2;
		}
		return false;
	}

	public function allowPurchase($id)
	{
		$sql = "SELECT * FROM retailers,members WHERE members.mid=retailers.rid AND rid = $id";
		$retailer = $this->connection->Query($sql);
		$retailer = $retailer[0];
		if($retailer)
		{
				$sql1 = "UPDATE retailers SET rauth = 'pur' WHERE rid = $id";
				$rshdc = 1;
				$sql2 = "UPDATE retstores SET rshdc = '$rshdc' WHERE rid = $id";
				$result1 = $this->connection->UpdateQuery($sql1);
				$result2 = $this->connection->UpdateQuery($sql2);

				$sql = "SELECT * FROM retstores WHERE rid = $id";
				$retstores = $this->connection->Query($sql);
				if(count($retstores)<=0)
				{
					$sql = "INSERT INTO `retstores`(`rid`, `rshdc`, `rsnm`, `rsadd`, `rsadd2`, `rscity`, `rsstate`, `rszip`, `rstel`, `rsfax`, `rswebsite`, `rsemail`,`rsdes`) 
					VALUES (".$id.",'1','".$retailer['rcompany']."','".$retailer['madd']."','".$retailer['madd2']."','".$retailer['mcity']."','".$retailer['mstate']."',".$retailer['mzip'].",".$retailer['mtel'].",".$retailer['mfax'].",'".$retailer['rwebsite']."','".$retailer['memail']."','')";
					$result3 = $this->connection->InsertQuery($sql);
				}

			return $result1 and $result2 and $result3;
		}
		return false;
	}

	public function online($id)
	{
		$sql = "SELECT * FROM retailers WHERE rid = $id";
		$retailer = $this->connection->Query($sql);
		if($retailer)
		{
			if($retailer[0]['retailerSellOnline'] == 1)
			{
				$sql = "UPDATE retailers SET retailerSellOnline = NULL WHERE rid = $id";
			}
			else
			{
				$sql = "UPDATE retailers SET retailerSellOnline = 1 WHERE rid = $id";				
			}
			return $this->connection->UpdateQuery($sql);
		}
		return false;
	}

	public function addNewRetailer($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$mdate = date('Y-m-d');
		$mtype = "retailer";
		if(!isset($mcompany)) $mcompany='';
		if(!isset($mein)) $mein = '';
		if(!isset($rauth)) $rauth = '';
		$mpass = 'dog123';
		$query = "INSERT INTO members SET mname = '".mysql_real_escape_string($mname)."', memail = '".mysql_real_escape_string($memail)."',
		mpass = '".mysql_real_escape_string(md5($mpass))."', madd = '".mysql_real_escape_string($madd)."', madd2 = '".mysql_real_escape_string($madd2)."',
	    mcity = '".mysql_real_escape_string($mcity)."', mstate = '".mysql_real_escape_string($mstate)."', mzip = '".mysql_real_escape_string($mzip)."',
	    mtel = '".mysql_real_escape_string($mtel)."', mfax = '".mysql_real_escape_string($mfax)."', mcompany = '".mysql_real_escape_string($mcompany)."',
	    mein = '".mysql_real_escape_string($mein)."', mdate = '".mysql_real_escape_string($mdate)."', mtype = '".mysql_real_escape_string($mtype)."',
	    mdes = '', mlist = '1', mconfirm = '1'";

	   if($this->connection->InsertQuery($query))
	   {
	   		
	   			$insert_id = $this->connection->GetInsertID();
	   			$query = "INSERT INTO `retailers`(`rid`, `rcompany`, `rein`, `rwebsite`, `retailerSellOnline`, 
	   				`regtype`, `rqual`, `rterm`, `rship`, `rshipqual`, `rauth`, `rinformed`) 
	   			VALUES (".$insert_id.",'".mysql_real_escape_string($mcompany)."','".mysql_real_escape_string($mein)."','".mysql_real_escape_string($mwebsite)."',
	   				'','manual','','','0','0','".mysql_real_escape_string($rauth)."','0')";
				$query2 = "INSERT INTO `member_mtype`(`member_mtype`, `member_id`, `membertype_id`) VALUES ('',".$insert_id.",3)";
				return $this->connection->InsertQuery($query) && $this->connection->InsertQuery($query2);
	   		
	   }
	   else 
	   {
	   	return false;
	   }
	}

	public function getRetailer($id)
	{
		$sql = "SELECT * FROM retailers, members WHERE members.mid = retailers.rid AND retailers.rid = $id";
		$retailer = $this->connection->Query($sql);
		if($retailer)
			return $retailer[0];
		else return false;
	}

	public function updateRetailer($post_data)
	{
		if(isset($post_data)) extract($post_data);
		if(!isset($mcompany)) $mcompany='';
		if(!isset($mein)) $mein = '';
		if(!isset($rauth)) $rauth = '';
		$query = "UPDATE members SET mname = '".mysql_real_escape_string($mname)."', memail = '".mysql_real_escape_string($memail)."',
		madd = '".mysql_real_escape_string($madd)."', madd2 = '".mysql_real_escape_string($madd2)."',
	    mcity = '".mysql_real_escape_string($mcity)."', mstate = '".mysql_real_escape_string($mstate)."', mzip = '".mysql_real_escape_string($mzip)."',
	    mtel = '".mysql_real_escape_string($mtel)."', mfax = '".mysql_real_escape_string($mfax)."', mcompany = '".mysql_real_escape_string($mcompany)."',
	    mein = '".mysql_real_escape_string($mein)."', mdes = '', mlist = '1', mconfirm = '1' WHERE mid = ".$rid;

	   if($this->connection->InsertQuery($query))
	   {
	   		
	   			$insert_id = $this->connection->GetInsertID();
	   			$query = "UPDATE `retailers` SET `rcompany`='$mcompany',`rein`=$mein,`rwebsite`='$mwebsite', `rauth`='$rauth' WHERE `rid` = $rid";
	   			// $query = "INSERT INTO `retailers`(`rid`, `rcompany`, `rein`, `rwebsite`, `retailerSellOnline`, 
	   			// 	`regtype`, `rqual`, `rterm`, `rship`, `rshipqual`, `rauth`, `rinformed`) 
	   			// VALUES (".$insert_id.",'".mysql_real_escape_string($mcompany)."','".mysql_real_escape_string($mein)."','".mysql_real_escape_string($mwebsite)."',
	   			// 	'','manual','','','0','0','".mysql_real_escape_string($rauth)."','0')";
				return $this->connection->InsertQuery($query);
	   		
	   }
	   else 
	   {
	   	return false;
	   }
	}
}