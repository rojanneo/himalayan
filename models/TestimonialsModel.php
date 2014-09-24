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
		$query = "Insert into testimonial_new(testimonial_date,testimonial_name,testimonial_email,testimonial_address,testimonial,testimonial_rating,testimonial_helpful_count, testimonial_not_helpful_count) values('".$t_dt."','".$t_name."','".$t_email."',
			'".$t_add."','".$t_comment."', 0, 0, 0)";
		$this->connection->InsertQuery($query);
	}

	public function getTestimonials($first, $limit)
	{
		$query = 'SELECT * FROM testimonial_new ORDER BY testimonial_id DESC Limit '.$first.','.$limit;
		$testimonials = $this->connection->Query($query);
		return $testimonials;

	}

	public function getAllTestimonials()
	{
		$query = 'SELECT * FROM testimonial_new ORDER BY testimonial_id DESC';
		$testimonials = $this->connection->Query($query);
		return $testimonials;		
	}

	public function searchTestimonials($keywords)
	{
		$results = array();
		foreach($keywords as $keyword => $key)
		{
			$query = "SELECT * FROM testimonial_new WHERE MATCH (testimonial) AGAINST ('+".$keyword."' IN BOOLEAN MODE)";
			$testimonials = $this->connection->Query($query);
			foreach($testimonials as $testimonial)
			{
				$results[$testimonial['testimonial_id']] = $testimonial;
			}
		}
		return $results;
	}

	public function getTestimonialsCount()
	{
		$query = 'SELECT COUNT(*) FROM testimonials;';
		$count = $this->connection->Query($query);
		return $count[0]['COUNT(*)'];
	}

	public function deleteTestimonial($id)
	{
		$sql = "DELETE FROM testimonial_new WHERE testimonial_id = $id";
		return $this->connection->DeleteQuery($sql);
	}

	public function getTestimonial($id)
	{
		$sql = "SELECT * FROM testimonial_new WHERE testimonial_id = $id";
		$t = $this->connection->Query($sql);
		return $t[0];
	}
}