# saprfc

##Installation instructions

(copy of original install document)
Installation Instructions for sapnwrfc
--------------------------------------

sapnwrfc is an extension module for PHP.
The idea behind sapnwrfc is to be able to call an SAP R/3 Function Module.

You must obtain and install the NW RFC SDK from SAP for this extension to work.


Quick info:
-----------

sapnwrfc is distributed under PHP license with source codes in
tarball sapnwrfc-$VERSION$.tar.gz.

Under Linux (UNIX) platform two methods for instalation exist:

  a) Rebuild PHP with sapnwrfc extension included
  b) Build sapnwrfc extension as dynamic module without rebuilding PHP

Steps for a)

  Extract source tarball to PHP source tree (under ext/ directory)  
and rebuild PHP with commands

  rm ./configure
  ./buildconf --force
  ./configure --with-sapnwrfc=<path to nwrfcsdk> (+ your configuration directives)
  make

Note: you must obtain the NW RFC SDK from SAP via http://service.sap.com.
  Please follow OSS note 1056472, 1058327, 1236530.

Steps for b)

  Extract source tarball to some directory and build dynamic module
 with commands  

  cd <sapnwrfc dir>
  phpize
  ./configure
  ./configure --with-sapnwrfc=<path to nwrfcsdk>
  make
  make install

  see build.sh for an example

  Enable sapnwrfc extension editing your php.ini - add line:

 extension=sapnwrfc.so


Requirements:
-------------

Under UNIX:

    * PHP sources (http://www.php.net/downloads.php)
    * php-devel package for installation sapnwrfc as dynamic module
    * GNU tools (autoconf, automake, flex, libtool, gcc, m4, make)
    * Non-Unicode SAP RFCSDK 6.20 for your platform (if you are SAP customer
      you can download it from http://service.sap.com/swdc under
      <Support Packages and Patches - My Company's Application Components
      SAP WEB AS - SAP WEB AS 6.20 - SAP RFC SDK>)

Under Win32:


After installation:
-------------------

  Have a look in the unit_tests directory for examples of how to call.

## Documentation

http://saprfc.sourceforge.net/
