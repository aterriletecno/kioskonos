<?php
@session_start();
/**
 * Template Name: Login
 *
 */

if( $_POST || session('logged') ):

	$user = checkValidUser($_POST['email'],$_POST['password']);
	if($user):
		if( $_GET['redirect'] ){
			$goto = urldecode($_GET['redirect']);
		} else {
			$goto = get_bloginfo('wpurl') . '/mi-tienda/';
		}
		header('Location: ' . $goto);
		exit();
	endif;
endif;

get_header(); 

while (have_posts()) : the_post();
?>

<div class="page-header header-filter header-small" data-parallax="true" style="background-image: url('<?php bloginfo('template_url') ?>/assets/img/registro-bg.jpg');">
	<div class="container">
		<div class="row title-row">
    		<div class="col-md-8 col-md-offset-2">
                <h1 class="title">Acceder</h1>
            </div>
        </div>
    </div>
</div>

<div class="main main-raised">
	<div class="container">
        <div class="about-description text-center py-3">
        	<form class="form" method="post" action="">
	            <div class="row">
					<div class="col-md-8 col-md-offset-2">
					</div>
				</div>
				<div class="row-centered">
					<div class="col-centered col-lg-6 col-xs-12">
						<div class="social text-center">
	                        <a href="#" class="btn btn-facebook btn-round btn-facebook-login">
	    						<i class="fa fa-facebook-square"></i> Entrar con Facebook
	    					</a>
	                        <h4> o accede con tus datos: </h4>
	                    </div>
					</div>
				</div>
				<div class="row row-centered">
					<div class="col-centered col-lg-6 col-md-12 col-xs-12">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="material-icons">email</i>
							</span>
							<input type="email" name="email" class="form-control" placeholder="Email..." required>
						</div>

						<div class="input-group">
							<span class="input-group-addon">
								<i class="material-icons">lock_outline</i>
							</span>
							<input type="password" name="password" placeholder="Password..." class="form-control" required />
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-success">Acceder &nbsp; <i class="material-icons">forward</i></button>
							<br><br>
							<a href="<?php bloginfo('wpurl') ?>/registro">o Registrarme</a>
						</div>
	            	</div>
				</div>
			</form>
        </div>
    </div>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>
