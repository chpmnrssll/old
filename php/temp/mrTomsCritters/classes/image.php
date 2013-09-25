<?php
class Image
{
	// Properties
	public $id = null;					// @var int The image ID from the database
	public $fileName = null;			// @var string Image file name
	public $description = null;			// @var string Image description
	
	// Sets the object's properties using the values in the supplied array
	public function __construct($data = array()) {
		if(isset($data['id'])) $this->id = (int) $data['id'];
		if(isset($data['fileName'])) $this->fileName = $data['fileName'];
		if(isset($data['description'])) $this->description = $data['description'];
	}
	
	// Sets the object's properties using the edit form post values in the supplied array
	public function storeFormValues($params) {
		// Store all the parameters
		$this->__construct($params);
	}
	
	// Returns an Image object matching the given ID or false if the record was not found or there was a problem
	public static function getById($id) {
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$sql = "SELECT * FROM images WHERE id = :id";
		$st = $conn->prepare($sql);
		$st->bindValue(":id", $id, PDO::PARAM_INT);
		$st->execute();
		$row = $st->fetch();
		$conn = null;
		if($row) return new Image($row);
	}
	
	// Returns all Image objects
	// @return Array|false A two-element array : results => array, a list of Image objects; totalRows => Total number of images
	public static function getList() {
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$sql = "SELECT * FROM images";
		$st = $conn->prepare($sql);
		$st->execute();
		$list = array();
		
		while($row = $st->fetch()) {
			$image = new Image($row);
			$list[] = $image;
		}
		
		// Now get the total number of images that matched the criteria
		$sql = "SELECT FOUND_ROWS() AS totalRows";
		$totalRows = $conn->query($sql)->fetch();
		$conn = null;
		return (array("results" => $list, "totalRows" => $totalRows[0]));
	}
	
	// Inserts the current Image object into the database, and sets its ID property.
	public function insert() {
		// Does the Image object already have an ID?
		if(!is_null($this->id) || $this->id != 0) { trigger_error("Image::insert(): Attempt to insert an Image object that already has its ID property set (to $this->id).", E_USER_ERROR); }
		
		// Insert the Image
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO images ( fileName, description ) VALUES ( :fileName, :description )";
		$st = $conn->prepare ($sql);
		$st->bindValue(":fileName", $this->fileName, PDO::PARAM_STR);
		$st->bindValue(":description", $this->description, PDO::PARAM_STR);
		$st->execute();
		$this->id = $conn->lastInsertId();
		$conn = null;
	}
	
	// Updates the current Image object in the database.
	public function update() {
		// Does the Image object have an ID?
		if(is_null($this->id)) trigger_error("Image::update(): Attempt to update an Image object that does not have its ID property set.", E_USER_ERROR);
		
		// Update the Image
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE images SET fileName=:fileName, description=:description WHERE id=:id";
		$st = $conn->prepare($sql);
		$st->bindValue(":fileName", $this->fileName, PDO::PARAM_STR);
		$st->bindValue(":description", $this->description, PDO::PARAM_STR);
		$st->bindValue(":id", $this->id, PDO::PARAM_STR);
		$st->execute();
		$conn = null;
	}
	
	// Deletes the current Image object from the database.
	public function delete() {
		// Does the Image object have an ID?
		if(is_null($this->id)) trigger_error("Image::delete(): Attempt to delete an Image object that does not have its ID property set.", E_USER_ERROR);
		
		// Delete the Image
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$st = $conn->prepare ( "DELETE FROM images WHERE id = :id LIMIT 1" );
		$st->bindValue( ":id", $this->id, PDO::PARAM_INT );
		$st->execute();
		$conn = null;
	}
}

?>
