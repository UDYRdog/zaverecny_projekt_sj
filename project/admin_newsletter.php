
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
        $email = $_GET['delete'];
        $id = $_GET['id'];
        $deleteStmt = $conn->prepare("DELETE FROM newsletter WHERE email = :email AND id = :id");
        $deleteStmt->bindParam(':email', $email);
        $deleteStmt->bindParam(':id', $id);
        $deleteStmt->execute();
    }

  
    if (isset($_POST['update'])) {
        $email = $_POST['email'];
        $id = $_POST['id'];
        $newEmail = $_POST['new_email'];
        $updateStmt = $conn->prepare("UPDATE newsletter SET email = :new_email WHERE email = :email AND id = :id");
        $updateStmt->bindParam(':email', $email);
        $updateStmt->bindParam(':id', $id);
        $updateStmt->bindParam(':new_email', $newEmail);
        $updateStmt->execute();
    }

  
    $sql = "SELECT * FROM newsletter";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

  
    if (!empty($records)) {
        echo "<table>";
        echo "<tr><th>Id</th><th>Email</th><th>Action</th></tr>";

        foreach ($records as $row) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td class='action-links'>";
            echo "<a href='admin_newsletter.php?delete=" . $row["email"] . "&id=" . $row["id"] . "'>Delete</a>";
            echo "<a href='admin_newsletter.php?update=" . $row["email"] . "&id=" . $row["id"] . "'>Update</a>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No records found.";
    }
    
   
    if (isset($_GET['update'])) {
        $emailToUpdate = $_GET['update'];
        $id = $_GET['id'];
        
       
        echo "<h2>Update Email</h2>";
        echo "<form method='post' action=''>";
        echo "<label for='email'>Current Email:</label>";
        echo "<input type='text' name='email' id='email' value='$emailToUpdate' readonly><br>";
        echo "<label for='new_email'>New Email:</label>";
        echo "<input type='text' name='new_email' id='new_email' required><br>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "<input type='submit' name='update' value='Update'>";
        echo "</form>";
    }
    ?>

</body>
</html>