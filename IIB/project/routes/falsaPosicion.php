<?php include("head.php"); ?>

<!doctype html>
<html lang="en">
  <head>
    <title>Falsa Posición Method</title>
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
                <h2>Encontrar Raiz </h2>
                <br/>
                <h3>Método de la Falsa Posición</h3>
                <ul style="font-size: 18px; ">
                    <li><b>a :</b> a</li>
                    <li><b>b :</b> b</li>
                    <li><b>tolerancia :</b> tolerancia</li>
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
                <form action="falsaPosicion.php" method="post" id="form">
                    <h4>Coeficientes</h4> <br/>
                    ecuación (d): <input required class="form-control" type="text" name="ecuacion" id="ecuacion">
                    <br/>
                    (a): <input required class="form-control" type="text" name="a" id="a">
                    <br/>
                    (b): <input required class="form-control" type="text" name="b" id="b">
                    <br/>
                    tolerancia (d): <input required class="form-control" type="text" name="tolerancia" id="tolerancia">
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
                                $tolerancia = $_POST['tolerancia'];
                                
                                //Convertir string a float

                                $a = floatval($a);
                                $b = floatval($b);
                                $tolerancia = floatval($tolerancia);

                                function tabla_falsa($ecuacion, $a, $b,$tolerancia){
                                    $i = 1;
                                    $funcionUser = new functions($ecuacion);
                                    $tramo = abs($b-$a);
                                    echo "<b>".sprintf("%s\t\t%s\t\t%s\n", "n", "c","Tramo")."</b>";
                                    echo "<hr>";
                                    
                                    function sign($fx){
                                        if($fx > 0){
                                            return 1;
                                        }else if($fx < 0){
                                            return -1;
                                        }else{
                                            return 0;
                                        }
                                    }

                                    while ($tramo>=$tolerancia){
                                        $fa= $funcionUser->getImage($a);
                                        $fb= $funcionUser->getImage($b);
                                        $c = $b-$fb*($a-$b)/($fa-$fb);
                                        $fc= $funcionUser->getImage($c);

                                        $cambio = sign($fa)*sign($fc);

                                        $tabla[$i++] = array('n' => $i,'c' => $c,'tramo' => $tramo);

                                        echo sprintf("%d\t\t%f\t%f\n", $i, $c, $tramo);
                                        $i++;
                                        if ($cambio>0){
                                            $tramo = abs($c-$a);
                                            $a = $c;
                                        }
                                        else{
                                            $tramo = abs($b-$c);
                                            $b = $c;
                                        }
                                    }

                                    echo sprintf("\nLa raiz de la ecuación es: %f", $c);
                                    return $tabla;
                                }


                                
                                // Driver method
                                $respuesta = tabla_falsa($ecuacionU , $a, $b,$tolerancia);
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