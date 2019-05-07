<?php 
  include 'inc/header.php'; 
  include 'lib/Database.php';
  $db =  new Database();
?>  

<div class="panel panel-default">
    <div class="row">
        <div class="col-3">
            <h2>Update Student</h2>
        </div>
        <div class="col-3"></div>
        <div class="col-3"></div>
        <div class="col-3" >
            <h2><a href="index.php" class="btn btn-info">Go Back</a></h2>
        </div>
    </div>
</div>

<?php
    $studentId = $_GET['studentId'];
    $table = "tbl_student";
    $whereCond = array(                   
      'where' => array('studentId' => $studentId),
      'return_type' => 'single'
  );
    $result  = $db->select($table,$whereCond);
    if (!empty($result)) {
?>

<form action="lib/process_student.php" method="post">
    
    <div class="form-group mt-3">
      <label for="name">Student Name:</label>
      <input type="name" class="form-control" id="name" name="name" value="<?php echo $result['name']; ?>">
    </div>
    
    <div class="form-group">
      <label for="email">Student Email:</label>
      <input type="email" class="form-control" id="email"  name="email" value="<?php echo $result['email']; ?>">
    </div>

    <div class="form-group">
      <label for="phone">Student Phone:</label>
      <input type="phone" class="form-control" id="phone"  name="phone" value="<?php echo $result['phone']; ?>">
    </div>

    <div class="form-group mt-4">
      <input type="hidden" name="studentId" value="studentId">
      <input type="hidden" name="action" value="edit">
      <input type="submit" class="btn btn-primary" name="submit" value="Update Student">
    </div>

</form>

<?php } ?>

<?php include 'inc/footer.php'; ?>      