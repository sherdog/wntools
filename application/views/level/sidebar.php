<div class="well">
	<div class="panel panel-default">
	  <!-- Default panel contents -->
	  <div class="panel-heading">Level Options</div>
	  <!-- List group -->
	  <ul class="list-group">
	  	<li class="list-group-item"><a href="<?php echo base_url('level/edit/' . $this->uri->segment(3).'/'.$this->uri->segment(4)); ?>">Edit Level</a></li>
	    <li class="list-group-item"><a href="<?php echo base_url('level/grid/'. $this->uri->segment(3).'/'.$this->uri->segment(4)); ?>">Grid</a></li>
	    <li class="list-group-item"><a href="<?php echo base_url('level/objectives/'.$this->uri->segment(3).'/'.$this->uri->segment(4)); ?>">Objectives</a></li>
	    <li class="list-group-item"><a href="<?php echo base_url('level/star_levels/'.$this->uri->segment(3).'/'.$this->uri->segment(4)); ?>">Score Tier</a></li>
	</div>
</div>