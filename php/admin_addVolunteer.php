<?php
include("db_conn.php");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $title = $_POST['title'];
    $requirements = $_POST['requirements'];
    $description = $_POST['description'];
    $date= $_POST['date'];

    $target_dir = __DIR__ . "/uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    $upload_dir = "uploads/";
    $target_file = $upload_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Error!</strong> File is not an image.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
        $uploadOk = 0;
    }
}

    if (file_exists($target_file)) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Error!</strong> Sorry, file already exists.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
        $uploadOk = 0;
    }

    if ($_FILES["image"]["size"] > 5000000) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Error!</strong> Sorry, your file is too large.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Error!</strong> Sorry, only JPG, JPEG, PNG & GIF files are allowed.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Error!</strong> Sorry, your file was not uploaded.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    } else {
 
        if (move_uploaded_file($_FILES["image"]["tmp_name"], __DIR__ . "/" . $target_file)) {
            // echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            //         <strong>Success!</strong> The file " . basename($_FILES["image"]["name"]) . " has been uploaded.
            //         <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            //       </div>";

            // Insert the new volunteer job into the database
            $sql = "INSERT INTO volunteerTable(title,description,requirements,date,image) VALUES ('$title', '$description', '$requirements', '$date', '$target_file')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Volunteer job added successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'admin_manageVolunteerJob.php';
                        }
                    });
                });
              </script>";
            } 
        } else {
            echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Error adding new volunteer job: " . $conn->error . "',
                icon: 'error',
                confirmButtonText: 'OK'
            });
          </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Volunteer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/public_addPet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">    <style>
       .nav-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            color: grey;
        }
    </style>
</head>
<body>
<div class="container" style="width: auto; max-height:100vh;">
<h2 style="text-align: center;">Add New Volunteer Job</h2>
        <a href="admin_manageVolunteerJob.php" class="nav-icon">
            <i class="fas fa-home fa-2x"></i>
        </a>
        <!-- Form to add a new volunteer job -->
        <div class="user-table justify-content-center"> 
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="mb-4" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Job title:</label>
                        <input type="text" id="title" name="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <input type="text" id="description" name="description" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="requirements" class="form-label">Requirements:</label>
                        <input type="text" id="requirements" name="requirements" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Date:</label>
                        <input type="date" id="date" name="date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image:</label>
                        <input type="file" id="image" name="image" class="form-control">
                    </div>

                    <input type="submit" value="Add Job" class="btn btn-primary">
                </form>
    </div>
</div>
        <?php

    $conn->close();
    ?>
</body>
</html>