<?php
/**
 * Global configurations
 */

 define('DB_HOST','localhost');
 define('DB_NAME','evolke');
 define('DB_PORT','3306');
 define('DB_USER','root');
 define('DB_PASSWD','');
 
 define('RECORD_PER_PAGE', 10);

 $status = array(
    1 => 'EM_ANDAMENTO',
    2 => 'PROCESSADO',
    3 => 'CANCELADO'
 );
