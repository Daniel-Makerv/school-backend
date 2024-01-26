<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## Instalacion del proyecto:

Este proyecto esta desarrollado con laravel, docker y vite.

### Documentacion de la api en postman:

- **[api back school](https://documenter.getpostman.com/view/15139381/2s9Yynm46u)**

# Instalaciòn
    *Clone el repositorio y cree el archivo .env en la raiz del proyecto con los datos compartidos por el admin del repo*

  ## Instalacion de las librerias de docker y laravel:
# Ejecute el siguiente comando:
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
# Ejecute el siguiente comando:
    ./vendor/bin/sail up
# Ejecute el siguiente comando para instalar las librerias de npm:
    npm i 
# Ejecute el siguiente comando para compilar vite:
    npm run dev
  
