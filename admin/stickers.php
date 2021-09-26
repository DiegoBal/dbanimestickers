<?php 
ob_start();
include('../admin_templet/admin_templet_header.php');
if(!isset($_SESSION['Username'])){
  header("Location:../index.php");
}
?>
<style type="text/css">
.remove_img_preview {
  position:relative;
  top:-53px;
  right:21px;
  background:red;
  color:white;
  border-radius:100px;
  font-size:0.9em;
  padding: 0 0.5em 0;
  text-align:center;
  cursor:pointer;
}
.remove_img_preview:before {
  content: "×";
}
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Stickers</h1>
    <ol class="breadcrumb">
      <li><a href="admin_dashbord.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><i class="fa fa-clone"></i> Stickers</li>
    </ol>
  </section>
  <section class="content">
    <!-- 
    <div class="box">
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="col-md-6">
              <select class="form-control" name="categoriesname" id="filtercategoriesname">     
                <option value="" >Select Categorie</option>   
                <?php 
                $sel_query="SELECT * FROM `categories` WHERE is_delete='0' order by categories_name ASC";
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
          <div class="col-md-6">
            <button type="button" class="btn btn-primary apply_filter_onpack" style="margin-right: 10px;">Apply</button>
            <button type="button" class="btn clear_filter_onpack" style="background-color: #EF534E; color: white;">Clear</button>
          </div>
        </div>
      </div>
    </div>
 -->
    <div class="row">
      <div class="col-xs-12" style="padding:10px;">
        <div class="box mycat_main">
          <div class="box-header">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs" id="yw0">
                <li class="active"><a href="stickers.php"><i class="fa fa-list nar" style="margin-right: 3px;"></i>List</a></li>
              </ul> 
            </div>
            <div class="tab-content"><br>
             <form  id="add_sticker" enctype="multipart/form-data" method="post">
               <div class="modal-bodylist">
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>SrNo:</th>
                        <th>Try Icon</th>
                        <th>Categorie Name</th>
                        <th>Pack (Title)</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $count=1;
                      $sel_query="SELECT sticker.*,cat.categories_name,cp.title,cp.try_icone, cp.cat_name_id FROM `stickers` as sticker left join categories_pack as cp ON sticker.pack_id=cp.id left join categories as cat ON cp.cat_name_id=cat.id";
                      $result = mysqli_query($db,$sel_query);

                      while($row = mysqli_fetch_assoc($result)){ 
                        $multi_images=ltrim($row['sticker'],',');
                        $multi_images=rtrim($multi_images,',');
                        $sticker=explode(',', $multi_images);
                        if (!empty($row['sticker'])) {
                          $stickercount=count($sticker);
                        }else{
                          $stickercount=0;
                        }
                        ?>
                        <tr id="<?php echo $row["id"]; ?>">
                          <td><?php echo $count; ?> </td>
                          <td><img src="../uploadpack/<?php echo $row["try_icone"]; ?>" alt="" height="75" width="75"><p style="font-style:italic;"> Total Stickers:  <?php echo $stickercount; ?> </p> </td>
                          <td><div style="margin-top: 25px; margin-left: 50px;"><?php echo $row["categories_name"]; ?></div></td>
                          <td><div style="margin-top: 25px;margin-left: 50px;"><?php echo $row["title"]; ?></div></td>
                          <td>
                            <div style="margin-top: 25px; margin-left: 50px;">
                              <a href="controller/pack_data.php?id=<?php echo $row["pack_id"]; ?>&action=download" class="btn btn-circle waves-effect waves-light" onclick="return confirm('Are you sure download json file of this pack..?')" title="download json file" style="margin-top:5px;margin-left: 10px; background-color: #81C9E8;">
                                <i class="fa fa-download" style="font-size:19px;color:white;"></i>
                              </a>
                              <a class="btn btn-warning btn-circle waves-effect waves-light edit_stick"  href="editsticker.php?id=<?php echo $row["id"]; ?>"  style="margin-top: 5px;margin-left: 10px;">
                                <i class="fa fa-pencil-square-o" style="font-size:19px;color:white;"></i>
                              </a> 
                              <a class="btn btn-danger btn-circle waves-effect waves-light" href="controller/sticker_data.php?id=<?php echo $row["id"]; ?>&flag=remove_sticker" onclick="return checkDelete()" style="margin-top: 5px;margin-left: 10px;">
                                <i class="fa fa-times" style="font-size:19px;color:white;"></i>
                              </a> 
                            </div>
                          </td>
                        </tr>
                        <?php $count++; $number[]=$count; } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </form>   
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include '../admin_templet/admin_templet_footer.php';?>
