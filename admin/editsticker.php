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
    top:-31px;
    right:24px;
    background:red;
    border-radius:100px;
    font-size:0.9em;
    padding: 0 5px 0;
    text-align:center;
    cursor:pointer;
    display: inline;

  }
  .remove_img_preview:before {
    content: "×";
  }

  @media only screen and (min-width: 992px) and (max-width: 1254px)
  {
    .remove_img_preview {
      top:-104px !important;
      right:-84px !important;
    }
  } 

/*  @media only screen and (max-width: 991px)
  {
    .remove_img_preview {
      top:-32px !important;
      right:23px !important;
    }
  } */
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Stickers</h1>
    <ol class="breadcrumb">
      <li><a href="admin_dashbord.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="stickers.php"><i class="fa fa-clone"></i> Stickers</a></li>
      <li class="active">Edit Stickers</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12" style="padding:10px;">
       <div class="box mycat_main">
        <div class="box-header">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" id="yw0">
              <li><a href="stickers.php"><i class="fa fa-list nar" style="margin-right: 3px;"></i>List</a></li>
              <li class="active"><a href="editsticker.php?id=<?php echo $_GET['id']; ?>"><i class="fa fa-pencil nar" style="margin-right: 3px;"></i>Update</a></li>
            </ul> 
          </div>
          <?php
          $id=$_GET['id'];

          $sel_query="SELECT sticker.*,cat.categories_name,cp.title,cp.try_icone, cp.cat_name_id FROM `stickers` as sticker left join categories_pack as cp ON sticker.pack_id=cp.id left join categories as cat ON cp.cat_name_id=cat.id WHERE sticker.id=$id";
          $result1 = mysqli_query($db,$sel_query);
          $data = mysqli_fetch_assoc($result1);
          ?>   
          <div class="tab-content"><br>
            <form  id="edit_sticker" enctype="multipart/form-data" method="post">
              <div class="modal-body"> 
                <div class="row">
                  <div class="col-sm-4 text-right">
                    <label style="margin-top: 6px;">Categorie Name<span style="color: red">*</span></label>
                  </div>
                  <div class="col-sm-6">
                    <select class="form-control esticker" name="ecategoriesname" id="ecategoriesname" required  disabled> 
                      <option value="" >Select Categorie</option>   
                      <?php 
                      $sel_query="SELECT * FROM `categories` order by categories_name ASC";
                      $result = mysqli_query($db,$sel_query);
                      while($row = mysqli_fetch_assoc($result)){
                        $select = ($data["cat_name_id"] == $row["id"]) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $row["id"]; ?>" <?php echo $select; ?>>
                          <?php echo $row["categories_name"]; ?>
                        </option>
                        <?php 
                      }
                      ?> 
                    </select>
                  </div>
                </div> 
                <div class="row" style="margin-top: 5px;">
                  <div class="col-sm-4 text-right">
                    <label style="margin-top: 6px;">Pack (Title)<span style="color: red">*</span></label>
                  </div>
                  <div class="col-sm-6">
                    <select class="form-control esticker1" name="epackname" id="<?php echo $row["id"]; ?>" required  disabled>
                      <option value="">select Pack</option>  
                      <?php 
                      $sel_query="SELECT * FROM `categories_pack` order by title ASC";
                      $result = mysqli_query($db,$sel_query);
                      while($row = mysqli_fetch_assoc($result)){
                        $select = ($data["pack_id"] == $row["id"]) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $row["id"]; ?>" <?php echo $select; ?>>
                          <?php echo $row["title"]; ?>
                        </option>
                      <?php } ?>  
                    </select>
                  </div>
                </div> 

                <div class="row" style="margin-top: 5px;">
                  <div class="col-sm-4 text-right">
                    <label style="margin-top: 6px;">Sticker<span style="color: red">*</span> </label>
                  </div>
                  <div class="col-sm-6">
                    <input type='file' name="files[]" id="efiles"  multiple accept="image/png" />
                    <div id="sticker_image_err" style="color: red;font-weight: bold;"></div>
                    <div class="image_gallery">
                      <?php 
                      $sel_query="SELECT sticker.*,cat.categories_name,cp.title,cp.try_icone, cp.cat_name_id FROM `stickers` as sticker left join categories_pack as cp ON sticker.pack_id=cp.id left join categories as cat ON cp.cat_name_id=cat.id";

                      $result = mysqli_query($db,$sel_query);
                      $image=explode(',', $data['sticker']);

                      foreach ($image as $key => $value) {
                        if (!empty($value)) { 
                          $countmultiple_img=ltrim($data['sticker'],',');
                          $countmultiple_img=rtrim($countmultiple_img,',');
                          $sticker=explode(',', $countmultiple_img);
                          if (!empty($data['sticker'])) {
                            $stickercount=count($sticker);
                          }else{
                            $stickercount=0;
                          }
                          ?>
                          <div class="col-md-4">
                            <span>
                              <img class="multiple_image_select" width="105px" height="105px" id="mulimg" style="margin-top: 15px; border: 2px solid;" src="../uploadpack/<?php echo $value; ?>">
                              <span class="remove_img_preview" data-name="<?php echo $value; ?>"></span>
                            </span>  
                          </div>  
                        <?php } } ?>  
                      </div>   
                    </div>
                    <input type="hidden" name="multiple_img" id="multi_img" value="<?php echo $data['sticker'] ?>">
                    <input type="hidden" name="countmultiple_img" id="countmulti_img" value="<?php echo $stickercount ?>"> 
                    <!--<input type='hidden' name="files[]" id="efiles" value="<?php echo $stickercount ?>"  multiple accept="image/x-png,image/gif,image/jpeg" /> -->
                  </div>                                    
                </div>   
                <div class="modal-footer">
                  <input type="hidden" name="hiddenid" class="hiddenid" value="<?php echo $id ?>">
                  <button type="submit" class=" update btn btn-success" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Loading..">Update</button>
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