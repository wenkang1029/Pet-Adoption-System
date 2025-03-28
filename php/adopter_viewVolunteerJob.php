<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pet Shelter Volunteer</title>
    <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/adopter_viewVol.css">
</head>
<body>
<header>

    <nav class="navbar navbar-expand-lg">
      <div class="container navbar__container">
        <a class="logo navbar-brand" href="../volunteer-main.html">Pet Adoption</a>

        <button class="navbar-toggler navbar__toggler" type="button" data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon navbar__toggler--icon">
            <i class="fas fa-bars"></i>
            <i class="fas fa-times"></i>
          </span>
        </button>

        <div id="primaryNav">
          <div class="navbar-collapse collapse" id="navbarSupportedContent" style>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="navbar__navitem nav-item">
                            <a class="navbar__navlink nav-link" href="volunteer-main.html">Home</a>
                        </li>
                        <li class="navbar__navitem nav-item">
                            <a class="navbar__navlink nav-link" href="php/adopter_viewVolunteerJob.php">View Job</a>
                        </li>
                        <li class="navbar__navitem nav-item">
                            <a class="navbar__navlink nav-link" href="php/adopter_viewApplicationStatus.php">View Status</a>
                        </li>
                        <li class="navbar__navitem nav-item">
                            <a class="navbar__navlink nav-link" href="adopter-main.html">Switch Adopter</a>
                        </li>
            </ul>
          </div>
        </div>

        <div id="userNav" class="navbar-nav mr-auto ml-auto align-items-center">
                    <img src="../img/volunteer.png" style="width: 30px; height: 30px;">
                <a href="/php/logout.php" class="btn btn-dark" style="margin-left: 20px;">Logout</a>
            </div>

          </div>
      </div>
    </nav>
  </header>
  <main>
    <div class="contain">
      <img src="../img/volunteer_hero.jpg" alt="">
      <div class="hero-text">
        <h1>Volunteer Opportunities in Our Shelter</h1>
        <p>"Share the Love, Change a Life: Volunteer at Our Pet Shelter!"</p>
        <button><a href="../contactUs.html" style="text-decoration:none; color:white;">Contact us</a></button>
      </div>
    </div>
  </main>

  <div id="listOfVolunteer"></div>

    <script>

        function createVolunteerPopup(volunteerData) {
        const popup = document.createElement('div');
        popup.classList.add('popup');

        const popupHeader = document.createElement('div');
        popupHeader.classList.add('popup-header');

        const closeBtn = document.createElement('span');
        closeBtn.classList.add('close-btn');
        closeBtn.textContent = 'X';
        closeBtn.addEventListener('click', () => {
            popup.remove();
        });
        popupHeader.appendChild(closeBtn);

        popup.appendChild(popupHeader);

        const popupContent = document.createElement('div');
        popupContent.classList.add('popup-content');

        const popupImage = document.createElement('div');
        popupImage.classList.add('popup-image');
        const image = document.createElement('img');
        image.src = volunteerData.image;
        popupImage.appendChild(image);
        popupContent.appendChild(popupImage);

        const popupInfo = document.createElement('div');
        popupInfo.classList.add('popup-info');

        const popupName = document.createElement('h3');
        popupName.textContent = volunteerData.title;
        popupInfo.appendChild(popupName);

        const popupDescription = document.createElement('p');
        popupDescription.textContent = `Job description: ${volunteerData.description}`;
        popupInfo.appendChild(popupDescription);

        const popupRequirements = document.createElement('p');
        popupRequirements .textContent = `Requirements: ${volunteerData.requirements}`;
        popupInfo.appendChild(popupRequirements );

        const popupDate = document.createElement('p');
        popupDate.textContent = `Volunteering date: ${volunteerData.date}`;
        popupInfo.appendChild(popupDate);
      const volunteerBtn = document.createElement('button');
            volunteerBtn.textContent = 'Become a volunteer';
            volunteerBtn.className = 'volunteer-btn';
            volunteerBtn.onclick = function () {
                const modal = createVolunteerModal(volunteerData.title);
                document.body.appendChild(modal);
                modal.style.display = 'block';
                popup.remove();
            };
            popupInfo.appendChild(volunteerBtn);
        popupContent.appendChild(popupInfo);
        popup.appendChild(popupContent);

        document.body.appendChild(popup);
    }

