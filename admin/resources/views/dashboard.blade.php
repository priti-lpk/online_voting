<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Dashboard</title>

        <!-- Custom fonts for this template-->
        <link href="{{ asset('public/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

        <!-- Page level plugin CSS-->
        <link href="{{ asset('public/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

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
                            <a href="{{ url('dashboard') }}">Dashboard</a>
                        </li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 mb-3">
                            <div class="card text-white o-hidden h-100" style="background-color:#007bff !important">
                                <div class="card-body">
                                    <div class="card-body-icon">
                                        <i class="fas fa-fw fa-life-ring"></i>
                                    </div>
                                    <?php
                                    foreach ($user as $vote) {
                                        ?>
                                        <div class="mr-5">Total Users: <b><?php echo $vote->total; ?></b></div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <a class="card-footer text-white clearfix small z-1" href="{{ url('view_user') }}">
                                    <span class="float-left">View Details</span>
                                    <span class="float-right">
                                        <i class="fas fa-angle-right"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <?php
                        $ldate = date('Y-m-d');
                        date_default_timezone_set('Asia/Kolkata');
                        $time = date("H:i:s");
                        $election = DB::select("select election_table.*,COUNT(voting_table.election_id) as total from voting_table inner join election_table on voting_table.election_id=election_table.id  where election_type = 'private' AND election_table.election_date='" . $ldate . "' group by voting_table.election_id");
                        $count = count($election);
                        for ($i = 0; $i < $count; $i++) {
                            if ($election[$i]->start_time < $time && $election[$i]->end_time > $time) {
                                ?>
                                <div class="col-xl-3 col-sm-6 mb-3">
                                    <div class="card text-white o-hidden h-100" style="background-color:#007bff !important">
                                        <div class="card-body">
                                            <div class="card-body-icon">
                                                <i class="fas fa-fw fa-life-ring"></i>
                                            </div>
                                            <div class="mr-5">Current Election: <b><?php echo $election[$i]->election_name; ?></b></div>
                                        </div>
                                        <a class="card-footer text-white clearfix small z-1" href="">
                                            <?php
                                            if (empty($election)) {
                                                ?>
                                                <span class="float-left">Total Vote: </span>
                                                <?php
                                            } else {
                                                ?>
                                                <span class="float-left">Total Vote: <b><?php echo $election[$i]->total; ?></b></span>
                                                <?php
                                            }
                                            ?>
                                            <span class="float-right">
                                                <i class="fas fa-angle-right"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
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

        <!-- Page level plugin JavaScript-->
        <script src="{{ asset('public/vendor/chart.js/Chart.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/dataTables.bootstrap4.js') }}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{ asset('public/js/sb-admin.min.js') }}"></script>

        <!-- Demo scripts for this page-->
        <script src="{{ asset('public/js/demo/datatables-demo.js') }}"></script>
        <script src="{{ asset('public/js/demo/chart-area-demo.js') }}"></script>

    </body>

</html>
