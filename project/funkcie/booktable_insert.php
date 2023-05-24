<?php 
include('../funkcie/databaza.php');
$db =  new Database();
$conn = $db->conn;




if(isset($_POST['form-submit'])){
    $sql = "SELECT id FROM reservation";
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
            'day' => $_POST["day"],
            'hour' => $_POST["hour"],
            'name' => $_POST["name"],
            'phone' => $_POST["phone"],
            'person' => $_POST["person"]
        ];

        try{
            $query = "INSERT INTO reservation (id,day,time,full_name,phone_number,person_count) VALUES (:id,:day, :hour,:name,:phone,:person)";
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