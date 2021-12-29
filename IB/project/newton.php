<?php include("head.php"); ?>



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
            <div class="col-md-3">

            <br/>
            <div class="card">
                <div class="card-header">
                    Encontrar Raiz por Newton Raphson
                </div>
                <div class="card-body">
                    <form action="newton.php" method="post">
                        <br/> La ecuación Ingresada debe ser un polinomio de máximo 
                        grado 3, por lo que solo se aceptan ecuaciones de la forma 
                        a*x^3+b*x^2+c*x+d. <br/><br/>

                        Ecuación: <input class="form-control" type="text" name="ecuacion" id="">
                        <br/>
                        X0: <input class="form-control" type="text" name="x0" id="">
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
                <br/>
                <div class="card" style="height: 38.59rem;">
                    <div class="card-header">
                        Resultados
                    </div>
                    <div class="card-body">
                        <table class="table">
                        <thead>
                            <tr>
                                <th>Iter</th>
                                <th>Raiz</th>
                                <th>Error</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                    <pre>
                    <?php
                        //Llamar a la clase functions
                        require("functions.php");
                        /*Crear una instancia --> Esta parte $obj solo es un 
                        ejemplo revisar functions para entender sintaxis
                        $obj = new functions("x^3+x^2+x+1"); */
                        $n=1;
                        $p=0.00;
                        if($_POST){
                            $x0=$_POST['x0'];
                            $x0WM = $x0;
                            $x0 = floatval($x0);
                            $funtion = $_POST['ecuacion'];
                            $tol=$_POST['tolerancia'];
                            $tol = floatval($tol);
                            while($n <= 20){
                                $funcion = new functions($funtion);
                                $f = $funcion->getImage($x0);
                                $Derivada = $funcion->derive();
                                $funcionD = new functions($Derivada);
                                $fprime = $funcionD->getImage($x0); 
                                $p = $x0 - ($f/$fprime);
                                $f1 = $funcion->getImage($p);
                                echo "  ".$n."\t\t".round($p,4)."\t\t".round(abs($p-$x0),9)."<br/>";
                                if (($f1==0)||(abs($p-$x0) < $tol)) {
                                    break;
                                }
                                $x0 = $p;
                                $n += 1;
                            }

                            echo "<br>"."La raiz es: ".$p."<br>";
                            echo "Con x0: ".$x0WM."<br>";
                            echo "La cantidad de iteraciones son: ".$n."<br>";
                        }
                        

                    ?>
                    </pre>
                    </div>
                    <div class="card-footer text-muted">
                        
                    </div>
                </div>
                
            
            </div>
            <div class="col-md-5" style="height: 38.59rem;">
                <br/>
                <div class="card">
                    <div class="card-header">
                        Gráfica
                    </div>
                    <div class="card-body">
                        Aqui va la gráfica
                    </div>
                    <div class="card-footer text-muted">
                        
                    </div>
                </div>
            </div>
        </div>

    

    </div>

    

  </body>
</html>

<?php include("footer.php"); ?>