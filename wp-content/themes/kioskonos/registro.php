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

			if( !checkPasswordStrength($_POST['password']) ){
				$_SESSION['kioskonos_alert'] = 'La contraseña debe tener como mínimo 6 caracteres y mezclar números con letras';
				header('Location: ' . get_bloginfo('wpurl') . '/registro' );
				exit();
			}

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

			$nombre_completo = explode(" ",$_POST['nombre']);
			$nombre = $nombre_completo[0];
			update_post_meta( $last_user_id, 'nombre', $nombre );
			array_shift($nombre_completo);
			$apellido = implode(" ",$nombre_completo);
			update_post_meta( $last_user_id, 'apellido', $apellido );
			
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
				'post_title' => 'Tienda de ' . $nombre,
				'post_excerpt' => '',
				'post_status' => 'publish',
				'post_type' => 'tiendas',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_password' => '',
				'post_name' => sanitize_title('Tienda de ' . $nombre),
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
			update_post_meta( $last_tienda_id, 'sud', true );
			update_post_meta( $last_user_id, 'tienda', $last_tienda_id );


			$_SESSION['kioskonos_logged'] = true;
            $_SESSION['kioskonos_user_id'] = $last_user_id;
            $_SESSION['kioskonos_nombre_completo'] = $_POST['nombre'];
            $_SESSION['kioskonos_email'] = $_POST['email'];
            $_SESSION['kioskonos_tienda_id'] = $last_tienda_id;


            /****************************************
            Enviar mail de bienvenida
            *****************************************/
			$mail_body = '
            <style>
			td{
				font-family: sans-serif;
			}
			p{
				font-size: 16px;
			    line-height: 24px;
			    font-weight: lighter;
			}
			</style>
			<table style="width: 80%; margin: 0 auto" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding: 30px; background-color: #4caf50">
						<img alt="Bienvenido a KioskoNOS" src="https://www.kioskonos.cl/wp-content/themes/kioskonos/assets/img/logo_welcome.png" style="display: block; margin: 0 auto">
					</td>
				</tr>
				<tr>
					<td style="padding: 50px 120px">
						<p><strong>Hola ' . $nombre . '...</strong></p>
						<p>Ya eres parte de <a href="https://www.kioskonos.cl">KioskoNOS</a>, el primer portal de ventas, exclusivo para el sector Nos, en San Bernardo.<p>
						<p>
							Te recordamos que tus datos de acceso son:<br>
							Usuario: ' . $_POST['email'] . '<br>
							Contraseña: ' . $_POST['password'] . '
						</p>
						<p>Recuerda que puedes cambiar tus datos cuando quieras, entrando a la seccion "Mi Perfil". </p>
						<p>
							Ahora tendrás acceso a crear tu propia tienda, para vender tus productos. Solo sigue los tips y consejos que te damos, para que tengas en un solo lugar todos tus productos.<br>
							Podrás guardar tus productos favoritos y tener acceso a ellos cuando quieras.<br>
							También podrás hacer los pedidos de tus tiendas favoritas, ya que necesitas estar registrado para poder hacer el pedido.
						</p>
						<p>Eres libre de activar y desactivar tu tienda cuando quieras, y aún seguir navegando dentro del sitio y pedir tus productos favoritos.</p>
						<p>Si tienes dudas, sugerencias, reclamos, felicitaciones, lo que se te ocurra, siéntete libre de enviarnos un mensaje para que podamos ayudarte en <a href="https://www.kioskonos.cl/contacto/">https://www.kioskonos.cl/contacto/</a></p>
						<p><br>Team KioskoNOS</p>
					</td>
				</tr>
				<tr>
					<td style="padding: 20px 50px; background-color: #eee">
						<table style="width: 100%;" cellspacing="0" cellpadding="0">
							<tr>
								<td style="text-align: left;"><span style="font-size: 14px; color:#777">Kioskonos.cl</span></td>
								<td style="text-align: right;">
									<a href="" style="text-decoration: none;">
										<img alt="Facebook" style="width: 24px; height: auto;" src="https://www.kioskonos.cl/wp-content/themes/kioskonos/assets/img/facebook_icon.png">
									</a>
									 &nbsp; 
									<a href="" style="text-decoration: none;">
										<img alt="Instagram" style="width: 24px; height: auto;" src="https://www.kioskonos.cl/wp-content/themes/kioskonos/assets/img/instagram_icon.png">
									</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
	        ';

	        enviarMail($_POST['email'],"","Bienvenido a KioskoNOS",$mail_body);

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
						<h5 class="description pt-3">
							Regístrate en KioskoNOS y tendrás acceso a crear tu propia tienda, para vender tus productos. Podrás guardar tus favoritos y tener acceso a ellos cuando quieras.<br>
							También podrás hacer los pedidos de tus tiendas favoritas, ya que necesitas estar registrado para poder hacer el pedido.
						</h5>
					</div>
				</div>
				<!--
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
				-->
				<div class="row row-centered">
					<div class="col-centered col-lg-6 col-md-12 col-xs-12">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="material-icons">face</i>
							</span>
							<input type="text" name="nombre" class="form-control" placeholder="Nombre y Apellido..." required>
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
							<input type="password" name="password" placeholder="Contraseña..." class="form-control"  required />
							<span class="input-group-addon">
								<a href="javascript: alerta({text:'Usa una contraseña de al menos 6 caracteres de largo y mezcla números con letras'})">
									<i class="material-icons">help_outline</i>
								</a>
							</span>
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
