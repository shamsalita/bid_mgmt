<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
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
                <h3 class="card-title">Edit User</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form method="POST">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tl">TL</label>
                            <select class="form-control" id="tl" name="tl">
                              <option value="0">No TL</option>
                              <?php
                              foreach ($tls as $tl_key => $tl_val){
                              ?>
                              <option value="<?php echo $tl_val['id'] ?>"<?php if($user['tl'] == $tl_val['id']){ echo ' selected'; } ?>><?php echo $tl_val['first_name'] . ' ' . $tl_val['last_name']; ?></option>
                              <?php
                              }
                              ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" value="<?php echo $user['first_name']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" value="<?php echo $user['last_name']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo $user['email']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of birthd</label>
                            <input type="text" class="form-control" id="dob" name="dob" placeholder="YYYY/MM/DD" value="<?php echo $user['dob']; ?>">
                        </div>
                        <div class="form-group form-check left-pad-0">
                            <input type="checkbox" class="tl_cb" id="role" name="role" class="form-check-input" value="3"<?php if($user['role'] == 3){ echo 'checked'; } ?>>
                            <label for="role" class="form-check-label">Is TL</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="<?php echo base_url(); ?>admin/users" class="btn btn-light">Cancel</a>
                        </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>