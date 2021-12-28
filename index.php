<?php
    //Llamar a la clase functions
    require("functions.php");
    /*Crear una instancia --> Esta parte $obj solo es un 
    ejemplo revisar functions para entender sintaxis
    $obj = new functions("x^3+x^2+x+1"); */
    

    function biseccion(){

    }
         
    function newton(){

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="index.php" method="post">

        Ingrese la funcion:
        <input type="text" name="funcion" id="">
        <input type="submit" value="Enviar"> 

    </form>

</body>
</html>