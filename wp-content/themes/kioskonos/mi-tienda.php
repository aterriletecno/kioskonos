<?php
@session_start();
/**
 * Template Name: Mi Tienda
 *
 */


$tienda_id = session('tienda_id');
if( is_object($tienda_id) ){
	$tienda_id = $tienda_id->ID;
}

if( session('logged') ){
	
	if( $_POST ){
		
		$status = 'publish';
		if( !$tienda_id ){
			$tienda_id = 0;
			$status = 'draft';
		}

		$current_date = date('Y-m-d H:i:s');
		$ayer = strtotime ( '-1 day' , strtotime ( $current_date ) ) ;
		$ayer = date ( 'Y-m-d H:i:s' , $ayer );

		$post_array = [
			'ID' => $tienda_id,
			'post_author' => 1,
			'post_date' => $ayer,
			'post_date_gmt' => $ayer,
			'post_content' => nl2br($_POST['descripcion']),
			'post_content_filtered' => '',
			'post_title' => $_POST['nombre'],
			'post_excerpt' => '',
			'post_status' => $status,
			'post_type' => 'tiendas',
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

		if( !$tienda_id ){
			$last_id = wp_insert_post($post_array);
			$last_tienda_id = $last_id;
			update_post_meta( session('user_id'), 'tienda', $tienda_id );
		} else {
			$last_id = wp_update_post($post_array);
			$last_tienda_id = $tienda_id;
		}


		if(!$last_tienda_id){
			show_array('Error actualizando tienda');
		} else {

			if( $_POST['activa'] ){
				$activa  = 1;
			} else {
				$activa  = 0;
			}
			update_post_meta( $last_tienda_id, 'activa', $activa );
			update_post_meta( $last_tienda_id, 'email', $_POST['email'] );
			update_post_meta( $last_tienda_id, 'telefono', $_POST['telefono'] );
			update_post_meta( $last_tienda_id, 'whatsapp', $_POST['whatsapp'] );
			update_post_meta( $last_tienda_id, 'messenger', $_POST['messenger'] );
			update_post_meta( $last_tienda_id, 'facebook', $_POST['facebook'] );
			update_post_meta( $last_tienda_id, 'instagram', $_POST['instagram'] );
			update_post_meta( $last_tienda_id, 'twitter', $_POST['twitter'] );
			update_post_meta( $last_tienda_id, 'youtube', $_POST['youtube'] );
		
			
			// These files need to be included as dependencies when on the front end.
			if( ( $_FILES['avatar']['name'] != "" ) || ( $_FILES['banner']['name'] != "" ) ){
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
				require_once( ABSPATH . 'wp-admin/includes/media.php' );
			}

			if( $_FILES['avatar']['name'] != "" ){
				// Let WordPress handle the upload.
				// Remember, 'my_image_upload' is the name of our file input in our form above.
				$attachment_id = media_handle_upload( 'avatar', $last_tienda_id );

				$attachment_url = wp_get_attachment_image_src($attachment_id, 'medium');
				$attachment_url = $attachment_url[0];
				
				if ( is_wp_error( $attachment_id ) ) {
					show_array('There was an error uploading the image. -> ' . $attachment_id->get_error_message(),0);
				} 
				set_post_thumbnail( $last_tienda_id, $attachment_id );	
			}

			if( $_FILES['banner']['name'] != "" ){
				// Let WordPress handle the upload.
				// Remember, 'my_image_upload' is the name of our file input in our form above.
				$attachment_id = media_handle_upload( 'banner', $last_tienda_id );

				$attachment_url = wp_get_attachment_image_src($attachment_id, 'medium');
				$attachment_url = $attachment_url[0];
				
				if ( is_wp_error( $attachment_id ) ) {
					show_array('There was an error uploading the image. -> ' . $attachment_id->get_error_message(),0);
				} 
				update_post_meta( $last_tienda_id, 'banner', $attachment_id );
			}
		
		}

	header('Location: ' . get_bloginfo('wpurl') . '/mi-tienda/' );
	exit();
	}

} else {
	header('Location: ' . get_bloginfo('wpurl') . '/login');
	exit();
}

if( !$tienda_id ){
	header('Location: ' . get_bloginfo('wpurl') );
	exit();	
}

get_header();

$args = [
	'p' => $tienda_id,
	'post_type' => 'tiendas'
];
$tienda = new WP_Query($args);
while ( $tienda->have_posts() ) : $tienda->the_post();
$banner = get_field('banner');
if( !is_array($banner) ){
	$banner = wp_get_attachment_image_src($banner,'full');
} else {
	$banner = [$banner['url']];
}


?>

<div class="page-header header-filter header-small" data-parallax="true" style="background-image: url('<?php echo $banner[0] ?>');">
	<div class="container">
		<div class="row title-row">
    		<div class="col-md-8 col-md-offset-2">
                <h1 class="title">Editar Mi Tienda</h1>
            </div>
        </div>
    </div>
</div>

<form method="post" action="" enctype="multipart/form-data">

	<div class="profile-page">
		<div class="main main-raised">
			<div class="profile-content">
		        <div class="container">

		            <div class="row">
		                <div class="col-xs-6 col-xs-offset-3">
		    	           <div class="profile">
		                        <div class="avatar">
		                            <?php if( has_post_thumbnail() ): ?>
		                            	<?php the_post_thumbnail('product-thumbnail', ['id' => 'previewLogo', 'srcset' => '']); ?>
		                            <?php else: ?>
		                            	<img src="<?php bloginfo('template_url') ?>/assets/img/placeholder.jpg" alt="..." id="previewLogo">
		                            <?php endif; ?>
		                            <div style="width: 250px;">
			                            <div class="input_myfile">
			                            	<button class="btn btn-default btn-round">Cambiar logo</button>
				                            <input type="file" name="avatar" onchange="loadFile(event, 'previewLogo')" >

				                            <a href="javascript: alerta({text:'Asegúrate que la imagen sea cuadrada (máximo 512x512 píxeles)<br> ya que la plataforma la recortará automaticamente'})" style="position: absolute; top: 19px; right: -20px;">
												<i class="material-icons">help_outline</i>
											</a>

				                        </div>
			                        </div>
		                        </div>
		                    </div>
		                    <div class="name text-center">
	                            <h3 class="title"><?php the_title(); ?></h3>	
							</div>
			            </div>
		            </div>

	           	 	<div class="card card-nav-tabs">
        				<div class="header header-success">
							<!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
							<div class="nav-tabs-navigation">
								<div class="nav-tabs-wrapper">
									<ul class="nav nav-tabs" data-tabs="tabs">
										<li class="active">
											<a href="<?php bloginfo('wpurl') ?>/mi-tienda/">
												<i class="material-icons">store</i>
												Datos de la tienda
											<div class="ripple-container"></div></a>
										</li>
										<?php if( get_field('activa',$tienda_id) == 1 ): ?>
										<li class="">
											<a href="<?php bloginfo('wpurl') ?>/mi-tienda/mis-productos">
												<i class="material-icons">local_offer</i>
												Productos
											<div class="ripple-container"></div></a>
										</li>
										<?php else: ?>
										<li>
											<a href="javascript: void(0)" class="disabled" data-toggle="tooltip" title="Primero debes activar tu tienda para poder agregar productos">
												<i class="material-icons">local_offer</i>
												Productos
												<div class="ripple-container"></div>
											</a>
										</li>
										<?php endif; ?>
									</ul>
								</div>
							</div>
						</div>


						<div class="card-content">
							<div class="tab-content">

								<div class="row">
									<div class="col-lg-12">
										<div class="togglebutton pl-5">
							            	<label>
							                	<input type="checkbox" name="activa" <?php echo (get_field('activa',$tienda_id)) ? 'checked' : ''; ?>>
												Activar Tienda
							            	</label>
							            </div>
									</div>
								</div>

								<div class="datos_tienda" style="display: <?php echo (get_field('activa',$tienda_id)) ? 'block' : 'none'; ?>">
	            					<div class="row pb-3">
										<div class="col-lg-6 col-md-12 col-xs-12">
											<div class="px-0 px-xl-3 px-lg-3">
												

												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">face</i>
													</span>
													<input type="text" name="nombre" class="form-control" placeholder="Nombre de la tienda..." value="<?php the_title(); ?>" required>
												</div>

												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">chat</i>
													</span>
													<textarea rows="5" name="descripcion" class="form-control" placeholder="Breve Descripcion..." required><?php echo strip_tags(get_the_content()) ?></textarea>
												</div>

												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">insert_photo</i>
													</span>
													<?php 
													if( get_field('banner',$tienda_id) ): 
													$banner = get_field('banner',$tienda_id);
													if( !is_array($banner) ){
														$banner = wp_get_attachment_image_src($banner,'full');
													} else {
														$banner = [$banner['url']];
													}
													?>
														<img src="<?php echo $banner[0] ?>" id="previewBanner" class="img-responsive">
													<?php else: ?>
														<img src="https://via.placeholder.com/468x100?text=Imagen%20horizontal%20%20de%201200x400%20Aprox." id="previewBanner" class="img-responsive">
													<?php endif; ?>
													<div class="form-group form-file-upload is-empty is-fileinput">
														<input type="file" name="banner" id="inputFile2" onchange="loadFile(event, 'previewBanner')">
														<div class="input-group">
															<input type="text" name="banner_name" readonly="" class="form-control" placeholder="Selecciona una imagen">
															<span class="input-group-btn input-group-s">
																<button type="button" class="btn btn-just-icon btn-round btn-primary">
																	<i class="material-icons">attach_file</i>
																</button>
															</span>
														</div>
													<span class="material-input"></span></div>
													<span class="input-group-addon">
														<a href="javascript: alerta({text:'Esta imagen aparecerá como imagen principal de fondo cuando la gente entre a revisar tu tienda<br>Debe ser de 1200x500 pixeles o similar tamaño proporcional'})">
															<i class="material-icons">help_outline</i>
														</a>
													</span>
												</div>

												<h3><small>Para hacer pedido</small></h3>

												<div class="input-group">
													<span class="input-group-addon lg">
														<i class="fa fa-whatsapp"></i>
													</span>
													<input type="text" name="whatsapp" class="form-control" placeholder="Numero de whatsapp..." value="<?php the_field('whatsapp') ?>" required>
													<span class="input-group-addon">
														<a href="javascript: alerta({text:'Ingresa tu número completo, inluyendo el +56 <br>Si no lo ingresas bien, la gente no podrá contactarte'})">
															<i class="material-icons">help_outline</i>
														</a>
													</span>
												</div>
												<div class="input-group">
													<span class="input-group-addon lg">
														<i class="fa fa-facebook-square"></i>
													</span>
													<input type="text" name="messenger" placeholder="Perfil Facebook Messenger..." class="form-control" value="<?php the_field('messenger'); ?>" />
													<span class="input-group-addon">
														<a href="javascript: alerta({text:'La gente puede contactarte por el chat de Facebook (Messenger) por medio de tu usuario de facebook.<br>Para encontrar tu usuario de Facebook Messenger ingresa a facebook <strong>desde tu computador</strong> y encuentra tu usuario al hacer click en tu nombre de perfil, como muestra la imagen:<br><br><img src=\'<?php bloginfo('template_url') ?>/assets/img/fb_help.png\'><br><br>Lo subrayado en rojo es lo que debes ingresar en esta parte<br><br>Si no tienes o no quieres usarlo, déjalo en blanco'});">
															<i class="material-icons">help_outline</i>
														</a>
													</span>
												</div>
											</div>
						            	</div>

						            	<div class="col-lg-6 col-md-12 col-xs-12">
											<div class="px-3">
												<h3><small>Datos de contacto</small></h3>

												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">email</i>
													</span>
													<input type="email" name="email" class="form-control" placeholder="Email..." value="<?php echo( get_field('email') ) ? get_field('email') : session('email'); ?>" required>
												</div>
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">phone</i>
													</span>
													<input type="text" name="telefono" placeholder="Teléfono..." class="form-control" value="<?php the_field('telefono'); ?>" required />
													<span></span>
												</div>

												<h3><small>Redes Sociales</small></h3>

												<div class="input-group">
													<span class="input-group-addon lg">
														<i class="fa fa-facebook"></i>
													</span>
													<input type="text" name="facebook" placeholder="Facebook..." class="form-control" value="<?php the_field('facebook'); ?>" />
													<span class="input-group-addon">
														<a href="javascript: alerta({text:'Ingresa la URL completa de tu pagina de Facebook<br><br>Si no tienes o no quieres usarlo, sólo déjalo en blanco'});">
															<i class="material-icons">help_outline</i>
														</a>
													</span>
												</div>

												<div class="input-group">
													<span class="input-group-addon lg">
														<i class="fa fa-instagram"></i>
													</span>
													<input type="text" name="instagram" placeholder="Instagram..." class="form-control" value="<?php the_field('instagram'); ?>" />
													<span class="input-group-addon">
														<a href="javascript: alerta({text:'Ingresa la URL completa de tu perfil de Instagram<br><br>Si no tienes o no quieres usarlo, sólo déjalo en blanco'});">
															<i class="material-icons">help_outline</i>
														</a>
													</span>
												</div>

												<div class="input-group">
													<span class="input-group-addon lg">
														<i class="fa fa-twitter"></i>
													</span>
													<input type="text" name="twitter" placeholder="Twitter..." class="form-control" value="<?php the_field('twitter'); ?>" />
													<span class="input-group-addon">
														<a href="javascript: alerta({text:'Ingresa la URL completa de tu perfil de Twitter<br><br>Si no tienes o no quieres usarlo, sólo déjalo en blanco'});">
															<i class="material-icons">help_outline</i>
														</a>
													</span>
												</div>

												<div class="input-group">
													<span class="input-group-addon lg">
														<i class="fa fa-youtube"></i>
													</span>
													<input type="text" name="youtube" placeholder="Youtube..." class="form-control" value="<?php the_field('youtube'); ?>" />
													<span class="input-group-addon">
														<a href="javascript: alerta({text:'Ingresa la URL completa de tu canal de Youtube<br><br>Si no tienes o no quieres usarlo, sólo déjalo en blanco'});">
															<i class="material-icons">help_outline</i>
														</a>
													</span>
												</div>
						            		</div>
						            	</div>
									
									</div>
								</div>

								<div class="row pb-3">
									<div class="col-lg-12">
					            		<div class="text-center">
											<button type="submit" class="btn btn-success">Guardar &nbsp; <i class="material-icons">save</i></button>
										</div>
					            	</div>
								</div>

							</div>
						</div>
					</div>									

		        </div>
		    </div>
		</div>
	</div>

</form>

<script>

$("[name=activa]").change(function(){
	if( $(this).prop('checked') == true ){
		$(".datos_tienda").slideDown();
	} else {
		$(".datos_tienda").slideUp();
	}
})

function loadFile(event,id_foto) {
	var reader = new FileReader();
	reader.onload = function(){
        var output = $("#" + id_foto);
        output.attr('src',reader.result);
    };
    reader.readAsDataURL(event.target.files[0]);
};
</script>

<?php endwhile; ?>
<?php get_footer(); ?>