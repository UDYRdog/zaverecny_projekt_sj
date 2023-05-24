<?php 
include('../funkcie/databaza.php');
$db = new Database();
$conn = $db->conn;

if(isset($_POST['form-submit'])){
    $sql = "SELECT id FROM newsletter";
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
        'email' => $_POST['email']
    ];
    
    try {
        $query = "INSERT INTO newsletter (id, email) VALUES (:id, :email)";
        $query_run = $db->conn->prepare($query);
        $query_run->execute($data);
        
        if(isset($_SERVER['HTTP_REFERER'])){
            header("Location: {$_SERVER['HTTP_REFERER']}");
        }
    } catch(PDOException $e) {
        print_r($e->getMessage());
    }
}
?>