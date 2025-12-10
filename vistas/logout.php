<?php
# Archivo: logout.php
# Propósito: Página intermedia para cerrar sesión y redirigir

    session_destroy();
    
    if(headers_sent()){
        echo "<script> window.location.href='index.php?vista=login'; </script>";
    }else{
        header("Location: index.php?vista=login");
    }