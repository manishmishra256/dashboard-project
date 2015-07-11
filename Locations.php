
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
    <?php
        
        $username = "root";
        $password = "tajmahal";
        $hostname = "localhost"; 


        $db = new mysqli($hostname, $username, $password, 'dashboard');

        if($db->connect_errno > 0){
            die('Unable to connect to database [' . $db->connect_error . ']');
        }

        $result = $db->query("SELECT * FROM locations");
    ?>

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
          <h1 class="page-header">Dashboard</h1>

          <h2 class="sub-header">Section title</h2>
          <div class="table-responsive">
            <table class="table table-striped">
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
                            // output data of each row
                            while($row = $result->fetch_assoc()) {

                                echo "<tr>";
                                echo "<td>".$row["Id"]."</td>";
                                echo "<td>".$row["Name"]."</td>";
                                echo "<td>".$row["Description"]."</td>";
                                echo "<td>".$row["Latitude"]."</td>";
                                echo "<td>".$row["Longitude"]."</td>";
                                echo "<td><a href='#'>Edit</a>&nbsp;<a href='#'>Delete</a></td>";
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
  </body>
</html>
