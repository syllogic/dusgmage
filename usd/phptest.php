<?php 
echo system('/usr/sbin/apache2 -l');
echo system('ls /etc/apache2/mods-enabled/');
echo system('ls /etc/apache2/mods-available/');
phpinfo();
?>