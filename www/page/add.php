<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Добавление песни</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <h2>Добавление новой песни</h2>
      <div class="result"></div>
      <form class="form-horizontal">
        <div class="form-group">
          <label class="control-label col-xs-3" for="name">Имя:</label>
          <div class="col-xs-9">
            <input type="text" class="form-control" id="name" name="name" placeholder="Введите имя песни">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-3" for="author">Автор:</label>
          <div class="col-xs-9">
            <input type="text" class="form-control" id="author" name="author" placeholder="Введите автора песни">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-3" for="genre">Жанр:</label>
          <div class="col-xs-9">
            <input type="text" class="form-control" id="genre" name="genre" placeholder="Введите жанр песни">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-xs-3" for="year">Год:</label>
          <div class="col-xs-9">
            <input type="text" class="form-control" id="year" name="year" placeholder="Введите год песни">
          </div>
        </div>
         <div class="form-group">
          <label class="control-label col-xs-3" for="album">Альбом:</label>
          <div class="col-xs-9">
            <input type="text" class="form-control" id="album" name="album" placeholder="Введите альбом песни">
          </div>
        </div>
          <div class="form-group">
          <label class="control-label col-xs-3" for="lang">Язык:</label>
          <div class="col-xs-9">
            <input type="text" class="form-control" id="lang" name="lang" placeholder="Введите язык песни">
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-offset-3 col-xs-9">
            <input type="button" class="btn btn-primary" value="Добавить" onclick="add_songs();">
            <input type="reset" class="btn btn-default" value="Очистить форму">
            <input type="button" class="btn btn-success" value="Назад" onclick="javascript:document.location.href='http://myzon.sl/page/main.php'">
          </div>
        </div>
      </form>
      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!--<script src="js/bootstrap.min.js"></script>-->
  </body>
</html>