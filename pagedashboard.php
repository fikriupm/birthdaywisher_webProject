<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
<?php
require_once('connection/getConnection.php');
session_start();

if (!isset($_GET['name']) || strlen($_GET['name']) < 1) {
    die('Name parameter missing. Need to login first. <a href="pagelogin.php">Click here to login</a>');
}

// if (!isset($_SESSION['name'])) {
//     // Redirect the user to the login page or display an appropriate message
//     header("Location: pagelogin.php");
//     exit();
// }



// if (isset($_POST['reset'])) {
//     // Clear the session
//     session_destroy();
//     session_start();
//     header("Location: pagelogin.php");
//     exit();
// }
// if (!isset($_SESSION['name'])) {
//     // Redirect the user to the login page or display an appropriate message
//     header("Location: pagelogin.php");
//     exit();
// }
// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

if (isset($_GET['name'])) {
    $_SESSION['name'] = $_GET['name'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['studentname']) && isset($_POST['dob']) && isset($_POST['age']) && isset($_POST['address']) && isset($_POST['studentphone'])) {
    $studentname = $_POST['studentname'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $studentphone = $_POST['studentphone'];

    $cusername = $_SESSION['name'];

    $sql = "INSERT INTO studentinfo (studentname, dob, age, address, studentphone, cusername) VALUES (:studentname, :dob, :age, :address, :studentphone, :cusername)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'studentname' => $studentname,
        'dob' => $dob,
        'age' => $age,
        'address' => $address,
        'studentphone' => $studentphone,
        'cusername' => $cusername
    ]);

    header("Location: " . $_SERVER['PHP_SELF'] . "?name=" . urlencode($cusername));
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Joyboy Main Page</title>
    <link rel="shortcut icon" type="image/png" href="images/favicon.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="style/pagedashboard.css">
    <style>
        .bgimg {
            background-image: url("images/bg8.jpg");
            min-height: 100%;
            background-position: center;
            background-size: cover;
        }

        /* .alert { 
            padding: 20px;
            background-color: #F0E68C;
            color: Black;
            border-radius: 10px;
            font-family: Arial, sans-serif;
            font-size: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .closebtn {
            margin-left: 15px;
            color: black;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        } */
    </style>
    <script>
        function showMessage() {
            swal("Successful", "Information inserted successfully", "success");
        }

        function logout() {
            // Make an AJAX request to logout.php
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Remove the name parameter from the URL
                    var url = window.location.href;
                    var index = url.indexOf('?');
                    if (index !== -1) {
                        url = url.substring(0, index);
                    }
                    window.location.href = url;
                }
            };
            xhttp.open("GET", "logout.php", true);
            xhttp.send();
        }
    </script>

</head>

<body>
    <div class="bgimg w3-display-container w3-text-white">
        <div class="overlay"></div>
        <div class="w3-display-middle w3-jumbo">
            <!--
            $currentDate = date('Y-m-d');
            $stmt = $pdo->prepare("SELECT * FROM studentinfo WHERE dob = :currentDate AND cusername = :cusername");
            $stmt->execute(['currentDate' => $currentDate, 'cusername' => $cusername]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($currentDate == $_GET['dob']) {
                echo "Today is the birthday!";
            } else {
                echo "There is no birthday today";
            }
             -->
            <img src="images/Logo1.png" alt="Logo">
        </div>
        <div class="w3-display-topleft w3-container w3-xlarge">
            <p><button onclick="document.getElementById('info').style.display='block'"
                    class="w3-button w3-black">DISPLAY</button></p>
            <p><button onclick="document.getElementById('insert').style.display='block'"
                    class="w3-button w3-black">INSERT</button></p>
            <p><button onclick="document.getElementById('upload').style.display='block'"
                    class="w3-button w3-black">UPLOAD</button></p>
            <!-- <p><button onclick="window.location.href='logout.php'" class="w3-button w3-black"
                    name="reset">LOGOUT</button></p> -->
            <p><button onclick="logout()" class="w3-button w3-black" name="reset">LOGOUT</button></p>


        </div>
        <div class="w3-display-bottomleft w3-container">
            <p class="w3-large">JOYBOY TECH.COMP</p>
            <p>@zul_hkimi</p>
            <p>@haredzikri</p>
            <p>@ammhzzq</p>
            <p> @fikrizaidakmal</p>
        </div>
    </div>

    <!-- Student Info -->
    <div id="info" class="w3-modal">
        <div class="w3-modal-content w3-animate-zoom">
            <div class="w3-container w3-black w3-display-container">
                <span onclick="document.getElementById('info').style.display='none'"
                    class="w3-button w3-display-topright w3-large">x</span>
                <!-- Display inserted student data -->
                <h2><strong>STUDENT INFORMATION</strong></h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date of Birth</th>
                            <th>Age</th>
                            <th>Address</th>
                            <th>Contact</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if (isset($_SESSION['name'])) {
                            $cusername = $_SESSION['name'];

                            $stmt = $pdo->prepare("SELECT * FROM studentinfo WHERE cusername = :cusername ORDER BY MONTH(dob)");
                            $stmt->execute(['cusername' => $cusername]);
                            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($rows as $row) {
                                echo "<tr><td>";
                                echo $row['studentname'];
                                $studentName = $row['studentname'];
                                echo "</td><td>";
                                echo $row['dob'];
                                echo "</td><td>";
                                echo $row['age'];
                                echo "</td><td>";
                                echo $row['address'];
                                echo "</td><td>";
                                $phoneNumber = $row['studentphone'];
                                echo '<a href="https://api.whatsapp.com/send?phone=' . $phoneNumber . '&text=Happy%20Birthday%20to%20' . $studentName . '!🎉 Click this link https://kualalumpurinformative.000webhostapp.com/index.html" target="_blank">';
                                echo '<i class="fab fa-whatsapp"></i>'; // Assuming you have included the Font Awesome library
                                echo '</a>';
                                echo "</td></tr>" . PHP_EOL;
                            }
                        }
                        echo "</table>" . PHP_EOL;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Insert Modal -->
    <div id="insert" class="w3-modal">
        <div class="w3-modal-content w3-animate-zoom">
            <div class="w3-container w3-black">
                <span onclick="document.getElementById('insert').style.display='none'"
                    class="w3-button w3-display-topright w3-large">x</span>
                <h2><strong>INSERT STUDENT INFORMATION</strong></h2>
            </div>
            <div class="w3-container">
                <form method="post">
                    <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Name" required
                            name="studentname"></p>
                    <p><input class="w3-input w3-padding-16 w3-border" type="date" placeholder="Date of Birth" required
                            name="dob"></p>
                    <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Age" required
                            name="age"></p>
                    <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Address" required
                            name="address"></p>
                    <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="Phone Number" required
                            name="studentphone"></p>
                    <p>
                        <button onclick="showMessage()" class="w3-button w3-button w3-black w3-round-large"
                            type="submit">Submit</button>
                    </p>
                </form>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
                    echo '<script>';
                    echo 'swal("Successful", "Information inserted Successfully", "success");';
                    echo '</script>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Upload File Form -->
    <div id="upload" class="w3-modal">
        <div class="w3-modal-content w3-animate-zoom">
            <div class="w3-container w3-black w3-display-container">
                <span onclick="document.getElementById('upload').style.display='none'"
                    class="w3-button w3-display-topright w3-large">x</span>
                <h2><strong>UPLOAD STUDENT INFORMATION</strong></h2>
                <form action="pagespsheet.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="import_file" class="form-control" />
                    <button type="submit" name="save_excel_data" class="btn btn-primary mt-3">Import</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>