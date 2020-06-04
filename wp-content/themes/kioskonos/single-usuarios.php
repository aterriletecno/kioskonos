<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

if( $_POST ):
	$updated_post_arr = array(
		'ID'  => session('user_id'),
		'post_title' => $_POST['nombre']
  	);
  	wp_update_post( $updated_post_arr );
  	if( $_POST['password'] != "" ){
  		update_post_meta( session('user_id'), 'password', md5($_POST['password']) );
  	}
  	$_SESSION['kioskonos_alert'] = 'Datos actualizados correctamente';
	header('Location: ' . get_bloginfo('wpurl') . '/?post_type=usuarios&p=' . session('user_id') );
	exit();
endif;

get_header();
while (have_posts()) : the_post();
if( get_the_ID() == session('user_id') ):
?>

<div class="page-header header-filter header-small" data-parallax="true" style="background-image: url('<?php bloginfo('template_url') ?>/assets/img/registro-bg.jpg');">
	<div class="container">
		<div class="row title-row">
    		<div class="col-md-8 col-md-offset-2">
                <h1 class="title">Perfil de usuario</h1>
                <h3 class="title"><?php the_title(); ?></h3>	
            </div>
        </div>
    </div>
</div>

<div class="profile-page">
	<div class="main main-raised">
		<div class="profile-content">
	        <div class="container">


	            <form method="post" action="" autocomplete="off">
	            	<input style="position: absolute; top: -999999px; left: -9999999px" type="text" name="fakeusernameremembered"/>
					<input style="position: absolute; top: -999999px; left: -9999999px" type="password" name="fakepasswordremembered"/>

		            <div class="row row-centered pb-5">
						<div class="col-centered col-lg-6 col-md-12 col-xs-12">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">face</i>
								</span>
								<input type="text" name="nombre" maxlength="100" class="form-control" placeholder="Nombre completo..." value="<?php the_title(); ?>" required>
							</div>

							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">email</i>
								</span>
								<input type="text" onfocus="javascript: alerta({text:'No puedes editar el email, ya que es tu llave de acceso al sitio'})" class="form-control" placeholder="Email..." value="<?php the_field('email') ?>" readonly required>
							</div>

							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">lock_outline</i>
								</span>
								<input type="password" name="password" placeholder="Cambiar Password..." class="form-control" />
							</div>

							<div class="text-center">
								<button type="submit" class="btn btn-success">Guardar &nbsp; <i class="material-icons">save</i></button>
							</div>
		            	</div>
					</div>
				</form>

	        </div>
	    </div>
	</div>
</div>

<?php  
else:
?>
<script>window.location.href="<?php bloginfo('wpurl'); ?>"</script>
<?php
	exit();
endif;
?>

<?php endwhile; ?>
<?php get_footer(); ?>