<?php
setCookie('store','test',time()+3600*24,'/','.himalayandogchew.com');
    if(isset($_GET['store']))
        $store = $_GET['store'];
    else $store = 'us_en';  
    echo '<a href="http://127.0.0.1/purepharma/index.php/'.$store.'/products.html">Products</a>';
?>