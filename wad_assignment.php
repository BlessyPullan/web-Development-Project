<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$q1 = "CREATE DATABASE IF NOT EXISTS healthcare_db";
mysqli_query($conn, $q1);


$q2 = "USE healthcare_db";
mysqli_query($conn, $q2);


$create_table_query = "CREATE TABLE IF NOT EXISTS patient_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    age INT,
    dob DATE,
    health_condition TEXT,
    gender VARCHAR(10),
    allergy VARCHAR(100),
    blood_group VARCHAR(5),
    height INT,
    weight INT,
    donor VARCHAR(5),
    patient_id VARCHAR(50) UNIQUE
)";

mysqli_query($conn, $create_table_query);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $name = $_POST['name'];
    $age = $_POST['age'];
    $dob = $_POST['dob'];
    $health_condition = $_POST['health_condition'];
    $gender = $_POST['gender'];
    $allergy = $_POST['allergy'];
    $blood_group = $_POST['blood_group'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $donor = isset($_POST['donor']) ? 'Yes' : 'No'; 
    $patient_id = $_POST['patient_id'];

   
$insert_query = "INSERT INTO patient_info (name, age, dob, health_condition, gender, allergy, blood_group, height, weight, donor, patient_id)
                     VALUES ('$name', $age, '$dob', '$health_condition', '$gender', '$allergy', '$blood_group', $height, $weight, '$donor', '$patient_id')";

    if (mysqli_query($conn, $insert_query)) {
        echo "New record inserted successfully<br>";
    } 

   else {
        echo "Error inserting record: " . mysqli_error($conn) . "<br>"; 
    }

$select_query = "SELECT * FROM patient_info";
$result = mysqli_query($conn, $select_query);

    if (!$result) {
        echo "Error in SELECT query: " . mysqli_error($conn); 
        exit(); 
    }

    if (mysqli_num_rows($result) > 0) {
        echo "<h3>All Patient Records:</h3>";
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>Patient ID</th><th>Name</th><th>Age</th><th>DOB</th><th>Health Condition</th><th>Gender</th><th>Allergy</th><th>Blood Group</th><th>Height</th><th>Weight</th><th>Donor</th></tr>";

        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['patient_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['age']) . "</td>";
            echo "<td>" . htmlspecialchars($row['dob']) . "</td>";
            echo "<td>" . htmlspecialchars($row['health_condition']) . "</td>";
            echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
            echo "<td>" . htmlspecialchars($row['allergy']) . "</td>";
            echo "<td>" . htmlspecialchars($row['blood_group']) . "</td>";
            echo "<td>" . htmlspecialchars($row['height']) . "</td>";
            echo "<td>" . htmlspecialchars($row['weight']) . "</td>";
            echo "<td>" . htmlspecialchars($row['donor']) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No records found.";
    }
}


mysqli_close($conn);
?>
