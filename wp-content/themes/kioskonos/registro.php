<?php
/**
 * Template Name: Registro
 *
 */

get_header(); ?>

<div class="page-header header-filter header-small" data-parallax="true" style="background-image: url('<?php bloginfo('template_url') ?>/assets/img/registro-bg.jpg');">
	<div class="container">
		<div class="row title-row">
    		<div class="col-md-8 col-md-offset-2">
                <h1 class="title">Registro</h1>
            </div>
        </div>
    </div>
</div>

<div class="main main-raised">
	<div class="container">
        <div class="about-description text-center">
        	<form class="form" method="" action="">
            <div class="row">
				<div class="col-md-8 col-md-offset-2">
					<h5 class="description pt-3">This is the paragraph where you can write more details about your product. Keep you user engaged by providing meaningful information. Remember that by this time, the user is curious, otherwise he wouldn't scroll to get here. Add a button if you want the user to see more.</h5>
				</div>
			</div>
			<div class="row-centered">
				<div class="col-centered col-lg-6 col-xs-12">
					<div class="social text-center">
                        <button class="btn btn-just-icon btn-round btn-twitter">
                            <i class="fa fa-twitter"></i>
                        </button>
                        <button class="btn btn-just-icon btn-round btn-dribbble">
                            <i class="fa fa-dribbble"></i>
                        </button>
                        <button class="btn btn-just-icon btn-round btn-facebook">
                            <i class="fa fa-facebook"> </i>
                        </button>
                        <h4> or be classical </h4>
                    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-md-12 col-xs-12">
					<div class="input-group">
						<span class="input-group-addon">
							<i class="material-icons">face</i>
						</span>
						<input type="text" class="form-control" placeholder="First Name...">
					</div>

					<div class="input-group">
						<span class="input-group-addon">
							<i class="material-icons">email</i>
						</span>
						<input type="text" class="form-control" placeholder="Email...">
					</div>

					<div class="input-group">
						<span class="input-group-addon">
							<i class="material-icons">lock_outline</i>
						</span>
						<input type="password" placeholder="Password..." class="form-control" />
					</div>
            	</div>
                <div class="col-lg-6 col-md-12 col-xs-12">
                    
					<div class="input-group">
						<span class="input-group-addon">
							<i class="material-icons">face</i>
						</span>
						<input type="text" class="form-control" placeholder="First Name...">
					</div>

					<div class="input-group">
						<span class="input-group-addon">
							<i class="material-icons">email</i>
						</span>
						<input type="text" class="form-control" placeholder="Email...">
					</div>

					<div class="input-group">
						<span class="input-group-addon">
							<i class="material-icons">lock_outline</i>
						</span>
						<input type="password" placeholder="Password..." class="form-control" />
					</div>

					<!-- If you want to add a checkbox to this form, uncomment this code -->

					<div class="checkbox">
						<label>
							<input type="checkbox" name="optionsCheckboxes" checked>
							I agree to the <a href="#something">terms and conditions</a>.
						</label>
					</div>

					<div class="footer text-center">
						<a href="#pablo" class="btn btn-primary btn-round">Get Started</a>
					</div>
				
                </div>	
			</div>
			</form>
        </div>
    </div>
</div>

<?php get_footer(); ?>
