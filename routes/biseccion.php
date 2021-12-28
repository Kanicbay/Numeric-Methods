<?php include("head.php"); ?>

<?php
    //Llamar a la clase functions
    require("functions.php");
    /*Crear una instancia --> Esta parte $obj solo es un 
    ejemplo revisar functions para entender sintaxis
    $obj = new functions("x^3+x^2+x+1"); */
    if($_POST){
        $ecuacionU = $_POST['ecuacion'];
        $intervaloA = $_POST['a'];
        $intervaloB = $_POST['b'];
        $tolerancia = $_POST['tolerancia'];
   
    }

    function bisection($ecuacionU, $intervaloA, $intervaloB, $tolerancia){
        $toleranciaAprox=1;
        $contador=0;

        //Convertir string a float
        $tolerancia = floatval($tolerancia);
        $intervaloA = floatval($intervaloA);
        $intervaloB = floatval($intervaloB);

        //Encontrar imagen de a en la ecuacion
        
        $funcionUser = new functions($ecuacionU);
        print_r("Iteración\t\tRaíz\t\tError\n");
        $fa=$funcionUser->getImage($intervaloA);

        echo $toleranciaAprox." y ".$tolerancia;

        while ($tolerancia <= $toleranciaAprox) {
            $toleranciaAprox=($intervaloB-$intervaloA)/2;
            $medio=$intervaloA + ($intervaloB-$intervaloA)/2;
            $fmedio=$funcionUser->getImage($medio);
            $contador=$contador+1;
            print_r($contador."\t\t".$medio."\t\t".$toleranciaAprox);
            if($fmedio==0||$toleranciaAprox<$tolerancia){
                return $medio;
            }
            if($fa*$fmedio>0){
                $intervaloA=$medio;
                $fa=$fmedio;
            }
            else{
                $intervaloB=$medio;
            }
        }
    }


    $raiz=bisection($ecuacionU, $intervaloA, $intervaloB, $tolerancia);
    echo "<br>"."La raíz es: ".$raiz;

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
     
    <div class="container">
        
        <div class="row">
            <div class="col-md-4">

            <br/>
            <div class="card">
                <div class="card-header">
                    Encontrar Raiz por Bisección
                </div>
                <div class="card-body">
                    <form action="biseccion.php" method="post">
                        <br/> La ecuación Ingresada debe ser un polinomio de máximo 
                        grado 3, por lo que solo se aceptan ecuaciones de la forma 
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
                </div>
                <div class="card-footer text-muted">
                    La raiz es:  <br/>
                    La cantidad de iteraciones son: <br/>
                </div>
            </div>

            
            </div>
            <div class="col-md-4">
                
            </div>
            <div class="col-md-4">
                
            </div>
        </div>

    

    </div>

    

  </body>
</html>


<?php include("footer.php"); ?>