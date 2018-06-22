    <div class="full-screen">
        <div class="main-content">
            <div class="top-slide"><img src="<?php echo base_url(); ?>assets/images/man-top.png" class="img-responsive" />
            </div>
            <div class="bottom-slide"><img src="<?php echo base_url(); ?>assets/images/car-bottom.png" class="img-responsive" />
            </div>
            <div class="profile-message">
                <div class="container">
                    <div class="info-container">
                        <div class="row">
                            <div class="col-md-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".2s">
                                <h1 class="text-center">Profile Info</h1>
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Name</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" value="Karmer">
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" value="Caswell">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Username</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="Karmer85">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Mobile</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="(502) 123 4567">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Email</label>
                                        <div class="col-sm-8">
                                            <input type="email" class="form-control" value="karmercas@gmail.com">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Password</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" value="*********">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-8 col-sm-offset-4">
                                            <a href="payment-method.html" class="btn btn-brand"><i class="icon-credit-card"></i>Payment method</a>
                                            <a href="#" class="btn btn-brand"><i class="icon-floppy-o"></i>Save</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay=".2s">
                                <h1 class="text-center">Car Info <a href="add-car.html" class="pull-right wow zoomIn" data-wow-duration="1s" data-wow-delay=".5s"><i class="icon-plus22"></i></a></h1>
                                <h3>Car #1</h3>
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Modal & Year</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" value="Toyato 4Runner">
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="custom-select">
                                                <select>
                                                    <option value="">1999</option>
                                                    <option value="">2001</option>
                                                    <option value="">2002</option>
                                                    <option value="">2003</option>
                                                    <option value="">2004</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Color</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="Red">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-8 col-sm-offset-4">
                                            <a href="add-car.html" class="btn btn-brand"><i class="icon-car"></i>Add another car?</a>
                                            <a href="#" class="btn btn-brand"><i class="icon-new-message"></i> Edit</a>
                                        </div>
                                    </div>
                                </form>
                                
                                <h2 class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.6s">Cars Available</h2>
                                
                                    <table class="table table-fancy wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.7s">
                                        <tr>
                                            <th>Modal & Year</th>
                                            <th>Color</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td>Toyato4Runner 2006</td>
                                            <td>Red</td>
                                            <td><a href="#" class="btn btn-warning tooltips" title="Edit"><i class="icon-edit2"></i></a><a href="#" class="btn btn-danger tooltips" title="Delete"><i class="icon-trash22"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>Range Rover 2015</td>
                                            <td>Grey</td>
                                            <td><a href="#" class="btn btn-warning tooltips" title="Edit"><i class="icon-edit2"></i></a><a href="#" class="btn btn-danger tooltips" title="Delete"><i class="icon-trash22"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>Toyato4Runner 2006</td>
                                            <td>Black</td>
                                            <td><a href="#" class="btn btn-warning tooltips" title="Edit"><i class="icon-edit2"></i></a><a href="#" class="btn btn-danger tooltips" title="Delete"><i class="icon-trash22"></i></a></td>
                                        </tr>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <?php print_r($result);?>