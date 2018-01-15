<?php
include_once 'utilities/connectWithDB.php';
$max_thesis_teacher = "SELECT user.fname , user.lname, COUNT(thesis.teacher_id) AS 'Arithmos diplwmatikwn' FROM `thesis`,user where user.id = thesis.teacher_id and thesis.state=5 GROUP BY thesis.teacher_id ORDER BY COUNT(thesis.teacher_id) DESC";
$average_score_per_teacher = "SELECT AVG(thesis.grade) as 'Mesos oros vathmologiwn',user.lname,user.fname FROM thesis,user WHERE thesis.teacher_id=user.id AND thesis.state = 5 GROUP BY thesis.teacher_id";
$max_thesis_teacher_per_year = "SELECT * FROM thesis_per_user_per_year WHERE arithmos = (SELECT MAX(arithmos)  FROM thesis_per_user_per_year ) GROUP BY etos";
$average_thesis_completion_time = "SELECT round(AVG(DATEDIFF(completion_date,assignment_date))/7) as 'meso diastima',thesis.teacher_id,thesis.assignment_date,thesis.completion_date,user.lname ,user.fname
FROM thesis,user where user.id=thesis.teacher_id and thesis.state = 5 GROUP BY teacher_id";

$result = mysqli_query($link, $max_thesis_teacher);
$result1 = mysqli_query($link, $average_score_per_teacher);
$result2 = mysqli_query($link, $max_thesis_teacher_per_year);
$result3 = mysqli_query($link, $average_thesis_completion_time);
$rows = array();
$rows1 = array(); 
$rows2 = array();
$rows3 = array();
// loop over the results of the query and input data into data structure
while ($max_thesis_teacher = mysqli_fetch_array($result)) {
//    $f_name = $query['f_name'];
//    $l_name = $query['l_name'];
    $count = $max_thesis_teacher['Arithmos diplwmatikwn'];
    $name = $max_thesis_teacher['fname'];
    $name3 = $max_thesis_teacher['lname'];
    // input data into data structure
    // typecast count as integer so it doesn't get interpreted as a string
    $rows[] = array($name." ".$name3, (int)$count);
}
$data = json_encode($rows);

while ($average_score_per_teacher = mysqli_fetch_array($result1)) {
    $count1 = $average_score_per_teacher['Mesos oros vathmologiwn'];
    $name1 = $average_score_per_teacher['lname'];
    $name2 = $average_score_per_teacher['fname'];
    $rows1[] = array($name2 . " " . $name1, (int)$count1);
}
$data1 = json_encode($rows1);

while ($max_thesis_teacher_per_year = mysqli_fetch_array($result2)) {
    $count2 = $max_thesis_teacher_per_year['arithmos'];
    $name2 = $max_thesis_teacher_per_year['etos'];
    $name5 = $max_thesis_teacher_per_year['lname'];
    $rows2[] = array($name2." ".$name5, (int)$count2);
}
$data2 = json_encode($rows2);

while ($average_thesis_completion_time = mysqli_fetch_array($result3)) {
    $count3 = $average_thesis_completion_time['meso diastima'];
    $name3 = $average_thesis_completion_time['fname'];
    $name4 = $average_thesis_completion_time['lname'];

    // input data into data structure
    // typecast count as integer so it doesn't get interpreted as a string
    $rows3[] = array($name3." ".$name4, (int)$count3);
}
$data3 = json_encode($rows3);
?>
<html>

<head>

    <?php
    include_once "page_parts/head.php";
    ?>


    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

        // Load the Visualization API and the piechart package.
        google.load('visualization', '1.0', {'packages': ['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.setOnLoadCallback(max_thesis_teacher_chart);
        google.setOnLoadCallback(average_score_per_teacher_chart);
        google.setOnLoadCallback(max_thesis_teacher_per_year_chart);
        google.setOnLoadCallback(average_thesis_completion_time_chart);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function max_thesis_teacher_chart() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'fname');
            data.addColumn('number', 'Συνολο Διπλωματικων');
            data.addRows(<?php echo $data; ?>);


            // Set chart options
            var options = {
                'title': 'Συνολο Διπλωματικων ανα Καθηγητη', 'width': 800,
                'height': 400
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_channel'));
            chart.draw(data, options);
        }

        function average_score_per_teacher_chart() {


            // Create the data table.
            var data1 = new google.visualization.DataTable();
            data1.addColumn('string', 'fname');
            data1.addColumn('number', 'Μεσος ορος Βαθμολογιων');
            data1.addRows(<?php echo $data1; ?>);

            // Set chart options
            var options1 = {
                'title': 'Μεσος ορος Βαθμολογιων Πτυχιακων ανα Καθηγητη', 'width': 800,
                'height': 400
            };

            // Instantiate and draw our chart, passing in some options.
            var chart1 = new google.visualization.ColumnChart(document.getElementById('chart_channel2'));
            chart1.draw(data1, options1);
        }

        function max_thesis_teacher_per_year_chart() {

            // Create the data table.
            var data2 = new google.visualization.DataTable();


            data2.addColumn('string', 'lname');
            data2.addColumn('number', 'Συνολο Διπλωματικων ανα ετος');
            data2.addRows(<?php echo $data2; ?>);

            // Set chart options
            var options2 = {
                'title': 'Συνολο Διπλωματικων ανα ετος', 'width': 800,
                'height': 400
            };

            // Instantiate and draw our chart, passing in some options.
            var chart2 = new google.visualization.ColumnChart(document.getElementById('chart_channel3'));
            chart2.draw(data2, options2);
        }

        function average_thesis_completion_time_chart() {

            // Create the data table.
            var data3 = new google.visualization.DataTable();


//            data2.addColumn('number', 'etos');


            data3.addColumn('string', 'lname');
            data3.addColumn('number', 'Μεσο Διαστημα');
            data3.addRows(<?php echo $data3; ?>);

            // Set chart options
            var options3 = {
                'title': 'Mέσο διάστημα ολοκλήρωσης πτυχιακής(σε εβδομάδες) ανά καθηγητή', 'width': 800,
                'height': 400
            };

            // Instantiate and draw our chart, passing in some options.
            var chart3 = new google.visualization.ColumnChart(document.getElementById('chart_channel4'));
            chart3.draw(data3, options3);
        }
    </script>
</head>
<body class="conatainer">
<?php
include_once "page_parts/header.php";
?>

<?php
include_once "page_parts/login_checker.php";
?>

<div class="page_content">
    <!--Div that will hold the pie chart-->
    <div id="chart_channel" align="center"></div>
    <div id="chart_channel3" align="center"></div>
    <div id="chart_channel2" align="center"></div>
    <div id="chart_channel4" align="center"></div>

</div>
</body>

</html>