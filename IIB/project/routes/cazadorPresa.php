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
        <div class="row">
            <div class="col-md-12 h-100">
                <h2>Sistemas de Ecuaciones Diferenciales</h2>
                <br/>
                <h3>Método Cazador Presa</h3>
                <hr>
                <p class="lead">Este modelo se considera como un modelo depredador-presa y caos. 
                    El modelo proviene de las Ecuaciones Lotka-Volterra donde se tiene el siguiente sistema de ecuaciones 
                    diferenciales:
                </p>
                <ul class="list-unstyled" style="position: relative; left: 20px;" >
                    <li><img src="https://latex.codecogs.com/svg.image?\frac{dx}{dy}&space;=&space;ax&space;-&space;bxy" title="\frac{dx}{dy} = ax - bxy" /></li>
                    <br/>
                    <li><img src="https://latex.codecogs.com/svg.image?\frac{dy}{dt}&space;=&space;-cy&space;&plus;&space;dxy" title="\frac{dy}{dt} = -cy + dxy" /></li>
                </ul>
                <p class="lead">
                    tomando como variables:
                </p>
                <ul style="font-size: 18px;">
                    <li><b>x :</b> número de presas</li>
                    <li><b>y :</b> número de depredadores</li>
                    <li><b>t :</b> tiempo de observación</li>
                    <li><b>h :</b> h</li>
                    <li><b>m :</b> número de muestras</li>
                </ul>
                <p class="lead">
                    y como coeficientes:
                </p>
                <ul style="font-size: 18px;">
                    <li><b>a :</b> razón de crecimiento de la presa</li>
                    <li><b>c :</b> razón de muerte del depredador</li>
                    <li><b>b :</b> efecto de la interacción depredador-presa sobre la muerte de la presa</li>
                    <li><b>d :</b> efecto de la interacción depredador-presa sobre el crecimiento del depredador</li>
                </ul>
            </div>
        </div>
    </div>
    <br/> <br/>
    <div class="container">
        <div class="row row-eq-height">
            <h3>Experimentación</h3>
            <hr>
            <br/>
            <div class="col-md-6 h-100">
                <form action="cazadorPresa.php" method="post" id="form">
                    <h4>Coeficientes</h4> <br/>
                    Razón de crecimiento de la presa (a): <input required class="form-control" type="text" name="a" id="a">
                    <br/>
                    Efecto interacción sobre la muerte de la presa (b): <input required class="form-control" type="text" name="b" id="b">
                    <br/>
                    Razón de muerte del depredador (c): <input required class="form-control" type="text" name="c" id="c">
                    <br/>
                    Efecto interacción sobre el crecimiento del depredador (d): <input required class="form-control" type="text" name="d" id="d">
                    <br/>
                    <h4>Variables</h4> <br/>
                    Tiempo observación (t): <input required class="form-control" type="text" name="t" id="t">
                    <br/>
                    Número de presas (x): <input required class="form-control" type="text" name="x" id="x">
                    <br/>
                    Número depredadores (y): <input required class="form-control" type="text" name="y" id="y">
                    <br/> 
                    (h): <input required class="form-control" type="text" name="h" id="h">
                    <br/>
                    Número de muestras (m): <input required class="form-control" type="text" name="m" id="m">
                    <br/>
                    <button class="btn btn-success" type="submit"><b>Ejecutar</b></button>
                </form>
            </div>
                
            <div class="col-md-6 h-100">
                <h4>Resultados</h4> <br/> 
                <div class="card" id="dataCard">
                    <div class="card-body">
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
                                $x = $_POST['x'];
                                $y = $_POST['y'];
                                $t = $_POST['t'];
                                $h = $_POST['h'];
                                $m = $_POST['m'];
                            
                                // PHP program to implement
                                // Runge Kutta method

                                // A sample differential equation
                                // "dy/dx = (x - y)/2"

                                function f($x,$y,$a,$b)
                                {
                                    $ecuac = $a*$x - $b*$x*$y;
                                    return $ecuac;
                                }

                                function g($x,$y,$c,$d)
                                {
                                    $ecuac = -$c*$y + $d*$x*$y;
                                    return $ecuac;
                                }

                                // Finds value of y for a
                                // given x using step size h
                                // and initial value y0 at x0.
                                function rungeKutta($t0, $x0, $y0, $h, $muestras,$a,$b,$c,$d)
                                {
                                    
                                    // Print the table headers
                                    echo "<b>".sprintf("%s\t\t\t%s\t\t\t%s\n", "Tiempo", "Depredadores","Presas")."</b>";
                                    echo "<hr>";
                                    echo sprintf("\n%d\t\t\t%d\t\t\t\t%d\n", $t0, $x0, $y0);

                                    // Count number of iterations
                                    // using step size or step
                                    // height h

                                    $k1; $k2; $k3; $k4; $k5;

                                    // Iterate for number
                                    // of iterations
                                    $y = $y0;
                                    $ti = $t0;
                                    
                                    //Save first values
                                    $tabla = array();
                                    //$valuesToString = '{"t":'.$t0.',"x":'.$x0.',"y":'.$y0.'}';
                                    $tabla[0] = array('t' => $t0,'x' => $x0,'y' => $y0);

                                    for($i = 1; $i <= $muestras; $i++)
                                    {
                                        
                                        // Apply Runge Kutta
                                        // Formulas to find
                                        // next value of y
                                        $k1x = $h * f($x0, $y,$a,$b);
                                        $k1y = $h * g($x0, $y,$c,$d);

                                        $k2x = $h * f($x0 + $k1x, $y + $k1y,$a,$b);
                                        $k2y = $h * g($x0 + $k1x, $y + $k1y,$c,$d);

                                        // Update next value of x and y
                                        $x0 = $x0 + (1/2)*($k1x + $k2x);
                                        $y = $y + (1/2) * ($k1y + $k2y);
                                        $ti = $ti + $h; 

                                        // Save each value into the array if we want to use it later
                                        //$valuesToString = '{"t":'.$ti.',"x":'.$x0.',"y":'.$y.'}';
                                        $tabla[$i] = array('t' => $ti,'x' => $x0,'y' => $y);

                                        // Print results after each iteration, in order to show the process to the user
                                        $tN = round(doubleval($ti),2);
                                        $xN = doubleval($x0);
                                        $yN = doubleval($y);

                                        echo sprintf("%.1f\t\t\t%f\t\t\t%f\n", $tN, $xN, $yN);
                                    }

                                    return $tabla;
                                }
                                    // Driver method
                                    $respuesta = rungeKutta($t ,$x, $y, $h, $m,$a,$b,$c,$d);
                                    echo "<script>
                                        window.localStorage.setItem('respuesta', JSON.stringify(".json_encode($respuesta)."));
                                    </script>";

                                    //Other way to print the array, but without number format
                                    //print_r($rF);
                            }
                        ?>
                        </pre>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <br/> <br/> <br/> 

    <div class="container">
        <div class="row">
            <h3>Gráficas</h3>
            <hr>
            <br/>
            <div class="col-md-6 h-100">
                <div class="card" style="height: 38.59rem;">
                    <div class="card-header">
                        Modelo Presa - Depredador [xi, yi]
                    </div>
                    <div class="card-body">
                        <div id="plot" id="plotG"></div>
                        <p>
                        Used plot library: <a href="https://plot.ly/javascript/">Plotly</a>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 h-100">
                <div class="card" style="height: 38.59rem;">
                    <div class="card-header">
                        Modelo Presa - Depredador vs Tiempo
                    </div>
                    <div class="card-body">
                        <div id="plot2" id="plotG"></div>
                        <p>
                        Used plot library: <a href="https://plot.ly/javascript/">Plotly</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function draw() {
            try {
                //Recupear datos guardados en el localStorage
                let values = window.localStorage.getItem('respuesta');

                values = JSON.parse(values);

                let xValues = [];
                let yValues = [];
                let tValues = [];

                for (let item of values) {
                    tValues.push(item.t);
                    xValues.push(item.x);
                    yValues.push(item.y);
                }

                // render the plot using plotly
                const trace = {
                    x: xValues,
                    y: yValues,
                    type: 'scatter'
                }

                const traceT1 = {
                    x: tValues,
                    y: xValues,
                    type: 'scatter',
                    name: "Depredadores"
                }

                const traceT2 = {
                    x: tValues,
                    y: yValues,
                    type: 'scatter',
                    name: "Presas"
                }
                
                const data = [trace];
                const data2 = [traceT1, traceT2];

                Plotly.newPlot('plot', data);
                Plotly.newPlot('plot2', data2);
            }
            catch (err) {
                console.error(err);
                alert(err)
            }
        }

        document.getElementById('form').onsubmit = function (event) {
            draw()
        }
        draw()
    </script>

    <br/> <br/> <br/>

  </body>
</html>


<?php include("footer.php"); ?>