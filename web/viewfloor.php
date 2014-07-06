<?php
  require_once('database.php');
  include('header.php');

  $address = 1;
  if (isset($_GET['address']))
  {
    $address = intval($_GET['address']);
  }
  if (isset($_GET['floor']))
  {
    $floor = intval($_GET['floor']);
  }
  echo '<form method="get" action="viewfloor.php">Card address:<input type="text" size="5" name="address" /><input type="submit" /></form>'."<br />\n";
  echo '<a href="viewfloor.php?address='.max(0,$address-1).'">[PREV]</a>';
  echo '<a href="viewfloor.php?address='.max(0,$address+1).'">[NEXT]</a>';
  echo '<form method="get" action="viewfloor.php">Floor:<input type="text" size="5" name="floor" /><input type="submit" /></form>'."<br />\n";
  echo '<br />'."\n";

  if (isset($floor))
  {
    echo '<a href="viewfloor.php?floor='.max(0,$floor-1).'">[PREV]</a>';
    echo '<a href="viewfloor.php?floor='.max(0,$floor+1).'">[NEXT]</a>';
    echo '<br />'."\n";
    $res = $dblink->query('select name from floor where id='.$floor);
    $dname = $res->fetch_assoc();
    $sql = 'select address from floor_access where floor='.$floor;
    $res = $dblink->query($sql);
    echo 'Floor # '.$floor.'('.$dname['name'].') is accessible by :<br />'."\n";
    while ($item = $res->fetch_assoc())
    {
      echo 'Card address # <a href="viewcard.php?address='.$item['address'].'">'.$item['address'].'</a><br />'."\n";
    }
  }
  else
  {
    $sql = 'select floor,name from floor_access join floor on floor=id where address='.$address;
    $res = $dblink->query($sql);
    echo 'Card address # '.$address."<br />\n";
    while ($item = $res->fetch_assoc())
    {
      echo '<a href="viewfloor.php?floor='.$item['floor'].'">'.$item['floor'].'</a> - '.$item['name']."<br />\n";
    }
  }
?>
