  <html>
        <head>
            <title></title>
        </head>
        <body><table>
                  <tr>
                    <td><a href='../  add'>Nuevo links</a></td>
                  </tr>
                  <tr><td>Id</td><td>Url</td><td>Created</td><td>Ip</td><td>&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                  <?php foreach ($data as $d) { ?>
                    <tr><td><?php echo $d['id'] ?></td><td><?php echo $d['url'] ?></td><td><?php echo $d['created'] ?></td><td><?php echo $d['ip'] ?></td><td><a href='..\edit\<?php echo $d['id'] ?>'>Editar</a></td>
                <td><a href='..\delete\<?php echo $d['id'] ?>'>Borrar</a></td>
                </tr>
                <?php } ?>
                <tr>
                  <td>
                  <?php for ($i=0; $i < $paginator['paginator']; $i++) { ?>
       
                              <a href='<?php echo $i + 1 * $cuantos?>' style='float:left'><?php echo $i ?></a>
                  <?php } ?>
                </td>
                </tr>
              </table>