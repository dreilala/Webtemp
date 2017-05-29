<?php
// used to get mysql database connection
class Database{

    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "webshop";
    private $username = "root";
    private $password = "";
    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;
        
        //$this->conn = new mysqli("localhost", "root", "", "bwi_bb17_chatter");
        //$result = $dbconn->query("select * from messages order by msgtime desc");

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }

}
?>
