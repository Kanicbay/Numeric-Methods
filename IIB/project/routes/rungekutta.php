<?php include("head.php"); ?>

<!doctype html>
<html lang="en">
  <head>
    <title>Taylor Method</title>
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
            <div class="col-md-12 h-100" id="colPD">
                <h2>Ecuaciones Diferenciales Ordinarias </h2>
                <br/>
                <h3>Método de Rungekutta</h3>
                <br/>
                <p>Para este método se toma la siguiente ecuación de referencia. </p>
                <img src="http://latex.codecogs.com/svg.latex?\frac{dy}{dx}&space;=&space;y&space;&plus;&space;x&space;-&space;x^{2}&space;&plus;1" title="http://latex.codecogs.com/svg.latex?\frac{dy}{dx} = y + x - x^{2} +1" />
                <br/><br/>
                <ul style="font-size: 16px; ">
                    <li><b>Valor Inicial para X</b> x0</li>
                    <li><b>Valor Inicial para Y :</b> y0</li>
                    <li><b>Tamaño de paso :</b> h</li>
                    <li><b>muestras :</b> muestras</li>
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
                <form action="rungekutta.php" method="post" id="form">
                    <h4>Coeficientes</h4> <br/>
                    x0: <input required class="form-control" type="text" name="x0" id="x0">
                    <br/>
                    y0: <input required class="form-control" type="text" name="y0" id="y0">
                    <br/>
                    h: <input required class="form-control" type="text" name="h" id="h">
                    <br/>
                    muestras: <input required class="form-control" type="text" name="muestras" id="muestras">
                    <br/>
                    <button class="btn btn-success" type="submit"><b>Ejecutar</b></button>
                </form>
            </div>
                
            <div class="col-md-6 h-100">
                <h4>Resultados</h4> <br/> 
                <div class="card" id="dataCard" style="height: 300px;";>
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
                                $x0 = $_POST['x0'];
                                $y0 = $_POST['y0'];
                                $h = $_POST['h'];
                                $muestras = $_POST['muestras'];
                                
                                //Convertir string a float

                                $x0 = floatval($x0);
                                $y0 = floatval($y0);
                                $h = floatval($h);
                                $muestras = floatval($muestras);

                                function f($x,$y)
                                {
                                    $ecuac = $y+$x-pow($x,2)+1;
                                    return $ecuac;
                                }

                                function tabla_rungekutta($x0, $y0 , $h, $muestras){
                                    $i=0;
                                    $tamano = $muestras;
                                    $tabla = array();
                                    $tabla[$i++] = array('xi' => $x0,'yi' => $y0);
                                    echo sprintf("%.1f\t\t%f\n", $x0, $y0);

                                    $x = $x0;
                                    $y = $y0;

                                    for($z=0; $z<$tamano; $z++){
                                        $k1 = $h*f($x,$y);
                                        $k2 = $h*f($x+$h,$y+$k1);
                                        
                                        $y = $y + ($k1 + $k2)/2;
                                        $x = $x + $h;

                                        $tabla[$i++] = array('xi' => $x,'yi' => $y);
                                        echo sprintf("%.1f\t\t%f\n", $x, $y);
                                    }
                                    
                                    return $tabla;
                                }                              

                                // Driver method
                                $respuesta = tabla_rungekutta($x0, $y0 ,$h, $muestras);
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
            <div class="col-md-12 h-100">
                <div class="card" style="height: 38.59rem;">
                    <div class="card-header">
                        Método Rungekutta
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
    </div>

    <script>
        function draw() {
            try {
                //Recupear datos guardados en el localStorage
                let values = window.localStorage.getItem('respuesta');

                values = JSON.parse(values);

                let xValues = [];
                let yValues = [];


                for (let item of values) {
                    xValues.push(item.xi);
                    yValues.push(item.yi);
                }



                // render the plot using plotly
                const trace = {
                    x: xValues,
                    y: yValues,
                    type: 'scatter'
                }
                
                const data = [trace];
                //const data2 = [traceT1, traceT2];

                Plotly.newPlot('plot', data);
                //Plotly.newPlot('plot2', data2);
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