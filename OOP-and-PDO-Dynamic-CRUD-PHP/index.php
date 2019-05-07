<?php 
    include 'inc/header.php'; 
    include 'lib/Database.php';
    $db = new Database();
    include 'lib/Session.php';
    Session ::init();
?>

<?php
    $msg = Session::get('msg');
    if (!empty($msg)) 
    {
       echo '<h2 class="alert alert-success text-center" >'.$msg.'</h2>';
       Session::set('msg', NULL);
       //Session::unset();
    } 
?>
      
    <div class="panel panel-default">
        <div class="row">
            <div class="col-3">
                <h2>Student List</a></h2>
            </div>
            <div class="col-3"></div>
            <div class="col-3"></div>
            <div class="col-3">
                <h2><a href="addstudent.php" class="btn btn-info">Add Student</a></h2>
            </div>
        </div>
	</div>
	
    <div class="panel-body">
        <form action="" method="post">
            <table class="table">    
                <tr>
                    <th width="20%">Serial</th>
                    <th width="20%">Name</th>
                    <th width="20%">Email</th>
                    <th width="20%">Phone</th>
                    <th width="20%">Action</th>
                </tr>
<!-- --------------------------------------------------------->
<?php
    $db = new Database();
    $table = "tbl_student";
    $order_by =  array('order_by' => 'studentId DESC'); //---------------------------------> 1
                // $selectCond = array('select' => 'name' );
                
                // $whereCond = array(                    //---------------------------------> 2  
                //     'where' => array('studentId' => '2', 'email' => 'arman@gmail.com'),
                //     'return_type' => 'single'
                // );
                
                //$limit = array('start' =>'2' , 'limit' =>'3'); //---------------------------------> 3
                //  $limit = array('limit' =>'4');
    
    //$studentData = $db->select($table, $limit);    //---> 3
    //$studentData = $db->select($table, $whereCond);  //---> 2
    $studentData = $db->select($table, $order_by);   //---> 1
    if (!empty($studentData)) 
    {
        $i=0;
        foreach ($studentData as $data ) 
        {
            $i++;
?>               <tr>
                                            <!-- ----------------------------2   -->    
                    <!-- <td><?php //  echo $studentData['name']; ?></td>   
                    <td><?php //  echo $studentData['email']; ?></td>
                    <td><?php //  echo $studentData['phone']; ?></td> -->

                                            <!-- ---------------------------- 1/3   -->
                    <td><?php  echo $i; ?></td> 
                    <td><?php  echo $data['name']; ?></td>
                    <td><?php  echo $data['email']; ?></td>
                    <td><?php  echo $data['phone']; ?></td>
                    
                    <td>
 <!--2-->               <!-- <a class="btn btn-warning" href="editstudent.php?studentId=<?php //echo $studentData['studentId']; ?>">Edit</a> -->
                        <!-- <a class="btn btn-danger"  href="deletestudent.php?studentId=<?php // echo $studentData['studentId']; ?>" onclick="return confirm('Are you sure to Delete ?')">Delete</a>  -->
 <!--1-->               <a class="btn btn-warning" href="editstudent.php?studentId=<?php echo $data['studentId']; ?>">Edit</a>
                        <a class="btn btn-danger"  href="lib/process_student.php?action=delete&studentId=<?php echo $data['studentId']; ?>" onclick="return confirm('Are you sure to Delete ?')">Delete</a> 
                    </td>
                </tr>
<?php
       } 
    } else { ?>

        <tr><td colspan="5"><h2>Student Data Not Found...</h2></td></tr> 

<?php } ?>                
<!-- __________________________ X _________________________ -->            
            </table>
        </form>
    </div>


<?php include 'inc/footer.php'; ?>      