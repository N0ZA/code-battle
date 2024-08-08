<?php
  $host='localhost';
  $dbname='code_battle';
  $dbusername = 'root';
  $dbpassword = '';
  
  $dsn="mysql:host=$host;dbname=$dbname";
  
  try{
      $pdo=new PDO($dsn,$dbusername,$dbpassword);
      $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  
  }catch(PDOException $e){
      die( "CONEECTION FAILED: ".$e->getMessage());
      
  }
/* 
$host='localhost';
$dbname='u355595427_code_battle_db';
$dbusername = 'u355595427_code_battle';
$dbpassword = 'Code-battle321#';

$dsn="mysql:host=$host;dbname=$dbname";

try{
    $pdo=new PDO($dsn,$dbusername,$dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
    die( "CONEECTION FAILED: ".$e->getMessage());
*/
    
