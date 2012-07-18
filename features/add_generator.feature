# language: es
# features/add_generator.feature
Característica: añadir_generator
  Para añadir un nuevo generator
  Como un usuario anónimo
  Necesito ser capaz de añadir un nuevo linea a la tabla expecificada

Escenario: Añadir nuevo generator a la base de datos
  Dada la siguiente lista de generator
      | url               | created             | ip        |
      | http://behat.com  | 2012-07-17 20:31:15 | 127.0.0.1 |
      | http://behat1.com | 2012-07-17 20:31:16 | 127.0.0.1 |
      | http://behat2.com | 2012-07-17 20:31:17 | 127.0.0.1 |
      | http://behat3.com | 2012-07-17 20:31:18 | 127.0.0.1 |
  Entonces los guarda en la base de datos
   