<?php

include './includes/header.php';
include './api/auth.php';
$data_fetched = new auth();

?>

<div class="container-fluid pt-4 px-4">
    <h4 class="mb-3">Visitors</h4>
    <div class="chart mb-4">
        <div class="col-lg-8 p-2 bg-light card"><canvas id="myChart"></canvas></div>
    </div>
    
    <h4 class="mb-3">Messages</h4>
    <table class="table table-hover mb-4 border border-rounded">
  <thead>
  </thead>
  <tbody>
    <tr role="button">
      <td class="col-2"><strong>Name</strong></td>
      <td class="col-2">Subject</td>
      <td class="col text-truncate">  Officiis odio nisi ipsam, aspernatur, culpa nobis provident amet pariatur quas illum exercitationem impedit, ipsum facilis! lorem</td>
    </tr>
  </tbody>
</table>

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
