<?php
class FormModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getAllForms()
	{
		$query = "SELECT * FROM forms";
		return $this->connection->Query($query);
	}

	public function getForms($first,$limit)
	{
		$query = "SELECT * FROM forms ORDER BY form_id LIMIT $first,$limit";
		return $this->connection->Query($query);
	}

	public function getForm($id)
	{
		$sql = "SELECT * FROM forms where form_id = $id";
		$form = $this->connection->Query($sql);
		if($form) return $form[0];
		else return false;
	}

	public function getFormCount()
	{
		return count($this->getAllForms());
	}

	public function uploadForm()
	{
			$output_dir = "assets/uploads/forms/";
			$outpurfiledir = 'forms/';
			$ret = array();

			$error =$_FILES["form"]["error"];
			{

		    	if(!is_array($_FILES["form"]['name'])) //single file
		    	{
		    		$fileName = $_FILES["form"]["name"];
		    		move_uploaded_file($_FILES["form"]["tmp_name"],$output_dir. $_FILES["form"]["name"]);
		       	 	 //echo "<br> Error: ".$_FILES["myfile"]["error"];

		    		$ret[$fileName]= $output_dir.$fileName;
		    	}
		    	else
		    	{
		    		$fileCount = count($_FILES["form"]['name']);
		    		for($i=0; $i < $fileCount; $i++)
		    		{
		    			$fileName = $_FILES["form"]["name"][$i];
		    			$ret[$fileName]= $output_dir.$fileName;
		    			move_uploaded_file($_FILES["form"]["tmp_name"][$i],$output_dir.$fileName );
		    		}

		    	}
    		}
    	$form_file = $outpurfiledir.$fileName;
    	return $form_file;
	}

	public function addNewForm($post_data)
	{
		extract($post_data);
		
		if(isset($_FILES["form"]))
		{
		$form_file = $this->uploadForm();
    	extract($post_data);
    	$sql = "INSERT INTO `forms`(`form_name`, `form_description`, `form_file`) VALUES ('$form_name','$form_description','$form_file')";
    	return $this->connection->InsertQuery($sql);

		}
		return false;
	}

	public function updateForm($post_data)
	{
		if(isset($post_data)) extract($post_data);
			if(!empty($_FILES['form']['name']))
			{
				$form_file = $this->uploadForm();
				$sql = "UPDATE `forms` SET `form_name`='$form_name',`form_description`='$form_description',`form_file`='$form_file' WHERE form_id = $form_id";
			}
			else
			{
				$sql = "UPDATE `forms` SET `form_name`='$form_name',`form_description`='$form_description' WHERE form_id = $form_id";
			}
			return $this->connection->UpdateQuery($sql);
	}

	public function deleteForm($id)
	{
		$sql = "DELETE FROM forms WHERE form_id = $id";
		return $this->connection->DeleteQuery($sql);
	}
}