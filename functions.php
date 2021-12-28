<?php

    class functions{

        public $function;
        public $valueFx;
        

        public function __construct($funcion){
            $this->function = $funcion;
        }

        public function evaluate($x){
            //Crear una copia de la funcion
            $funcion = $this->function;
            
            /*Declarar las constantes de la funcion como cero para
            hacer una funcion dinamica entre lineal, cuadrada y cubica*/
            $a=0; $b=0; $c=0; $d=0;

            //Encontrar las constantes ingresadas por el usuario
            //Agregar comas
            $funcion = str_replace("x^3", "x^3,",$funcion);
            $funcion = str_replace("x^2", "x^2,",$funcion);
            $funcion = str_replace("x+", "x,+",$funcion);
            $funcion = str_replace("x-", "x,-",$funcion);
            $funcion = str_replace("*", "", $funcion);

            //Quitar signos
            $funcion = str_replace("+", "",$funcion);

            //Separar las constantes
            $separados = explode(",", $funcion);

            /*Encuentra coincidencias con cubica, cuadrada, lineal y constante 
            para sacar sus constantes respectivas*/
            foreach($separados as $indice=>$valor){
                if(stristr($valor, "x^3")==="x^3"){	
                    $valor=str_replace("x^3", "", $valor);
                    if($valor=="" || $valor=="+" || $valor=="-"){
                        $valor=$valor."1";
                    }
                    $a=$valor;
                }
                if(stristr($valor, "x^2")==="x^2"){
                    $valor=str_replace("x^2", "", $valor);
                    if($valor=="" || $valor=="+" || $valor=="-"){
                        $valor=$valor."1";
                    }
                    $b=floatval($valor);
                }
                if(stristr($valor, "x")==="x"){
                    $valor=str_replace("x", "", $valor);
                    if($valor=="" || $valor=="+" || $valor=="-"){
                        $valor=$valor."1";
                    }
                    $c=floatval($valor);
                }
                if(is_numeric($separados[$indice])){
                    $d=floatval($separados[$indice]);
                }
            }

            echo $a." ".$b." ".$c." ".$d."<br>";

            //Formato de la funcion a seguir
            $functionR = $a*pow($x,3) + $b*pow($x,2) + $c*pow($x,1) + $d;

            //Evaluar la funcion
            $this->valueFx = $functionR;
            return $this->valueFx;
        }


        public function biseccion($a, $b, $tol, $N){
           
        } 

        public function newtonR($x0, $tol, $N){
            
        }

    }

    $funcionPrueba = new functions("-x^2-2");

    $funcionPrueba->evaluate(2);
    echo $funcionPrueba->valueFx;
?>

