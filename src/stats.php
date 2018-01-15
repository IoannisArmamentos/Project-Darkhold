<?php
include_once 'utilities/connectWithDB.php';
$query1 ="SELECT thesis_state.description,plithos_per_state.plithos as plithos ,(plithos_per_state.plithos / COUNT(thesis.teacher_id)) * 100 as pososto FROM plithos_per_state,thesis,thesis_state where thesis_state.id=plithos_per_state.state GROUP by plithos_per_state.state";
$query2="SELECT COUNT(thesis.teacher_id) as plithos FROM thesis,user where thesis.teacher_id=user.id ";
$query3="SELECT COUNT(thesis.teacher_id) as plithos_parous 
FROM thesis WHERE month(thesis.completion_date)=month(CURRENT_TIMESTAMP) and YEAR(thesis.completion_date) = YEAR(CURRENT_TIMESTAMP) and thesis.state=4";

$result1 = mysqli_query($link, $query1);
$result2 = mysqli_query($link, $query2);
$result3 = mysqli_query($link, $query3);



$rows1 = array();
while ($query1 = mysqli_fetch_array($result1)) {
//    $f_name = $query['f_name'];
//    $l_name = $query['l_name'];
    $count = $query1['plithos'];
    $name = $query1['description'];
    // input data into data structure
    // typecast count as integer so it doesn't get interpreted as a string
    $rows1[] = array($name, (int)$count);
}
$data = json_encode($rows1);

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
        google.setOnLoadCallback(piechart);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function piechart() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'description');
            data.addColumn('number', 'plithos');
            data.addRows(<?php echo $data; ?>);


            // Set chart options
            var options = {
                'title': 'Ποσοστο διπλωματικων ανα ειδος', 'width': 800,
                'height': 400
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart'));
            chart.draw(data, options);
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
    <div id="chart" align="center"></div>
    <div id="statistika" align="center">
    <h4 >Στατιστικά Στοιχεία</h4>
    <?php
    while($query2 = mysqli_fetch_array($result2)) {
        $countp = $query2['plithos'];
        $str="Το σύνολο των διπλωματικών που έχουν δημιουργηθεί είναι:";
        echo $str."".$countp;

    }
    ?>
       <br>
     <?php
        while($query3 = mysqli_fetch_array($result3)) {
            $count_pou_parousiazetai = $query3['plithos_parous'];
            $str="Tο πλήθος των διπλωματικών που παρουσιάζονται στον τρέχοντα μήνα είναι:";
            echo $str."".$count_pou_parousiazetai;
        }
        ?>
    </div>
</div>
</body>

</html>