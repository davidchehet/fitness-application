<?php
        //Connect to DB
        if(!include('connect.php')){
        die('error finding connect file');
        }

        $dbh = ConnectDB();
?>
<html>
<body>

<?php

        if(!isset($_GET["UserID"])) { echo "Insert UserID in query string. For example add '?UserID=1' at the end of this URL"; }

        else {
                $UserID = $_GET["UserID"];
                echo "<h1>Current Workout For User: " . $UserID . "</h1>\n";
                $sql = "CALL fetch_current_workout(:UserID);";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':UserID', $UserID, PDO::PARAM_STR);
                $stmt->execute();
                echo $stmt->rowCount() . " Activites Retrieved.";

                $list = '<ul>';
                foreach ($stmt->fetchAll() as $row) {
                $list .= "<li>" . $row['Activity'] . "</li>";
             }

        $list .= "</ul>";
        echo $list;
     }
?>

</body>
</html>
