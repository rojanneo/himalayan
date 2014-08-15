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

	public function getAttributeOptions($attribute_id)
	{
		//die('here');
		$sql = "SELECT * FROM attribute_values WHERE values_aid = ".$attribute_id;
		//echo $sql;die;
		$options = $this->connection->Query($sql);
		return $options;
	}
}