<?php 

// source URL please visit it 
//http://theserverpages.com/php/manual/en/function.printer-open.php
printer_open("\\\\servername\\printername"); ?> 

What I had been missing is that the function needed the internet host name of the server, which includes the domain name.  So, let's say my print server was called "PServer" and my network's domain was called php.net: 

<?php printer_open("\\\\Pserver.php.net\\printername"); ?> 

This will more than likely work, then you can open and print a file as follows: 

<?php 
$printer = "\\\\Pserver.php.net\\printername"); 
if($ph = printer_open($printer)) 
{ 
   // Get file contents 
   $fh = fopen("filename.ext", "rb"); 
   $content = fread($fh, filesize("filename.ext")); 
   fclose($fh); 
        
   // Set print mode to RAW and send PDF to printer 
   printer_set_option($ph, PRINTER_MODE, "RAW"); 
   printer_write($ph, $content); 
   printer_close($ph); 
} 
else "Couldn't connect..."; 
?>

Connecting to Network Printers 
<?php 
   $handle = printer_open("\\\\DOMAIN_NAME\\Printer_Name"); 
?> 
Similiar to how you would locate a domain on your network 
you need to have 2 prefix slashes.  But as reminder 
you need to escape it.  So really you need 4 slashes.  It 
worked me. Hopefully this helps who is having problems 
connecting to network printer.