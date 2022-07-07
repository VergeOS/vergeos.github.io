<?php
$path = DEEP_COMPONENTS_DIR . 'widgets';
$files = glob($path . '/*.php');
foreach( $files as $file ) :
	if ( __FILE__ != basename( $file ) ) :
		include_once $file;
	endif;
endforeach;