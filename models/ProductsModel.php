<?php
class ProductsModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getAvailableProductTypes()
	{
		$query = "SELECT * FROM ptype";
		$types = $this->connection->Query($query);
		return $types;
	}

	public function getAllProducts()
	{
		$query = "SELECT * FROM products_simple";
		return $this->connection->Query($query);
	}

	public function getTypeNameFromId($product_type_id)
	{
		$query = "SELECT * FROM ptype where ptid = $product_type_id";
		$type = $this->connection->Query($query);
		return $type[0]['type_name'];
	}

	public function getProduct($product_id)
	{
		$sql = "SELECT * FROM products_simple WHERE pid = $product_id";
		$product = $this->connection->Query($sql);
		return $product[0];
	}

	public function getProductAttributeById($product_id, $attribute_id)
	{
		$attribute = getModel('attribute')->getAttributeById($attribute_id);
		$sql = null;
		if($attribute[0]['atype'] == 'select')
		{
				$sql = "SELECT * FROM product_attribute_values_select where pavs_pid = $product_id AND pavs_aid = $attribute_id";
				$av = $this->connection->Query($sql);
				return $av[0]['pavs_vid'];
		}
		else
		{
			$atype = $attribute[0]['atype'];
			$sql = "SELECT * FROM product_attribute_values_".$atype." where pav".$atype[0]."_pid = $product_id AND pav".$atype[0]."_aid = $attribute_id";
			$av = $this->connection->Query($sql);
			return $av[0]['value'];
		}
	}

	public function addNewProduct($post_data)
	{
		if($post_data) extract($post_data);
		$sql = "INSERT INTO `products_simple`(`pname`, `psku`, `ptype`, `product_asid`, `quantity`, `in_stock`,`status`) VALUES 
		('$name','$sku','$product_type','$attribute_set','$quantity','$in_stock','$status')";
		$result1 = $this->connection->InsertQuery($sql);

		$pid = $this->connection->GetInsertID();

		$attributeTable = 'product_attribute_values_';

		$aModel = getModel('attribute');
		foreach($attributes as $acode => $attrib)
		{
			$attribute = $aModel->getAttributeByCode($acode);
			$atype = $attribute['atype'];
			$table =$attributeTable.$atype;
			$a = $atype[0];
			if($atype == 'select')
			{
					$sql = "INSERT INTO ".$table."(pavs_pid, pavs_aid, pavs_vid) VALUES(".$pid.",".$attribute['aid'].",".$attrib.")";
			}
			else
			{
				$sql = "INSERT INTO ".$table."(pav".$a."_pid,pav".$a."_aid,value) VALUES(".$pid.",".$attribute['aid'].",'".$attrib."')";				
			}
			$result2 = $this->connection->InsertQuery($sql);
		}
		return $result1 and $result2;
	}

	public function updateProduct($post_data)
	{
		if(isset($post_data)) extract($post_data);
		$sql = "UPDATE products_simple SET pname = '".$name."', psku = '".$sku."', ptype='".$product_type."', product_asid = '".$attribute_set."',
		 quantity = '".$quantity."', in_stock = '".$in_stock."', status = '".$status."' WHERE pid = '".$product_id."'";
		$result = $this->connection->UpdateQuery($sql);
		if(isset($attributes))
		{
			$sql = "DELETE FROM product_attribute_values_int WHERE pavi_pid = $product_id"; 
			$result = $this->connection->DeleteQuery($sql);
			$sql = "DELETE FROM product_attribute_values_text WHERE pavt_pid = $product_id"; 
			$result = $this->connection->DeleteQuery($sql);
			$sql = "DELETE FROM product_attribute_values_varchar WHERE pavv_pid = $product_id"; 
			$result = $this->connection->DeleteQuery($sql);
			$sql = "DELETE FROM product_attribute_values_select WHERE pavs_pid = $product_id"; 
			$result = $this->connection->DeleteQuery($sql);


			$attributeTable = 'product_attribute_values_';

			$aModel = getModel('attribute');
			foreach($attributes as $acode => $attrib)
			{
				$attribute = $aModel->getAttributeByCode($acode);
				$atype = $attribute['atype'];
				$table =$attributeTable.$atype;
				$a = $atype[0];
				if($atype == 'select')
				{
						$sql = "INSERT INTO ".$table."(pavs_pid, pavs_aid, pavs_vid) VALUES(".$product_id.",".$attribute['aid'].",".$attrib.")";
				}
				else
				{
					$sql = "INSERT INTO ".$table."(pav".$a."_pid,pav".$a."_aid,value) VALUES(".$product_id.",".$attribute['aid'].",'".$attrib."')";				
				}
				$result2 = $this->connection->InsertQuery($sql);
			}

		 
		}

	return $result and $result2;

	}
}