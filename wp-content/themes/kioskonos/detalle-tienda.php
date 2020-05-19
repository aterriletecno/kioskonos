<?php
/**
 * Template Name: Detalle Tienda
 *
 */

get_header();
while (have_posts()) : the_post();

if( session('logged') ){
	echo "logged";
}
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

<div class="profile-page">
	<div class="main main-raised">
		<div class="profile-content">
	        <div class="container">

	            <div class="row">
	                <div class="col-xs-6 col-xs-offset-3">
	    	           <div class="profile">
	                        <div class="avatar">
	                            <img src="<?php bloginfo('template_url') ?>/assets/img/placeholder.jpg" alt="..." id="previewLogo">
	                            <!-- <img src="<?php bloginfo('template_url') ?>/assets/img/faces/christian.jpg" alt="Circle Image" class="img-circle img-responsive img-raised"> -->
	                            <div class="input_myfile">
	                            	<button class="btn btn-default btn-round">Cambiar logo</button>
		                            <input type="file" name="" onchange="loadFile(event)" >
		                        </div>
	                        </div>
	                        <div class="clearfix"></div>
							<div class="clearfix"></div>
	                    </div>
		            </div>
	            </div>

	            <form method="post" action="">
		            <div class="row row-centered pb-5">
						<div class="col-centered col-lg-6 col-md-12 col-xs-12">
							<div class="name">
	                            <h3 class="title"><?php the_title(); ?></h3>	
							</div>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">face</i>
								</span>
								<input type="text" class="form-control" placeholder="Nombre completo..." value="<?php the_title(); ?>" required>
							</div>

							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">email</i>
								</span>
								<input type="text" class="form-control" placeholder="Email..." value="<?php the_field('email') ?>" disabled required>
							</div>

							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">lock_outline</i>
								</span>
								<input type="password" placeholder="Password..." class="form-control" value="<?php the_field('password'); ?>" required />
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


<script>
function loadFile(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('previewLogo');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};
</script>

<?php endwhile; ?>
<?php get_footer(); ?>