<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Bids</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Edit Bid</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form method="POST">
                  <?php
                    $user_role = 'user/';
                    $bid_user_id = $this->session->userdata('user')['id'];
                    if($this->session->userdata('user')['role'] == 1){
                        $user_role = 'admin/';
                        $bid_user_id = null;
                    }
                  ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Job Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="<?php echo $bid_details['title']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="title">Job Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Enter description"><?php echo $bid_details['description']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="client_name">Client Name</label>
                            <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Enter Client Name" value="<?php echo $bid_details['client_name']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="title">Job URL</label>
                            <input type="text" class="form-control" id="url" name="url" placeholder="Enter URL" value="<?php echo $bid_details['url']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="title">Country</label>
                            <select class="form-control" id="country_id" name="country_id" required>
                              <option value="247" <?php if($bid_details['country_id'] == 247){ echo 'selected'; } ?>>No Country</option>
                              <?php
                                foreach($countries as $cid => $cname){
                              ?>
                                <option value="<?php echo $cname['id']; ?>" <?php if($bid_details['country_id'] == $cname['id']){ echo 'selected'; } ?>><?php echo $cname['country_name']; ?></option>
                              <?php
                                }
                              ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Job Type</label>
                            <select class="form-control" id="job_type" name="job_type" required>
                              <option>Select</option>
                              <option value="0" <?php if($bid_details['job_type'] == 0){ echo 'selected'; } ?>>Hourly</option>
                              <option value="1" <?php if($bid_details['job_type'] == 1){ echo 'selected'; } ?>>Fixed</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="rate">Rate</label>
                            <input type="text" class="form-control" id="rate" name="rate" placeholder="Enter rate" value="<?php echo $bid_details['rate']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="technology">Technology</label>
                            <?php
                            $technology = $bid_details['technology'];
                            ?>
                            <select class="form-control" id="technology" name="technology">
                              <option value="1" <?php if($technology == 1){ echo 'selected'; } ?>>PHP</option>
                              <option value="2" <?php if($technology == 2){ echo 'selected'; } ?>>React</option>
                              <option value="3" <?php if($technology == 3){ echo 'selected'; } ?>>Vue</option>
                              <option value="4" <?php if($technology == 4){ echo 'selected'; } ?>>React + Laravel</option>
                              <option value="5" <?php if($technology == 5){ echo 'selected'; } ?>>Laravel</option>
                              <option value="6" <?php if($technology == 6){ echo 'selected'; } ?>>CI</option>
                              <option value="7" <?php if($technology == 7){ echo 'selected'; } ?>>Angular</option>
                              <option value="8" <?php if($technology == 8){ echo 'selected'; } ?>>Node</option>
                              <option value="9" <?php if($technology == 9){ echo 'selected'; } ?>>MERN</option>
                              <option value="10" <?php if($technology == 10){ echo 'selected'; } ?>>MEAN</option>
                              <option value="11" <?php if($technology == 11){ echo 'selected'; } ?>>Laravel + Vue</option>
                              <option value="12" <?php if($technology == 12){ echo 'selected'; } ?>>Fullstack</option>
                              <option value="13" <?php if($technology == 13){ echo 'selected'; } ?>>Angular + Laravel</option>
                              <option value="14" <?php if($technology == 14){ echo 'selected'; } ?>>Angular + PHP</option>
                              <option value="15" <?php if($technology == 15){ echo 'selected'; } ?>>Wordpress</option>
                              <option value="16" <?php if($technology == 16){ echo 'selected'; } ?>>Front End</option>
                              <option value="17" <?php if($technology == 17){ echo 'selected'; } ?>>React + SEO</option>
                              <option value="18" <?php if($technology == 18){ echo 'selected'; } ?>>Webflow</option>
                              <option value="19" <?php if($technology == 19){ echo 'selected'; } ?>>QA</option>
                              <option value="20" <?php if($technology == 20){ echo 'selected'; } ?>>Shopify app</option>
                              <option value="21" <?php if($technology == 21){ echo 'selected'; } ?>>Next.js</option>
                              <option value="22" <?php if($technology == 22){ echo 'selected'; } ?>>Nuxt.js</option>
                              <option value="23" <?php if($technology == 23){ echo 'selected'; } ?>>.NET MVC</option>
                              <option value="24" <?php if($technology == 24){ echo 'selected'; } ?>>.NET Core</option>
                              <option value="25" <?php if($technology == 25){ echo 'selected'; } ?>>.NET</option>
                              <option value="26" <?php if($technology == 26){ echo 'selected'; } ?>>.NET + React</option>
                              <option value="27" <?php if($technology == 27){ echo 'selected'; } ?>>.NET + Angular</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="<?php echo base_url() . $user_role; ?>bids" class="btn btn-light">Cancel</a>
                        </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>