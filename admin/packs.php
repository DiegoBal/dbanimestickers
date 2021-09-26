<?php 
ob_start();
include('../admin_templet/admin_templet_header.php');
if(!isset($_SESSION['Username'])){
  header("Location:../index.php");
}
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Packs</h1>
    <ol class="breadcrumb">
      <li><a href="admin_dashbord.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><i class="fa fa-briefcase"></i> Packs</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="col-md-6">
              <select class="form-control" name="categoriesname" id="filtercategoriesname">     
                <option value="" >Select Categorie</option>   
                <?php 
                $sql="SELECT * FROM `categories` order by categories_name ASC";
                $result_sql = mysqli_query($db,$sql);
                while($row = mysqli_fetch_assoc($result_sql)){
                  ?>
                  <option value="<?php echo $row["id"]; ?>">
                    <?php echo $row["categories_name"]; ?>
                  </option>
                  <?php 
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <button type="button" class="btn btn-primary apply_filter_onpack" style="margin-right: 10px;">Apply</button>
            <button type="button" class="btn clear_filter_onpack" style="background-color: #EF534E; color: white;">Clear</button>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <div class="box mycat_main">
          <div class="box-header">
            <h3 class="box-title">All Packs</h3>
            <div class="row" style="margin-top: 10px;">
              <button type="submit" name="submit" class="btn btn-primary add-category" data-toggle="modal" data-target="#addmodel" style="margin-bottom: 5px; float: right;margin-right: 26px;" >Add Pack</button>
            </div>
            <div class="table-responsive">
              <div class="box-body">
                <div class="row">
                  <div class="col-sm-12">
                    <table id="packtbl" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                      <thead>
                        <tr>
                          <th>SrNo:</th>
                          <th>Categorie Name</th>
                          <th>Try Icon</th>
                          <th>Title</th>
                          <th>Identifier</th>
                          <th>Publisher</th>
                          <th>Publisher Website</th>
                          <th>Privacy Policy Website</th>
                          <th>Licence Website</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                       <?php 

                       $query_sql="SELECT cp.*,cat.categories_name FROM `categories_pack` as cp join categories as cat where cp.cat_name_id=cat.id";
                       $result_query_sql = mysqli_query($db,$query_sql);
                       $count=1;
                       while($row = mysqli_fetch_assoc($result_query_sql))
                       {   
                        ?>
                        <tr id="<?php echo $row["id"]; ?>">
                          <td> <?php echo $count; ?></td>
                          <td><?php echo $row["categories_name"]; ?></td>
                          <td><img src="../uploadpack/<?php echo $row['try_icone'];?>" alt=" " height="75" width="75"></td>
                          <td><?php echo $row["title"]; ?></td>
                          <td><?php echo $row["identifier"]; ?></td>
                          <td><?php echo $row["publisher"]; ?></td>
                          <td><?php echo $row["publisher_website"]; ?></td>
                          <td><?php echo $row["pp_website"]; ?></td>
                          <td><?php echo $row["la_website"]; ?></td>
                          <td>
                            <div style="width: 200px; margin-top: 10px">
                              <a href="controller/pack_data.php?id=<?php echo $row["id"]; ?>&action=download" class="btn btn-circle waves-effect waves-light" onclick="return confirm('Are you sure download json file of this pack..?')" title="download json file" style="margin-top:10px;margin-left: 5px; background-color: #81C9E8;">
                                <i class="fa fa-download" style="font-size:15px;color:white;"></i>
                              </a>
                              <button class="btn btn-warning btn-circle waves-effect waves-light edit_cat" data-toggle="modal" data-target="#editmodel" data-id="<?php echo $row["id"]; ?>" data-name="<?php echo $row["cat_name_id"]; ?>" data-count="<?php echo($count) ?>" data-title="<?php echo $row["title"]; ?>" data-identifier="<?php echo $row["identifier"]; ?>"
                                data-publisher="<?php echo $row["publisher"]; ?>" data-publisher_website="<?php echo $row["publisher_website"]; ?>" data-pp_website="<?php echo $row["pp_website"];  ?>" data-image="<?php echo $row['try_icone'];?>"
                                data-la_website="<?php echo $row["la_website"]; ?>" title="edit pack detail" style="margin-top:10px; margin-left: 5px;">
                                <i class="fa fa-pencil-square-o" style="font-size:15px;color:white;"></i>
                              </button>
                              <a class="btn btn-danger btn-circle waves-effect waves-light" href="controller/pack_data.php?id=<?php echo $row["id"];?>&flag=remove_pack" onclick="return checkDelete()" title="remove pack" style="margin-top: 10px;margin-left: 5px;">
                                <i class="fa fa-times" style="font-size:15px;color:white;"></i>
                              </a>
                            </div>
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

  <!-- ADD Pack Modal -->
  <div class="modal fade" id="addmodel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add New Pack
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </h4>
        </div>
        <form id="add_pack" enctype="multipart/form-data" method="post">
          <div class="modal-body"> 
            <div class="row">
              <div class="col-sm-4 text-right">
                <label style="margin-top: 6px;">Categorie Name<span style="color: red">*</span></label>
              </div>
              <div class="col-sm-6">
                <select class="form-control" name="categoriesname" id="categoriesname" required >     
                  <option value="" >Select Categorie</option>   
                  <?php 
                  $sel_query="SELECT * FROM `categories` order by categories_name ASC";
                  $result_sel_query = mysqli_query($db,$sel_query);
                  while($row = mysqli_fetch_assoc($result_sel_query)){
                    ?>
                    <option value="<?php echo $row["id"]; ?>">
                      <?php echo $row["categories_name"]; ?>
                    </option>
                    <?php 
                  }
                  ?>
                </select>
              </div>
            </div> 

            <div class="row" style="margin-top:5px;">
              <div class="col-sm-4 text-right">
                <label style="margin-top: 6px;">Title <span style="color: red">*</span></label>
              </div>
              <div class="col-sm-6">
                <input type="text" id="titlename" name="titlename" class="form-control" placeholder="Title" required="">
                <p class="error" style="color: red;"></p>
              </div>
            </div> 

            <div class="row" style="margin-top:5px;">
              <div class="col-sm-4 text-right">
                <label style="margin-top: 6px;">Identifier <span style="color: red">*</span></label>
              </div>
              <div class="col-sm-6">
                <input type="text" id="identifiername" name="identifiername" class="form-control" placeholder="Identifier" required="">
              </div>
            </div> 

            <div class="row" style="margin-top:5px;">
              <div class="col-sm-4 text-right">
                <label style="margin-top: 6px;">Publisher <span style="color: red">*</span></label>
              </div>
              <div class="col-sm-6">
                <input type="text" id="publishername" name="publishername" class="form-control" placeholder="Publisher" required="">
              </div>
            </div>  

            <div class="row" style="margin-top:5px;">
              <div class="col-sm-4 text-right">
                <label style="margin-top: 6px;">Publisher Website</label>
              </div>
              <div class="col-sm-6">
                <input type="text" id="publisherwebsitename" name="publisherwebsitename" class="form-control" placeholder="Publisher Websitename" >
              </div>
            </div> 

            <div class="row" style="margin-top:5px;">
              <div class="col-sm-4 text-right">
                <label style="margin-top: 6px;">Privacy Policy Website</label>
              </div>
              <div class="col-sm-6">
                <input type="text" id="ppwebsitename" name="ppwebsitename" class="form-control" placeholder="Privacy Policy Websitename">
              </div>
            </div>

            <div class="row" style="margin-top:5px;">
              <div class="col-sm-4 text-right">
                <label style="margin-top: 6px;">Licence Website </label>
              </div>
              <div class="col-sm-6">
                <input type="text" id="lawebsitename" name="lawebsitename" class="form-control" placeholder="Licence Website " >
              </div>
            </div> 

            <div class="row" style="margin-top:5px;">
              <div class="col-sm-4 text-right">
                <label style="margin-top: 6px;">Try icon <span style="color: red">*</span> </label>
              </div>
              <div class="col-sm-6">
                <input type='file' name="fileToUpload" id="fileToUpload" required="" accept="image/x-png,image/gif,image/jpeg"/>
                <img id="image_upload_preview" src="http://placehold.it/96x96" alt="your image" height="96" width="96" style="margin-top:10px" />
              </div>
            </div>                                    
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning closebtn" data-dismiss="modal" style="float: left;">Close</button>
            <button type="submit" class="add btn btn-success " id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Loading..">Save</button>
          </div>
        </form>    
      </div>
    </div>
  </div>

  <div class="modal fade" id="editmodel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit pack
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </h4>
        </div>
        <form id="edit_pack" enctype="multipart/form-data" method="post">
          <div class="modal-body"> 
           <div class="row">
             <div class="col-sm-4 text-right">
               <label style="margin-top: 6px;">Categorie Name<span style="color: red">*</span></label>
             </div>
             <div class="col-sm-6">
               <select class="form-control ecat" name="ecategorieid" id="ecategorieid" required disabled>     <option value="" >Select Categorie</option>   
                 <?php 
                 $count=1;
                 $sel_query="SELECT * FROM `categories` order by categories_name ASC";
                 $result = mysqli_query($db,$sel_query);
                 while($row = mysqli_fetch_assoc($result)){
                  ?>
                  <option value="<?php echo $row["id"]; ?>">
                    <?php echo $row["categories_name"]; ?>
                  </option>
                  <?php 
                }
                ?>
              </select>
            </div>
          </div> 

          <div class="row" style="margin-top:5px;">
            <div class="col-sm-4 text-right">
              <label style="margin-top: 6px;">Title <span style="color: red">*</span></label>
            </div>
            <div class="col-sm-6">
              <input type="text" id="etitlename" name="etitlename" class="form-control etitle" placeholder="Title" required="">
              <p class="error1" style="color: red;"></p>
            </div>
          </div> 

          <div class="row" style="margin-top:5px;">
            <div class="col-sm-4 text-right">
              <label style="margin-top: 6px;">Identifier <span style="color: red">*</span></label>
            </div>
            <div class="col-sm-6">
              <input type="text" id="eidentifiername" name="eidentifiername" class="form-control eidentifier" placeholder="Identifier" required="">
            </div>
          </div> 

          <div class="row" style="margin-top:5px;">
            <div class="col-sm-4 text-right">
              <label style="margin-top: 6px;">Publisher <span style="color: red">*</span></label>
            </div>
            <div class="col-sm-6">
              <input type="text" id="epublishername" name="epublishername" class="form-control epublisher" placeholder="Publisher" required="">
            </div>
          </div>  

          <div class="row" style="margin-top:5px;">
            <div class="col-sm-4 text-right">
              <label style="margin-top: 6px;">Publisher Website</label>
            </div>
            <div class="col-sm-6">
              <input type="text" id="epublisherwebsitename" name="epublisherwebsitename" class="form-control epublisherwebsite" placeholder="Publisher Websitename" >
            </div>
          </div> 

          <div class="row" style="margin-top:5px;">
            <div class="col-sm-4 text-right">
              <label style="margin-top: 6px;">Privacy Policy Website</label>
            </div>
            <div class="col-sm-6">
              <input type="text" id="eppwebsitename" name="eppwebsitename" class="form-control eppwebsite" placeholder="Privacy Policy Websitename">
            </div>
          </div>

          <div class="row" style="margin-top:5px;">
            <div class="col-sm-4 text-right">
              <label style="margin-top: 6px;">Licence Website </label>
            </div>
            <div class="col-sm-6">
              <input type="text" id="elawebsitename" name="elawebsitename" class="form-control elawebsite" placeholder="Licence Website " >
            </div>
          </div> 

          <div class="row" style="margin-top:5px;">
            <div class="col-sm-4 text-right">
              <label style="margin-top: 6px;">Try
                icon <span style="color: red">*</span> </label>
              </div>
              <div class="col-sm-6">
                <input type='file' name="efileToUpload1" id="efileToUpload" value="" />
                <img id="eimage_upload_preview" class="previewimg" src="http://placehold.it/96x96" alt="your image" height="96" width="96" style="margin-top:10px" />
              </div>
            </div>                                    
          </div>
          <div class="modal-footer">
            <input type="hidden" name="hiddenid" class="hiddenid" value="">
            <input type="hidden" name="trsrno" class="trsrno1" value="">
            <input type="hidden" name="hiddenimg" class="hiddenimg" value=""> <button type="button" class="btn btn-warning" data-dismiss="modal" style="float: left;">Close</button>                      
            <button type="submit" class="update btn btn-success" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Loading..">Update</button> 
          </div>
        </form> 
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('#editmodel').on('hidden.bs.modal', function () 
  {
    
    $("#edit_pack")[0].reset();
    $('.error1').html('');
  });
</script>
<?php include '../admin_templet/admin_templet_footer.php';?>
