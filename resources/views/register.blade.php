<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>User Register</title>

        <!-- Custom fonts for this template-->
        <link href="{{ asset('public/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('public/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="{{ asset('public/css/sb-admin.css')}}" rel="stylesheet">

    </head>

    <body class="bg-dark">

        <div class="container">
            <div class="card card-register mx-auto mt-5">
                <div class="card-header">Register an Account</div>
                <div class="card-body">
                    <form method="post" action="{{ URL::to('/add_register') }}">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="text" id="firstName" class="form-control" placeholder="First name" name="firstname" required="required" autofocus="autofocus">
                                        <label for="firstName">First name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="text" id="lastName" class="form-control" placeholder="Last name" name="lastname" required="required">
                                        <label for="lastName">Last name</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <input type="email" id="email_id" class="form-control" placeholder="Email address" name="email_id" autofocus="autofocus" onblur="chkemail();">
                                <label for="inputEmail">Email address</label>
                            </div>
                            <div class = "col-md-12">
                                <p id = 'waitFor'></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="password" id="new_pwd" class="form-control" placeholder="Password" name="password" required="required" onblur="test_str();">
                                        <label for="inputPassword">Password</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="password" id="con_pwd" class="form-control" placeholder="Confirm password" required="required">
                                        <label for="confirmPassword">Confirm password</label>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-md-12">
                                <p id = 'compare'></p>
                            </div>
                        </div>
                        <!--                        <div class="form-group">
                                                    <div class="form-row">
                                                        <div class="col-md-6">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input form-control" name="image">
                                                                <label class="custom-file-label"  for="customFile">Choose Profile</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>-->
                        <button type="submit" class="btn btn-primary btn-block" id="myBtn">Register</button>
                    </form>
                </div>
            </div>
        </div>

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
        <script>
                                            $('#con_pwd').on('blur', function () {
                                                if ($('#new_pwd').val() != $('#con_pwd').val())
                                                {
                                                    $('#compare').html('Both passwords mismatched!');
                                                    bothMatched = 0;
                                                } else
                                                {
                                                    $('#compare').css('color', 'green');
                                                    $('#compare').html('Passwords matched');
                                                    bothMatched = 1;
                                                }
                                                if ($('#con_pwd').val() == '')
                                                {
                                                    $('#compare').html('confirm password can not be blank!');
                                                    bothMatched = 0;
                                                }
                                            });
        </script>
        <script type="text/javascript">
            function chkemail()
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var ele = document.getElementById("email_id").value;
                var dataString = 'email=' + ele;
                $.ajax
                        ({
                            url: "<?php echo URL('checkemail') ?>",
                            type: 'POST',
                            data: dataString,
                            success: function (html)
                            {
//                                alert(html);
                                if (html == 1)
                                {
                                    $('#waitFor').html('EmailId matched..! Please Another Email Add..!');
                                    document.getElementById("myBtn").disabled = true;
                                } else {
                                    $('#waitFor').html('');
                                    document.getElementById("myBtn").disabled = false;
                                }
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
            function test_str() {
                var res;
                var str = document.getElementById("new_pwd").value;
                if (str.match(/[a-z]/g) && str.match(
                        /[A-Z]/g) && str.match(
                        /[0-9]/g) && str.match(
                        /[^a-zA-Z\d]/g)) {
                    res = "Correct Password";
                    document.getElementById("myBtn").disabled = false;
                    alert(res);
                } else {
                    res = "Please..!! must contain one Uppercase, Special character & number.";
                    document.getElementById("myBtn").disabled = true;
                    alert(res);
                }
//                document.getElementById("t2").value = res;

            }
        </script>
    </body>

</html>
