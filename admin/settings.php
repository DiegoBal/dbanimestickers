<?php 
ob_start();
include('../admin_templet/admin_templet_header.php');
if(!isset($_SESSION['Username'])){
	header("Location:../index.php");
}
?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Settings</h1>
		<ol class="breadcrumb">
			<li><a href="admin_dashbord.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><i class="fa fa-gear"></i> Settings</li>
		</ol>
	</section>
	<section class="content">
		<div class="box">
			<div class="box-body">
				<div class="row">
					<div class="col-md-6">
						<div class="col-md-8">
							<?php 
							$query="SELECT * FROM api_authentication";
							$result=mysqli_query($db,$query);
							$data = mysqli_fetch_assoc($result);
							
							?>
							<div class="form-group">
								<label>auth_token:</label>
								<input type="text" class="form-control" id="secret-token" value="<?php echo $data['token']; ?>" readonly/>
							</div>
							<input type="hidden" id="tokenid" value="<?php echo $data['id']; ?>">
						</div>
						<div class="col-md-4">
						</div>
					</div>
					<div class="col-md-6">
						<br>
						<button type="button" id="edittoken" data-toggle="modal" data-target="#id_pass_checkmodel" class="btn btn-primary edit-token" style="margin-right: 10px;">Edit Token</button>

						<button type="button" id="updatetoken" class="btn btn-primary update-token" style="margin-right: 10px; display: none;">Update Token</button>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="col-md-8">
							
							<div class="form-group">
								<label>Play Store Link:</label>
								<input type="text" class="form-control" id="play_store_link" value="<?php echo $data['play_store_link']; ?>" disabled=""/>
								
							</div>
							
						</div>
						<div class="col-md-4">
						</div>
					</div>
					<div class="col-md-6">
						<br>
						<button type="button" id="edit_link" class="btn btn-primary edit-token" style="margin-right: 10px;">Edit Link</button>

						<button type="button" id="update_link" class="btn btn-primary" style="margin-right: 10px; display: none;">Update</button>
					</div>

					
				</div>
			</div>
		</div>
	</section>

	<div class="modal fade" id="id_pass_checkmodel">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Your Password
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</h4>
				</div>
				<form id="edit_token_pass_check" enctype="multipart/form-data" method="post">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-4 text-right">
								<label style="margin-top: 6px;">Password</label> <span style="color: red">*</span>
							</div>
							<div class="col-sm-6">
								<input type="password" id="passcheck" name="passcheck" class="form-control" placeholder="Enter Your Password" required>
								<p class="error" style="color: red;"></p>
							</div>
							<input type="hidden" name="userid" value="<?php echo $_SESSION['Username']; ?>">
						</div>       
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal" style="float: left;">Close</button>
						<button type="submit" class=" add btn btn-success" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Loading..">Submit</button>
					</div>
				</form>   
			</div>
		</div>
	</div>
</div>

<?php include '../admin_templet/admin_templet_footer.php';?>