<?php

$uri = $_GET["uri"];
  
if ( extension_loaded( 'curl' ) ) {
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $uri );
    curl_setopt( $ch, CURLOPT_HEADER, 0 );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_FAILONERROR, 1 );
    $result = curl_exec( $ch );
    if ( curl_errno( $ch ) ) {
        die('<div id="search-results" class="error">'. sprintf(__('%s'), curl_error( $ch ) ). '</div>');    
    }
    curl_close( $ch );
} else {
    $result = file_get_contents($uri);
}

echo $result;