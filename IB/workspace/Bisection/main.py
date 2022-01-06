# -*- coding: utf-8 -*-
"""
Created on Fri Nov 26 14:40:37 2021

@author: brian
"""

"""
numpy  -->                Libreria para crear vectores y matrices con una gran 
                          coleccion de funciones matematicas.
matplotlib.pyplot -->     Libreria para graficar funciones
metodo_bicesion -->       Importar el metodo en este ejemplo

"""
# Importar Librerias
import numpy as np
import matplotlib.pyplot as plt
import metodo_bicesion as B

"""
Funciones estudiadas anteriormente

#fx = lambda x: x**3 - 3*x**2 - x + 2
#fx = lambda x: np.tan(x) - x
#fx = lambda x: x**2 - 1
#fx = lambda x: x**2 - np.e**x
#fx = lambda x: 2*x**4 - 3*x**2 + 6*x - 1

"""

# Funciones para exposicion
#fx = lambda x: -x**2 + 1.8*x + 2.5  # Funcion cuadratica, 2 raices
fx = lambda x: -1 + 5.5*x - 4*x**2 + 0.5*x**3 # Funcion cubica, 3 raices

a = -10
b = 10

print('Limite "a" representado con azul: ', end='')
a = int(input())
print('Limite "b" representado con negro: ', end='')
b = int(input())

"""
# Intervalo donde se buscara la 1era raiz
a = -5 # -5    0
b = 2 #  2    1
"""

"""
# Intervalo donde se buscara la 2nda raiz
a = 1  # 2    1
b = 1  # 5      2
"""

"""
# Intervalo donde se buscara la 3era raiz
a = 5
b = 7
"""

# % de tolerancia
tolera = 0.05

# Crear un vector espaciado con los limites para x
x = np.linspace(a,b)

# Graficar y marcar x con una linea
ox = 0*x
plt.figure()
plt.plot(x, fx(x))
plt.plot(x,ox,'k-')
plt.ylim(-20, 20)
plt.grid()
plt.title("Método de Biseccion")


# Resultado
raiz=B.biseccion(fx, a, b, tolera, 120)
plt.figure()
plt.plot(x, fx(x))
plt.plot(x,ox,'k-')
plt.plot(raiz,fx(raiz),'o',color="red",label="Raiz")
plt.ylim(-20, 20)
plt.grid()
plt.title("Método de Biseccion")

print('\nLa raiz aproximada es: ',raiz)
