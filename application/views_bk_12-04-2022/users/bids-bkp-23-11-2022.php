<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Bids</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title bid-add-title">Bids</h3>
                <a class="btn btn-primary float-right" href="<?php echo base_url() . $user_role; ?>add_bid">Add Bid</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form>
              <div class="col-md-6 row">
                  <div class="col-md-4 form-group">
                    <input type="text" name="from_date" id="from_date" class="form-control search_from_date" value="<?php if($this->input->get('from_date')){ echo $this->input->get('from_date'); } ?>">
                  </div>
                  <div class="col-md-4 form-group">
                    <input type="text" name="to_date" id="to_date" class="form-control search_to_date" value="<?php if($this->input->get('from_date')){ echo $this->input->get('to_date'); } ?>">
                  </div>
                  <div class="col-md-4 form-group">
                    <button type="submit" class="btn btn-success">Search</button>
                  </div>
                </div>
                </form>
                <table id="example2" class="table table-bordered table-hover table-14-fonts">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Job Title</th>
                    <th>Job Description</th>
                    <th>Client Name</th>
                    <th>Job URL</th>
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
                        foreach($bids as $bid_id => $bid_data){
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
                            <?php echo $status_arr[$bid_data['status']]; ?>
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
                            if($bid_data['status'] == 3 && $user_role == 'admin/'){
                            ?>
                              <a class="btn btn-success" data-bidid="<?php echo $bid_data['id']; ?>" data-role="<?php echo $user_role; ?>" href="<?php echo base_url() . $user_role; ?>bids/edit_bid/<?php echo $bid_data['id']; ?>">Edit</a>
                            <?php
                            }
                            ?>
                            <?php
                            if($bid_data['status'] < 3){
                            ?>
                              <a class="btn btn-success" data-bidid="<?php echo $bid_data['id']; ?>" data-role="<?php echo $user_role; ?>" href="<?php echo base_url() . $user_role; ?>bids/edit_bid/<?php echo $bid_data['id']; ?>">Edit</a>
                            <?php
                            }
                            ?>
                            <?php
                            if($bid_data['status'] == 1){
                            ?>
                            <a class="btn btn-primary change_status make_lead" data-bidid="<?php echo $bid_data['id']; ?>" data-role="<?php echo $user_role; ?>">Lead</a>
                            <?php
                            }elseif($bid_data['status'] == 2){
                            ?>
                            <a class="btn btn-primary change_status make_project" data-bidid="<?php echo $bid_data['id']; ?>" data-role="<?php echo $user_role; ?>">Project</a>
                            <?php
                            }
                            if($user_role == 'admin/'){
                            ?>
                            <a class="btn btn-danger delete_bid" data-bidid="<?php echo $bid_data['id']; ?>" data-role="<?php echo $user_role; ?>">Delete</a>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                        $i++;
                        }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>