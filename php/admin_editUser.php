<?php
include("db_conn.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_GET['id'];
$sql = "SELECT * FROM user WHERE id = $userId";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    

    // Update the user listing in the database
    $sql = "UPDATE user SET username = '$username', password = '$password', role = '$role', name = '$name', email = '$email' WHERE id = $userId";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Success!',
                        text: 'user entry updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'admin_manageUser.php';
                        }
                    });
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Error updating record: " . $conn->error . "',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Edit User</h1>

        <!-- Form to edit the user entry -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $userId; ?>" class="mb-4" enctype="multipart/form-data">
            
        <div class="mb-3">
                <label for="username" class="form-label">User Name:</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo $userData['username']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" value="<?php echo $userData['password']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select class="form-select mb-3" name="role" aria-label="Default select example" id="role" name="role" required>
                        <option value="adopter">Adopter</option>
                        <option value="shelters">Shelter</option>
                        <option value="admin">Admin</option>
                        <option value="volunteer">Volunteer</option>
                    </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $userData['name']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Password:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $userData['email']; ?>" required>
            </div>

            <input type="submit" value="Update user" class="btn btn-primary">
        </form>
    </div>

    <?php
 
    $conn->close();
    ?>
</body>
</html>