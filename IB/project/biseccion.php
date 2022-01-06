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

    <script src="https://unpkg.com/mathjs@10.0.1/lib/browser/math.js"></script>
    <script src="https://cdn.plot.ly/plotly-1.35.2.min.js"></script>

  </head>
  <body>
     
    <div class="container">
        
        <div class="row">
            <div class="col-md-3">
                <br/>
                <div class="card">
                    <div class="card-header">
                        Encontrar Raiz por Bisección
                    </div>
                    <div class="card-body">
                        <form action="biseccion.php" method="post" id="form">
                            <br/> La ecuación Ingresada debe ser un polinomio de máximo 
                            grado 3, por lo que solo se aceptan ecuaciones de la forma 
                            a*x^3+b*x^2+c*x+d. <br/><br/>

                            Ecuación: <input class="form-control" type="text" name="ecuacion" id="eq">
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
                        if($_POST){
                            echo "hola";
                            $ecuacionU = $_POST['ecuacion'];
                            $intervaloA = $_POST['a'];
                            $intervaloB = $_POST['b'];
                            $tolerancia = $_POST['tolerancia'];
                            
                            function bisection($ecuacionU, $intervaloA, $intervaloB, $tolerancia){
                                $toleranciaAprox=1;
                                $contador=0;
                        
                                //Convertir string a float
                                $tolerancia = floatval($tolerancia);
                                $intervaloA = floatval($intervaloA);
                                $intervaloB = floatval($intervaloB);
                        
                                //Encontrar imagen de a en la ecuacion
                                
                                $funcionUser = new functions($ecuacionU);
                                $fa=$funcionUser->getImage($intervaloA);
                        
                                while ($tolerancia <= $toleranciaAprox) {
                                    //Encontrar tolearancia Aproximada
                                    $toleranciaAprox=($intervaloB-$intervaloA)/2;

                                    //Encontrar el punto medio y su imagen
                                    $medio=$intervaloA + ($intervaloB-$intervaloA)/2;
                                    $fmedio=$funcionUser->getImage($medio);

                                    $contador=$contador+1;

                                    echo "  ".$contador."\t\t".round($medio,4)."\t\t".$toleranciaAprox."<br/>";

                                    //Aplicar el algoritmo para cambiar puntos
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
                            echo "<br>"."La raiz es: ".$raiz."<br>";
                            echo "En el intervalo [".$intervaloA.",".$intervaloB."]";
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
                    <div id="plot"></div>
                    <p>
                    Used plot library: <a href="https://plot.ly/javascript/">Plotly</a>
                    </p>

                    <script>
                    function draw() {
                        try {
                            // compile the expression once
                            console.log("hola")
                            const expression = document.getElementById('eq').value
                            console.log(expression)
                            const expr = math.compile(expression)

                            // evaluate the expression repeatedly for different values of x
                            const xValues = math.range(-10, 10, 0.5).toArray()
                            const yValues = xValues.map(function (x) {
                                return expr.evaluate({x: x})
                            })

                            // render the plot using plotly
                            const trace1 = {
                                x: xValues,
                                y: yValues,
                                type: 'scatter'
                            }
                            const data = [trace1]
                            Plotly.newPlot('plot', data)
                            console.log("adios")
                        }
                        catch (err) {
                            console.error(err)
                            alert(err)
                        }
                    }

                    document.getElementById('form').onsubmit = function (event) {
                        event.preventDefault()
                        draw()
                    }

                    draw()
                    


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