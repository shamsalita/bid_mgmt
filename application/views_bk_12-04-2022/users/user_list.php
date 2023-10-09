<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
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
                <h3 class="card-title">Users</h3>
                <a class="btn btn-primary float-right" href="<?php echo base_url(); ?>admin/add_user">Add User</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>DOB</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                        $i = 1;
                        foreach($users as $user_key => $user_data){
                    ?>
                    <tr>
                        <td>
                            <?php echo $i; ?>
                        </td>
                        <td>
                            <?php echo $user_data['first_name'] . ' ' . $user_data['last_name']; ?>
                        </td>
                        <td>
                            <?php echo $user_data['email']; ?>
                        </td>
                        <td>
                            <?php echo $user_data['dob']; ?>
                        </td>
                        <td>
                            <a class="btn btn-primary" href="<?php echo base_url(); ?>admin/edit_user/<?php echo $user_data['id']; ?>">Edit</a>
                            <a class="btn btn-danger delete-user" data-userid="<?php echo $user_data['id']; ?>">Delete</a>
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