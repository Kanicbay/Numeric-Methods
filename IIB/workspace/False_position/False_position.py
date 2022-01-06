# -*- coding: utf-8 -*-
"""
Created on Thu Jan  6 09:36:16 2022

@author: OMEN
"""

import numpy as np
import matplotlib.pyplot as plt
fx= lambda x:x**3+4*x**2-10
a=1
b=2
tolerancia= 0.0001
n=1
#proceso
tramo=abs(b-a)
while not(tramo<=tolerancia):
    fa=fx(a)
    fb=fx(b)
    c=b-fb*(a-b)/(fa-fb)
    fc=fx(c)
    
    cambio=np.sign(fa)*np.sign(fc)
    print('{0:2d} {1:18.8f} {2:12.10f}'.format(n,c,tramo))
    n=n+1
    if cambio>0:
        tramo=abs(c-a)
        a=c
    else:
        tramo= abs(b-c)
        b=c
raiz = c

x=np.linspace(1,2)
ox=0*x
plt.figure()
plt.plot(x,fx(x))
plt.plot(x,ox,'k--')
