<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    
    <title>Admin Page</title>

</head>
<body>
    <h1>Admin Page</h1>

    <?php
    include('funkcie/databaza.php');
    $db = new Database();
    $conn = $db->conn;
 
 
    
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $deleteStmt = $conn->prepare("DELETE FROM reservation WHERE id = :id");
        $deleteStmt->bindParam(':id', $id);
        $deleteStmt->execute();
    }

   
   
    $sql = "SELECT * FROM reservation";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

  
    if (!empty($records)) {
        echo "<table>";
        echo "<tr><th>Id</th><th>Day</th><th>Time</th><th>Phone</th><th>Person_count</th><th>Full_name</th><th>Action</th></tr>";

        foreach ($records as $row) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["day"] . "</td>";
            echo "<td>" . $row["time"] . "</td>";
            echo "<td>" . $row["phone_number"] . "</td>";
            echo "<td>" . $row["person_count"] . "</td>";
            echo "<td>" . $row["full_name"] . "</td>";
            echo "<td class='action-links'>";
            echo "<a href='admin_booktable.php?delete=" . $row["id"] . "'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No records found.";}

    ?>

</body>
</html>