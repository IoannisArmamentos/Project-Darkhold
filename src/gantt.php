<html>
<head>
    <?php
    include_once "page_parts/head.php";
    ?>

</head>
<body class="container">
<?php
include_once "page_parts/header.php";
?>

<?php
include_once "page_parts/login_checker.php";
?>


<div class="page_content">

</div>


<div class="form-group">
    <label for="thesis-selector">Διαθέσιμες Διπλωματικές:</label>
    <div class="input-group">

            <?php
            $selected_student = $_SESSION['user_id'];


            $s="SELECT * FROM thesis WHERE teacher_id=$selected_student AND state>1" ;
            $result1=$link->query($s);
            echo "<table  border='3' width='70%'>";

            if(mysqli_query($link,$s)){

                while($row1=$result1->fetch_assoc()){
                    $title=$row1['id'];

                    $publish=$row1['publication_date'];
                    $assign=$row1['assignment_date'];
                    $complete=$row1['completion_date'];
                    echo "<tr><th>Τίτλος </th>  <th> Περιγραφή </th>  <th> Βαθμός </th> <th> Στάδιο Κατάστασης</th> </tr>" ;
                    echo "<tr><td>" .$row1['title']. "</td><td>" . $row1['description'] . "</td><td>". $row1['grade'] . "</td><td>" . $row1['state'] . "</td>";
                    echo'<p> <form action="" method="post" enctype="multipart/form-data">';
                    echo'<input type="hidden" id=" publish" name="publish" value='. $publish.'>';
                    echo'<input type="hidden" id=" assign" name="assign" value='. $assign.'>';
                    echo'<input type="hidden" id="complete" name="complete" value='. $complete.'>';
                    echo'<td><button type="submit" name="submit" onclick="drawChart()" class="btn btn-danger">CHOOSE CHART!</button></td></tr>';
                    echo'</form>';



                }

            }

            if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
                $publish =$_POST['publish'];
                $assign =$_POST['assign'];
                $complete =$_POST['complete'];
                echo"<br>publish: ".$publish ;
                echo"<br>assign: ".$assign ;
                echo"<br>complete: ".$complete ;
?>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages': ['gantt']});
        google.charts.setOnLoadCallback(drawChart);

        function daysToMilliseconds(days) {
            return days * 24 * 60 * 60 * 1000;
        }

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Task ID');
            data.addColumn('string', 'Task Name');
            data.addColumn('date', 'Ημερομηνία Έναρξης');
            data.addColumn('date', 'Ημερομηνία Ολοκλήρωσης');
            data.addColumn('number', 'Διάρκεια');
            data.addColumn('number', '% complete');
            data.addColumn('string', 'Dependencies');

            data.addRows([
                ['Research', 'Δεν έχουν ανατεθεί',
                    new Date(<?php echo $publish?>), new Date(<?php echo $assign?>), daysToMilliseconds(4), 10, null],
                ['Write', 'Yπο έγκριση',
                    new Date(<?php echo $assign?>),null, daysToMilliseconds(1),20 , 'Research'],
                ['Cite', 'Έχουν ανατεθεί',
                    new Date(<?php echo $assign?>), new Date(<?php echo $complete?>), daysToMilliseconds(64), 90, 'Research'],
                ['Complete', 'Έτοιμες για παρουσίαση',
                    new Date(<?php echo $complete?>), new Date(<?php echo $complete?>), daysToMilliseconds(20), 95, 'Cite,Write'],
                ['Outline', 'Έχουν ολοκληρωθεί',
                    new Date(<?php echo $assign?>), null, daysToMilliseconds(10), 100, 'Research']
            ]);

            var options = {
                height: 275
            };

            var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
</head>
                <?php
            }
            ?>
<body>
<div id="chart_div">


</div>
</body>
</html>
</body>
</html>

