<?php

class AttributesetModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getAllAttributeSets()
	{
		$query = "SELECT * FROM attributeset";
		$sets = $this->connection->Query($query);
		return $sets;
	}

	public function getAttributeSetById($attribute_set)
	{
		$sql = "SELECT * FROM attributeset where asid = ".$attribute_set;
		return $this->connection->Query($sql);
	}

	public function addNewAttributeset($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$sql = "INSERT INTO attributeset(ascode, asname) VALUES('".$ascode."','".$asname."')";
		$result1 = $this->connection->InsertQuery($sql);
		$insert_id = $this->connection->GetInsertID();
		$result2 = true;
		if(isset($attributes))
		{
			foreach($attributes as $aid)
			{
				$sql = "INSERT INTO a_as(aas_aid, aas_asid) VALUES('".$aid."','".$insert_id."')";
				$result2 = $this->connection->InsertQuery($sql);
			}
		}

		return $result1 and $result2;
	}

	public function updateAttributeSet($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$sql = "UPDATE attributeset SET ascode = '".$ascode."', asname = '".$asname."' WHERE asid = '".$attribute_set_id."'";
		$result1 = $this->connection->UpdateQuery($sql);
		$result2 = true;
		if(isset($attributes))
		{
			$sql = "DELETE FROM a_as WHERE aas_asid = ".$attribute_set_id;
			$result3 = $this->connection->DeleteQuery($sql);
			if($result3)
			{
				foreach($attributes as $attribute)
				{
					
					
						$sql = "INSERT INTO a_as(aas_aid, aas_asid) VALUES('".$attribute."','".$attribute_set_id."')";
						$result2 = $this->connection->InsertQuery($sql);
				}
			}
			else
			{
				return $result3;
			}

		}
		return $result1 and $result2;
	}
}