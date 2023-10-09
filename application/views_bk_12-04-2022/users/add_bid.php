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
                <h3 class="card-title">Add Bid</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form method="POST">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Job Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
                        </div>
                        <div class="form-group">
                            <label for="title">Job Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Enter description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="client_name">Client Name</label>
                            <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Enter Client Name">
                        </div>
                        <div class="form-group">
                            <label for="title">Job URL</label>
                            <input type="text" class="form-control" id="url" name="url" placeholder="Enter URL">
                        </div>
                        <!-- <div class="form-group">
                            <label for="rate">Rate</label>
                            <input type="text" class="form-control" id="rate" name="rate" placeholder="Enter rate">
                        </div> -->
                        <div class="form-group">
                            <label for="technology">Technology</label>
                            <select class="form-control" id="technology" name="technology">
                              <option value="1">PHP</option>
                              <option value="2">React</option>
                              <option value="3">Vue</option>
                              <option value="4">React + Laravel</option>
                              <option value="5">Laravel</option>
                              <option value="6">CI</option>
                              <option value="7">Angular</option>
                              <option value="8">Node</option>
                              <option value="9">MERN</option>
                              <option value="10">MEAN</option>
                              <option value="11">Laravel + Vue</option>
                              <option value="12">Need to select</option>
                              <option value="13">Fullstack</option>
                              <option value="14">Angular + Laravel</option>
                              <option value="15">Angular + PHP</option>
                              <option value="16">Wordpress</option>
                              <option value="17">Front End</option>
                              <option value="18">Shopify app</option>
                              <option value="19">React + Node</option>
                              <option value="20">PERN</option>
                              <option value="21">React + PHP</option>
                              <option value="22">QA + Testing</option>
                              <option value="23">WebFlow</option>
                              <option value="24">WebFlow + SEO</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Add</button>
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