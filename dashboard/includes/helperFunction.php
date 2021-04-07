<?php
function url($url){
   
   return "http://".$_SERVER['HTTP_HOST']."/portfolio/dashboard/".$url;

  }

function cleanInputs($input){
  $input = htmlentities(htmlspecialchars(trim($input)));
  return $input;
}
?>