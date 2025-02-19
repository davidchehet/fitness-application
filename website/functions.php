<html>
<head>
        <title>Information on User</title>
</head>

<?php
        //Connect to the DB
        if(!include('connect.php')) {
          die('error finding connect file');
        }

        $dbh = ConnectDB();
?>

<body>

<?php

        if(!isset($_GET['UserID'])) { echo "Insert UserID in query string."; }
        else {
                $UserID = $_GET["UserID"];
                echo "<h1>Workouts for User: " . $UserID . "</h1>\n";


        //Last Workout
        //$sql = "SET @LWD = (SELECT wd.Name FROM chehet25.WorkoutDay wd WHERE wd.WorkoutDayID = chehet25.last_workout_day(:UserID));";
        //$sql .= "SET @NWD = (SELECT wd.Name FROM chehet25.WorkoutDay wd WHERE wd.WorkoutDayID = chehet25.next_workout_day(:UserID));";
        $sql = "select u.Name as 'Fitness User', ";
        $sql .= "(concat((select wd.Name from chehet25.WorkoutDay wd where wd.WorkoutDayID = chehet25.last_workout_day(:UserID)), ' - ', muscles_worked(chehet25.last_workout_day(:UserID)))) as 'Last Workout', ";
        $sql .= "(concat((select wd.Name from chehet25.WorkoutDay wd where wd.WorkoutDayID = chehet25.next_workout_day(:UserID)), ' - ', muscles_worked(chehet25.next_workout_day(:UserID)))) as 'Next Workout' ";
        $sql .= "from chehet25.User u where u.UserID = :UserID;";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':UserID', $UserID, PDO::PARAM_STR);
        $stmt->execute();

        foreach($stmt->fetchAll() as $row) {
                 echo "<p><b>Fitness User:</b> " . $row['Fitness User'] . "</p>\n";
                 echo "<p><b>Last Workout:</b> " . $row['Last Workout'] . "</p>\n";
                 echo "<p><b>Next Workout:</b> " . $row['Next Workout'] . "</p>\n";

        }
        }
?>
