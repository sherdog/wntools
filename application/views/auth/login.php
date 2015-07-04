
<div class="row">
  <div class="col-sm-4 col-sm-offset-4 well" style="margin-top:150px;">
    <?php if($message !='') : ?>
    <div id="infoMessage" class="alert alert-danger"><?php echo $message;?></div>
    <?php endif; ?>
    <?php echo form_open("auth/login");?>
      <div class="form-group">
        <?php echo lang('login_identity_label', 'identity');?>
        <?php echo form_input($identity);?>
      </div>
       <div class="form-group">
        <?php echo lang('login_password_label', 'password');?>
        <?php echo form_input($password);?>
      </div>
       <div class="form-group">
        <?php echo lang('login_remember_label', 'remember');?>
        <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
      </div>
      <div class="form-group"><?php echo form_submit('submit', lang('login_submit_btn'), 'class="btn btn-primary btn-block"');?></div>
    <?php echo form_close();?>
    <p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>
  </div>
</div>