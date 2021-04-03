<title>Test CI Application - <?php echo $title;?></title>

<meta name="description" content="overview & stats">

<!-- bootstrap & fontawesome -->
		  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
		  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/fontawesome.min.css">
		  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-theme.min.css" class="theme-stylesheet" id="theme-style">
<!-- page specific plugin styles -->

<!---- navbar start -->
	<!-- Static navbar -->
	<nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#">About</a></li>
              <li><a href="#">Contact</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="active"><a href="./">Default <span class="sr-only">(current)</span></a></li>
              <li><a href="../navbar-static-top/">Static top</a></li>
              <li><a href="../navbar-fixed-top/">Fixed top</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
<!---- nav bar list -->

<div class="page-content">



<div class="row">


<div class="col-xs-12">
				<!-- PAGE CONTENT BEGINS -->
								<?php echo $contents;?>
				<!-- PAGE CONTENT ENDS -->
</div>

<!-- /.col -->
</div>

<!-- /.row -->
</div>

<!-- /.page-content -->

<!-- /.main-content -->



<div class="footer">


<div class="footer-inner">


<div class="footer-content">
<span class="bigger-120">
Copyright © js-tutorials.com. All rights reserved.
</span>
</div>


</div>


</div>



<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>
<!-- /.main-container -->

<!-- basic scripts -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>