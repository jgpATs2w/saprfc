<?php
namespace sap;
/*
* Class specialized in communicate through Remote Function Calls,
* with SAP server.
* Check updates in http://github.com/jgpATs2w/saprfc
*
*/
class SAPRFC{
  static $rfc = null;
  static $fce = null;

  private static $login = null;
	static $function = null;

	static function load(){
		self::$login = array (// Set login data to R/3
            "ASHOST"=> SAP_HOST,       // application server host name
            "SYSNR"=> SAP_SYSNR,      // system number
            "CLIENT"=> SAP_CLIENT,    // client
            "USER"=> SAP_USER,        // user
            "PASSWD"=> SAP_PASSWD
           );

		self::$function = SAP_FUNCTION;
	}

  static function checkModule(){
  	return function_exists( "saprfc_open" );
  }

	static function start(){
		if( ! self::login() )
			return _theend( 0, "no se puede conectar con el servidor SAP", null );

		if( ! self::discover() )
			return _theend( 0, "no existe la funcion " . SAP_FUNCTION, null );
	}

	static function login(){

	   self::$rfc = saprfc_open ( self::$login );

	   if ( ! self::$rfc ){
	       self::logError( "login:" . saprfc_error() );
	       return false;
	   }

	   return true;
	}

	static function discover(){
		self::$fce = saprfc_function_discover( self::$rfc, self::$function );
	   if (! self::$fce ){
	      self::logError( "discover: no function " . self::$function );
		  return false;
	   }

	   return true;
	}

	static function call(){

	   $rc = saprfc_call_and_receive ( self::$fce );

	   if ( $rc != SAPRFC_OK ){
	       if ( self::$rfc == SAPRFC_EXCEPTION )
	           self::logError( "Exception raised: " . saprfc_exception( self::$fce) );
	       else
	           self::logError( "Call error: " . saprfc_error( self::$fce) );

		   return false;
	   }

	   return true;
	}

	static function export( $param ){
		return saprfc_export( self::$fce, $param );
	}

	static function importAll( $params ){

		foreach( $params as $param => $value )
			if( ! is_null( $value ) )
				self::import( $param, $value );

		return true;

	}

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

	static function import( $param, $value ){
		return saprfc_import( self::$fce, $param, $value );
	}

	static function close(){

	   saprfc_function_free( self::$fce );

	   saprfc_close( self::$rfc );
	}

}
