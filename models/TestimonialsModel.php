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
		return $count;
	}
}