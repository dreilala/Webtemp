<?php
// 'cart item' object
class CartItem{
 
    // database connection and table name
    private $conn;
    private $table_name = "cart_items";
 
    // object properties
    public $id;
    public $product_id;
    public $quantity;
    public $user_id;
    public $created;
    public $modified;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
}
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);
$cart_item = new CartItem($db);
// to prevent undefined index notice
$action = isset($_GET['action']) ? $_GET['action'] : "";
 
// for pagination purposes
$page = isset($_GET['page']) ? $_GET['page'] : 1; // page is the current page, if there's nothing set, default is page 1
$records_per_page = 6; // set records or rows of data per page
$from_record_num = ($records_per_page * $page) - $records_per_page; // calculate for the query LIMIT clause
// read all products in the database
$stmt=$product->read($from_record_num, $records_per_page);
 
// count number of retrieved products
$num = $stmt->rowCount();
 
// if products retrieved were more than zero
if($num>0){
    // needed for paging
    $page_url="products.php?";
    $total_rows=$product->count();
 
    // show products
    include_once "read_products_template.php";
}
 
// tell the user if there's no products in the database
else{
    echo "<div class='col-md-12'>";
        echo "<div class='alert alert-danger'>No products found.</div>";
    echo "</div>";
}
// check if a cart item exists
public function exists(){
 
    // query to count existing cart item
    $query = "SELECT count(*) FROM " . $this->table_name . " WHERE product_id=:product_id AND user_id=:user_id";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // sanitize
    $this->product_id=htmlspecialchars(strip_tags($this->product_id));
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
 
    // bind category id variable
    $stmt->bindParam(":product_id", $this->product_id);
    $stmt->bindParam(":user_id", $this->user_id);
 
    // execute query
    $stmt->execute();
 
    // get row value
    $rows = $stmt->fetch(PDO::FETCH_NUM);
 
    // return
    if($rows[0]>0){
        return true;
    }
 
    return false;
}
// count user's items in the cart
public function count(){
 
    // query to count existing cart item
    $query = "SELECT count(*) FROM " . $this->table_name . " WHERE user_id=:user_id";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // sanitize
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
 
    // bind category id variable
    $stmt->bindParam(":user_id", $this->user_id);
 
    // execute query
    $stmt->execute();
 
    // get row value
    $rows = $stmt->fetch(PDO::FETCH_NUM);
 
    // return
    return $rows[0];
}
// create cart item record
function create(){
 
    // to get times-tamp for 'created' field
    $this->created=date('Y-m-d H:i:s');
 
    // query to insert cart item record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                product_id = :product_id,
                quantity = :quantity,
                user_id = :user_id,
                created = :created";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->product_id=htmlspecialchars(strip_tags($this->product_id));
    $this->quantity=htmlspecialchars(strip_tags($this->quantity));
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
 
    // bind values
    $stmt->bindParam(":product_id", $this->product_id);
    $stmt->bindParam(":quantity", $this->quantity);
    $stmt->bindParam(":user_id", $this->user_id);
    $stmt->bindParam(":created", $this->created);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
