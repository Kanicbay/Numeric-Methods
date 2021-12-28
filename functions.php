<?php

    class functions{

        public $function;
        public $valueFx;

        public function __construct($funcion){
            $this->function = $funcion;
        }

        public function evaluate($x,$y){
            //Crear una copia de la funcion
            $funcion = $y;
            
            /*Declarar las constantes de la funcion como cero para
            hacer una funcion dinamica entre lineal, cuadrada y cubica*/
            $a=0; $b=0; $c=0; $d=0;

            //Encontrar las constantes ingresadas por el usuario
            $funcion = str_replace("+x", "+1*x",$funcion);
            $funcion = str_replace("-x", "-1*x",$funcion);
            $funcion = str_replace("*x", ",*x",$funcion);
            $funcion = str_replace("*x^3", "", $funcion);
            $funcion = str_replace("*x^2", "", $funcion);
            $funcion = str_replace("*x", "", $funcion);
            $funcion = str_replace("+", "", $funcion);

            $constantes = explode(",", $funcion);
            $a = floatval($constantes[0]);
            $b = floatval($constantes[1]);
            $c = floatval($constantes[2]);
            $d = floatval($constantes[3]);

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

    $funcionPrueba = new functions("0.5*x^3-4*x^2+5.5*x-1");

    $funcionPrueba->evaluate(2, $funcionPrueba->function);
    echo $funcionPrueba->valueFx;
?>
