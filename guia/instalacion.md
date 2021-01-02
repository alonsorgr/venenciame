# Instrucciones de instalación y despliegue

## En local

#### Requisitos:
- PHP 7.4
- PostgreSQL
- Composer
- Cuenta de Amazon S3
- Correo electrónico
- Cuenta de PayPal y Sandbox PayPal

#### Instalación:
1. Ir al repositorio en GitHub de la [Aplicación](https://github.com/alonsorgr/venenciame) y clonar el repositorio en el disco de la máquina.
    - ``git clone https://github.com/alonsorgr/venenciame.git``
2. Movernos hasta el directorio donde se clonó el repositorio y ejecutar el comando:
    - ``composer install``
3. Creamos las variables de entorno en un fichero llamado .env en la raíz del proyecto. Las variables son:
    - ``SMTP_PASS`` contraseña de aplicación para gestión de correo electrónico
    - ``S3_KEY`` clave de Amazon Web Services S3
    - ``S3_SECRET`` clave secreta de Amazon Web Services S3
    - ``PAYPAL_ID`` identificador de cuenta de PayPal
    - ``PAYPAL_SECRET`` clave secreta de la cuenta de PayPal
4. Creación de base de datos y volcado de datos
    - ``./db/create.sh``
    - ``./db/load.sh``
5. Abrimos la shell del sistema Ubuntu y ejecutamos el comando:
    - ``make serve``
6. Para acceder a la aplicación, escribir en la barra de direcciones la siguiente url:
    - ``http://localhost:8080/``
## En la nube

#### Requisitos:
- Heroku CLI

#### Despliegue:
1. Realizar una clonación o fork del repositorio de la [Aplicación](https://github.com/alonsorgr/venenciame).
2. Nos dirigimos al sitio web de Heroku y creamos una nueva app y vinculamos nuestro repositorio con la nueva app.
3. En la configuración de la app en Heroku, añadimos el add-on de Postgres.
4. Configuramos las variables del entorno en la configuración de la app en Heroku:
    - ``DATABASE_URL`` url de la base de datos
    - ``YII_ENV`` con el valor ``PROD``
    - ``SMTP_PASS`` contraseña de aplicación para gestión de correo electrónico
    - ``S3_KEY`` clave de Amazon Web Services S3
    - ``S3_SECRET`` clave secreta de Amazon Web Services S3
    - ``PAYPAL_ID`` identificador de cuenta de PayPal
    - ``PAYPAL_SECRET`` clave secreta de la cuenta de PayPal
5. A través de una terminal de nuestra máquina, nos conectamos al servidor mediante Heroku CLI y volcamos la base de datos:
    - ``heroku login``
    - ``heroku pg:psql < db/venenciame.sql``
    - ``heroku pg:psql < db/data.sql``
6. Acceder a la aplicación a través de la url que nos proporciona Heroku de nuestra app
