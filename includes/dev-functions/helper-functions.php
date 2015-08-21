<?php 
//* Delete one array-record based on value
function remove_array_value( $value, $array ) 
{
	$key = array_search($value, $array);

	if( $key !== false)
		unset($array[$key]);

	return $array;
}