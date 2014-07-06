<?php
  require_once('database.php');
  include('header.php');

  $group = 0; $commit = false;
  if (isset($_GET['group']))
  {
    $group = intval($_GET['group']);
  }
  if (isset($_POST['group']))
  {
    $group = intval($_POST['group']);
    $commit = true;
  }
  if ($group <= 0)
  { die ('No group'); }

  if ($commit == false)
  {
    $res = $dblink->query('select max(location) as md from door');
    $row = $res->fetch_assoc();
    $max_door = $row['md'];
    $res = $dblink->query('select door from door_group where id='.$group.' order by door asc');
    $row = $res->fetch_assoc();
    echo '<form name="group_edit" method="post" action="editgroup.php">'."\n";
    echo '<input type="hidden" name="group" value='.$group.'" />'."\n";
    for ($i = 1;$i <= $max_door;$i ++)
    {
      echo '<input type="checkbox" name="door['.$i.']"';
      if ($row && $row['door'] == $i)
      { echo 'checked'; }
      echo ' /><br />'."\n";
    }
    echo '<input type="reset" /><input type="submit" />'."\n";
    echo "</form>\n";
  }
  else
  {
  }
?>
