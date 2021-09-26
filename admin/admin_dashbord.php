<?php 
ob_start();
include('../admin_templet/admin_templet_header.php');
if(!isset($_SESSION['Username'])){
  header("Location:../index.php");
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Dashboard<small>Version 1.0.1</small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Info boxes -->
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="categories.php" style="color: black;">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-briefcase"></i></span>
            <div class="info-box-content">
              <?php 
              $sql="SELECT COUNT(*) AS count FROM categories";
              $result = mysqli_query($db,$sql);
              $data = mysqli_fetch_assoc($result);
              ?>
              <span class="info-box-text">Categories</span>
              <span class="info-box-number"><?php print_r($data['count']); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div></a>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="packs.php" style="color: black;">
            <div class="info-box">
              <span class="info-box-icon bg-red"><i class="icon ion-ios-albums"></i></span>
              <div class="info-box-content">
                <?php 
                $sql1="SELECT COUNT(*) AS count FROM categories_pack";
                $result1 = mysqli_query($db,$sql1);
                $data1 = mysqli_fetch_assoc($result1);
                ?>
                <span class="info-box-text">Packs</span>
                <span class="info-box-number"><?php print_r($data1['count']); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div></a>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix visible-sm-block"></div>
          <div class="col-md-3 col-sm-6 col-xs-12">
           <a href="stickers.php" style="color: black;">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="icon ion-images"></i></span>
              <div class="info-box-content">
                <?php 
                
                  $sql2="SELECT * FROM stickers";
                  $totalSticker = 0;
                  $result = mysqli_query($db,$sql2);
                  while($row = mysqli_fetch_assoc($result)){ 
                    $stickersPerCat = $row['sticker'];
                    $tempTotal = count(explode(',', $stickersPerCat));
                    $totalSticker += $tempTotal;
                  }
                ?>
                <span class="info-box-text">Stickers</span>
                <span class="info-box-number"><?php print_r($totalSticker); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div></a>
            <!-- /.info-box -->
          </div>
          

        </section>
        <!-- /.content -->
      </div>

      <?php include '../admin_templet/admin_templet_footer.php';?>