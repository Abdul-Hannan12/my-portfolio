<?php

include './includes/header.php';
include './api/auth.php';
$data_fetched = new auth();
$role = $_SESSION['role'];
$bid = $_SESSION['bid'];

?>

<div class="container-fluid pt-4 px-4">
    <h3>Visitors</h3>
    <div class="chart">
        <div class="col-lg-8 p-2 bg-light card"><canvas id="myChart"></canvas></div>
    </div>
</div>

<?php include './includes/footer.php' ?>

<script>

    var xValues = ["1-may", "2-may", "3-may", "4-may", "5-may", "6-may", "7-may", "8-may", "9-may", "10-may", "11-may", "12-may", "13-may", "14-may", "15-may"];

    new Chart("myChart", {
        type: "line",
        data: {
            labels: xValues,
            datasets: [
                {
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    borderColor: "blue",
                    fill: false
                },
             ],
        },
        options: {
            legend: {
                display: false
            }
        }
    });

</script>
