<?php

use saprfc\SAPRFC;

class SaprfcTest extends \PHPUnit_Framework_TestCase
{
  function test_ping(){

    $parameters= array (
            "ASHOST"=> "10.197.7.103", // application server host name
            "SYSNR"=> '00',      // system number
            "CLIENT"=> '100',    // client
            "USER"=> 'NOTI_P',        // user
            "PASSWD"=> 'inicio'
           );

    SAPRFC::init($parameters);
  	SAPRFC::call("Z_AV_PING_JAVA");

  	$fecha = SAPRFC::export( "FECHA" );

    $this->assertSame($fecha,date('Ymd'));

  }

  function test_table(){

    $parameters= array (
            "ASHOST"=> "10.197.7.103", // application server host name
            "SYSNR"=> '00',      // system number
            "CLIENT"=> '100',    // client
            "USER"=> 'NOTI_P',        // user
            "PASSWD"=> 'inicio'
           );

    SAPRFC::init($parameters);

  	SAPRFC::call("ZZZZ");

    SAPRFC::import("PARAM_TABLA", array());
    SAPRFC::import("POS_VTA_IN", array());

    \saprfc_function_debug_info(SAPRFC::$function);
    //$table= \saprfc_table_read(SAPRFC::$function, "INTER", 0);

    var_dump(SAPRFC::export("INTER"));
    var_dump(SAPRFC::export("CAMP"));
  }
}

?>
