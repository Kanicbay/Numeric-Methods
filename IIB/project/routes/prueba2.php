<?php include("head.php"); ?>

<!doctype html>
<html lang="en">
  <head>
    <title>Rungekutta Method</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://unpkg.com/mathjs@10.0.1/lib/browser/math.js"></script>
    <script src="https://cdn.plot.ly/plotly-1.35.2.min.js"></script>

    <link rel="stylesheet" href="../styles/styles.css" media="screen">

  </head>
  <body>
     
    <div class="container">
        <div class="row row-eq-height">
            <div class="col-md-3 h-100">
                <br/>
                <div class="card"  style="height: 38.59rem;">
                    <div class="card-header">
                        Método Rungenkutta 4
                    </div>
                    <div class="card-body">
                        <form action="rungekutta.php" method="post" id="form">
                            <br/> Método por Rungekutta 4<br/><br/>
                            Ecuación: <input class="form-control" type="text" name="ecuacion" id="eq">
                            <br/>
                            x0: <input class="form-control" type="text" name="x0" id="x0">
                            <br/>
                            y0: <input  class="form-control" type="text" name="y0" id="y0">
                            <br/>
                            x: <input  class="form-control" type="text" name="x" id="x">
                            <br/>
                            h: <input  class="form-control" type="text" name="h" id="h">
                            <br/>
                            <button class="btn btn-success" type="submit">Ejecutar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4 h-100">
                <br/>
                <div class="card" style="height: 38.59rem;">
                    <div class="card-header">
                        Resultados
                    </div>
                    <div class="card-body">
                        <table class="table" id="tabla">
                        <thead>
                            <tr>
                                <th>Resultado</th>
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
                            //$ecuacionU = $_POST['ecuacion'];
                            $x0 = $_POST['x0'];
                            $y0 = $_POST['y0'];
                            $xN = $_POST['x'];
                            $h = $_POST['h'];
                            
                        
                            // PHP program to implement
                            // Runge Kutta method

                            // A sample differential equation
                            // "dy/dx = (x - y)/2"

                            function dydx($x, $y)
                            {
                                $ecuac = (($x - $y) / 2);
                                return(($x - $y) / 2);
                                
                            }

                            // Finds value of y for a
                            // given x using step size h
                            // and initial value y0 at x0.
                            function rungeKutta($x0, $y0, $xN, $h)
                            {
                                
                                // Count number of iterations
                                // using step size or step
                                // height h
                                $n = (($xN - $x0) / $h);

                                $k1; $k2; $k3; $k4; $k5;

                                // Iterate for number
                                // of iterations
                                $y = $y0;
                                for($i = 1; $i <= $n; $i++)
                                {
                                    
                                    // Apply Runge Kutta
                                    // Formulas to find
                                    // next value of y
                                    $k1 = $h * dydx($x0, $y);
                                    $k2 = $h * dydx($x0 + 0.5 * $h,
                                                    $y + 0.5 * $k1);
                                    $k3 = $h * dydx($x0 + 0.5 * $h,
                                                    $y + 0.5 * $k2);
                                    $k4 = $h * dydx($x0 + $h, $y + $k3);

                                    // Update next value of y
                                    $y = $y + (1.0 / 6.0) * ($k1 + 2 *
                                                $k2 + 2 * $k3 + $k4);;

                                    // Update next value of x
                                    $x0 = $x0 + $h;
                                }

                                return $y;
                            }

                                // Driver method
                                $x0 = 0;
                                $y = 1;
                                $x = 2;
                                $h = 0.2;
                                echo "The value of y at x is : ",
                                    rungeKutta($x0, $y, $x, $h);

                            // This code is contributed by anuj_67.
   
                            /*if($intervaloA != null && $intervaloB != null && $tolerancia != null){
                                $raiz=bisection($ecuacionU, $intervaloA, $intervaloB, $tolerancia);
                                echo "<br>"."La raiz es: ".$raiz."<br>";
                                echo "En el intervalo [".$intervaloA.",".$intervaloB."]";
                            }
                            else{
                                echo "Puedes visualizar la función"."<br>"."Busca el intervalo adecuado";
                            }*/
                        }
                    ?>
                    </pre>
                    </div>
                </div>
            </div>
            <div class="col-md-5 h-100">
                <br/>
                <div class="card" style="height: 38.59rem;">
                    <div class="card-header">
                        Gráfica
                    </div>
                    <div class="card-body">
                    <div id="plot" id="plotG"></div>
                    <p>
                    Used plot library: <a href="https://plot.ly/javascript/">Plotly</a>
                    </p>
                </div>
            </div>
        </div>
    

    </div>

    <script>
        function draw() {
            try {
            //Recupear datos guardados en el localStorage
            const expression = window.localStorage.getItem('expression');
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
            }
            catch (err) {
            console.error(err)
            alert(err)
            }
        }

        document.getElementById('form').onsubmit = function (event) {
            // Buscar el elemento por su ID
            let expressionM = document.getElementById('eq').value
            // Guardar el elemento en el localStorage 
            window.localStorage.setItem('expression', expressionM)
            draw()
        }
        draw()
    </script>
    <br/>
    <br/>
        
    <br/>
  </body>
</html>


<?php include("footer.php"); ?>