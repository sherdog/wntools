<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h1>ERROR!</h1>
			<div class="well">
				<p>
					<?php if($message): ?><?php echo "<h4>".$message."</h4>"; ?><?php else: ?><h4>There was an error in your request</h4><?php endif; ?>
				</p>
			</div>
		</div>
	</div>
</div>