<?php
include("db_conn.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$title = $_POST['title'];
$description = $_POST['description'];
$requirements = $_POST['requirements'];
$date = $_POST['date'];

$target_dir = __DIR__ . "/uploads/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0755, true);
}
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$upload_dir = "volunteerimg/"; 
$target_file = $upload_dir . basename($_FILES["image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        
        echo "<script>
        Swal.fire({
            title: 'Error!',
            text:'File is not an image.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
      </script>";
        $uploadOk = 0;
    }
}


if (file_exists($target_file)) {
   
    echo "<script>
    Swal.fire({
        title: 'Error!',
        text:'Sorry, file already exists.',
        icon: 'error',
        confirmButtonText: 'OK'
    });
  </script>";
    $uploadOk = 0;
}

if ($_FILES["image"]["size"] > 5000000) {
  
    echo "<script>
    Swal.fire({
        title: 'Error!',
        text:'Sorry, your file is too large.',
        icon: 'error',
        confirmButtonText: 'OK'
    });
  </script>";
    $uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
   
    echo "<script>
    Swal.fire({
        title: 'Error!',
        text:'Sorry, only JPG, JPEG, PNG & GIF files are allowed.',
        icon: 'error',
        confirmButtonText: 'OK'
    });
  </script>";
    $uploadOk = 0;
}

if ($uploadOk == 0) {

    echo "<script>
    Swal.fire({
        title: 'Error!',
        text:'Sorry, your file was not uploaded.',
        icon: 'error',
        confirmButtonText: 'OK'
    });
  </script>";
} else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"],__DIR__ . "/".$target_file)) {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Success!',
                text: 'Image has been uploaded.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });
      </script>";
        $sql = "INSERT INTO volunteerTable (title, description, requirements, date,  image) VALUES ('$title', '$description', '$requirements', '$date', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'New volunteer job posted successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'publisher_manageVolunteerJob.php';
                    }
                });
            });
          </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
       
        echo "<script>
        Swal.fire({
            title: 'Error!',
            text:'Sorry, there was an error uploading your file.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
      </script>";
    }
}}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- <link rel="stylesheet" href="../css/public_addVol.css"> -->
    <link rel="stylesheet" href="../css/public_addPet.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Add New Job</title>
</head>
<body>
    <div class="container" style="width: auto; max-height:100vh;">
    <h2 style="text-align: center;">Add New Volunteer Job</h2>

    <a href="publisher_manageVolunteerJob.php" class="nav-icon">
            <i class="fas fa-home fa-2x"></i>
        </a>

        <div class="user-table justify-content-center"> 
        <form id="addVolunteerJobForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Job title</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Job description</label>
                    <input type="text" id="description" name="description" required>
                </div>
                <div class="form-group">
                    <label for="requirements">Requirements</label>
                    <input type="text" id="requirements" name="requirements" required>
                </div>
                <div class="form-group">
        <label for="date">Date</label>
        <input type="date" id="date" name="date" class="form-control" required>


           
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" accept="image/png, image/jpeg, image/jpg" >
            </div>
         
            <button type="submit">Post job</button>
        </form>
    </div>
</div>
</div>
    <?php
    $conn->close();?>
</body>
</html>
