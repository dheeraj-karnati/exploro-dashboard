<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">



    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Reserve Forms</title>
    <link rel="apple-touch-icon" href="http://library.marist.edu/images/jac-m.png"/>
    <link rel="shortcut icon" href="http://library.marist.edu/images/jac.png" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="http://library.marist.edu/archives/icon/box.png" />
    <link rel="stylesheet" type="text/css" href="http://library.marist.edu/css/library.css" />
    <link rel="stylesheet" type="text/css" href="http://library.marist.edu/css/library_child.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" src="js/dropzone.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

        });
        $('button#initiate').click(function () {

            if ($('input#files')[0]) {
                var filesize = $('input#files')[0].size / 1024 / 1024;
                if (filesize <= 8.0) {
                    var form_data = new FormData();

                    if ($('input#files')[0]) {

                        form_data.append('files', $('input#files')[0]);
                    }
                }
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url("?c=exploro-dashboard&m=uploadFiles");?>",
                        data: form_data,
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function (data) {
                            if (data > 0) {

                                alert("Folder has been uploaded successfully");
                                //  $('#requestStatus').show().css('background', '#66cc00').append("#" + data + ": File has been uploaded successfully");

                            } else {

                                alert("Failure: Something went wrong. Please contact administrator");

                                // $('#requestStatus').show().css('background', '#b31b1b').append("Something went wrong.Please contact adminstrator");

                            }

                        }

                    });
                } else {
                    e.preventDefault();
                    alert("uploaded file size should be less than 2MB");

                }


            });

    </script>

</head>
<body>
<!--<div>
<form action="uploadfolder.php" class="dropzone">
    <div class="fallback">
        <input name="file" type="file" multiple />
    </div>
</form>
</div>-->

<form action="uploadfolder.php" class="dropzone">
    <div class="fallback">
<input type="file" name="files[]" id="files" multiple>
        </div>
</form>
<!--<footer>
    <p class = "foot">
        James A. Cannavino Library, 3399 North Road, Poughkeepsie, NY 12601; 845.575.3106
        <br />
        &#169; Copyright 2007-2016 Marist College. All Rights Reserved.

        <a href="http://www.marist.edu/disclaimers.html" target="_blank" >Disclaimers</a> | <a href="http://www.marist.edu/privacy.html" target="_blank" >Privacy Policy</a> | <a href="http://library.marist.edu/ack.html?iframe=true&width=50%&height=62%" rel="prettyphoto[iframes]">Acknowledgements</a>
    </p>
</footer>-->
</body>
<?php


?>
</html>
