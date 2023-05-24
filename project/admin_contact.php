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
        $deleteStmt = $conn->prepare("DELETE FROM contact WHERE id = :id");
        $deleteStmt->bindParam(':id', $id);
        $deleteStmt->execute();
    }

   
   
    $sql = "SELECT * FROM contact";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    if (!empty($records)) {
        echo "<table>";
        echo "<tr><th>Id</th><th>Name</th><th>Email</th><th>Phone</th><th>Message</th><th>Action</th></tr>";

        foreach ($records as $row) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["meno"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["phone"] . "</td>";
            echo "<td>" . $row["message"] . "</td>";
            echo "<td class='action-links'>";
            echo "<a href='admin_contact.php?delete=" . $row["id"] . "'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No records found.";}

    ?>

</body>
</html>