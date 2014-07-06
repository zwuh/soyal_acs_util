<?php
  require_once('database.php');
  include('header.php');

  $group = 1;
  if (isset($_GET['group']))
  {
    $group = intval($_GET['group']);
  }
  if (isset($_GET['door']))
  {
    $door = intval($_GET['door']);
  }
  echo '<form method="get" action="viewgroup.php">Group:<input type="text" size="5" name="group" /><input type="submit" /></form>'."<br />\n";
  echo '<form method="get" action="viewgroup.php">Door:<input type="text" size="5" name="door" /><input type="submit" /></form>'."<br />\n";
  echo '<a href="viewgroup.php?group='.max(0,$group-1).'">[PREV]</a>';
  echo '<a href="viewgroup.php?group='.max(0,$group+1).'">[NEXT]</a>';
  echo '<br />'."\n";

  if (isset($door))
  {
    $res = $dblink->query('select name from door where location='.$door);
    $dname = $res->fetch_assoc();
    $sql = 'select id from door_group where door='.$door;
    $res = $dblink->query($sql);
    echo 'Door # '.$door.'('.$dname['name'].') is associated with :<br />'."\n";
    while ($item = $res->fetch_assoc())
    {
      echo 'Group # <a href="viewgroup.php?group='.$item['id'].'">'.$item['id']."</a><br />\n";
    }
  }
  else
  {
    $sql = 'select door,name from door_group join door on door=location where id='.$group;
    $res = $dblink->query($sql);
    echo 'Group # '.$group.' (<a href="editgroup.php?group='.$group.'">EDIT</a>)<br />'."\n";
    if ($group == 0)
    {
      echo 'Group # 0 is the ALL group.';
    }
    while ($item = $res->fetch_assoc())
    {
      echo '<a href="viewgroup.php?door='.$item['door'].'">'.$item['door'].'</a> - '.$item['name']."<br />\n";
    }
  }
?>
