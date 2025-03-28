<?php
include("db_conn.php");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];


    $sql = "DELETE FROM user WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Success!',
                text: 'User deleted successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });
      </script>";
    } else {
        echo "<script>
        Swal.fire({
            title: 'Error!',
            text: 'Error delete user record: " . $conn->error . "',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'admin_manageUser.php';
            }
        });
      </script>";
    }
}


if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    header("Location:admin_editUser.php?id=$id");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Publisher - Manage User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
       .nav-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            color: grey;
        }

        .add-btn{
            padding: 5px;
            display: inline-block;
            text-align: center;
            text-decoration: none;
            color: white;
            background:#0d6efd;
            border-radius:5px;
            padding: var(--bs-btn-padding-y) var(--bs-btn-padding-x);
        }

    </style>
</head>
<body>
    <div class="container">
        <a href="../admin-main.html" class="nav-icon">
            <i class="fas fa-home fa-2x"></i>
        </a>
  <br>
    <div class="justify-content-between" style="display:flex;">
        <h2>User</h2>
        <a href="admin_addUser.php" class='add-btn btn-sm'> Add User 
    </a>
    </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>   
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM user";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['role'] . "</td>";
                 
                        echo "<td>
                                <a href='?edit=" . $row['id'] . "' class='btn btn-primary btn-sm me-2'>Edit</a>
                                <a href='?delete=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>No jobs found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php
    $conn->close();
    ?>
</body>
</html>