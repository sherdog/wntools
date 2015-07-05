<html lang="en">
	<head>
		<title><?php echo $title; ?></title>
		<meta name="resource-type" content="document" />
		<meta name="robots" content="all, index, follow"/>
		<meta name="googlebot" content="all, index, follow" />
		<script src="<?php echo base_url('assets/js/jquery-1.9.1.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
	<?php
	/** -- Copy from here -- */
	if(!empty($meta))
	foreach($meta as $name=>$content){
		echo "\n\t\t";
		?><meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" /><?php
			 }
	echo "\n";

	if(!empty($canonical))
	{
		echo "\n\t\t";
		?><link rel="canonical" href="<?php echo $canonical?>" /><?php

	}
	echo "\n\t";

	foreach($css as $file){
	 	echo "\n\t\t";
		?><link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" /><?php
	} echo "\n\t";

	foreach($js as $file){
			echo "\n\t\t";
			?><script src="<?php echo $file; ?>"></script><?php
	} echo "\n\t";

	/** -- to here -- */
?>

<link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/wn.css'); ?>">
</head>

  <body>

     <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Word Ninja Quest</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="<?php echo base_url('tools'); ?>">Tools</a></li>
            <li><a href="#contact">Players</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Levels <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo base_url('level'); ?>">Manage Levels</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Add Level</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
             <?php if ($this->ion_auth->is_admin()): ?>
             <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo base_url('auth/index'); ?>">List Users</a></li>
                <li><a href="<?php echo base_url('auth/create_user'); ?>">Add User</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="<?php echo base_url('auth/change_password'); ?>">Update Password</a></li>
              </ul>
            </li>
            <?php endif; ?>
            <li><a href="<?php echo base_url('auth/logout'); ?>">Log out</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
    <?php if($this->load->get_section('text_header') != '') { ?>
    	<h1><?php echo $this->load->get_section('text_header');?></h1>
    <?php }?>
    <div class="row">
	    <?php echo $output;?>
		<?php echo $this->load->get_section('sidebar'); ?>
    </div>
      <hr/>

      <footer>
      	<div class="row">
	        <div class="span6 b10">
				Copyright &copy; <a target="_blank" href="http://wordninjaquest.com">Word Ninja Quest</a> | <a target="_blank" href="http://interactivearmy.com">www.interactivearmy.com</a>
	        </div>
        </div>
      </footer>

    </div> <!-- /container -->
</body></html>
