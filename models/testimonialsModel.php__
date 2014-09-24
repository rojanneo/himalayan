<?php
class TestimonialsModel extends Model
{
	public function __construt()
	{
		parent::__cosntruct();
	}

	public function saveTestimonial($post_data)
	{
		extract($post_data);
		$query = "Insert into testimonials(t_dt,t_name,t_email,t_add,t_comment) values('".$t_dt."','".$t_name."','".$t_email."',
			'".$t_add."','".$t_comment."')";
		$this->connection->InsertQuery($query);
	}

	public function getTestimonials($first, $limit)
	{
		$query = 'SELECT * FROM testimonials ORDER BY t_id DESC Limit '.$first.','.$limit;
		$testimonials = $this->connection->Query($query);
		return $testimonials;

	}

	public function getTestimonialsCount()
	{
		$query = 'SELECT COUNT(*) FROM testimonials;';
		$count = $this->connection->Query($query);
		return $count[0]['COUNT(*)'];
	}

	public function deleteTestimonial($id)
	{
		$sql = "DELETE FROM testimonials WHERE t_id = $id";
		return $this->connection->DeleteQuery($sql);
	}

	public function getTestimonial($id)
	{
		$sql = "SELECT * FROM testimonials WHERE t_id = $id";
		$t = $this->connection->Query($sql);
		return $t[0];
	}
}