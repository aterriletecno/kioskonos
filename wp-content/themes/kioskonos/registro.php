<?php
/**
 * Template Name: Registro
 *
 */

if( session('logged') ):
	$user = checkValidUser($_POST['email'],$_POST['password']);
	if($user):
		header('Location: ' . get_bloginfo('wpurl') . '/mi-tienda/');
		exit();
	endif;
endif;

get_header(); 

?>

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
	                        <a href="#" class="btn btn-facebook btn-round btn-facebook-login">
	    						<i class="fa fa-facebook-square"></i> Entrar con Facebook
	    					</a>
	                        <h4> o puedes llenar los campos manualmente </h4>
	                    </div>
					</div>
				</div>
				<div class="row row-centered">
					<div class="col-centered col-lg-6 col-md-12 col-xs-12">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="material-icons">face</i>
							</span>
							<input type="text" class="form-control" placeholder="Nombre completo...">
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
				</div>
			</form>
        </div>
    </div>
</div>

<?php get_footer(); ?>
