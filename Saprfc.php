<?php
namespace saprfc;
/*
* Class specialized in communicate through Remote Function Calls,
* with SAP server.
* Check updates in http://github.com/jgpATs2w/saprfc
*
*/
class SAPRFC{
  static $connection = null;//connection handler
	static $function = null;//function handler

  /*
  * Initialization function
  *  @param array $settings this array MUST content all of these elements: array (
          "ASHOST"=> SAP_HOST,       // application server host name
          "SYSNR"=> SAP_SYSNR,      // system number
          "CLIENT"=> SAP_CLIENT,    // client
          "USER"=> SAP_USER,        // user
          "PASSWD"=> SAP_PASSWD
         );
  *
  */

	static function init( $settings ){
    self::$connection= \saprfc_open ( $settings );
	}
  /*
  * Make a call to an function module, the function must exist.
  */
	static function call($functionName){

    self::$function= \saprfc_function_discover (self::$connection, $functionName );

    //\saprfc_table_init(SAPRFC::$function, "INTER");

	   $returnCode = \saprfc_call_and_receive ( self::$function );

     switch($returnCode){
       case SAPRFC_OK:
        return true;
       case SAPRFC_EXCEPTION:
        throw new \Exception("Saprfc.call# Exception raised: '" . \saprfc_exception( self::$function)."'");
       default:
        throw new \Exception("Saprfc.call# Error: '" . \saprfc_error( self::$function) . "'");
     }
	}
  /*
  * Export a single parameter
  */
	static function export( $param ){
		return \saprfc_export( self::$function, $param );
	}
  /*
  * Export an array of parameters
  * @return array Key-value pairs
  */
  static function exportAll( $params ){

		$RETURN = array();

		foreach( $params as $param ){

			$export = self::export( $param );

			if( is_array( $export ) )

				$RETURN[ $param ] = array_map( 'utf8_encode', $export );

			else
			 	$RETURN[ $param ] = utf8_encode( $export );
		}

		return $RETURN;
	}

  /*
  * Import an argument to the defined interface.
  */
  static function import( $param, $value ){
    return \saprfc_import( self::$function, $param, $value );
  }

  /*
  * Import an array of key-value parameters
  */
	static function importAll( $params ){

		foreach( $params as $param => $value )
			if( ! is_null( $value ) )
				self::import( $param, $value );

		return true;

	}

  /*
  * Close the connection
  */
	static function close(){

	   \saprfc_function_free( self::$function );

	   \saprfc_close( self::$connection );
	}
  /*
  * Check if the saprfc module is supported
  */
  static function checkModule(){
  	return function_exists( "saprfc_open" );
  }
  /*
  * Get last error of the function
  */
  static function getError(){
    return \saprfc_error();
  }

}
