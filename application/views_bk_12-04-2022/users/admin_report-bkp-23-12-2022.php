<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Report</h1>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<section class="content">
	<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title bid-add-title">Report</h3>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<div class="col-md-12 row">
						<div class="col-lg-3 col-6">
							<!-- small card -->
							<div class="small-box bg-info">
								<div class="inner">
									<h3><?php echo $total_bids; ?></h3>
									<p>Bids</p>
								</div>
								<div class="icon">
									<i class="fa fa fa-gavel"></i>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-6">
							<!-- small card -->
							<div class="small-box bg-warning">
								<div class="inner">
									<h3><?php echo $total_leads; ?></h3>
									<p>Leads</p>
								</div>
								<div class="icon">
									<i class="fa fa fa-gavel"></i>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-6">
							<!-- small card -->
							<div class="small-box bg-success">
								<div class="inner">
									<h3><?php echo $total_projects; ?></h3>
									<p>Projects</p>
								</div>
								<div class="icon">
									<i class="fa fa fa-gavel"></i>
								</div>
							</div>
						</div>
					</div>
					<form>
						<div class="col-md-12 row">
							<div class="col-md-2 form-group">
								<select class="form-control technology_filter" id="technology_filter" name="technology_filter">
									<?php
										foreach ($tech_arr as $tech_key => $tech_value) {
										?>
									<option value="<?php echo $tech_key; ?>"<?php if(isset($_GET['technology_filter']) && $_GET['technology_filter'] == $tech_key){ echo ' selected'; } ?>><?php echo $tech_value; ?></option>
									<?php
										}
										?>
								</select>
							</div>
							<div class="col-md-2 form-group">
								<select class="form-control user_filter" name="user_filter" id="user_filter">
									<?php
										if($this->session->userdata('user')['role'] == 3){
										?>
									<option value="">No user</option>
									<?php
										}elseif($this->session->userdata('user')['role'] == 1){
										?>
									<option value="0">All users</option>
									<?php
										}
										?>
									<?php
										foreach($users as $u_key => $u_data){
										?>
									<option value="<?php echo $u_data['id']; ?>"<?php if(isset($_GET['user_filter']) && $_GET['user_filter'] == $u_data['id']){ echo ' selected'; } ?>><?php echo $u_data['first_name'] . ' ' . $u_data['last_name']; ?></option>
									<?php
										}
										?>
								</select>
							</div>
							<div class="col-md-2 form-group">
								<select class="form-control status_filter" name="status_filter" id="status_filter">
									<option value="0"<?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == '0'){ echo 'selected'; } ?>>Select status</option>
									<option value="1"<?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == '1'){ echo 'selected'; } ?>>Bid</option>
									<option value="2"<?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == '2'){ echo 'selected'; } ?>>Lead</option>
									<option value="3"<?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == '3'){ echo 'selected'; } ?>>Project</option>
								</select>
							</div>
							<div class="col-md-2 form-group">
								<select class="form-control type_filter" name="type_filter" id="type_filter">
									<option value="day"<?php if(isset($_GET['type_filter']) && $_GET['type_filter'] == 'day'){ echo 'selected'; } ?>>Day</option>
									<option value="month"<?php if(isset($_GET['type_filter']) && $_GET['type_filter'] == 'month'){ echo 'selected'; } ?>>Month</option>
									<option value="year"<?php if(isset($_GET['type_filter']) && $_GET['type_filter'] == 'year'){ echo 'selected'; } ?>>Year</option>
									<option value="custom"<?php if(isset($_GET['type_filter']) && $_GET['type_filter'] == 'custom'){ echo 'selected'; } ?>>Custom</option>
								</select>
							</div>
							<div class="col-md-2 form-group">
								<input type="text" class="form-control date_filter" name="date_filter" value="<?php if(isset($_GET['date_filter'])){ echo $_GET['date_filter']; } else { echo date('Y-m-d'); } ?>">
							</div>
							<?php if(isset($_GET['type_filter']) && $_GET['type_filter'] == 'custom'){ ?>
							<div class="col-md-2 form-group">
								<input type="text" class="form-control end_date_filter" name="end_date_filter" value="<?php if(isset($_GET['end_date_filter'])){ echo $_GET['end_date_filter']; } ?>">
							</div>
							<?php } ?>
							<div class="col-md-2 form-group">
								<button type="submit" class="btn btn-success">Search</button>
							</div>
						</div>
					</form>
					<?php
						if(isset($find_bids)){
						?>
					<table id="example2" class="table table-bordered table-hover table-14-fonts">
						<thead>
							<tr>
								<th>#</th>
								<th>Job Title</th>
								<th>Job Description</th>
								<th>Client Name</th>
								<th>Job URL</th>
								<th>Technology</th>
								<th>Status</th>
								<th>Bid Date</th>
								<?php if($this->session->userdata('user')['role'] == 1){ ?>
								<th>Bidder Name</th>
								<?php } ?>
								<th>Lead Date</th>
								<th>Conversion Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i = 1;
								foreach($find_bids as $bid_id => $bid_data){
								?>
							<tr>
								<td>
									<?php echo $i; ?>
								</td>
								<td>
									<?php echo $bid_data['title']; ?>
								</td>
								<td>
									<?php echo $bid_data['description']; ?>
								</td>
								<td>
									<?php echo $bid_data['client_name']; ?>
								</td>
								<td>
									<?php echo $bid_data['url']; ?>
								</td>
								<td>
									<?php echo $tech_arr[$bid_data['technology']]; ?>
								</td>
								<td>
                                    <?php
                                        // if($bid_data['status'] == "1"){
                                        //     $total_bids = $total_bids + 1;
                                        // }elseif($bid_data['status'] == "2"){
                                        //     $total_leads = $total_leads + 1;
                                        // }elseif($bid_data['status'] == "3"){
                                        //     $total_projects = $total_projects + 1;
                                        // }
                                        echo $status_arr[$bid_data['status']];
                                    ?>
								</td>
								<td>
									<?php echo $bid_data['created']; ?>
								</td>
								<?php if($this->session->userdata('user')['role'] == 1){ ?>
								<td>
									<?php echo $bid_data['first_name'] . ' ' . $bid_data['last_name']; ?>
								</td>
								<?php } ?>
								<td>
									<?php
										if($bid_data['lead_date'] != null){
                                            echo $bid_data['lead_date'];
										}else{
                                            echo '-';
										}
										?>
								</td>
								<td>
									<?php
										if($bid_data['conversion_date'] != null){
                                            echo $bid_data['conversion_date'];
										}else{
                                            echo '-';
										}
										?>
								</td>
								<td>
									<?php
										if($bid_data['status'] == 3){
										?>
									<a class="btn btn-success" data-bidid="<?php echo $bid_data['id']; ?>" data-role="admin" href="<?php echo base_url(); ?>admin/bids/edit_bid/<?php echo $bid_data['id']; ?>">Edit</a>
									<?php
										}
										?>
									<?php
										if($bid_data['status'] < 3){
										?>
									<a class="btn btn-success" data-bidid="<?php echo $bid_data['id']; ?>" data-role="admin" href="<?php echo base_url() ?>admin/bids/edit_bid/<?php echo $bid_data['id']; ?>">Edit</a>
									<?php
										}
										?>
									<?php
										if($bid_data['status'] == 1){
										?>
									<a class="btn btn-primary change_status make_lead" data-bidid="<?php echo $bid_data['id']; ?>" data-role="admin">Lead</a>
									<?php
										}elseif($bid_data['status'] == 2){
										?>
									<a class="btn btn-primary change_status make_project" data-bidid="<?php echo $bid_data['id']; ?>" data-role="admin">Project</a>
									<?php
										}
										?>
									<a class="btn btn-danger delete_bid" data-bidid="<?php echo $bid_data['id']; ?>" data-role="admin">Delete</a>
								</td>
							</tr>
							<?php
								$i++;
								}
								?>
						</tbody>
					</table>
					<?php
						}
						?>
				</div>
			</div>
		</div>
	</div>
</section>