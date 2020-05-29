<?php
@session_start();
/**
 * Template Name: Mis Productos
 *
 */
$tienda_id = session('tienda_id');
if( is_object($tienda_id) ){
	$tienda_id = $tienda_id->ID;
}

if( session('logged') ){

	$tienda = isTiendaActiva(session('tienda_id'));

	if( !$tienda ){
		header('Location: ' . get_bloginfo('wpurl') . '/mi-tienda');
		exit();
	}
	
	if( $_POST ){
		
		$producto_id = 0;
		if( $_POST['product_id'] ){
			$producto_id = $_POST['product_id'];
		}

		$current_date = date('Y-m-d H:i:s');
		$ayer = strtotime ( '-1 day' , strtotime ( $current_date ) ) ;
		$ayer = date ( 'Y-m-d H:i:s' , $ayer );

		$post_array = [
			'ID' => $producto_id,
			'post_author' => 1,
			'post_date' => $ayer,
			'post_date_gmt' => $ayer,
			'post_content' => nl2br($_POST['descripcion']),
			'post_content_filtered' => '',
			'post_title' => $_POST['nombre'],
			'post_excerpt' => '',
			'post_status' => 'publish',
			'post_type' => 'productos',
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

		if( !$_POST['product_id'] ){
			$last_product_id = wp_insert_post($post_array);
		} else {
			$last_product_id = wp_update_post($post_array);
		}
		
		
		if(!$last_product_id){
			show_array('Error actualizando tienda');
		} else {

		    if( $_FILES['foto_producto']['name'] != "" ){
		    	require_once( ABSPATH . 'wp-admin/includes/image.php' );
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
				require_once( ABSPATH . 'wp-admin/includes/media.php' );

				$attachment_id = media_handle_upload( 'foto_producto', $last_product_id );
				$attachment_url = wp_get_attachment_image_src($attachment_id, 'product-thumbnail');
				$attachment_url = $attachment_url[0];
				
				if ( is_wp_error( $attachment_id ) ) {
					show_array('There was an error uploading the image. -> ' . $attachment_id->get_error_message(),0);
				} 
				set_post_thumbnail( $last_product_id, $attachment_id );	
			}

			update_post_meta( $last_product_id, 'precio', $_POST['precio'] );
			update_post_meta( $last_product_id, 'tienda', session('tienda_id') );
			wp_set_post_categories( $last_product_id, $_POST['categoria'], false );

			header('Location: ' . get_bloginfo('wpurl') . '/mis-productos/');
			exit();
	    
	    }

	}



} else {
	header('Location: ' . get_bloginfo('wpurl') . '/login');
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

<div class="mis-productos">
	<div class="page-header header-filter header-small" data-parallax="true" style="background-image: url('<?php echo $banner[0] ?>');">
		<div class="container">
			<div class="row title-row">
	    		<div class="col-md-8 col-md-offset-2">
	                <h1 class="title">Productos de Mi Tienda</h1>
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
										<ul class="nav nav-tabs pull-left" data-tabs="tabs">
											<li class="">
												<a href="<?php bloginfo('wpurl') ?>/mi-tienda/">
													<i class="material-icons">store</i>
													<span class="hidden-xs">Datos de la</span> tienda
												<div class="ripple-container"></div></a>
											</li>
											<li class="active">
												<a href="#">
													<i class="material-icons">local_offer</i>
													Productos
												<div class="ripple-container"></div></a>
											</li>
										</ul>
										<ul class="nav navbar-nav navbar-right">
											<li>
				                                <button type="button" data-toggle="modal" data-target="#addProductModal" class="btn btn-info m-0 mr-5" id="btnAddProduct">
													<i class="material-icons">add</i>
				                                    Agregar nuevo producto
				                                </button>
				                            </li>
										</ul>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>


							<div class="card-content">
								<div class="tab-content">

	            					<div class="row pb-3">

	            						<div class="table-responsive">
					                        <table class="table">
					                            <thead>
					                                <tr>
					                                    <th class="text-center">#</th>
					                                    <th>Foto</th>
					                                    <th>Producto</th>
					                                    <th>Descripcion</th>
					                                    <th>Categorias</th>
					                                    <th>Precio</th>
					                                    <th class="text-right">Actions</th>
					                                </tr>
					                            </thead>
					                            <tbody>
					                            	<?php 
					                            	$i=1;
					                            	$args = [
					                            		'post_type' => 'productos',
					                            		'meta_key' => 'tienda',
					                            		'meta_value' => $tienda_id
					                            	];
					                            	$productos = new WP_Query($args);
					                            	while ( $productos->have_posts() ) : $productos->the_post();
					                            	?>
					                                <tr>
					                                    <td class="text-center"><?php echo $i; ?></td>
					                                    <td><?php the_post_thumbnail('thumbnail',['class' => 'product-thumbnail']); ?></td>
					                                    <td><?php the_title(); ?></td>
					                                    <td><?php echo excerpt(get_the_content(),10) ?>[...]</td>
					                                    <td>
					                                    	<?php  
					                                    	$post_cat = get_the_category(get_the_ID());
					                                    	foreach ($post_cat as $cat) {
				                                    			echo $cat->name.",<br>";
				                                    		} 
				                                    		?>
					                                    </td>
					                                    <td class="text-right"><?php the_field('precio'); ?></td>
					                                    <td class="td-actions text-right">
					                                        <a href="#" class="btn btn-success btnEdit" data-product-id="<?php echo get_the_ID(); ?>" rel="tooltip" title="Editar producto">
					                                            <i class="material-icons">edit</i>
					                                        </a>
					                                        <button type="button" data-product-id="<?php echo get_the_ID(); ?>" rel="tooltip" class="btn btn-danger btnDelete" title="Eliminar Producto">
					                                            <i class="material-icons">close</i>
					                                        </button>
					                                    </td>
					                                </tr>
					                            	<?php 
					                            	$i++;
					                            	endwhile; 
					                            	?>

					                            </tbody>
					                        </table>
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
</div>


<div class="modal fade modal-lg" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form method="post" id="formNewModelo" enctype="multipart/form-data">
			<input type="hidden" name="product_id">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						<i class="material-icons">clear</i>
					</button>
					<h4 class="modal-title">Agregar nuevo producto</h4>
				</div>
				<div class="modal-body">
        			<input type="hidden" name="action" value="agregar_producto">
                    
                    <div class="row">
                    	<div class="col-lg-6 col-sm-12">
                    		<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">face</i>
								</span>
								<input name="nombre" type="text" class="form-control" placeholder="Nombre del Producto..." required>
							</div>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">chat</i>
								</span>
								<textarea rows="5" name="descripcion" class="form-control" placeholder="Breve Descripcion..."></textarea>
							</div>
							<img src="<?php bloginfo('template_url'); ?>/assets/img/img_icon.png" id="product-thumbnail" class="mt-4">
                    	</div>
                    	<div class="col-lg-6 col-sm-12">
                    		<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">attach_money</i>
								</span>
								<input name="precio" type="number" class="form-control" placeholder="Precio..." required>
							</div>

							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">attach_file</i>
								</span>
		                    	<div class="form-group form-file-upload">
									<input type="file" id="foto_producto" name="foto_producto" onchange="loadFile(event,'product-thumbnail')">
									<div class="input-group">
										<input type="text" readonly="" class="form-control" placeholder="Elije una foto...">
										<span class="input-group-btn input-group-s">
											<button type="button" class="btn btn-just-icon btn-round btn-primary">
												<i class="material-icons">insert_photo</i>
											</button>
										</span>
									</div>
								</div>
							</div>

							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">assignment_turned_in</i>
								</span>
								<?php  
								$args = [
									'orderby' => 'id',
								    'parent'  => 0,
								    'hide_empty'=> false,
								];
								$categorias = get_categories($args);
								?>
								Elije la o las categorias a la que pertenece tu producto
							</div>
							<div id="categoryTree" style="height: 200px; overflow: auto;">
								<div class="panel-body category_list">
									<?php 
									foreach ($categorias as $category) { 
									if($category->term_id != 1):
									?>
									<div class="checkbox">
										<label>
										   	<input type="checkbox" name="categoria[]" value="<?php echo $category->term_id; ?>" data-toggle="checkbox">
											<?php echo $category->name ?>
										</label>
									</div>
									<?php 
									endif;
									} 
									?>
							   	</div>
						   	</div>

                    	</div>
                    </div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa fa-times"></i> Cerrar y volver</button>
	                <button type="submit" class="btn btn-success btnGuardar">Guardar <i class="fa fa-save"></i> </button>
				</div>
			</div>
		</form>
	</div>
</div>
<!--  End Modal -->


<script>

$(".btnEdit").click(function(event){
	event.preventDefault();
	product_id = $(this).data('product-id');
	$.ajax({
		type: 'POST',
		url: '<?php echo admin_url('admin-ajax.php'); ?>',
		dataType: 'json',
		data: 'action=get_producto&product_id=' + product_id,
		beforeSend: function(){
		},
		success: function(json){
			$("[name=product_id]").val( json.id );
			$("[name=nombre]").val( json.title );
			$("[name=descripcion]").val( json.descripcion );
			$("[name=precio]").val( json.precio );
			$("#product-thumbnail").attr( 'src',json.thumbnail );
			$.each(json.categorias, function(k,v){
				$("[name='categoria[]'][value=" + v.term_id + "]").prop('checked',true);
			})
			$("#addProductModal").modal('show');
		}
	})

	
})

$(".btnDelete").click(function(e){
	product_id = $(this).data('product-id');
	tr = $(this).closest('tr');
	e.preventDefault();
	$.confirm({
        'message'   : '¿Seguro que desea eliminar el producto seleccionado?<br><strong>Esta accion no puede deshacerse</strong>',
        'buttons'   : {
            'No'    : {
                'class' : 'btn-default pull-left'
            },
            'Si'   : {
                'class' : 'btn-success pull-right',
                'action': function(){
                    $.ajax({
	            		type: 'POST',
	            		url: '<?php echo admin_url('admin-ajax.php'); ?>',
	            		dataType: 'json',
	            		data: 'action=eliminar_producto&product_id=' + product_id,
	            		beforeSend: function(){
	            		},
	            		success: function(json){
	            			if(json.status = 'OK'){
	            				tr.fadeOut(400, function(){
	            					alerta({text:'Producto eliminado correctamente'});
	            				});
	            			}
	            		}
	            	})
                }
            }
        }
    });
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