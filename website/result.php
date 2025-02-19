<?php

        //Connect to DB
        if (!include('connect.php')) {
           die('error finding connect file');
        }

        $dbh = ConnectDB();
?>

<body>
<div class = 'Muscle Group'>

<?php

        if  (!isset($_GET["muscles"])) {
            echo "No Muscle Detected.";

            }

        else {

                $musc = $_GET["muscles"];
                echo "<h1>Exercise that workout your " . $musc . "</h1>\n";

                $sql = "select fa.Name AS 'Activity', fa.FitnessActivityType AS 'Activity Type', IFNULL(GROUP_CONCAT(wd.Name SEPARATOR '/'), '') AS 'Workout Days' ";
                $sql .= "from FitnessActivity fa ";
                $sql .= "left join Scheduled s on fa.FitnessActivityID = s.FitnessActivityID_Scheduled ";
                $sql .= "left join WorkoutDay wd on s.WorkoutDayID_Scheduled = wd.WorkoutDayID ";
                $sql .= "where fa.PrimaryMuscleGroup = :muscles ";
                $sql .= "group by fa.Name, fa.FitnessActivityType;";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':muscles', $musc, PDO::PARAM_STR);
                $stmt->execute();

                echo "<p>Activity : Activity Type : Workout Days </p>";
                echo"<ol>\n";
                foreach ($stmt->fetchAll() as $row) {
                        echo "<li>"
                        . $row['Activity'] . " : "
                        .  $row['Activity Type'] . " : "
                        . $row['Workout Days'] . "</li>\n";
                }
                echo"</ol>\n";

                echo $stmt->rowCount() . " rows retrieved<br/><br />\n";
            }
?>
            
</div>
</body>
            