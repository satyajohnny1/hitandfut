<?php
include 'sessionCheck.php'; 
session_start(); 
?>
<!DOCTYPE html>
<html>

<head>
   <?php include 'css.php';?>
</head>

<body class="page-header-fixed">  
    <!-- Search Form -->
    <main class="page-content content-wrap">
        <?php include 'navbar.php';?>
     	  	<div class="page-sidebar sidebar">
                  <?php include('sidemenu.php');  ?>  
                <!-- Page Sidebar Inner -->
            </div>
            <!-- Page Sidebar -->
		    <div class="page-inner">
            <div class="page-title">
                <h3>Actors List</h3>
            </div>
            <div id="main-wrapper" >
                <div class="row">
                           <div class="col-md-9">
                                                    <div class="table-responsive">
                                                        <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Director</th>
                                                                    <th>Remuneration</th>
                                                                    <th>Grade</th>                                                                   
                                                                    <th>PIC</th>
                                                                </tr>
                                                            </thead>
													<!-- Director serach code -->
                                                        
                                                            <tbody>
                                                             <?php 
                                                    			include 'db.php'; 
                                                    			$sql = "SELECT * FROM tolly_director";
                                                    			$result = mysqli_query($conn, $sql);
                                                    			
                                                    			if (mysqli_num_rows($result) > 0) {
                                                    				// output data of each row
                                                    				while($row = mysqli_fetch_assoc($result)) {
                                                    					$dir_id = $row["director_id"];
                                                    					$dir_name = $row["director_name"];
                                                    					$dir_rate = $row["director_rate"];
                                                    					$dir_pic = $row["director_pic"];                                                    					
                                                    					$dir_cr = round(($dir_rate/10000000),2);   
                                                    					echo "<tr>";
                                                    					echo "<td><a href='director.php?did=$dir_id' class='btn'>$dir_name</a></td>";
                                                     					echo "<td><b>".$dir_cr." CRORES</b>";
                                                    					echo "<td>".$row["director_grade"]."</td>";                                                    					
                                                    					echo  "<td><img class=\"img-circle avatar\" src=\"$dir_pic\" width=\"40\" height=\"40\"></td>";                                                    					
                                                    					echo  "</tr>"; 
                                                    					 
                                                    				
                                                    				}
                                                    			}  
                                                    			  
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                            
                  </div><!-- Row -->	
            
        </div>
        <!-- Page Inner -->
    </main>
    <!-- Page Content -->

     

	<?php include 'js.php';?>
	<script type="text/javascript">
	toastr.options = {
			  "closeButton": false,
			  "debug": false,
			  "newestOnTop": false,
			  "progressBar": false,
			  "positionClass": "toast-top-right",
			  "preventDuplicates": false,
			  "onclick": null,
			  "showDuration": "300",
			  "hideDuration": "1000",
			  "timeOut": "5000",
			  "extendedTimeOut": "1000",
			  "showEasing": "swing",
			  "hideEasing": "linear",
			  "showMethod": "fadeIn",
			  "hideMethod": "fadeOut"
			}

	 
	
	</script>

</body>

</html> 
<?php 
if($conn!=null){
mysqli_close($conn);
}
?>