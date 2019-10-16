<?php
session_start();
if($_SESSION['admin'] != 1){
	$html = '<div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <a class="navbar-brand" href="#">Название компании</a>
          </div>
          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
              <li><a onclick="get_list();" style="cursor:pointer">Список песен</a></li>
              <li><a onclick="get_top();" style="cursor:pointer">Топ-песен</a></li>
              <li><a href="add.php" style="cursor:pointer">Добавить песню</a></li>
              <li style="padding-left: 530px;"><a href="http://myzon.sl">Выход</a></li>
            </ul>
          </div>
        </div>
      </div>';
} else {
	$html = '<div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <a class="navbar-brand" href="#">Название компании</a>
          </div>
          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
              <li><a onclick="get_list();" style="cursor:pointer">Список песен</a></li>
              <li><a onclick="get_top();" style="cursor:pointer">Топ-песен</a></li>
              <li><a href="add.php" style="cursor:pointer">Добавить песню</a></li>
              <li><a onclick="set_concert();" style="cursor:pointer">Создать голосование</a></li>
              <li><a onclick="get_statistics();" style="cursor:pointer">Статистика</a></li>
              <li style="padding-left: 250px;"><a href="http://myzon.sl">Выход</a></li>
            </ul>
          </div>
        </div>
      </div>';
}
echo $html;
?>