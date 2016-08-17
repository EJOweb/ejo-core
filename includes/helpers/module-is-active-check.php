<?php 

function ejo_base_module_is_available( $module ) 
{
	//* We're starting positive
	$module_is_available = true;

	//* Check if theme supports the module
	if ( ! current_theme_supports( 'ejo-base', $module ) )
		$module_is_available = false;

	//* Check if EJO Base supports module
	if ( ! in_array( $module, EJO_Base::$supported_modules ) )
		$module_is_available = false;

	return $module_is_available;
}

function ejo_base_module_is_active( $module ) 
{
	//* We're starting positive
	$module_is_active = true;

	//* Return false if module isn't available
	if ( ! ejo_base_module_is_available( $module ) )
		$module_is_active = false;

	//* Get EJO Base Modules
	$ejo_base_active_modules = get_option( 'ejo_base_active_modules', array() );

	//* Check if module is active in options
	if ( empty($ejo_base_active_modules[$module]) )
		$module_is_active = false;

	return $module_is_active;
}

function ejo_base_get_available_modules()
{
	$available_theme_modules = get_theme_support( 'ejo-base-modules' );
	$ejo_base_modules = EJO_Base::$supported_modules;

	write_log($available_theme_modules);
	write_log($ejo_base_modules);
	write_log();
}