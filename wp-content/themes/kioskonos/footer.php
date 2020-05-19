<footer class="footer <?php echo ( is_home() || is_front_page() ) ? 'footer-black footer-big' : ''; ?>">
	<div class="container">

		<?php if( is_home() || is_front_page() ): ?>

		<div class="content">
			<div class="row">
				<div class="col-md-4">
					<h5>About Us</h5>
					<p>Creative Tim is a startup that creates design tools that make the web development process faster and easier. </p> <p>We love the web and care deeply for how users interact with a digital product. We power businesses and individuals to create better looking web projects around the world. </p>
				</div>

				<div class="col-md-4">
					<h5>Social Feed</h5>
					<div class="social-feed">
						<div class="feed-line">
							<i class="fa fa-twitter"></i>
							<p>How to handle ethical disagreements with your clients.</p>
						</div>
						<div class="feed-line">
							<i class="fa fa-twitter"></i>
							<p>The tangible benefits of designing at 1x pixel density.</p>
						</div>
						<div class="feed-line">
							<i class="fa fa-facebook-square"></i>
							<p>A collection of 25 stunning sites that you can use for inspiration.</p>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<h5>Instagram Feed</h5>
					<div class="gallery-feed">
						<img src="<?php bloginfo('template_url') ?>/assets/img/faces/card-profile6-square.jpg" class="img img-raised img-rounded" alt="" />
						<img src="<?php bloginfo('template_url') ?>/assets/img/faces/christian.jpg" class="img img-raised img-rounded" alt="" />
						<img src="<?php bloginfo('template_url') ?>/assets/img/faces/card-profile4-square.jpg" class="img img-raised img-rounded" alt="" />
						<img src="<?php bloginfo('template_url') ?>/assets/img/faces/card-profile1-square.jpg" class="img img-raised img-rounded" alt="" />

						<img src="<?php bloginfo('template_url') ?>/assets/img/faces/marc.jpg" class="img img-raised img-rounded" alt="" />
						<img src="<?php bloginfo('template_url') ?>/assets/img/faces/kendall.jpg" class="img img-raised img-rounded" alt="" />
						<img src="<?php bloginfo('template_url') ?>/assets/img/faces/card-profile5-square.jpg" class="img img-raised img-rounded" alt="" />
						<img src="<?php bloginfo('template_url') ?>/assets/img/faces/card-profile2-square.jpg" class="img img-raised img-rounded" alt="" />
					</div>

				</div>
			</div>
		</div>
		<hr />

		<?php endif; ?>

		<ul class="pull-left">
			<li>
				<a href="#pablo">
				   Blog
				</a>
			</li>
			<li>
				<a href="#pablo">
					Presentation
				</a>
			</li>
			<li>
				<a href="#pablo">
				   Discover
				</a>
			</li>
			<li>
				<a href="#pablo">
					Payment
				</a>
			</li>
			<li>
				<a href="#pablo">
					Contact Us
				</a>
			</li>
		</ul>

		<div class="copyright pull-right">
			Copyright &copy; <script>document.write(new Date().getFullYear())</script> Creative Tim All Rights Reserved.
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




<?php wp_footer(); ?>

</html>
