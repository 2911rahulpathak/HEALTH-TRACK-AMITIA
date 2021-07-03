<?php
if (isset($_POST['register'])) {
    if (isset($_POST['NameofthePatient']) && isset($_POST['ContactNumber']) &&
        isset($_POST['EmailId']) && isset($_POST['Address']) &&
        isset($_POST['Incomeperannum']) && isset($_POST['Selectthedisease'])
        && isset($_POST['NationCardNo'])) {
        
        $NameofthePatient = $_POST['NameofthePatient'];
        $ContactNumber = $_POST['ContactNumber'];
        $EmailId = $_POST['EmailId'];
        $Address = $_POST['Address'];
        $Incomeperannum = $_POST['Incomeperannum'];
        $Selectthedisease = $_POST['Selectthedisease'];
        $NationCardNo = $_POST['NationCardNo'];
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "tech11";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT EmailId FROM registeration1 WHERE EmailId = ? LIMIT 1";
            $Insert = "INSERT INTO register1(NameofthePatient, ContactNumber, EmailId, Address, Incomeperannum, Selectthedisease, NationCardNo ) values(?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $EmailId);
            $stmt->execute();
            $stmt->bind_result($resultEmailId);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssssssi",$NameofthePatient, $ContactNumber, $EmailId, $Address, $Incomeperannum, $Selectthedisease, $NationCardNo);
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