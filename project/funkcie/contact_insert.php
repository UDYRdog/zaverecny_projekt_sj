<?php 
include('../funkcie/databaza.php');
$db =  new Database();

if(isset($_POST['form-submit'])){

        $data = [
            'meno' => $_POST["name"],
            'email' => $_POST["email"],
            'phone' => $_POST["phone"],
            'message' => $_POST["message"]
        ];

        try{
            $query = "INSERT INTO contact (meno,email,phone,message) VALUES (:meno,:email,:phone,:message)";
            $query_run = $db->conn->prepare($query);
            $query_run->execute($data);

            if(isset($_SERVER['HTTP_REFERER'])){
                header("Location: {$_SERVER['HTTP_REFERER']}");
            }
            
        }catch(PDOException $e){
            print_r($e->getMessage());
        }   
    }

?>