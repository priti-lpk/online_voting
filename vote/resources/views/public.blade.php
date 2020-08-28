<!DOCTYPE html>
<html>
    <head>

        <style type="text/css">
            body{
                background-color: #bdbdbd;
                color: #757575;
            }
            .container {
                width: 100%;
                padding-right: 15px;
                padding-left: 15px;
                margin-right: auto;
                margin-left: auto;
                margin-top: 7%;
            }

            @media (min-width: 1200px){
                .container {
                    max-width: 1140px;
                }
            }

            @media (min-width: 992px){
                .container {
                    max-width: 960px;
                }
            }

            @media (min-width: 768px){
                .container {
                    max-width: 720px;
                }
            }

            @media (min-width: 576px){
                .container {
                    max-width: 540px;
                }
            }

            .row {
                display: flex;
                flex-wrap: wrap;
                margin-right: -15px;
                margin-left: -15px;
            }
            h1{
                text-align: center;
                color: #4a4a4a;
                margin-bottom: 40px;
            }

            h3{
                color: #4a4a4a;
            } 


            form{
                width: 100% !important;
            }

            form.example input[type=text] {
                padding: 10px;
                font-size: 17px;
                border: 1px solid grey;
                float: left;
                width: 85%;
                background: #f1f1f1;
                height: 20px;
            }

            form.example select{

                float: left;
                width: 80%;
                color: #757575;

            }

            form.example button {
                float: left;
                width: 10%;
                height: 42px;
                padding: 10px;
                background: #2196F3;
                color: white;
                font-size: 17px;
                border: 1px solid #2196F3;
                border-left: none;
                cursor: pointer;
            }



            form.example button:hover {
                background: #000;
            }

            .filterElements{
                width: 80%;
                height: 42px;
            }

            .filterElements option{
                height: 20px !important;
            }

            table, th, td {
                border: 1px solid grey;
            }

            table {
                border-collapse: collapse;
                border-spacing: 0;
                width: 100%;
                background-color: #fff;
                border: 1px solid grey;
                text-align: center;
            }

            th, td {
                padding: 8px;
            }

            .radioBtn {
                display: block;
                position: relative;
                /*padding-left: 35px;*/
                /* margin-bottom: 12px;*/
                cursor: pointer;
                font-size: 20px;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                margin-top: -10px !important;
            }

            /* Hide the browser's default radio button */
            .radioBtn input {
                position: absolute;
                opacity: 0;
                cursor: pointer;
                height: 0;
                width: 0;
            }

            /* Create a custom radio button */
            .checkmark {
                position: absolute;
                top: 0;
                left: 0;
                height: 20px;
                width: 20px;
                background-color: #ccc;
                border-radius: 50%;
            }

            /* On mouse-over, add a grey background color */
            .radioBtn:hover input ~ .checkmark {
                background-color: #aaa;
            }

            /* When the radio button is checked, add a blue background */
            .radioBtn input:checked ~ .checkmark {
                background-color: #2196F3;
            }

            /* Create the indicator (the dot/circle - hidden when not checked) */
            .checkmark:after {
                content: "";
                position: absolute;
                display: none;
            }

            /* Show the indicator (dot/circle) when checked */
            .radioBtn input:checked ~ .checkmark:after {
                display: block;
            }

            /* Style the indicator (dot/circle) */
            .radioBtn .checkmark:after {
                top: 7px;
                left: 7px;
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: white;
            }

            select {
                font-size: .9rem;
                padding: 2px 5px;
                height:42px;
            }
            .submit {

                width: 100%;
                height: 42px;
                padding: 10px;
                margin-top: 15px;
                background: #2196F3;
                color: white;
                font-size: 17px;
                border: 1px solid #2196F3;
                cursor: pointer;
            }



            form.submit button:hover {
                background: #000;
            }

        </style>
    </head>
    <body>
        <div class="container">
            <h1>Voting System</h1>

            <form class="example" action="">
                <!--<input placeholder="Select Position">-->
                <select name="position_id" id="pet-select" class="chosen">
                    <option value="">Select Position</option>
                    <?php
                    foreach ($position as $pos)
                        if (isset($getdata)) {
                            echo "<option  value=" . $pos->id . " " . ($pos->id == $getdata[0]->position_id ? 'selected' : '') . ">" . $pos->position_name . "</option>";
                        } else {
                            echo "<option  value=" . $pos->id . " >" . $pos->position_name . "</option>";
                        }
                    ?>
                </select>


                <button type="submit"><i class="material-icons"><img src="icon/search.png"/></i></button>
            </form>

        </div>

        <div style="overflow-x:auto;" class="container">
            <form action="<?php echo (isset($getdata)) ? URL('edit_position/' . $getdata[0]->id) : URL('add_vote'); ?>" method="post" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <table>
                    <tr>
                        <th>No.</th>
                        <th></th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Symbol</th>
                    </tr>
                    <?php
                    // Turn on output buffering
                    ob_start();
//Get the ipconfig details using system commond
                    system('ipconfig /all');

// Capture the output into a variable
                    $mycom = ob_get_contents();
// Clean (erase) the output buffer
                    ob_clean();

                    $findme = "Physical";
//Search the "Physical" | Find the position of Physical text
                    $pmac = strpos($mycom, $findme);

// Get Physical Address
                    $mac = substr($mycom, ($pmac + 36), 17);
//Display Mac Address
                    echo $mac;

                    if (isset($pos_id)) {
                        ?>
                        <input type = "hidden" name = "position_id" value = "<?php echo $pos_id ?>" >
                        <input type="text" name="mac_address" value="<?php echo $mac ?>">
                        <input type="hidden" name="user_id" value="<?php echo session()->get('userid') ?>">
                        <?php
                        $getdata = DB::select('select * from candidates_table where position_id = ?', [$pos_id]);
                        $i = 1;
                        foreach ($getdata as $can) {
                            ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><input type = 'radio' class = 'create' name="candidates_id" value="<?php echo $can->id ?>"/></td>
                                <td><img src="<?php echo url('../admin/' . $can->image); ?>" id='image-link' alt='image' class='img-responsive' height=50 width=50'></td>
                                <td><?php echo $can->first_name . " " . $can->last_name ?></td>
                                <td><img src="<?php echo url('../admin/' . $can->symbol); ?>" id='image-link' alt='image' class='img-responsive' height=50 width=50'></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </table>
                <?php
                $data = '';
                if (isset($pos_id)) {
                    $address = DB::select('select mac_address from voting_table INNER JOIN position_table ON voting_table.position_id=position_table.id LEFT JOIN election_table ON position_table.election_id=election_table.id where position_id=' . $pos_id . ' and mac_address="' . $mac . '" and election_table.election_type="public"');
                    if ($address == Array()) {
                        ?>
                        <button  type="submit" id='submit-button' class="btn submit">Submit</button>
                        <?php
                    } else {
                        echo "<h4>You are already give vote...!</h4>";
                    }
                }
                ?>
            </form>
        </div>

    </body>
</html>
