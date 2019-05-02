<?php 

spl_autoload_register( function( $class ) {
    $pos = strrpos( $class, '\\' );
    include ( $pos === false ? $class : substr( $class, $pos + 1 ) ).'.php';
});


new Test\test;
new test3;


 ?>