<?php include("head.php"); ?>

<!doctype html>
<html lang="en">
  <head>
    <title>Cazador Presa Method</title>
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
                        Método Cazador Presa
                    </div>
                    <div class="card-body">
                        <form action="cazadorPresa.php" method="post" id="form">
                            <br/> Método Cazador <br/><br/>
                            Ecuación: <input class="form-control" type="text" name="ecuacion" id="eq">
                            <br/>
                            Razón de crecimiento: <input class="form-control" type="text" name="a" id="a">
                            <br/>
                            Razón de muerte depredador: <input  class="form-control" type="text" name="b" id="b">
                            <br/>
                            Efecto muere presa: <input  class="form-control" type="text" name="c" id="c">
                            <br/>
                            Efecto crece depredador: <input  class="form-control" type="text" name="d" id="d">
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
                            $a = $_POST['a'];
                            $b = $_POST['b'];
                            $c = $_POST['c'];
                            $d = $_POST['d'];
                            
                        
                            // PHP program to implement
                            // Runge Kutta method

                            // A sample differential equation
                            // "dy/dx = (x - y)/2"

                            function f($x,$y)
                            {
                                $ecuac = $a*$x - $b*$x*$y;
                                return $ecuac;
                            }

                            function g($x,$y)
                            {
                                $ecuac = -$c*$y + $d*$x*$y;
                                return $ecuac;
                            }

                            // Finds value of y for a
                            // given x using step size h
                            // and initial value y0 at x0.
                            function rungeKutta($f, $g, $t0, $x0, $y0, $xN, $h)
                            {
                                
                                // Count number of iterations
                                // using step size or step
                                // height h
                                $n = (($xN - $x0) / $h);

                                $k1; $k2; $k3; $k4; $k5;

                                // Iterate for number
                                // of iterations
                                $y = $y0;
                                $ti = $t0;
                                
                                $tabla = array();
                                $tabla[0] = array($ti,$x0,$y);

                                for($i = 1; $i <= $n; $i++)
                                {
                                    
                                    // Apply Runge Kutta
                                    // Formulas to find
                                    // next value of y
                                    $k1x = $h * f($x0, $y);
                                    $k1y = $h * g($x0, $y);

                                    $k2x = $h * f($x0 + $k1x, $y0 + $k1y);
                                    $k2x = $h * g($x0 + $k1x, $y0 + $k1y);

                                    // Update next value of y
                                    $x0 = $x0 + (1/2)*($k1x + $k2x);
                                    $y = $y + (1/2) * ($k1x + $k2x);
                                    $ti = $ti + 2*$h; 

                                    // Update next value of x
                                    $tabla[$i] = array($ti,$x0,$y); 
                                }

                                return $tabla;
                            }
                                $t0 = 0;
                                $x0 = 2;
                                $y0 = 1;
                                
                                $h = 0.5;
                                $muestras = 102;
                                // Driver method
                                echo "Answer",rungeKutta($f, $g, $t0 ,$x0, $y0, $h, $muestras);

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