<?php include 'inc/header.php'; ?>  

<div class="panel panel-default">
    <div class="row">
        <div class="col-3">
            <h2>Add Student</h2>
        </div>
        <div class="col-3"></div>
        <div class="col-3"></div>
        <div class="col-3" >
            <h2><a href="index.php" class="btn btn-info">Go Back</a></h2>
        </div>
    </div>
</div>

<form action="lib/process_student.php" method="post">
    
    <div class="form-group mt-3">
      <label for="name">Student Name:</label>
      <input type="name" class="form-control" id="name" placeholder="Enter Student Name" name="name">
    </div>
    
    <div class="form-group">
      <label for="email">Student Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter Student Email" name="email">
    </div>

    <div class="form-group">
      <label for="phone">Student Phone:</label>
      <input type="phone" class="form-control" id="phone" placeholder="Enter Student Phone" name="phone">
    </div>

    <div class="form-group mt-4">
      <input type="hidden" name="action" value="add">
      <input type="submit" class="btn btn-primary" name="submit" value="Add Student">
    </div>

</form>

<?php include 'inc/footer.php'; ?>      