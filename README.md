# Instrucciones para configurar el proyecto

1. Descarga **XAMPP** y activa *Apache* y *MySQL*.
2. Dirígete a la carpeta `htdocs` de tu XAMPP (por defecto suele ser `C:\xampp\htdocs`).
3. Da clic derecho en una parte vacía de la carpeta y selecciona *"Abrir en Terminal"*.
4. Copia, pega y dale enter al siguiente código:
```console
git clone https://github.com/guevarajcm/control-apoyos
```
5. Después dirígete al panel de *PhpMyAdmin*. Esto lo puedes hacer clicando en el botón *"Admin"* de la ventana de XAMPP, o si tienes todo por defecto, entrando a http://localhost/phpmyadmin/ desde tu navegador.
6. Una vez en *PhpMyAdmin*, da clic en *"Importar"* en la parte superior de la pantalla.
7. Da clic en examinar, busca y selecciona el archivo `ayuntnog.sql`.
8. Da clic en el botón continuar, que se encuentra abajo a la derecha de la pantalla.
9. De ser necesario, limpia los registros existentes.
10. Prueba la página web. Si tienes todo por defecto, debería ser http://localhost/control-apoyos. En su defecto, cambia la IP a la que resuelve XAMPP o el nombre del directorio donde lo guardaste.
