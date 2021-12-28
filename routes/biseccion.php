<?php include("head.php"); ?>

<?php
    //Llamar a la clase functions
    require("functions.php");
    /*Crear una instancia --> Esta parte $obj solo es un 
    ejemplo revisar functions para entender sintaxis
    $obj = new functions("x^3+x^2+x+1"); */

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Bisection Method</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  </head>
  <body>
     
    <form action="biseccion.php" method="post">

        La ecuación Ingresada debe ser un polinomio de máximo <br/>
        grado 3, por lo que solo se aceptan ecuaciones de la forma <br/>
        a*x^3+b*x^2+c*x+d. <br/><br/>
        
        Ecuación: <input class="form-control" type="text" name="ecuacion" id="">
        <br/>
        Valor a: <input class="form-control" type="text" name="a" id="">
        <br/>
        Valor b: <input class="form-control" type="text" name="b" id="">
        <br/>
        Tolerancia: <input class="form-control" type="text" name="tolerancia" id="">
        <br/>
        <button class="btn btn-success" type="submit">Calcular Raiz</button>


    </form>

  </body>
</html>


<?php include("footer.php"); ?>