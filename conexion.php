<?php
function conectarse($mibase)
{
  if(!($link=mysql_connect("localhost","root","web")))
    {
      echo "Error en la conxi&oacute;n";
      exit;
      }
  if(!mysql_select_db($mibase,$link))
    {
      echo "Error al seleccionar la base de datos";
      exit;
      }
    return $link;
    }
   ?>