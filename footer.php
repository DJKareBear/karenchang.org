<?php global $apollo13; ?>
		</div><!-- #mid -->

        <footer id="footer">
            <?php
            $ft = $apollo13->get_option( 'settings', 'footer_text' )   ;
            if(!empty($ft)) echo '<div class="foot-text">'.nl2br($ft).'</div>';
            ?>
            <?php
            $ct = $apollo13->get_option( 'settings', 'copyright_text' )   ;
            if(!empty($ct)) echo '<div class="copyright">'.nl2br($ct).'</div>';
            ?>
            <a href="#top" id="to-top"></a>
        </footer>
<?php
        //why here google analytics code? For speed :-)
        echo $apollo13->get_option( 'settings', 'ga_code' );

        /* Always have wp_footer() just before the closing </body>
         * tag of your theme, or you will break many plugins, which
         * generally use this hook to reference JavaScript files.
         */

        wp_footer();
?>

</body>
</html>