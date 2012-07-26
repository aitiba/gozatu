<!DOCTYPE HTML>
  <html lang='en-US'>
  <head>
     <meta charset='UTF-8'>
            <title></title>
             <script src='http://code.jquery.com/jquery-latest.js'></script>
             <script src='../../../../web/js/jquery.tablesorter.js'></script>
              <script>
                $(document).ready(function() { 
                    $('.tablesorter').tablesorter({sortList:[[1,1],[2,1],[3,1],[4,1]]});
          
                });
                
              </script>

              <link rel='stylesheet' href='../../../../web/css/tables.css' type='text/css' media='print, projection, screen' />

        </head>
        <body> <p>
          <a href='..\add'>Nuevo links</a>
        </p> 
        <table cellspacing='1' class='tablesorter' border='0'>
          <thead>
            <tr> <th class='header headerSortUp'>Id</th>
 <th class='header headerSortUp'>Url</th>
 <th class='header headerSortUp'>Created</th>
 <th class='header headerSortUp'>Ip</th>
<td colspan='2'></td>
                    </tr>
      </thead>
      <tbody>
                  <?php foreach ($data as $d) { ?>
                    <tr><td><?php echo $d['id'] ?></td>
<td><?php echo $d['url'] ?></td>
<td><?php echo $d['created'] ?></td>
<td><?php echo $d['ip'] ?></td>
<td><a href='edit\<?php echo $d['id'] ?>'>Editar</a></td>
                <td><a href='delete\<?php echo $d['id'] ?>'>Borrar</a></td>
                </tr>
                <?php } ?>
                </tbody>
              </table>
               <p>
                    <?php for ($i=0; $i < $paginator['paginator']; $i++) { ?>
         
                                <a href='<?php echo ($i + 1) * $cuantos?>' style='float:left'><?php echo $i ?></a>
                    <?php } ?>
          
                  </p>