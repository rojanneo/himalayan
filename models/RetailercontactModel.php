<?php

class RetailercontactModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getContact($contact_id)
	{
		$sql = "SELECT * FROM retailer_contacts WHERE retailer_contact_id = $contact_id";
		$contact = $this->connection->Query($sql);
		if($contact)
		return $contact[0];
		else return false;
	}

	public function updateContact($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$query = "UPDATE `members` SET 
		`mname`='".mysql_real_escape_string($mname)."',
		`memail`='".mysql_real_escape_string($memail)."',
		`madd`='".mysql_real_escape_string($madd)."',
		`madd2`='".mysql_real_escape_string($madd2)."',
		`mcity`='".mysql_real_escape_string($mcity)."',
		`mstate`='".mysql_real_escape_string($mstate)."',
		`mzip`='".mysql_real_escape_string($mzip)."',
		`mtel`='".mysql_real_escape_string($mtel)."',
		`mfax`='".mysql_real_escape_string($mfax)."'
		WHERE `mid` = '$mid'";


		if($this->connection->UpdateQuery($query))
		{
			$query2 = "UPDATE `retailer_contacts` SET `rid`='".mysql_real_escape_string($rid)."', `mid`='".mysql_real_escape_string($mid)."', 
			`retailer_designation` = '".mysql_real_escape_string($mpost)."' WHERE `retailer_contact_id` = ".$retailer_contact_id;
	   		return $this->connection->UpdateQuery($query2);
		}
		else
		{
			return false;
		}
	}

	public function deleteContact($id)
	{
		$sql = "SELECT * FROM `retailer_contacts` WHERE retailer_contact_id = $id";
		$contact = $this->connection->Query($sql)[0];
		$sql = "DELETE FROM `retailer_contacts` WHERE retailer_contact_id = $id";
		$result1 = $this->connection->DeleteQuery($sql);
		//DELETE MEMBERS IF NEEDED.

		return $result1;
	}

	public function registerContact($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$mdate = date('Y-m-d');
		$query = "INSERT INTO members SET mname = '".mysql_real_escape_string($mname)."', memail = '".mysql_real_escape_string($memail)."',
		mpass = '', madd = '".mysql_real_escape_string($madd)."', madd2 = '".mysql_real_escape_string($madd2)."',
	    mcity = '".mysql_real_escape_string($mcity)."', mstate = '".mysql_real_escape_string($mstate)."', mzip = '".mysql_real_escape_string($mzip)."',
	    mtel = '".mysql_real_escape_string($mtel)."', mfax = '".mysql_real_escape_string($mfax)."', mcompany = '',
	    mein = '', mdate = '".mysql_real_escape_string($mdate)."', mtype = '".mysql_real_escape_string($mtype)."',
	    mdes = '', mlist = '0', mconfirm = '0'";

	   if($this->connection->InsertQuery($query))
	   {
	   		$insert_id = $this->connection->GetInsertID();
	   		$query2 = "INSERT INTO `retailer_contacts`(`rid`, `mid`,`retailer_designation`) VALUES ('".mysql_real_escape_string($rid)."','".$insert_id."','".mysql_real_escape_string($mpost)."')";
	   		return $this->connection->InsertQuery($query2);
	   }
	   else 
	   {
	   	return false;
	   }
	}

	public function getContacts($retailer_id)
	{
		if(isset($retailer_id))
		{
			$query = "SELECT * FROM(SELECT members.mid, members.mname, members.memail, members.madd, members.madd2, members.mcity, members.mstate, members.mzip, members.mtel, members.mfax, retailer_contacts.retailer_contact_id,retailer_contacts.rid, retailer_contacts.retailer_designation 
				FROM members JOIN retailer_contacts ON members.mid = retailer_contacts.rid) as contacts WHERE rid = ".$retailer_id;
			$contacts = $this->connection->query($query);
			return $contacts;
		}
		else
		{
			return false;
		}
	}
}