<?php
require_once('database.php');

define ('NL', "\r\n");

if (!isset($_GET) || !isset($_GET['action']))
{
  die ('Usage: GET[action] = {floor,group,user}');
}

switch ($_GET['action'])
{
  case 'floor':
    dump_floor($dblink);
    break;
  case 'group':
    dump_group($dblink);
    break;
  case 'user':
    dump_user($dblink);
    break;
  default:
    die ('Usage: GET[action] = {floor,group,user}');
    break;
}

function http_header($name = '')
{
  header('Content-Type: text/plain');
}

function dump_floor($dblink)
{
  http_header('FloorAccess.txt');
  $n_floor = 64;
  $n_cards = 4999;
  echo "Num :";
  for ($i = 1;$i <= 64;$i++)
  {
    echo $i % 10;
    if ($i % 4 == 0 && $i < $n_floor) echo ' ';
  }
  echo NL;
  $res = $dblink->query('select max(address) as mc from card');
  $row = $res->fetch_assoc();
  $max_address = $row['mc'];
  for ($addr = 1;$addr <= $n_cards;$addr ++)
  {
    printf('%04d:', $addr);
    $row = null;
    if ($addr <= $max_address)
    {
      $res = $dblink->query('select floor from floor_access where address='.
                      $addr.' order by floor asc');
      $row = $res->fetch_assoc();
    }
    for ($i = 1;$i <= $n_floor;$i ++)
    {
      if ($row && $row['floor'] == $i)
      {
        echo 'Y';
	$row = $res->fetch_assoc();
      }
      else
      {
        echo '.';
      }
      if ($i % 4 == 0 && $i < $n_floor) echo ' ';
    }
    echo NL;
  }

}

function dump_group($dblink)
{
  http_header('DoorGroup.txt');
  $res = $dblink->query('select max(`group`) as mg from card');
  $row = $res->fetch_assoc();
  $max_group = $row['mg'];
  $n_group = 255;
  $n_door = 255;
  for ($i = 1;$i <= $n_group;$i ++)
  {
    printf('DoorGroup:%03d - Link:000  Level:000'.NL, $i);
    if ($i > $max_group ||
        (($res = $dblink->query('select door from door_group where id='.$i.' order by door asc')) && $res->num_rows == 0))
    {
      continue;
    }
    $row = $res->fetch_assoc();
    for ($d = 0;$d <= $n_door;$d ++)
    {
      if ($d % 10 == 0)
      {
	if ($d > 0) echo NL;
        printf('%03d:', $d);
      }
      if ($row && $row['door'] == $d)
      { echo 'Y'; $row = $res->fetch_assoc(); }
      else
      { echo '.'; }
      echo ' ';
    }
    echo NL;
  }
}

function print_a_card($addr,$site,$number,$name,$group)
{
  $fmt = '%1$05d ;%2$05d:%3$05d;%4$-30s;0119  ;                ;%5$03d   ;00    ;            ;                ;00    ;20000101  ;20990101N ;                    ;                    ;                                        ;                    '.NL;
  printf($fmt, $addr, $site, $number, $name, $group);
}

function dump_user($dblink)
{
  http_header('UserCard.txt');

  $res = $dblink->query('select max(address) as ma from card');
  $row = $res->fetch_assoc();
  $max_address = $row['ma'];
  $n_cards = 5000;

  echo 'Addres;Card #     ;Name                          ;PIN   ;Dep.(1)         ;Group ;Zone  ;UserID      ;Car #           ;Level ;Begin     ;Expiry    ;Alias               ;VISA_ID             ;Address                                 ;TEL#1               '.NL;

  for ($i = 1;$i <= $n_cards;$i ++)
  {
    if ($i > $max_address ||
      (($res = $dblink->query('select `site`,`number`,`group`,`user` from card where address='.$i.' limit 1')) && $res->num_rows == 0))
    {
      print_a_card($i, 0, 0, '', 0);
    }
    else
    {
      $row = $res->fetch_assoc();
      print_a_card($i, $row['site'], $row['number'], $row['user'], $row['group']);
    }
  }
}


?>
