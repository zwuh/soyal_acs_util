<?php
  require_once('database.php');
  include('header.php');

  function show_more_card_link($base = 0)
  {
    echo '<a href="viewcard.php?base='.max(0,$base-30).'">[PREV]</a>';
    echo '<a href="viewcard.php?base='.max(0,$base+30).'">[NEXT]</a>';
    echo "<br />\n";
  }
  echo '<form method="get" action="viewcard.php">Base:<input type="text" name="base" size="5" /><input type="submit" /></form>'."\n";
  echo '<form method="get" action="viewcard.php">Address:<input type="text" name="address" size="5" /><input type="submit" /></form>'."\n";
  echo '<form method="get" action="viewcard.php">Number:<input type="text" name="number" size="5" /><input type="submit" /></form>'."\n";
  $base = 0;
  if (isset($_GET['base']))
  {
    $base = max(intval($_GET['base']), 0);
  }
  if (isset($_POST['base']))
  {
    $base = max(intval($_POST['base']), 0);
  }

  $where = 1;
  if (isset($_GET['address']))
  {
    $target = intval($_GET['address']);
    $where = 'address='.$target;
  }
  if (isset($_GET['number']))
  {
    $target = intval($_GET['number']);
    $where = 'number='.$target;
  }
  $sql = 'select `address`,`site`,`number`,`group`,`user`,`name` from card '.
         'left join unit on unit=id where '.$where.' order by address asc '.
	 'limit '.$base.',30';
  $res = $dblink->query($sql);
  show_more_card_link($base);
  echo '<table border="1"><tr><th>Address</th><th>Card #</th><th>Group</th><th>Unit</th><th>User</th><th>Operation</th></tr>'."\n";
  while ($item = $res->fetch_assoc())
  {
    echo '<tr><td>'.$item['address'].'</td><td>'.
      $item['site'].':'.$item['number'].'</td><td>'.
      $item['group'].'</td><td>'.$item['name'].'</td><td>'.
      $item['user'].'</td><td>'.
      '<a href="editcard.php?address='.$item['address'].'">EDIT</a> '.
      '<a href="viewfloor.php?address='.$item['address'].'">FLOOR</a> '.
      '<a href="viewgroup.php?group='.$item['group'].'">GROUP</a></td>'.
      '</tr>'."\n";
  }
  echo '</table>'."\n";
  show_more_card_link($base);
?>
