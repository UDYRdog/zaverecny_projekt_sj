<?php 
class Database{
    

    function __construct(){
            try{
                $this->conn = new PDO('mysql:host=localhost;dbname=web_puchovsky;charset=utf8','root','');
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                var_dump($e->getMessage());
            }
        }
}
?>