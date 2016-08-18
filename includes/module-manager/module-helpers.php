<?php 

function ejo_base_module_has_theme_support( $module_id ) 
{
	//* Return true if theme supports the module
	if ( current_theme_supports( 'ejo-base-modules', $module_id ) )
		return true;

	return false;
}

function ejo_base_module_exists( $module_id)
{
	//* Return true if EJO Base module exists
	if ( in_array( $module_id, EJO_Base_Module_Manager::$modules ) )
		return true;

	return false;
}

function ejo_base_module_is_available( $module_id ) 
{
	if ( !ejo_base_module_has_theme_support($module_id) ) {
		return false;
	}

	if ( ejo_base_module_exists($module_id) ) {
		return false;
	}

	if ( ejo_base_module_missing_dependancies($module_id) ) {
		return false;
	}

	return true;
}

function ejo_base_module_is_active( $module_id, $active_modules = '' ) 
{
	if ( ! $active_modules )
		$active_modules = get_option( 'ejo_base_active_modules', array() );
	
	//* Check if module is active in options
	if ( in_array($module_id, $active_modules) )
		return true;

	return false;
}

function ejo_base_module_missing_dependancies( $module ) 
{
	//* If no dependancies, then there are no missing dependancies
	if ( empty($module['dependancies']) )
		return false;

	//* Sort array by keys
	ksort($module['dependancies']);

	$missing_dependancies = array();

	//* Check if dependancies are fulfilled
	foreach ($module['dependancies'] as $dependancy_key => $dependancy) {
		if ($dependancy_key == 'ejo-base-module') {

			if ( ejo_base_module_is_active($dependancy) === false )
				$missing_dependancies[$dependancy_key] = $dependancy;
		}
		elseif ( $dependancy_key == 'plugin' ) {

			if ( is_plugin_active( $dependancy.'/'.$dependancy.'.php' ) === false )
				$missing_dependancies[$dependancy_key] = $dependancy;
		}
	}

	//* If no missing_dependancies, return true. Else return missing_dependancies array
	write_log($missing_dependancies);
	return (empty($missing_dependancies)) ? true : $missing_dependancies;
}

function ejo_base_module_show_dependancies( $module )
{
	if ( ! empty($module['dependancies']) ) {

		//* Sort array by keys
		ksort($module['dependancies']);
		
		foreach ($module['dependancies'] as $dependancy_key => $dependancy) {

			echo "<strong>$dependancy</strong>: ";

			if ($dependancy_key == 'ejo-base-module') {
				if (ejo_base_module_is_active($dependancy))
					_e( 'Activated');
				else 
					_e( 'Not Activated');
				echo " ($dependancy_key)<br/>";
			}
			elseif ( $dependancy_key == 'plugin' ) {
				if ( is_plugin_active( $dependancy.'/'.$dependancy.'.php' ) )
					_e( 'Activated');
				else 
					_e( 'Not Activated');
				echo " ($dependancy_key)<br/>";
			}
		}
	}

	// $plugin_dependancies = ( isset($module['dependancies']['plugins']) ) ? $module['dependancies']['plugins'] : array();
	// $ejo_base_module_dependancies = ( isset($module['dependancies']['ejo-base-modules']) ) ? $module['dependancies']['ejo-base-modules'] : array();

	// if ( ! empty($plugin_dependancies) ) {
	// 	echo '<h4>Plugins</h4>';
	// 	foreach ($plugin_dependancies as $dependancy) {
	// 		echo "<strong>$dependancy</strong>: ";
	// 		if ( is_plugin_active( $dependancy.'/'.$dependancy.'.php' ) )
	// 			_e( 'Activated');
	// 		else 
	// 			_e( 'Not Activated');
	// 		echo '<br/>';
	// 	}
	// }

	// if ( ! empty($ejo_base_module_dependancies) ) {
	// 	echo '<h4>EJO Base Modules</h4>';
	// 	foreach ($ejo_base_module_dependancies as $dependancy) {
	// 		echo "<strong>$dependancy</strong>: ";
	// 		if (ejo_base_module_is_active($dependancy))
	// 			_e( 'Activated');
	// 		else 
	// 			_e( 'Not Activated');
	// 		echo '<br/>';
	// 	}
	// }		
}

function ejo_base_get_available_modules()
{
	$available_theme_modules = get_theme_support( 'ejo-base-modules' );
	$ejo_base_modules = EJO_Base_Module_Manager::$modules;

	write_log($available_theme_modules);
	write_log($ejo_base_modules);
	write_log();
}