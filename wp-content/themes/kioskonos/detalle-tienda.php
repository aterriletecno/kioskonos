<?php
@session_start();
/**
 * Template Name: Detalle Tienda
 *
 */

if( session('logged') ){
	if( !isMyTienda($_GET['t']) ){
		header('Location: ' . get_bloginfo('wpurl') . '/editar-tienda/?t=' . session('tienda_id'));
		exit();
	}

	if( $_POST ){

		show_array($_POST,0);
		show_array($_FILES);

	}



} else {
	header('Location: ' . get_bloginfo('wpurl'));
	exit();
}

get_header();

$tienda_id = session('tienda_id');

$args = [
	'p' => $tienda_id,
	'post_type' => 'tiendas'
];
$tienda = new WP_Query($args);
while ( $tienda->have_posts() ) : $tienda->the_post();
?>

<div class="page-header header-filter header-small" data-parallax="true" style="background-image: url('<?php bloginfo('template_url') ?>/assets/img/registro-bg.jpg');">
	<div class="container">
		<div class="row title-row">
    		<div class="col-md-8 col-md-offset-2">
                <h1 class="title">Editar tienda</h1>
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

				                            <a href="javascript: alerta({text:'Asegúrate que la imagen es cuadrada, ya que la plataforma la recortará automaticamente'})" style="position: absolute; top: 19px; right: -20px;">
												<i class="material-icons">help_outline</i>
											</a>

				                        </div>
			                        </div>
		                        </div>
		                    </div>
			            </div>
		            </div>

		            
	            	<div class="row pb-3">
	            		<div class="col-lxs-12 col-lg-12">
	            			<div class="name text-center">
	                            <h3 class="title"><?php the_title(); ?></h3>	
							</div>
	            		</div>
						<div class="col-lg-6 col-md-12 col-xs-12">
							<div class="px-3">
								<div class="togglebutton">
					            	<label>
					                	<input type="checkbox" name="activa">
										Activar Tienda
					            	</label>
					            </div>

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
									<img src="https://via.placeholder.com/468x100?text=Imagen%20horizontal%20%20de%201200x400%20Aprox." id="previewBanner" class="img-responsive">
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
										<a href="javascript: alerta({text:'Esta imagen aparecerá como imagen principal de fondo cuando la gente entre a revisar tu tienda'})">
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
									<input type="text" name="messenger" placeholder="Perfil Facebook Messenger..." class="form-control" value="<?php the_field('telefono'); ?>" required />
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
									<input type="email" name="email" class="form-control" placeholder="Email..." value="<?php the_field('email') ?>" required>
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
									<input type="text" name="facebook" placeholder="Facebook..." class="form-control" value="<?php the_field('telefono'); ?>" />
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
									<input type="text" name="instagram" placeholder="Instagram..." class="form-control" value="<?php the_field('telefono'); ?>" />
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
									<input type="text" name="twitter" placeholder="Twitter..." class="form-control" value="<?php the_field('telefono'); ?>" />
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
									<input type="text" name="youtube" placeholder="Youtube..." class="form-control" value="<?php the_field('telefono'); ?>" />
									<span class="input-group-addon">
										<a href="javascript: alerta({text:'Ingresa la URL completa de tu canal de Youtube<br><br>Si no tienes o no quieres usarlo, sólo déjalo en blanco'});">
											<i class="material-icons">help_outline</i>
										</a>
									</span>
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

</form>

<script>
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