# -*- coding: utf-8 -*-
"""
Created on Fri Nov 26 14:30:55 2021

@author: brian
"""

"""
los parametros son los siguientes:
    a y b: Limites para buscar la raiz
    f: funcion donde buscaremos la raiz
    tol: tolerancia que buscamos en la raiz
    N: Numero maximo de iteraciones
    
"""
import matplotlib.pyplot as plt
import numpy as np

def biseccion(f, a, b, tol, N):
    x = np.linspace(a,b)
    i = 1
    # Se encuentra el valor de y para a
    fa = f(a)
    
    # a = blue
    # b = black
    
    print('Iteraciones   Raiz           Error' )
    while(i <= N):
        # Grafica con los puntos que quedan
        ox = 0*x
        plt.figure()
        plt.plot(x, f(x))
        plt.plot(x,ox,'k-')
        plt.ylim(-20, 20)
        plt.plot(a,f(a),'o',color="blue")
        plt.plot(b,f(b),'o')
        plt.grid()
        plt.title("Método de Biseccion")
        
        
        
        # Se encuentra el valor para definir a que punto seguir
        p = a + (b-a)/2
        # Se encuentra el valor de y para p
        fp = f(p)
        plt.plot(p,fp,'o',color="brown")
        # Formato para imprimir cada iteracion con raiz y error
        print('{0:2d}{1:24.10f}{2:15.10f}'.format(i, p, (b-a)/2))
        
        # Se decide si se rompe la tolerancia
        if((fp == 0) or ((b-a)/2 < tol)):
            return p
        i = i+1
        # Se usa las reglas del algoritmo, si fa*fp > 0 entonces a = p
        if(fa * fp > 0):
            a = p
            fa = fp
        # Se usa las reglas del algoritmo, si fa*fp <= 0 entonces b = p
        else:
            b = p
            
        # Se sigue las iteraciones hasta que la tolerancia sea alcanzada
    
                         