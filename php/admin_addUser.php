<?php
include("db_conn.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $name = $_POST['name'];
    $email = $_POST['email'];

        // Insert the new user entry into the database
        $sql = "INSERT INTO user (username, password, role, name, email) VALUES ('$username', '$password', '$role', '$name', '$email')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'User entry added successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'admin_manageUser.php';
                    }
                });
            });
          </script>";
        } 
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Error adding new user record: " . $conn->error . "',
                icon: 'error',
                confirmButtonText: 'OK'
            });
          </script>";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/public_addPet.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
</head>

<body>
<div class="container" style="width: auto;">
        <h1 style="text-align: center;">Add New User</h1>
        <a href="admin_manageUser.php" class="nav-icon">
            <i class="fas fa-home fa-2x"></i>
        </a>

        <div class="user-table justify-content-center">            
            <form id="addUserForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>


            <div class="form-group">
                <label for="role">Role</label>
                <div class="custom-select-wrapper">
                  <select class="form-select custom-select" aria-label="Default select example" id="role" name="role" required>
                    <option value="" disabled selected>Select a role</option>
                    <option value="adopter">Adopter</option>
                        <option value="shelters">Shelter</option>
                        <option value="admin">Admin</option>
                        <option value="volunteer">Volunteer</option>
                  </select>
                </div>
              </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required></textarea>
            </div>
            
            <button type="submit">Add User</button>
        </form>
    </div>
    </div>
    <?php
    $conn->close();
    ?>
</body>
</html>