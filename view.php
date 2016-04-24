<?php

include('connectionData.php');

// Create connection
$sql_con = new mysqli($server, $username, $password, $dbname, $port);

// Check connection
if ($sql_con->connect_error) {
    die("Connection failed: ".$sql_con->connect_error);
} 

//$sql = 
?>

<!DOCTYPE html>
<html>
    <head>
        <title>SafeRide Schedule</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href="dashboard.css" rel="stylesheet">
    </head>

    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="http://pages.uoregon.edu/saferide/">Safe Ride</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li><a href="http://pages.uoregon.edu/saferide/aboutus.html">About</a></li>
                        <li><a href="http://pages.uoregon.edu/saferide/aboutus.html">Contact</a></li>
                        <li><a href="addNewRider.html">Form</a></li>
                    </ul>
                  
                    <ul class="nav navbar-nav navbar-right">
                        
                        
                        <li><a href="logoff.html">Logout</a></li>
                    </ul>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li class="active"><a href="view-test.php">Schedule</a></li>
                        <li><a href="addNewRider.html">Add New Rider</a></li>
                    </ul>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header ">Dispatcher's Schedule -
                        <script type="text/javascript">
                            var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                            var currentTime = new Date()
                            var month = currentTime.getMonth()
                            var day = currentTime.getDate()
                            var year = currentTime.getFullYear()
                            document.write(monthNames[month] + " " + day + "," + year)
                        </script>
                    </h1>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <!-- <th>ID</th> -->
                                    <th>Time Requested</th>
                                    <th>Rider's Name</th>
                                    <th>UO ID #</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Pick Up Time</th>
                                    <th>Party #</th>
                                    <th>Pick Up</th>
                                    <th>Dropoff</th>
                                    <th>Comments</th>
                                    <th>Vehicle #</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    $user_name = $_POST['username'];
                                    $pwd = $_POST['password'];

                                    if ($stmt = $sql_con->prepare("SELECT full_name, uoid, email, phone, pickup_time, party, pickup, dropoff, comments, vehicle_no, color, time_stamp, ID from schedules order by pickup_time"));
                                    $stmt->execute();
                                    $stmt->bind_result($name, $uoid, $email, $phone, $pickup_time, $party, $pickup, $dropoff, $comments, $vehicle_no, $color, $time_stamp, $id);

                                    $counter = 0; //########### added this to make unique ids ###########

                                    while ($stmt->fetch()){
                                        if ($color == 'green'){
                                            echo "<tr class='success' id = $counter>";

                                        }
                                        else {
                                            echo "<tr class='danger' id = $counter>";
                                        }
                                        // echo "<td class='editable-col' col-index='0' id=0 >$id</td>"    
                                        echo "<td class='editable-col' col-index='0' name='0' >$time_stamp</td>";
                                        echo "<td class='editable-col' col-index='1' name='1' >$name</td>";
                                        echo "<td class='editable-col' col-index='2' name='2' >$uoid</td>";
                                        echo "<td class='editable-col' col-index='3' name='3' >$email</td>";
                                        echo "<td class='editable-col' col-index='4' name='4' >$phone</td>";
                                        echo "<td class='editable-col' col-index='5' name='5' >$pickup_time</td>";
                                        echo "<td class='editable-col' col-index='6' name='6' >$party</td>";
                                        echo "<td class='editable-col' col-index='7' name='7' >$pickup</td>";
                                        echo "<td class='editable-col' col-index='8' name='8' >$dropoff</td>";  
                                        echo "<td class='editable-col' col-index='9' name='9' >$comments</td>";
                                        echo "<td class='editable-col' col-index='10' name='10' >$vehicle_no</td>";
                                        echo "<td><button class='btn btn-default' id='editButton' onclick = foo('$counter')>Modify</button></td>";
                                        echo "<td><button class='btn btn-default' id='saveButton' onclick = save('$counter')>Save</button></td>";
                                        // echo "<td><a href='delete_entry.php?id=$id'>Cancel Request</a></td>";
                                        echo "<td><button type='button' class='btn btn-default' onclick='deleteRow($id)'> X </button></td>";
                                        echo "</tr>";
                                        $counter++;
                                    }
                                    $sql_con->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="deleteAll()">Clear All Data</button>
                </div>


                <!-- Jenny -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
                <script>
                 function foo(arg){
                 	console.log('Button clicked  ' + arg);
	                var row = document.getElementById(arg);
                    var ebutt = document.getElementById('editButton');

                    console.log('row: ' + row);

                    row.contentEditable = true;
                    //console.log('Made it past the contentEditable thing');
                    ebutt.contentEditable = false;
                    row.focus();
                    
                 }
                 
                 function save(arg){
                 	var row = document.getElementById(arg);
                 	row.contentEditable = false;
                 	
                 	
                 	var indexArray = [];
                    for (i = 0; i<11; i++){
                        indexArray[i] = i;
                    }
                    
                    $(document).ready(function(){
                        //$(row).on('focusout', function() {
                            $.each(indexArray, function(ind, value){
                                var cells = document.getElementsByName(value);
                                var element = cells[arg];
                                
                                data = {};
                                data['val'] = $(element).text();
                                //console.log("data val: ");
                                //console.log(data['val']);
                                data['id'] = arg;
                                //console.log(data['id']);
                                data['index'] = $(element).attr('name');
                                //console.log(data['index']);
                                debugger;
                                $.ajax({   
                                  type: "POST",  
                                  url: "update.php", 
                                  cache:false,  
                                  data: data,
                                  dataType: "json",     
                                  
                                  success: function(response)  
                                  {   
                                    if(response.status) {
                                      $("#msg").removeClass('alert-danger');
                                      $("#msg").addClass('alert-success').html(response.msg);
                                    } else {
                                      $("#msg").removeClass('alert-success');
                                      $("#msg").addClass('alert-danger').html(response.msg);
                                    }
                                  },
                                  error: function(response)
                                  {
                                  debugger;
                                  }
                                });   
                                //console.log(JSON.stringify("#msg"));
                            });
                    });
                 	
                 	
                 	
                 	
                 }
                </script>
                
                <!--
                <script type="text/javascript">
                //     $(function() {

                //         $(".delbutton").click(function() {
                //             var del_id = $(this).attr("id");
                //             var info = 'id=' + del_id;
                //             if (confirm("Delete this post? This cannot be undone.")) {
                //                 $.ajax({
                //                     type : "POST",
                //                     url : "delete_entry.php", //URL to the delete php script
                //                     data : info,
                //                     success : function() {
                //                     }
                //                 });
                //                 $(this).parents(".record").animate("fast").animate({
                //                     opacity : "hide"
                //                 }, "slow");
                //             }
                //             return false;
                //         });
                //     });
                </script>

                  -->

                <script type="text/javascript">
                    function deleteRow(id){

                       if (confirm("Are you sure? If yes, click OK.")){
                            $.post("delete_entry.php?id="+id); 
                            window.location.reload();
                        } 
                    }

                    function deleteAll() {
                        if (confirm("Are you sure? If yes, click OK.")){
                            $.post("delete_all.php"); 
                            window.location.reload();
                        }
                    }

                </script>
                
            </div>
        </div>
    </body>
</html>
