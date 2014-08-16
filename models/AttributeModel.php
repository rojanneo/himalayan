<?php

class AttributeModel extends Model
{
	public function __construct()
	{

		parent::__construct();
	}

	public function getAttributeCollection($attribute_set)
	{
		$sql = "SELECT * FROM (SELECT aid, acode, aname, atype, aas_asid FROM attributes join a_as 
			on attributes.aid = aas_aid) as attributes WHERE aas_asid = ".$attribute_set;
		$attributes = $this->connection->Query($sql);
		return $attributes;
	}

	public function getAllAttributes()
	{
		$sql = "SELECT * FROM attributes";
		$attributes = $this->connection->Query($sql);
		return $attributes;
	}

	public function getAttributeById($attribute_id)
	{
		$sql = "SELECT * FROM attributes WHERE aid = ".$attribute_id;
		return $this->connection->Query($sql);
	}

	public function getAttributeOptions($attribute_id)
	{
		//die('here');
		$sql = "SELECT * FROM attribute_values WHERE values_aid = ".$attribute_id;
		//echo $sql;die;
		$options = $this->connection->Query($sql);
		return $options;
	}

	public function addNewAttribute($post_data)
	{
		if($post_data) extract($post_data);
		$sql = "INSERT INTO attributes(acode, aname, atype) VALUES ('".$acode."','".$aname."','".$atype."')";
		$result1 = $this->connection->InsertQuery($sql);
		$insert_id = $this->connection->GetInsertID();
		$result2 = true;
		if(isset($option_value))
		{
			foreach($option_value as $value)
			{
				$sql2 = "INSERT INTO attribute_values(values_aid, value) VALUES ('".$insert_id."','".$value."')";
				$result = $this->connection->InsertQuery($sql2);
				$result2 = $result;
			}
		}

		return $result2 and $result2;
	}

	public function updateAttribute($post_data)
	{
		if($post_data) extract($post_data);
		$sql = "UPDATE attributes SET acode = '".$acode."', aname = '".$aname."', atype = '".$atype."' WHERE aid = '".$attribute_id."'";
		$result1 = $this->connection->UpdateQuery($sql);
		if(isset($option_value))
		{
			$sql = "DELETE FROM attribute_values WHERE values_aid = ".$attribute_id;
			$this->connection->DeleteQuery($sql);
			foreach($option_value as $value)
			{
				$sql2 = "INSERT INTO attribute_values(values_aid, value) VALUES ('".$attribute_id."','".$value."')";
				$result = $this->connection->InsertQuery($sql2);
				$result2 = $result;
			}
		}

		return $result2 and $result2;
	}
}