<?php
        // Connect to DB
        if(!include('connect.php')) {
        die('error finding connect file');
        }
        $dbh = ConnectDB();
?>
<html>
<body>

<?php

        if(!isset($_GET["UserID"])) {echo "Insert UserID in query string. For example add '?UserID=1' at the end of this URL";}

        else {
                $UserID = $_GET["UserID"];
                echo "<h1>Building Workout For User: " . $UserID . "</h1>\n";
                $sql = "CALL build_workout(:UserID, next_workout_day(:UserID));";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':UserID', $UserID, PDO::PARAM_STR);
                $stmt->execute();



                if($stmt->rowCount() == 0) { echo "A workout already exists for today.";}
                else {
                echo "<p>Number of workout records added: " . $stmt->rowCount() . "</p>";
                     }

             }

?>

</body>
</html>
