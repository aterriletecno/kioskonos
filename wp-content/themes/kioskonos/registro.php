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
else:
	if( $_POST ):
		if (getUserByEmail( $_POST['email'] )){
			$_SESSION['kioskonos_alert'] = 'Ya existe un usuario con el email ingresado';
			header('Location: ' . get_bloginfo('wpurl') . '/registro' );
			exit();
		} else {


			$current_date = date('Y-m-d H:i:s');
			$ayer = strtotime ( '-1 day' , strtotime ( $current_date ) ) ;
			$ayer = date ( 'Y-m-d H:i:s' , $ayer );
			
			// Primero, crear al usuario
			$user_array = [
				'ID' => 0,
				'post_author' => 1,
				'post_date' => $ayer,
				'post_date_gmt' => $ayer,
				'post_content' => '',
				'post_content_filtered' => '',
				'post_title' => $_POST['nombre'],
				'post_excerpt' => '',
				'post_status' => 'publish',
				'post_type' => 'usuarios',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_password' => '',
				'post_name' => sanitize_title($_POST['nombre']),
				'to_ping' => '',
				'pinged' => '',
				'post_modified' => $current_date,
				'post_modified_gmt' => $current_date,
				'post_parent' => 0,
				'menu_order' => 0,
				'post_mime_type' => '',
				'guid' => '',
				'post_category' => '',
				'tags_input' => '',
				'tax_input' => '',
				'meta_input' => ''
			];

			$last_user_id = wp_insert_post($user_array);
			update_post_meta( $last_user_id, 'email', $_POST['email'] );
			update_post_meta( $last_user_id, 'password', md5($_POST['password']) );
			update_post_meta( $last_user_id, 'activo', true );



			// Crearle una tienda vacia (e inactiva) al usuario re100 creado
			$tienda_array = [
				'ID' => 0,
				'post_author' => 1,
				'post_date' => $ayer,
				'post_date_gmt' => $ayer,
				'post_content' => '',
				'post_content_filtered' => '',
				'post_title' => 'Tienda de ' . $_POST['nombre'],
				'post_excerpt' => '',
				'post_status' => 'publish',
				'post_type' => 'tiendas',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_password' => '',
				'post_name' => sanitize_title('Tienda de ' . $_POST['nombre']),
				'to_ping' => '',
				'pinged' => '',
				'post_modified' => $current_date,
				'post_modified_gmt' => $current_date,
				'post_parent' => 0,
				'menu_order' => 0,
				'post_mime_type' => '',
				'guid' => '',
				'post_category' => '',
				'tags_input' => '',
				'tax_input' => '',
				'meta_input' => ''
			];

			$last_tienda_id = wp_insert_post($tienda_array);
			update_post_meta( $last_tienda_id, 'activa', false );
			update_post_meta( $last_user_id, 'tienda', $last_tienda_id );


			$_SESSION['kioskonos_logged'] = true;
            $_SESSION['kioskonos_user_id'] = $last_user_id;
            $_SESSION['kioskonos_nombre_completo'] = $_POST['nombre'];
            $_SESSION['kioskonos_email'] = $_POST['email'];
            $_SESSION['kioskonos_tienda_id'] = $last_tienda_id;

			$_SESSION['kioskonos_alert'] = '<p class="text-center"><strong>Listo!</strong></p>Ya eres parte de KioskoNOS.<br>Ahora puedes crear tu propia tienda, si asi lo quieres, o navegar para buscar los productos que más te interesan';
			header('Location: ' . get_bloginfo('wpurl') . '/mi-tienda' );
			exit();

		}
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
        	<form class="form" method="post" action="" id="register-form">
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
							<input type="text" name="nombre" class="form-control" placeholder="Nombre completo..." required>
						</div>

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
							<input type="password" name="password" placeholder="Password..." class="form-control"  required />
						</div>
						<div class="input-group">
							<div class="checkbox ml-2">
								<label>
									<input type="checkbox" name="terminos">
									Acepto los <a href="<?php bloginfo('wpurl') ?>/terminos-y-condiciones" target="_blank"> Términos y condiciones</a>
								</label>
							</div>
						</div>
						<div class="text-center pb-5">
							<button type="submit" class="btn btn-success">Registrarme &nbsp; <i class="material-icons">forward</i></button>
						</div>
	            	</div>
				</div>
			</form>
        </div>
    </div>
</div>

<?php get_footer(); ?>
