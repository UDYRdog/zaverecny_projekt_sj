<?php 
include('../funkcie/databaza.php');
$db =  new Database();

if(isset($_POST['form-submit'])){

        $data = [
            'email' => $_POST["email"]
        ];

        try{
            $query = "INSERT INTO newsletter (Email) VALUES (:email)";
            $query_run = $db->conn->prepare($query);
            $query_run->execute($data);
            if(isset($_SERVER['HTTP_REFERER'])){
                header("Location: {$_SERVER['HTTP_REFERER']}");
            }else{
                header("Location: index.php");
            }
        }catch(PDOException $e){
            print_r($e->getMessage());
        }   
}

?>