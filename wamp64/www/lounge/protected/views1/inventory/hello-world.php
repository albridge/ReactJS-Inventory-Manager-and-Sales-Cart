<?php

/* Call this file 'hello-world.php' */
require __DIR__ . '/../vendor/mike42/escpos/autoload.php';
require __DIR__ .'Mike42\Escpos\PrintConnectors\FilePrintConnector';
require __DIR__ .'Mike42\Escpos\Printer';
$connector = new FilePrintConnector("php://stdout");
$printer = new Printer($connector);
$printer -> text("Hello World!\n");
$printer -> cut();
$printer -> close();

?>