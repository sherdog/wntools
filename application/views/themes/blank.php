<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title; ?></title>
<meta name="resource-type" content="document" />
<meta name="robots" content="all, index, follow"/>
<meta name="googlebot" content="all, index, follow" />
<script src="<?php echo base_url('assets/js/jquery-1.9.1.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<?php
		 foreach($js as $file){
				echo "\n\t\t"; 
				?><script src="<?php echo $file; ?>"></script><?php
		 } echo "\n\t"; 
?>	
<?php
		
		 foreach($css as $file){ 
		 	echo "\n\t\t"; 
			?><link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" /><?php
		 } echo "\n\t"; 
?>
<?php
		if(!empty($meta)) 
			foreach($meta as $name=>$content){
				echo "\n\t\t"; 
				?><meta name="<?php echo $name; ?>" content="<?php echo is_array($content) ? implode(", ", $content) : $content; ?>" /><?php
		 }
	?>


<link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/wn.css'); ?>">
</head>
<body>
	<div class="container">
		<div class="row">
			<?php echo $output;?>
		</div>
	</div>
</body>
</html>