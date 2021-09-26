<?php 
ob_start();
include('../admin_templet/admin_templet_header.php');
if(!isset($_SESSION['Username'])){
  header("Location:../index.php");
}
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Categories</h1>
    <ol class="breadcrumb">
      <li><a href="admin_dashbord.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><i class="fa fa-list-alt"></i> Categories</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box mycat_main">
          <div class="box-header">
            <h3 class="box-title">All Categories</h3>
            <div class="row">
              <button type="submit" name="submit" class="btn btn-primary add-category" data-toggle="modal" data-target="#addmodel" style="margin-bottom: 5px; float: right;margin-right: 26px;" >Add Category</button>
            </div>
            <div class="table-responsive">
              <div class="box-body">
               <div class="row">
                <div class="col-sm-12">
                  <table id="categorietbl" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr>
                        <th>SrNo</th>
                        <th>Categorie Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $count=1;
                      $sel_query="SELECT * FROM `categories`";
                      $result = mysqli_query($db,$sel_query);
                      while($row = mysqli_fetch_assoc($result)){ 
                        ?>
                        <tr id="<?php echo $row["id"]; ?>">
                          <td><?php echo $count; ?></td>
                          <td><?php echo $row["categories_name"]; ?></td>
                          <td>
                            <button class="btn btn-warning btn-circle waves-effect waves-light edit_cat" data-toggle="modal" data-target="#editmodel" data-id="<?php echo $row["id"]; ?>" data-name="<?php echo $row["categories_name"]; ?>" data-count="<?php echo($count) ?>">
                              <i class="fa fa-pencil-square-o" style="font-size:19px;color:white;"></i>
                            </button>

                            <a class="btn btn-danger btn-circle waves-effect waves-light" href="controller/categories_data.php?id=<?php echo $row["id"]; ?>&flag=remove_categories" onclick="return checkDelete()" style="margin-left: 15px;">
                              <i class="fa fa-times" style="font-size:19px;color:white;"></i>
                            </a>
                          </td>
                        </tr>
                        <?php $count++; $number[]=$count; } ?>
                      </tbody>
                    </table>
                    <input type="hidden" name="srno" value="<?php echo count($number) ?>" class="srno">
                  </div>
                </div>
              </div>
            </div> 
          </div>
        </div> 
      </div>
    </div>
  </section>

  <div class="modal fade" id="addmodel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add New Categorie
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </h4>
        </div>
        <form id="add_categories" enctype="multipart/form-data" method="post">
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-4 text-right">
                <label style="margin-top: 6px;">Categorie Name</label> <span style="color: red">*</span>
              </div>
              <div class="col-sm-6">
                <input type="text" id="categoriesname" name="categoriesname" class="form-control" placeholder="Categorie Name" required="">
                <p class="error" style="color: red;"></p>
              </div>
            </div>       
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal" style="float: left;">Close</button>
            <button type="submit" class=" add btn btn-success" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Loading..">Save</button>
          </div>
        </form>   
      </div>
    </div>
  </div>

  <div class="modal fade" id="editmodel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Categorie
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </h4>
        </div>
        <form id="edit_categorie" enctype="multipart/form-data" method="post">
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-4 text-right">
                <label style="margin-top: 6px;">Categorie Name</label>  <span style="color: red">*</span>
              </div>
              <div class="col-sm-6">
                <input type="text" name="ecategoriesname" class="form-control ecat" id="ecategoriesname" placeholder="Category Name" required="">
                <p class="error1" style="color: red;"></p>
              </div>
            </div>  
          </div>
          <div class="modal-footer">
            <input type="hidden" name="hiddenid" class="hiddenid" value="">
            <input type="hidden" name="trsrno" class="trsrno1" value="">
            <button type="button" class="btn btn-warning" data-dismiss="modal" style="float: left;">Close</button>
            <button type="submit" class="update btn btn-success" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Loading..">Update</button> 
          </div>
        </form> 
      </div>
    </div>
  </div>
</div>
<?php include '../admin_templet/admin_templet_footer.php';?>



