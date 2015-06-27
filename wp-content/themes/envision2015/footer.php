<?php

        echo '</main>'; // #content
?>
<footer>
	<div class="triangle dark-blue"></div>
	<div class="site-logo">
		<a class="logo left" href="#">
			<span class="site-name">Envision Interiors, Inc.</span>
		</a>
	</div>
	<span class="copyright">© Copyright 2010—2015 Envision Interiors Inc.</span>
	<span class="credit">Website by <a href="http://gabesimagination.prosite.com" title="Visit Gabe's Imagination" target="_blank">Gabe's Imagination</a></span>
</footer>

<?
        //if(!is_user_logged_in() && 'SITE_ENVIRONMENT' == "production"){
	       ?>
	       <script>
			  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			  ga('create', 'UA-63770389-1', 'auto');
			  ga('send', 'pageview');

			</script>
	       <?php
	   // }
        //LOGO
        //COPYRIGHT
        //CREDITS

        wp_footer();
        echo '</div>'; // .page-wrapper



?>

    </body>
</html>
