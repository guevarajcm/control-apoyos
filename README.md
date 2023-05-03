# Instrucciones para configurar el proyecto

1. Descarga **XAMPP** y activa *Apache* y *MySQL*.
2. Dirígete a la carpeta `htdocs` de tu XAMPP (por defecto suele ser `C:\xampp\htdocs`).
3. Clona el repositorio.
Si estás usando Linux, copia, pega y dale enter al siguiente código en tu consola:
```console
git clone https://github.com/guevarajcm/control-apoyos
```
Si usas Windows, puedes buscar otra forma de clonar el repositorio, por ejemplo, descargando y usando [Git Bash](https://git-scm.com/download/win)
4. Después dirígete al panel de *PhpMyAdmin*. Esto lo puedes hacer clicando en el botón *"Admin"* de la ventana de XAMPP, o si tienes todo por defecto, entrando a http://localhost/phpmyadmin/ desde tu navegador.
5. Una vez en *PhpMyAdmin*, da clic en *"Importar"* en la parte superior de la pantalla.
6. Da clic en examinar, busca y selecciona el archivo `ayuntnog.sql`, ubicado en el directorio `database/` de este repositorio.
7. Da clic en el botón continuar, que se encuentra abajo a la derecha de la pantalla.
8. La tabla de `apoyos` viene truncada; y puedes hacer lo mismo con la de `users` para agregar tus propios usuarios y sus credenciales.
9. Prueba la página web. Si tienes todo por defecto, debería ser http://localhost/control-apoyos. En su defecto, cambia la IP a la que resuelve XAMPP o el nombre del directorio donde lo guardaste.
