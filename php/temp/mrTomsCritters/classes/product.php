<?php
class Product
{
	// Properties
	public $id = null;					// @var int The product ID from the database
	public $name = null;				// @var string Product name
	public $description = null;			// @var string HTML product description
	public $price = null;				// @var int 
	public $stock = null;				// @var int Stock number
	public $available = null;			// @var bool available
	public $category = null;			// @var string
	public $images = null;				// @var string
	public $video = null;				// @var string
	
	// Sets the object's properties using the values in the supplied array
	public function __construct($data = array()) {
		if(isset($data['id'])) $this->id = (int) $data['id'];
		if(isset($data['name'])) $this->name = $data['name'];
		if(isset($data['description'])) $this->description = $data['description'];
		if(isset($data['price'])) $this->price = (int) $data['price'];
		if(isset($data['stock'])) $this->stock = (int) $data['stock'];
		if(isset($data['available'])) $this->available = (bool) $data['available'];
		if(isset($data['category'])) $this->category = $data['category'];
		if(isset($data['images'])) $this->images = $data['images'];
		if(isset($data['video'])) $this->video = $data['video'];
	}
	
	// Sets the object's properties using the edit form post values in the supplied array
	public function storeFormValues($params) {
		// Store all the parameters
		$this->__construct($params);
		
		if($_POST['available'] == "true") {
			$this->available = 1;
		}
		else {
			$this->available = 0;
		}
	}
	
	// Returns a Product object matching the given ID or false if the record was not found or there was a problem
	public static function getById($id) {
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$sql = "SELECT * FROM products WHERE id = :id";
		$st = $conn->prepare($sql);
		$st->bindValue(":id", $id, PDO::PARAM_INT);
		$st->execute();
		$row = $st->fetch();
		$conn = null;
		if($row) return new Product($row);
	}
	
	// Returns all Product objects in a certain category
	// @param string Product category
	// @return Array|false A two-element array : results => array, a list of Product objects; totalRows => Total number of products
	public static function getList($category) {
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		
		if($category) {
			$sql = "SELECT * FROM products WHERE category = :category";
		}
		else {
			$sql = "SELECT * FROM products ORDER BY category";
		}
		$st = $conn->prepare($sql);
		$st->bindValue(":category", $category, PDO::PARAM_INT);
		$st->execute();
		$list = array();
		
		while($row = $st->fetch()) {
			$product = new Product($row);
			$list[] = $product;
		}
		
		// Now get the total number of products that matched the criteria
		$sql = "SELECT FOUND_ROWS() AS totalRows";
		$totalRows = $conn->query($sql)->fetch();
		$conn = null;
		return (array("results" => $list, "totalRows" => $totalRows[0]));
	}
	
	// Inserts the current Product object into the database, and sets its ID property.
	public function insert() {
		// Does the Product object already have an ID?
		if(!is_null($this->id) || $this->id != 0) { trigger_error("Product::insert(): Attempt to insert a Product object that already has its ID property set (to $this->id).", E_USER_ERROR); }
		
		// Insert the Product
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO products ( name, description, price, stock, available, category, images, video ) VALUES ( :name, :description, :price, :stock, :available, :category, :images, :video )";
		$st = $conn->prepare ($sql);
		$st->bindValue(":name", $this->name, PDO::PARAM_STR);
		$st->bindValue(":description", $this->description, PDO::PARAM_STR);
		$st->bindValue(":price", $this->price, PDO::PARAM_INT);
		$st->bindValue(":stock", $this->stock, PDO::PARAM_INT);
		$st->bindValue(":available", $this->available, PDO::PARAM_INT);
		$st->bindValue(":category", $this->category, PDO::PARAM_STR);
		$st->bindValue(":images", $this->images, PDO::PARAM_STR);
		$st->bindValue(":video", $this->video, PDO::PARAM_STR);
		$st->execute();
		$this->id = $conn->lastInsertId();
		$conn = null;
	}
	
	// Updates the current Product object in the database.
	public function update() {
		// Does the Product object have an ID?
		if(is_null($this->id)) trigger_error("Product::update(): Attempt to update a product object that does not have its ID property set.", E_USER_ERROR);
		
		// Update the Product
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE products SET name=:name, description=:description, price=:price, stock=:stock, available=:available, category=:category, images=:images, video=:video WHERE id=:id";
		$st = $conn->prepare($sql);
		$st->bindValue(":name", $this->name, PDO::PARAM_STR);
		$st->bindValue(":description", $this->description, PDO::PARAM_STR);
		$st->bindValue(":price", $this->price, PDO::PARAM_INT);
		$st->bindValue(":stock", $this->stock, PDO::PARAM_INT);
		$st->bindValue(":available", $this->available, PDO::PARAM_INT);
		$st->bindValue(":category", $this->category, PDO::PARAM_STR);
		$st->bindValue(":images", $this->images, PDO::PARAM_STR);
		$st->bindValue(":video", $this->video, PDO::PARAM_STR);
		$st->bindValue(":id", $this->id, PDO::PARAM_STR);
		$st->execute();
		$conn = null;
	}
	
	// Deletes the current Product object from the database.
	public function delete() {
		// Does the Product object have an ID?
		if(is_null($this->id)) trigger_error("Product::delete(): Attempt to delete a product object that does not have its ID property set.", E_USER_ERROR);
		
		// Delete the Product
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$st = $conn->prepare ( "DELETE FROM products WHERE id = :id LIMIT 1" );
		$st->bindValue( ":id", $this->id, PDO::PARAM_INT );
		$st->execute();
		$conn = null;
	}
}

?>
