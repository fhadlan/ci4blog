<?php $this->extend('backend/layout/auth-layout.php') ?>
<?php $this->section('content') ?>

<div class="col-md-6 col-lg-5">
	<div class="login-box bg-white box-shadow border-radius-10">
		<div class="login-title">
			<h2 class="text-center text-primary">Login</h2>
		</div>

		<?php $validation = \Config\Services::validation(); ?>
		<form action="<?php route_to('admin.login.handler'); ?>" method="POST">
			<?= csrf_field()?>
			<?php if (!empty(session()->getFlashdata('success'))) : ?>
				<div class="alert alert-success">
					<?php echo session()->getFlashdata('success'); ?>
					<button type='button' class='close' data-dismiss="alert" aria-label="close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php endif; ?>
			<?php if (!empty(session()->getFlashdata('fail'))) : ?>
				<div class="alert alert-danger">
					<?php echo session()->getFlashdata('fail'); ?>
					<button type='button' class='close' data-dismiss="alert" aria-label="close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php endif; ?>

			<!-- login id-->
			<div class="input-group custom">
				<input type="text" class="form-control form-control-lg" placeholder="Username or Email" name="login_id" value="<?php set_value('login_id'); ?>" />
				<div class="input-group-append custom">
					<span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
				</div>
			</div>
			<!-- validation id-->
			<?php if ($validation->getError('login_id')) : ?>
				<div class="d-block text-danger" style="margin-top: -25; margin-bottom:15;">
					<?php echo $validation->getError('login_id'); ?>
				</div>
			<?php endif; ?>

			<!-- password-->
			<div class="input-group custom">
				<input type="password" class="form-control form-control-lg" placeholder="**********" name="password" value="<?php set_value('password'); ?>" />
				<div class="input-group-append custom">
					<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
				</div>
			</div>
			<!-- validation password-->
			<?php if ($validation->getError('password')) : ?>
				<div class="d-block text-danger" style="margin-top: -25; margin-bottom:15;">
					<?php echo $validation->getError('password'); ?>
				</div>
			<?php endif; ?>


			<div class="row pb-30">
				<div class="col-6">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="customCheck1" />
						<label class="custom-control-label" for="customCheck1">Remember</label>
					</div>
				</div>
				<div class="col-6">
					<div class="forgot-password">
						<a href="<?= route_to('admin.forgot.form') ?>">Forgot Password</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="input-group mb-0">
						<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
					</div>
					<div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">

					</div>

				</div>
			</div>
		</form>
	</div>
</div>

<?php $this->endSection() ?>