function createVolunteerModal(title) {
    const modal = document.createElement('div');
    modal.classList.add('modal');

    const modalContent = document.createElement('div');
    modalContent.classList.add('modal-content');

    const closeBtn = document.createElement('span');
    closeBtn.classList.add('x-btn');
    closeBtn.textContent = 'X';
    closeBtn.onclick = function() {
        modal.style.display = 'none';
    };

    const head = document.createElement('h3');
    head.textContent = `${title} Application Form`;

    const form = document.createElement('form');
form.innerHTML = `
<br>
    <input type="hidden" id="title" name="title" value="${title}">
    <label for="name">Your Name:</label>
    <input type="text" id="volunteerName" name="volunteerName" required><br><br>

    <label for="volunteerEmail">Your Email:</label>
    <input type="email" id="volunteerEmail" name="volunteerEmail" required><br><br>

    <label for="volunteerPhone">Your Phone:</label>
    <input type="tel" id="volunteerPhone" name="volunteerPhone" required><br><br>
     <label for="volunteerAddress">Your Address:</label>
    <input type="text" id="volunteerAddress" name="volunteerAddress" required><br><br>
        <label>Do you have any volunteer experience?</label><br>
    <input type="radio" id="yes_experience" name="experienced" value="yes" required>
    <label for="yes_experience">Yes</label><br>
    <input type="radio" id="no_experience" name="experienced" value="no" required>
    <label for="no_experience">No</label><br><br>
  <label for="reasons">Why are you interested in becoming volunteer for ${title} : </label>
    <input type="text" id="reasons" name="reasons" required><br><br>
    <button type="submit">Apply</button>
`;

form.onsubmit = function(e) {
    e.preventDefault();
    const formData = new FormData(form);

    fetch('adopter_volunteerRequest.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            modal.remove();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting the form.');
    });
};

    modalContent.appendChild(closeBtn);
    modalContent.appendChild(head);
    modalContent.appendChild(form);
    modal.appendChild(modalContent);
    return modal;
}
</script>

    <?php
    include("db_conn.php");


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM volunteerTable";
    $result = $conn->query($sql);

    $volunteerJobs = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $volunteerJobs[] = $row;
        }
    }

    ?>
    <script>

        let listOfVolunteer = <?php echo json_encode($volunteerJobs); ?>;
     function createVolunteerCard(volunteerData) {
    let volunteerCard = document.createElement("div");
    volunteerCard.classList.add("volunteerCard");
    
    let imgContainer = document.createElement("div");
    imgContainer.classList.add("image-container");

    let image = document.createElement("img");
    if (volunteerData.image) {
        image.setAttribute("src", volunteerData.image); 
    }

    imgContainer.appendChild(image);
    volunteerCard.appendChild(imgContainer);

    let container = document.createElement("div");
    container.classList.add("container");

    let jobtitle = document.createElement("h5");
    jobtitle.classList.add("title");
    if (volunteerData.title) {
        jobtitle.innerText =volunteerData.title.toUpperCase();
    }
    container.appendChild(jobtitle);

    let date= document.createElement("h6");
    if (volunteerData.date) {
        date.innerText = `Volunteering Date: ${volunteerData.date}`;
    }
    container.appendChild(date);

    let postedDate = document.createElement("p");
    if (volunteerData.created_at) {
        postedDate.innerText = `Posted by: ${volunteerData.created_at}`;
    }
    container.appendChild(postedDate);

   volunteerCard.appendChild(container);

   volunteerCard.addEventListener('click', () => {
            createVolunteerPopup(volunteerData);
        });
    return volunteerCard;
}

        listOfVolunteer.forEach(volunteer => {
            console.log("Creating card for:", volunteer.title);
            let volunteerCard = createVolunteerCard(volunteer);
            document.getElementById("listOfVolunteer").appendChild(volunteerCard);

        });
    </script>
    <?php
    $conn->close();
    ?>
</body>
</html>