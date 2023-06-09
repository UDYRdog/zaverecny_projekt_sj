<?php 
include('../funkcie/databaza.php');
$db =  new Database();
$conn = $db->conn;

if(isset($_POST['form-submit'])){
    $sql = "SELECT id FROM contact";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $usedIds = array();
    foreach ($records as $record) {
        $usedIds[] = $record['id'];
    }
    
    for ($i = 0; $i < 100; $i++) {
        if (!in_array($i, $usedIds)) {
            $id = $i;
            break;
        }
    }

        $data = [
            'id' => $id,
            'meno' => $_POST["name"],
            'email' => $_POST["email"],
            'phone' => $_POST["phone"],
            'message' => $_POST["message"]
        ];

        try{
            $query = "INSERT INTO contact (id,meno,email,phone,message) VALUES (:id,:meno,:email,:phone,:message)";
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