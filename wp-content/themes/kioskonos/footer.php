<footer class="footer <?php echo ( is_home() || is_front_page() ) ? 'footer-black footer-big' : ''; ?>">
	<div class="container">

		<?php if( is_home() || is_front_page() ): ?>

		<div class="content">
			<div class="row">
				<div class="col-md-4">
					<h5>KioskoNOS</h5>
					<p>
						Somos un sitio "multi tiendas" creado pensando en los pequeños emprendedores, con la finalidad de ayudarlos a vender sus productos. Principalmente para los usuarios del sector NOS de San Bernardo. <br>
						Eres libre de registrarte si no eres de San Bernardo, pero eres responsable de las ventas que puedas realizar fuera de los limites geográficos. <br>
						Disfruta KioskoNOS
					</p>
				</div>

				<div class="col-md-4">
					<h5>Redes Sociales</h5>
					<div class="social-feed">
						<div class="feed-line">
							<p>
								<a href="javascript: alerta({text:'Pronto!'})"><i class="fa fa-twitter"></i> &nbsp; Twitter (Pronto)</a>
							</p>
						</div>
						<div class="feed-line">
							<p>
								<a href="https://www.facebook.com/Kioskonos-101812454896531"  target="_blank"><i class="fa fa-facebook-square"></i> &nbsp; Facebook</a>
							</p>
						</div>
						<div class="feed-line">
							<p>
								<a href="https://www.instagram.com/kioskonos/" target="_blank"><i class="fa fa-instagram"></i> &nbsp; Instagram</a>
							</p>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<h5>InstaTiendas Feed</h5>
					<div class="gallery-feed">
						<?php  
						$args = [
							'posts_per_page' => 8,
							'meta_key' => 'activa',
							'meta_value' => true,
							'post_type' => 'tiendas',
							'orderby' => 'rand'
						];
						$tiendas = new WP_Query($args);
						while( $tiendas->have_posts() ) : $tiendas->the_post();
							the_post_thumbnail('thumbnail',[ 'class'=>'img img-raised img-rounded','alt'=>get_the_title() ]);
						endwhile;
						?>
						
					</div>

				</div>
			</div>
		</div>
		<hr />

		<?php endif; ?>

		<ul class="pull-left">
			<li><a href="<?php bloginfo('wpurl') ?>/terminos-y-condiciones"> Términos y condiciones</a></li>
			<li><a href="javascript: alerta({text:'Pronto tendremos precios para que puedas destacar tu tienda en nuesta plataforma.<br>Debes estar atento'})"> Precios</a></li>
			<li><a href="<?php bloginfo('wpurl') ?>/contacto"> Contacto</a></li>
		</ul>

		<div class="copyright pull-right">
			Copyright &copy; <?php echo date('Y') ?> KioskoNOS - Todos los derechos reservados
		</div>
	</div>
</footer>

<div class="overlay"></div>
<div class="loader"><img src="<?php bloginfo('template_url') ?>/assets/img/logo_icon.png" class="flip-vertical-right"></div>


</body>

<!--   Core JS Files   -->
<script src="<?php bloginfo('template_url') ?>/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_url') ?>/assets/js/material.min.js"></script>

<!--    Plugin for Date Time Picker and Full Calendar Plugin   -->
<script src="<?php bloginfo('template_url') ?>/assets/js/moment.min.js"></script>

<!--	Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/   -->
<script src="<?php bloginfo('template_url') ?>/assets/js/nouislider.min.js" type="text/javascript"></script>

<!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker   -->
<script src="<?php bloginfo('template_url') ?>/assets/js/bootstrap-datetimepicker.js" type="text/javascript"></script>

<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select   -->
<script src="<?php bloginfo('template_url') ?>/assets/js/bootstrap-selectpicker.js" type="text/javascript"></script>

<!--	Plugin for Tags, full documentation here: http://xoxco.com/projects/code/tagsinput/   -->
<script src="<?php bloginfo('template_url') ?>/assets/js/bootstrap-tagsinput.js"></script>

<!--	Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput   -->
<script src="<?php bloginfo('template_url') ?>/assets/js/jasny-bootstrap.min.js"></script>


<!--    Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc    -->
<script src="<?php bloginfo('template_url') ?>/assets/js/material-kit.js?v=1.2.1" type="text/javascript"></script>

<!-- OwlCarousel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- Fancybox -->
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<!-- Custom JS -->
<script src="<?php bloginfo('template_url') ?>/assets/js/custom.js?v=1.<?php echo uniqid(); ?>" type="text/javascript"></script>


<?php if( $_SESSION['kioskonos_alert'] ): ?>
<script>
$(window).on("load",function(){
	alerta({ text : '<?php echo $_SESSION['kioskonos_alert']; ?>' })	
})
</script>
<?php 
unset($_SESSION['kioskonos_alert']);
endif; 
?>

<?php wp_footer(); ?>

</html>
