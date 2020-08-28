<html>
    <head>
        <style type='text/css'>
            body{
                font-size:15px; 
            }
            .container{
                width:500px;
                padding: 10px;
                line-height: 1.3;
                font-family: Verdana;
            } 
            .subhead{
                color: #434343;
            }
            span{
                color: #434343;
            }
            hr{
                border: 1px solid #00b99b;
            }
        </style>
    </head>
    <body>
        <div class='container' style='width:600px;'>
            <table style='padding: 10px;border: 1px solid #d2d2d2; font-size: 17px;' width='100%' border='0' cellspacing='0' cellpadding='0'>
                <tr> 
                    <td class='subhead'>
                        <h3><b>You Voting Details</b></h3>
                        <p><b>Your Email:</b> <?php echo $data['email']; ?></p>
                        <p><b>Your Password:</b> <?php echo $data['password']; ?></p>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
