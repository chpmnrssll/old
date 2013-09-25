<?php

class Page extends ActiveRecord\Model
{
	//static $table_name = 'Pages';
	//static $primary_key = 'id';
	//static $connection = 'development';
	//static $db = 'cms';
	
	// Returns an excerpt of page content stripped of HTML tags of $excerpt_length characters long
	public function excerpt($excerpt_length) {
		$content_length = strlen(strip_tags($this->content));
		$position = $content_length < $excerpt_length ? $content_length : $excerpt_length;
		$char = substr(strip_tags($this->content), $position, 1);
		if($char != " " && $position < $content_length) {
			while($char != " " && $position < $content_length) {
				$i = 1;
				$position = $position + $i;
				$char = substr(strip_tags($this->content), $position, 1);
			}
		}
		
		return strip_tags(substr(strip_tags($this->content), 0, $position));
	}
}
?>