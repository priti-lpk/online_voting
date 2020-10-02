<?php
//// Turn on output buffering
//ob_start();
////Get the ipconfig details using system commond
//system('ipconfig /all');
//
//// Capture the output into a variable
//$mycom = ob_get_contents();
//// Clean (erase) the output buffer
//ob_clean();
//
//$findme = "Physical";
////Search the "Physical" | Find the position of Physical text
//$pmac = strpos($mycom, $findme);
//
//// Get Physical Address
//$mac = substr($mycom, ($pmac + 36), 17);
//Display Mac Address
//echo $mac;
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>Voting</title>

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
                            <a href="">Voting</a>
                        </li>

                    </ol>

                    <!-- Icon Cards-->
                    <div class="row">
                        <div class="col-xl-10">

                            <form action="" method="get" enctype="multipart/form-data">
                                <!--<input name="_token" type="hidden" value="{{ csrf_token() }}"/>-->
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Election</label>
                                    <div class="col-sm-4" style="margin-left: -40px">
                                        <select type="text" class="form-control select2 chosen" id = "ele_id" name = "election_id" required="" onchange="poschange();"/>
                                        <option>Select Election</option>       
                                        <?php
                                        foreach ($election as $ele)
                                            if (isset($getdata)) {
                                                echo "<option  value=" . $ele->id . " " . ($ele->id == $getdata[0]->election_name ? 'selected' : '') . ">" . $ele->election_name . "</option>";
                                            } else {
                                                echo "<option  value=" . $ele->id . " >" . $ele->election_name . "</option>";
                                            }
                                        ?>
                                        </select>
                                    </div>
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Position</label>
                                    <div class="col-sm-4" style="margin-left: -40px;">
                                        <select type="text" class="form-control select2 chosen" id = "pos_id" name = "position_id" required=""/>
                                        <option>Select Position</option>       
                                        <?php
                                        foreach ($position as $pos)
                                            if (isset($getdata)) {
                                                echo "<option  value=" . $pos->id . " " . ($pos->id == $getdata[0]->position_id ? 'selected' : '') . ">" . $pos->position_name . "</option>";
                                            } else {
                                                echo "<option  value=" . $pos->id . " >" . $pos->position_name . "</option>";
                                            }
                                        ?>
                                        </select>
                                    </div>
                                    <div class = "button-items">
                                        <button type = "submit" id="btn_go" name="btn_go" class = "btn btn-primary waves-effect waves-light"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>  
                            </form>
                            <form action="<?php echo (isset($getdata)) ? URL('edit_position/' . $getdata[0]->id) : URL('add_vote'); ?>" method="post" enctype="multipart/form-data">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th></th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Symbol</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($pos_id) && isset($ele_id)) {
                                            $ldate = date('Y-m-d');
                                            $time = date("h:i:s a", time());
                                            $election = DB::table('election_table')
                                                    ->select('*')
                                                    ->where('election_type', 'private')
                                                    ->where('election_date', $ldate)
                                                    ->get();
                                            foreach ($election as $ele) {
                                                print_r($ele->election_date);
                                                print_r($ldate);
                                                if ($ele->id == $ele_id) {
                                                    if ($ele->election_date == $ldate) {
                                                        
                                                        if ($ele->start_time < $time && $ele->end_time > $time) {
                                                            ?>
                                                        <input type = "hidden" name = "position_id" value = "<?php echo $pos_id ?>" >
                                                        <input type = "hidden" name = "election_id" value = "<?php echo $ele_id ?>" >
                    <!--                                        <input type="hidden" name="mac_address" value="<?php // echo $mac                       ?>">-->
                                                        <input type="hidden" name="user_id" value="<?php echo session()->get('userid') ?>">
                                                        <?php
                                                        $getdata = DB::select('select * from candidates_table where position_id = ?', [$pos_id]);
                                                        $i = 1;
                                                        foreach ($getdata as $can) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i++ ?></td>
                                                                <td><input type = 'radio' class = 'create' name="candidates_id" value="<?php echo $can->id ?>"/></td>
                                                                <td><img src="<?php echo url('admin/' . $can->image); ?>" id='image-link' alt='image' class='img-responsive' height=50 width=50'></td>
                                                                <td><?php echo $can->first_name . " " . $can->last_name ?></td>
                                                                <td><img src="<?php echo url('admin/' . $can->symbol); ?>" id='image-link' alt='image' class='img-responsive' height=50 width=50'></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    } else {
                                                        echo "<h4>Election Complete...!</h4>";
                                                    }
                                                } else {
                                                    echo"AS";
                                                    echo "<h4>Election Complete...!</h4>";
                                                }
                                            }
                                        }
                                        ?>

                                        <?php
//                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>


                                <div class="form-group row">  
                                    <div class="col-sm-2"> </div>
                                    <div class="col-sm-10">
                                        <?php
                                        $data = '';
                                        if (isset($pos_id)) {
                                            $address = DB::select('select user_id from voting_table where position_id=' . $pos_id . ' and user_id=' . session()->get('userid'));
                                            if ($address == Array()) {
                                                ?>
                                                <button  type="submit" id='submit-button' class="btn btn-primary btn-block w-md waves-effect waves-light">Submit</button>
                                                <?php
                                            } else {
                                                echo "<h4>You are already give vote...!</h4>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>

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
        <script src="{{ asset('public/vendor/datatables/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/dataTables.bootstrap4.js') }}"></script>
        <!-- Custom scripts for all pages-->
        <script src="{{ asset('public/js/sb-admin.min.js') }}"></script>
        <!-- Demo scripts for this page-->
        <script src="{{ asset('public/js/demo/datatables-demo.js') }}"></script>
        <script src="{{ asset('public/vendor/select2/select2.min.js') }}"></script>
        <script src="{{ asset('public/js/sb-basic.js') }}"></script>
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
        <!--<script src="{{ asset('public/vendor/datatables/dataTables.responsive.min.js') }}"></script>-->
        <script src="{{ asset('public/vendor/datatables/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('public/js/datatables.init.js') }}"></script>
        <script type="text/javascript">
                                            function poschange()
                                            {
                                                $.ajaxSetup({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    }
                                                });

                                                var ele = document.getElementById("ele_id").value;
                                                var dataString = 'ele_id=' + ele;
//                                                alert(dataString);
                                                $.ajax
                                                        ({
                                                            url: "<?php echo URL('getdata') ?>",
                                                            type: 'POST',
                                                            data: dataString,
                                                            success: function (html)
                                                            {
//                                                                alert(html);
                                                                $("#pos_id").html(html);
                                                            },
                                                            error: function (errorThrown) {
                                                                alert(errorThrown);
                                                                alert("There is an error with AJAX!");
                                                            }
                                                        });
                                            }
                                            ;
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.chosen').select2();
            });

        </script>
    </body>
</html>
