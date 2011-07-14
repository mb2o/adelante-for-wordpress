	<?php if (get_option('adelante_css_framework') === '1140') { ?>
		</div><!-- /.row -->
    
    </div><!-- /#wrap -->    
		
    <div class="row">
<?php } ?>	
    	 
        <footer id="content-info" class="<?php echo adelante_container_class; ?>" role="contentinfo">
            
            <div class="container">           
                <?php  
                    $columns = get_option( 'adelante_footer_columns' );
                    
                    $firstCol = 'first';
                    switch( $columns ) {
                        case 1: $class = ''; break;
                        case 2: $class = 'one_half'; break;
                        case 3: $class = 'one_third'; break;
                        case 4: $class = 'one_fourth'; break;
                        case 5: $class = 'one_fifth'; break;
                        default: $class = '';
                    }
                    
                    for ( $i = 1; $i <= $columns; $i++ ) {
                        echo "<div class='$class $firstCol'>";
                        if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 'Footer Column #'. $i ) ) : 
                        endif;
                        echo "</div>";
                        $firstCol = "";
                    }                        
                ?>                             
            </div> 
      
            <div class="subfooter container">
                
                <p class="copy"><small>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></small></p>
                
                <?php
                    //show additional textblock if the user has set one
                    $footer_text = get_option( 'adelante_footer_text' );
                    if ( $footer_text ) {
                        echo "<div id='footer_text'>";
                        echo $footer_text;
                        echo "</div>";
                    } 
                     
                    if (get_option('adelante_footer_social_share') == 'checked') { ?>
                        <div class="social alignleft">
                            <a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo home_url('/'); ?>" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
                            <iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo home_url('/'); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=110&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:21px;" allowTransparency="true"></iframe>
                            <span class="plusone"><g:plusone></g:plusone></span>
                        </div>
                <?php 
                    }                                    
                              
                    if (get_option('adelante_footer_vcard') == 'checked') { ?>
                        <div class="vcard alignright">
                            <a class="fn org url" href="<?php echo home_url('/'); ?>" title="Contact Information for <?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a><br>
                            <span class="adr">
                                <span class="street-address"><?php echo get_option('adelante_vcard_street-address'); ?></span><br>
                                <span class="locality"><?php echo get_option('adelante_vcard_locality'); ?></span>,
                                <span class="region"><?php echo get_option('adelante_vcard_region'); ?></span>
                                <span class="postal-code"><?php echo get_option('adelante_vcard_postal-code'); ?></span><br>
                            </span>
                            <span class="tel"><span class="value"><span class="hidden">+1-</span><?php echo get_option('adelante_vcard_tel'); ?></span></span><br>
                            <a class="email" href="mailto:<?php echo get_option('adelante_vcard_email'); ?>"><?php echo get_option('adelante_vcard_email'); ?></a>
                        </div>
                <?php } ?>            
            </div>   
            
        </footer>    
            
<?php if ( get_option( 'adelante_css_framework' ) === '1140' ) { ?>
	</div><!-- /.row -->
<?php } ?>		

    <?php wp_footer(); ?>

<!-- Place this tag in your head or just before your close body tag -->
<script src="https://apis.google.com/js/plusone.js">
    {parsetags: 'explicit'}
</script>

<!-- Now render! -->
<script>
    gapi.plusone.go();
</script>
    
</body>
</html>