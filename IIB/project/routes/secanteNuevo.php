<?php include("head.php"); ?>

<!doctype html>
<html lang="en">
  <head>
    <title>Secante Method</title>
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
                <h2>Encontrar Puntos </h2>
                <br/>
                <h3>Método de la Secante</h3>
                <ul style="font-size: 18px; ">
                    <li><b>a :</b> a</li>
                    <li><b>b :</b> b</li>
                    <li><b>xa :</b> xa</li>
                    <li><b>tolerancia :</b> tolerancia</li>
                    <li><b>tramos :</b> tramos</li>
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
                <form action="secanteNuevo.php" method="post" id="form">
                    <h4>Coeficientes</h4> <br/>
                    ecuación (d): <input required class="form-control" type="text" name="ecuacion" id="ecuacion">
                    <br/>
                    (a): <input required class="form-control" type="text" name="a" id="a">
                    <br/>
                    (b): <input required class="form-control" type="text" name="b" id="b">
                    <br/>
                    (xa): <input required class="form-control" type="text" name="xa" id="xa">
                    <br/>
                    tolerancia (d): <input required class="form-control" type="text" name="tolerancia" id="tolerancia">
                    <br/>
                    tramos (d): <input required class="form-control" type="text" name="tramos" id="tramos">
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
                                $ecuacionU = $_POST['ecuacion'];
                                $a = $_POST['a'];
                                $b = $_POST['b'];
                                $xa = $_POST['xa'];
                                $tolerancia = $_POST['tolerancia'];
                                $tramos = $_POST['tramos'];
                                
                                //Convertir string a float

                                $a = floatval($a);
                                $b = floatval($b);
                                $xa = floatval($xa);
                                $tolerancia = floatval($tolerancia);
                                $tramos = floatval($tramos);

                                function tabla_secante($ecuacion, $xa, $tolerancia){
                                    $i = 0;
                                    $funcionUser = new functions($ecuacion);
                                    $dx = 4*$tolerancia;
                                    $xb = $xa + $dx;
                                    $tramo = $dx;
                                    $tabla = array();

                                    echo "<b>".sprintf("%s\t\t%s\t\t%s\t\t%s\n", "Xa", "Xb","Xc","Tramo")."</b>";
                                    echo "<hr>";
                                    

                                    while($tramo>=$tolerancia){
                                        $fa= $funcionUser->getImage($xa);
                                        $fb= $funcionUser->getImage($xb);
                                        $xc = $xa - $fa*($xb-$xa)/($fb-$fa);
                                        $tramo = abs($xc-$xa);

                                        $tabla[$i++] = array('xa' => $xa,'xb' => $xb,'xc' => $xc,'tramo' => $tramo);
                                        echo sprintf("%.3f\t\t%f\t%f\t%f.3\n", $xa, $xb, $xc, $tramo);
                                        $xb = $xa;
                                        $xa = $xc;
                                    }

                                    echo sprintf("\nLa raiz de la ecuación es: %f", $xc);
                                    return $tabla;
                                }


                                
                                // Driver method
                                $respuesta = tabla_secante($ecuacionU ,$xa, $tolerancia);
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
                a = document.getElementById('a').value;
                b = document.getElementById('b').value;
                tramos = document.getElementById('tramos').value;

                values = JSON.parse(values);

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
                }*/
                
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