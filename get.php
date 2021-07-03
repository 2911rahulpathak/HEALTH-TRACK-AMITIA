<?php
if (isset($_POST['Register'])) {
    if (isset($_POST['NameofDonor']) && isset($_POST['ContactNumber']) &&
        isset($_POST['NationCardNumber']) && isset($_POST['Enteryouraddress']) &&
        isset($_POST['Entertheyouliketodonate']) && isset($_POST['gender'])) {
        
        $NameofDonor = $_POST['NameofDonor'];
        $ContactNumber = $_POST['ContactNumber'];
        $NationCardNumber = $_POST['NationCardNumber'];
        $Enteryouraddress = $_POST['Enteryouraddress'];
        $Entertheyouliketodonate = $_POST['Entertheyouliketodonate'];
        $gender = $_POST['gender'];
        
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "tech11";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT ContactNumber FROM registeration2 WHERE ContactNumber = ? LIMIT 3";
            $Insert = "INSERT INTO register2(NameofDonor,ContactNumber,NationCardNumber , Enteryouraddress, , Entertheyouliketodonate, gender  ) values(?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $ContactNumber);
            $stmt->execute();
            $stmt->bind_result($resultContactNumber);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("siisss",$NameofDonor, $ContactNumber, $NationCardNumber, $Enteryouraddress, $Entertheyouliketodonate, $gender);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Register button is not set";
}
?>