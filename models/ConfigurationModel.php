<?php

class ConfigurationModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getConfigGroups()
	{
		$sql = "SELECT * FROM config_group";
		return $this->connection->Query($sql);
	}

	public function addConfigGroup($post_data)
	{
		if($post_data) extract($post_data);
		$sql = "INSERT INTO config_group(config_group_identifier, config_group_name) VALUES('$config_group_identifier', '$config_group_name')";
		return $this->connection->InsertQuery($sql);
	}

	public function updateConfigGroup($post_data)
	{
		if($post_data) extract($post_data);
		$sql = "UPDATE `config_group` SET `config_group_identifier`='$config_group_identifier',`config_group_name`='$config_group_name' WHERE `config_group_id`=$config_group_id";
		return $this->connection->UpdateQuery($sql);
	}

	public function deleteConfigGroup($id)
	{
		$sql = "DELETE FROM config_group WHERE config_group_id = $id";
		return $this->connection->DeleteQuery($sql);
	}

	public function getConfigGroupById($group_id)
	{
		$sql = "SELECT * FROM config_group WHERE config_group_id = $group_id";
		return $this->connection->Query($sql)[0];
	}

	public function getConfigFieldById($field_id)
	{
		$sql = "SELECT * FROM configurations WHERE config_id = $field_id";
		return $this->connection->Query($sql)[0];
	}


	public function getFieldsByGroup($group_id)
	{
		$sql = "SELECT * FROM configurations WHERE config_group = $group_id";
		return $this->connection->Query($sql);
	}

	public function getFieldsOrderedByGroup()
	{
		$groups = $this->getConfigGroups();
		$groupArray = array();
		foreach($groups as $group)
		{
		$fieldArray = array();
			$fields = $this->getFieldsByGroup($group['config_group_id']);
			foreach($fields as $field)
			{
				array_push($fieldArray, $field['config_identifier']);
			}
			$groupArray[$group['config_group_identifier']] = $fieldArray;
			unset($fieldArray);
		}
		return $groupArray;
	}

	public function getGroupNameByIdentifier($identifier)
	{
		$sql = "SELECT * FROM config_group WHERE config_group_identifier = '$identifier'";
		$group = $this->connection->Query($sql)[0];
		return $group['config_group_name'];
	}

	public function getGroupNameById($id)
	{
		$sql = "SELECT * FROM config_group WHERE config_group_id = '$id'";
		$group = $this->connection->Query($sql)[0];
		return $group['config_group_name'];
	}

	public function getConfigValue($identifier)
	{
		$sql = "SELECT * FROM configurations WHERE config_identifier = '$identifier'";
		$config = $this->connection->Query($sql);
		if(($config)) return $config[0]['config_value'];
		else return false;
	}

	public function getConfigName($identifier)
	{
		$sql = "SELECT * FROM configurations WHERE config_identifier = '$identifier'";
		$config = $this->connection->Query($sql)[0];
		return $config['config_name'];				
	}

	public function saveConfigData($post_data)
	{
		if(isset($post_data))
		{
			$result = true;
			foreach($post_data as $config_identifier => $config_value)
			{
				$sql = "UPDATE configurations SET config_value = '$config_value' WHERE config_identifier = '$config_identifier'";
				if(!$this->connection->UpdateQuery($sql))
				{
					$result = false;
				}
			}
			return $result;
		}
	}

	// public function getConfigFields()
	// {
	// 	$sql = "SELECT * FROM configurations";
	// 	return $this->connection->Query($sql);
	// }

	public function addConfigField($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$sql = "INSERT INTO `configurations`(`config_identifier`, `config_name`, `config_value`, `config_group`) VALUES ('$config_identifier','$config_name','',$config_group)";
		return $this->connection->InsertQuery($sql);
	}

	public function updateConfigField($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$sql = "UPDATE `configurations` SET `config_identifier`='$config_identifier',`config_name`='$config_name',`config_group`=$config_group WHERE `config_id` = $config_id";
		return $this->connection->UpdateQuery($sql);

	}

	public function deleteField($id)
	{
		$sql = "DELETE FROM configurations WHERE config_id = $id";
		return $this->connection->DeleteQuery($sql);
	}

	public function getConfigFields($first, $limit)
	{
		$sql = "SELECT * FROM configurations ORDER BY config_id LIMIT $first, $limit";
		return $this->connection->Query($sql);
	}

	public function getConfigFieldsCount()
	{
		$sql = "SELECT * FROM configurations";
		return count($this->connection->Query($sql));
	}

}