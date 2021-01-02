# Dificultades encontradas

### Uso del i18n
Al crear la aplicación multilenguaje, me vi con la dificultad de que cuando el usuario accede a través de un controlador a una sección de la aplicación, debía comprobar el lenguaje seleccionado por el usuario y aplicarlo en el controlador, lo que era muy tedioso y repetir mucho código.

La solución adoptada fue crear un controlador que heredara de ``yii/base/controller`` donde aplico la funcionalidad de aplicar el idioma seleccionado, heredando de dicho controladior, los demás controladores de la aplicación.

# Elementos de innovación
- Uso de la Internacionalización (`yii\i18n`) en la plantilla básica
- Uso de pago por PayPal
- Uso de Amazon Web Services S3 para alojamiento de imágenes