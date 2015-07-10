<!doctype html>
<!--[if lte IE 8]> <script type="text/javascript">
       //window.location.href = "/unsupported-browser";
</script> <![endif]-->
<!--[if IE 8]> <html xmlns="http://www.w3.org/1999/xhtml" class="ie lt-ie9" lang="en"> <![endif]-->
<!--[if IE 9]> <html xmlns="http://www.w3.org/1999/xhtml" class="ie lte-ie9" lang="en"> <![endif]-->
<script>
var isIE10 = false;
    /*@cc_on
        if (/^10/.test(@_jscript_version)) {
            isIE10 = true;
        }
    @*/
</script>
<!--[if gt IE 9]><!--> <html <?php language_attributes(); ?> ><!--<![endif]-->
<head>
<?php global $post; ?>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="google-site-verification" content="hF84QRz2Ycf3zuPPorykVDvrXMKtiNwtCiCem-K1wQg" />
    <title><?php wp_title('|', true, 'right'); ?></title>

    <link rel="apple-touch-icon-precomposed" media="handheld" href="<?php echo bloginfo('stylesheet_directory');?>/images/icons/touch-icon.png" />
    <link rel="icon" href="<?php echo bloginfo('stylesheet_directory');?>/images/icon/favicon.png">
    <meta name="msapplication-TileImage" content="<?php echo bloginfo('stylesheet_directory');?>/images/icon/tileicon144.png">

    <?php wp_head(); ?>

    <!--[if lte IE 9]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
        <?php //env_ie_enqueue(); ?>
    <![endif]-->

</head>
<?php
echo '<body '; body_class($body_class); echo '>';
?>
<script>
if(isIE10){
jQuery('body').addClass('ie10');
}
</script>
<?php
    echo '<div class="page-wrapper outer container">';

    get_template_part('template-parts/primary-nav');

        echo '<main id="content" role="main">';
?>
