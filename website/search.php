<html>
<head>
        <title>Muscle Groups Worked Out</title>
</head>

<?php
        //Connect to the database

        if (!include('connect.php')) {
           die('error finding connect file');
           }
        $dbh = ConnectDB();
?>

<body>
<h1>Muscle Groups</h1>
<div class="form">
<form action="result.php" method="get">

<h2>Choose A Muscle You Want To Work Out</h2>
<select id='muscles' name='muscles'>

<?php

        //Dropdown menu for muscle groups
        $sql = "select distinct fa.PrimaryMuscleGroup ";
        $sql .= "from FitnessActivity fa;";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        //Loop through the rows to find all the values for muscle name
        foreach ($stmt->fetchAll() as $row) {

           echo '<option value="' . $row['PrimaryMuscleGroup'] . '">' . $row['PrimaryMuscleGroup'] . '</option>' . "\n";
        }
        ?>

        </select>
<p><input type='submit' value='Submit'></p>

</form>

</body>
</html>
