<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package SKT Full Width
 */
?>
<?php if (of_get_option('show-right-sidebar', '1') != '1'): ?>
    <style>
        #sidebar { display: none; }
        .blog-post {
            width: 100%;
        }
    </style>
<?php endif; ?>

<div id="sidebar">

    <?php dynamic_sidebar( 'sidebar-1' ); ?>
	
</div><!-- sidebar -->