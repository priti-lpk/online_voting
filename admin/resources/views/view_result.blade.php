<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>View Result</title>

        <!-- Custom fonts for this template-->
        <link href="{{ asset('public/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

        <!-- Page level plugin CSS-->
        <link href="{{ asset('public/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
        <link href="{{ asset('public/vendor/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="{{ asset('public/css/sb-admin.css') }}" rel="stylesheet">
    </head>

    <body id="page-top">

        @include('topbar')
        <div id="wrapper">

            <!-- Sidebar -->
            @include('sidebar')
            <div id="content-wrapper">

                <div class="container-fluid">

                    <!-- Breadcrumbs-->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="">View Result</a>
                        </li>

                    </ol>

                    <!-- Icon Cards-->
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-table"></i>&nbsp;View Result</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>

                                            <th>#</th>
                                            <th>Position</th>
                                            <th>Name</th>
                                            <th>Total Vote</th>
                                            <!--<th></th>-->

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($getdata as $vote) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $vote->position_name ?></td>
                                                <td><?php echo $vote->first_name . " " . $vote->last_name ?></td>
                                                <td><?php echo $vote->position ?></td>
    <!--                                                <td></td>-->
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar"></i>
                                    Result of Voting
                                </div>
                                <?php
                                $position = array();
                                $tvote = array();
                                foreach ($getdata as $data) {
//                                    print_r($data);
                                    if ($data->position_name == '') {
                                        $position[] = '';
                                    } else {
                                        $position[] = $data->position_name;
                                    }
                                }
//                                print_r($position);
                                $pos = json_encode($position);
                                foreach ($getdata as $total) {
                                    $tvote[] = $total->position;
                                }
                                $vot = json_encode($tvote);
//                                print_r($vot);
                                ?>
                                <div class="card-body">
                                    <canvas id="myBarChart" width="100%" height="50"></canvas>
                                </div>
                                <?php
                                $date = "Last modified: " . date("j M Y G:i A.", getlastmod());
                                ?>
                                <div class="card-footer small text-muted">Updated <?php echo $date; ?></div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

                <!-- Sticky Footer -->
                @include('footer')
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /#wrapper -->


        <!-- Bootstrap core JavaScript-->
        <script src="{{ asset('public/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('public/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{ asset('public/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

        <!-- Required datatable js -->
        <script src="{{ asset('public/vendor/datatables/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <!-- Buttons examples -->
        <script src="{{ asset('public/vendor/datatables/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/jszip.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/pdfmake.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/vfs_fonts.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/buttons.print.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/buttons.colVis.min.js') }}"></script>
        <!-- Responsive examples -->
        <script src="{{ asset('public/vendor/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/responsive.bootstrap4.min.js') }}"></script>

        <script src="{{ asset('public/js/datatables.init.js') }}"></script>
        <!-- Custom scripts for all pages-->
        <script src="{{ asset('public/js/sb-admin.min.js') }}"></script>
        <script src="{{ asset('public/vendor/chart.js/Chart.min.js') }}"></script>

        <!-- Demo scripts for this page-->
        <script src="{{ asset('public/js/demo/datatables-demo.js') }}"></script>
        <!--<script src="{{ asset('public/js/select2/select2.min.js') }}"></script>-->
        <!--<script src="{{ asset('public/js/demo/chart-bar-demo.js') }}"></script>-->

        <script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart Example
var ctx = document.getElementById("myBarChart");
//var position = [];
//var name=[];
//var data =<?php // echo $pos       ?>;
//console.log(data[0]);
//for (var i in data) {
//    position.push("total " + data[i].position_name);
////    name.push(data[i].position);
//}
var myLineChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo $pos ?>,
        datasets: [{
                label: "Revenue",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: <?php echo $vot ?>,
            }],
    },
    options: {
        scales: {
            xAxes: [{
                    time: {
                        unit: 'month'
                    },
                    gridLines: {
                        display: false
                    },
//                    ticks: {
//                        maxTicksLimit: 6
//                    }
                }],
            yAxes: [{
                    ticks: {
                        min: 0,
//                        max: 15000,
//                        maxTicksLimit: 5
                    },
                    gridLines: {
                        display: true
                    }
                }],
        },
        legend: {
            display: false
        }
    }
});

        </script>
    </body>

</html>
