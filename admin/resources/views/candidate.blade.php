<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Candidates</title>

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
                            <a href="">Candidate</a>
                        </li>

                    </ol>

                    <!-- Icon Cards-->
                    <div class="row">
                        <div class="col-xl-10">

                            <form action="<?php echo (isset($getdata)) ? URL('edit_candidate/' . $getdata[0]->id) : URL('add_candidate'); ?>" method="post" enctype="multipart/form-data">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Position</label>
                                    <div class="col-sm-10">
                                        <select type="text" class="form-control select2 chosen" id = "cat" name = "position_id" required=""/>
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
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">First Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id = "first_name" name = "first_name" value="<?php echo (isset($getdata) ? $getdata[0]->first_name : ''); ?>" required=""/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Last Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id = "last_name" name = "last_name" value="<?php echo (isset($getdata) ? $getdata[0]->last_name : ''); ?>" required=""/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Image</label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input form-control" name="image"  value="<?php echo (isset($getdata) ? $getdata[0]->image : ''); ?>">
                                            <label class="custom-file-label"  for="customFile"><?php echo (isset($getdata) ? $getdata[0]->image : 'Choose Image'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Symbol</label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input form-control" name="symbol"  value="<?php echo (isset($getdata) ? $getdata[0]->symbol : ''); ?>">
                                            <label class="custom-file-label"  for="customFile"><?php echo (isset($getdata) ? $getdata[0]->symbol : 'Choose Symbol'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">  
                                    <div class="col-sm-2"> </div>
                                    <div class="col-sm-10">
                                        <button  type="submit" id='submit-button' class="btn btn-primary btn-block w-md waves-effect waves-light"><?php echo (isset($getdata) ? 'Update' : 'Save'); ?></button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-table"></i>&nbsp;View Candidate</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Position</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Image</th>
                                            <th>Symbol</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $k = 1;
                                        foreach ($candidate as $can) {
                                            echo "<tr>";
                                            echo "<td>" . $k++ . "</td>";
                                            echo "<td>" . $can->position_name . "</td>";
                                            echo "<td>" . $can->first_name . "</td>";
                                            echo "<td>" . $can->last_name . "</td>";
                                            if (is_file($can->image)) {
                                                $FileDetails = stat($can->image);
                                                echo '<td><img src="' . url($can->image) . '?MT=' . dechex($FileDetails['mtime']) . '" style="width:50px; height:50px;"/></td>';
                                            } else {
                                                echo "<td><img src='" . url($can->image) . "' alt='image' style='width:50px; height:50px;'></td>";
                                            }
                                            if (is_file($can->symbol)) {
                                                $FileDetails = stat($can->symbol);
                                                echo '<td><img src="' . url($can->symbol) . '?MT=' . dechex($FileDetails['mtime']) . '" style="width:50px; height:50px;"/></td>';
                                            } else {
                                                echo "<td><img src='" . url($can->symbol) . "' alt='image' style='width:50px; height:50px;'></td>";
                                            }
                                            ?>
                                        <td><a href='<?php echo route('candidate.edit', $can->id) ?>' class='btn btn-primary waves-effect waves-light'>Edit</a>&nbsp;
                                            <a href='<?php echo route('candidate.delete', $can->id) ?>' class='btn btn-primary waves-effect waves-light'>Delete</a></td>
                                            <?php
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
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
        <script src="{{ asset('public/vendor/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('public/vendor/datatables/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('public/js/datatables.init.js') }}"></script>
        <script type="text/javascript">
$(document).ready(function () {
    $('.chosen').select2();
});

        </script>
    </body>
</html>
