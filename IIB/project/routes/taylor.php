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
                <h3>Método de Taylor</h3>
                <ul style="font-size: 18px; ">
                    <li><b>x0 :</b> x0</li>
                    <li><b>y0 :</b> y0</li>
                    <li><b>h :</b> h</li>
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
                <form action="taylor.php" method="post" id="form">
                    <h4>Coeficientes</h4> <br/>
                    f: <input required class="form-control" type="text" name="f" id="f">
                    <br/>
                    g: <input required class="form-control" type="text" name="g" id="g">
                    <br/>
                    x0: <input required class="form-control" type="text" name="x0" id="x0">
                    <br/>
                    y0: <input required class="form-control" type="text" name="y0" id="muestras">
                    <br/>
                    h: <input required class="form-control" type="text" name="h" id="muestras">
                    <br/>
                    muestras: <input required class="form-control" type="text" name="muestras" id="muestras">
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
                                $x0 = $_POST['x0'];
                                $y0 = $_POST['y0'];
                                $h = $_POST['h'];
                                $muestras = $_POST['muestras'];
                                
                                //Convertir string a float

                                $x0 = floatval($x0);
                                $y0 = floatval($y0);
                                $h = floatval($h);
                                $muestras = floatval($muestras);


                                function d1y($x,$y)
                                {
                                    $ecuac = $y - pow($x,2) + $x + 1;
                                    return $ecuac;
                                }

                                function d2y($x,$y)
                                {
                                    $ecuac = $y - pow($x,2) + $x + 2;
                                    return $ecuac;
                                }


                                function tabla_taylor($x0, $y0 , $h, $muestras){
                                    $i=0;
                                    $tamano = $muestras + 1;
                                    $tabla = array();
                                    $d1yi = d1y($x0,$y0);
                                    $d2yi = d2y($x0,$y0);
                                    $tabla[$i] = array('xi' => $x0,'yi' => $y0,'d1yi' => $d1yi,'d2yi' => $d2yi);

                                    $x = $x0;
                                    $y = $y0;

                                    for($z=0; $z<$tamano; $z++){
                                        $d1y = d1y($x,$y);
                                        $d2y = d2y($x,$y);
                                        $tabla[$i] = array('d1yi' => $d1y,'d2yi' => $d2y);
                                        
                                        $y = $y + $h*$d1y + (pow($h,2)/2)*$d2y;
                                        $x = $x + $h;
                                        
                                        $tabla[$i] = array('xi' => $x,'yi' => $y);
                                        $i++;
                                        echo sprintf("%f\t\t%f\t%f\t\t%f\n", $x, $y, $d1y, $d2y);
                                    }
                                    
                                    return $tabla;
                                }


                                
                                // Driver method
                                $respuesta = tabla_taylor($x0, $y0 ,$h, $muestras);
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
                        Método de la secante
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

                document.getElementById('form').onsubmit = function (event) {
                    a = document.getElementById('a').value;
                    b = document.getElementById('b').value;
                    tramos = document.getElementById('tramos').value;
                }

                

                /*values = JSON.parse(values);

                let xaValues = [];
                let xbValues = [];
                let xcValues = [];
                let trValues = [];


                for (let item of values) {
                    xaValues.push(item.xa);
                    xbValues.push(item.xb);
                    xcValues.push(item.xc);
                    trValues.push(item.tramo);
                }

                // render the plot using plotly
                const trace = {
                    x: xaValues,
                    y: xbValues,
                    type: 'scatter'
                }

                /*const traceT1 = {
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
                //const data2 = [traceT1, traceT2];

                Plotly.newPlot('plot', data);*/
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