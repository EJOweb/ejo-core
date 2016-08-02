<?php 

function ejo_base_module_is_active( $module ) {

	if ( ! current_theme_supports( 'ejo-base', $module ) )
		return false;


	if ( ! in_array( $module, EJO_Base::$activated_modules ) )
		return false;

	write_log( $module . ' is active' );
	
	return true;
}
	
