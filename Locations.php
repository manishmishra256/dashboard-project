    <?php 
        
        $username = "root";
        $password = "tajmahal";
        $hostname = "localhost"; 
        $isValid = true;
        $msg  = "";

        $db = new mysqli($hostname, $username, $password, 'dashboard');

        if($db->connect_errno > 0){
            die('Unable to connect to database [' . $db->connect_error . ']');
        }

        if(isset($_REQUEST["name"]) ){

            $id = $_REQUEST["id"];
            $name = $_REQUEST["name"];
            $desc = $_REQUEST["desc"];
            $lat = $_REQUEST["latitude"];
            $long = $_REQUEST["longitude"];


            if(empty($name)){

              $isValid = false;
              $msg =  "Name cannot be left empty";
            }

            if(empty($desc)){

              $isValid = false;
              $msg =  "Description cannot be left empty";
            }

            if(empty($lat)){

              $isValid = false;
              $msg = "Latitude cannot be left empty";
            }

            if(empty($long)){

              $isValid = false;
              $msg = "Longitude cannot be left empty";
            }

            if(empty($id)){
              $id = 0;
            } 

            if($isValid){

              if($id == 0){//insert mode

                  $query = "insert into locations(`Name`, `Description`, `Latitude`, `Longitude`) values('$name','$desc','$lat','$long')";
              }
              else{

                  $query = "update locations set Name = '". $name ."', Description= '". $desc ."', Latitude = '". $lat. "', Longitude = '". $long ."' where id =" . $id;
              }

                mysqli_query($db, $query);
            }

        }

        $result = $db->query("SELECT * FROM locations");
    ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Locations</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
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
          <a class="navbar-brand" href="#">Dashboard Project</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <!-- gutter space-->
      <div class="row" style="height:15px"></div>
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar" style="margin-top:50px;">
          <ul class="nav nav-sidebar">
            <li><a href="index.htm">Users</a></li>
            <li><a href="sites.htm">Sites</a></li>
            <li><a href="locations.php">Locations</a></li>
          </ul>
        </div>
        <div class="col-sm-9">
          <h1 class="page-header">Dashboard 
            <button class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#modalLocation">Add New</button>
          </h1>
            <span class="clearfix"></span>
          <h2 class="sub-header">Section title</h2>
          <div class="table-responsive">
            <table class="table table-striped" id='tblLocations'>
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Latitude</th>
                  <th>Longitude</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                
                <?php 

                      if($result->num_rows > 0) {

                            $count = 0;
                            // output data of each row
                            while($row = $result->fetch_assoc()) {

                                $count++;

                                echo "<tr id='t" . $count . "' >";
                                echo "<td>".$row["Id"]."</td>";
                                echo "<td>".$row["Name"]."</td>";
                                echo "<td>".$row["Description"]."</td>";
                                echo "<td>".$row["Latitude"]."</td>";
                                echo "<td>".$row["Longitude"]."</td>";
                                echo "<td><a href='#' onclick='editLocations(". $count .")'data-toggle='modal' data-target='#modalLocation'>Edit</a>&nbsp;<a href='#' onclick='deleteLocations()'>Delete</a></td>";
                                echo "</tr>";
                                }
                            

                        } else {
                            echo "<tr><td colspan='4'>No Rows Found</td></tr>";
                        }

                ?>


              </tbody>

            </table>
          </div>
        </div>
      </div>
    </div>
    <!--My modals --!>
    <!-- Button trigger modal -->
<!-- Modal -->
    <div class="modal fade" id="modalLocation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Add New Location</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" id="formLocation">
              <input type ='hidden' id='hdnId' /> 
              <div class="form-group">
                <label for="txtName" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="Name" id="txtName" placeholder="Name">
                </div>
              </div>

              <div class="form-group">
                <label for="txtDescription" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="Description" id="txtDescription" placeholder="Description">
                </div>
              </div>

              <div class="form-group">
                <label for="txtLongitude" class="col-sm-2 control-label">Longitude</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="Longitude" id="txtLongitude" placeholder="Longitude">
                </div>
              </div>

              <div class="form-group">
                <label for="txtLatitude" class="col-sm-2 control-label">Latitude</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="Latitude" id="txtLatitude" placeholder="Latitude">
                </div>
              </div>
          </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button onclick= "addNewRecord(this)" type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <script>
        function addNewRecord(elem){


          //collect user data
          var id = document.getElementById('hdnId').value;
          var name = document.getElementById('txtName').value;
          var desc = document.getElementById('txtDescription').value;
          var latitude = document.getElementById('txtLatitude').value;
          var longitude = document.getElementById('txtLongitude').value;
        
          if(isEmpty(name)){ alert('name cannot be left empty');return;}
          if(isEmpty(desc)){ alert('description cannot be left empty');return;}   
          if(isEmpty(latitude)){ alert('latitude cannot be left empty');return;}   
          if(isEmpty(longitude)){ alert('longitude cannot be left empty');return;}   

          var url = "locations.php?id=" +id +"&name=" + name +"&desc=" + desc +"&latitude=" + latitude +"&longitude=" + longitude;

          window.open(url,'_self');

        };

        function isEmpty(val){

              if(val===undefined || val===null || val==='' || val.length===0 || val.trim()===''){
                  return true;
              }

              return false;
        };

        var isValid =  <?php echo $isValid?'true':'false';  ?> ;
        if(!isValid){

            alert('<?php echo $msg; ?>')
        }
        function editLocations(num){

          var row = document.getElementById('t'+ num);
          var tds = row.getElementsByTagName('td');
          var id = tds[0].textContent;
          var name = tds[1].textContent;
          var desc = tds[2].textContent;
          var lat = tds[3].textContent;
          var long = tds[4].textContent;

          document.getElementById('hdnId').value = id;
          document.getElementById('txtName').value = name;
          document.getElementById('txtDescription').value = desc;
          document.getElementById('txtLatitude').value = lat;
          document.getElementById('txtLongitude').value = long;
      }

    </script>
  </body>
</html>

