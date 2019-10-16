var a = '';

function get_list(){
    $.ajax({
	  dataType: 'json',
	  url: '../controller.php?id=list',
	  success: function(jsondata){
	    //$('.results').html(jsondata);
	    console.log(jsondata);
	    var div = '';
	    if(jsondata === ""){
	    	$('.row').html('Нет песен');
	    } else {
	    	div +='<div class="results"></div>'
	    	div += '<table class="table table-hover">'
	    		div += '<thead>'
	    		div += '<tr>'
	    			div += '<td align="center">№</td>'
	    			div += '<td align="center">Имя</td>'
	    			div += '<td align="center">Автор</td>'
	    			div += '<td align="center">Жанр</td>'
	    			div += '<td align="center">Год</td>'
	    			div += '<td align="center">Альбом</td>'
	    			div += '<td align="center">Язык</td>'
	    			div += '<td align="center">Выбор</td>'
	    		div += '</tr>'
	    		div += '</thead>'
	    		div += '<tbody>'
	    		for(var index in jsondata){
	    			for(var key in jsondata[index]){
		    			if(key == 'id'){
		    				var id = jsondata[index][key];
		    				div += '<tr>'
		    			}
			    		div += '<td align="center">'+jsondata[index][key]+'</td>'
			    		if(key == 'lang'){
			    			div += '<td align="center"><span class="glyphicon glyphicon-heart" onclick="like_song('+id+');"></span></td>'
		    				div += '</tr>'
			    		}
		    		}
	    		}
	    		div += '</tbody>'
	    	div += '</table>'
    	$('.row').html(div);
	    }
	  },
	  error: function(jqxhr, status, errorMsg) {
	  		console.log(errorMsg);
			}
	});
	$.ajax({
	  dataType: 'json',
	  url: '../controller.php?id=get_time',
	  success: function(jsondata){
	    //$('.results').html(jsondata);
	    console.log(jsondata);
	    if(jsondata['error'] == 'vote is complite'){
			$('.results').html('<span style="color: red;">Голосование окончилось</span>');
	    } else if(jsondata['error'] == 'not found concert'){
			$('.results').html('<span style="color: red;">Голосование ни разу не проводилось</span>');
	    } else {
	    	$('.results').html('<span style="color: red;">Голосование окончится:'+jsondata['ok']+'</span>');
	    }
	    //$('.row').html(div);
	  },
	  error: function(jqxhr, status, errorMsg) {
	  		console.log(errorMsg);
			}
	});
}

function get_top(){
	$.ajax({
	  dataType: 'json',
	  url: '../controller.php?id=top',
	  success: function(jsondata){
	    //$('.results').html(jsondata);
	    //console.log(jsondata);
	    var div = '';
	    if(jsondata === ""){
	    	$('.row').html('Нет песен');
	    } else if(jsondata['error'] == 'not found cid'){
	    	alert('Голосование не началось');
	    } 
	    else {
	    	div += '<table class="table table-hover">'
	    		div += '<thead>'
	    		div += '<tr>'
	    			div += '<td align="center">№</td>'
	    			div += '<td align="center">Имя</td>'
	    			div += '<td align="center">Автор</td>'
	    			div += '<td align="center">Жанр</td>'
	    			div += '<td align="center">Год</td>'
	    			div += '<td align="center">Альбом</td>'
	    			div += '<td align="center">Язык</td>'
	    			div += '<td align="center">Количество голосов</td>'
	    		div += '</tr>'
	    		div += '</thead>'
	    		div += '<tbody>'
	    		for(var index in jsondata){
	    			for(var key in jsondata[index]){
		    			if(key == 'id'){
		    				div += '<tr>'
		    			}
			    		div += '<td align="center">'+jsondata[index][key]+'</td>'
			    		if(key == 'count'){
		    				div += '</tr>'
			    		}
		    		}
	    		}
	    		div += '</tbody>'
	    	div += '</table>'
    	$('.row').html(div);
	    }
	  },
	  error: function(jqxhr, status, errorMsg) {
	  		console.log(errorMsg);
			}
	});
}

function add_songs(){
	$('.result').html('');
	var name = $('input[name="name"]').val();
	var author = $('input[name="author"]').val();
	var genre = $('input[name="genre"]').val();
	var year = $('input[name="year"]').val();
	var album = $('input[name="album"]').val();
	var lang = $('input[name="lang"]').val();
	var dataPost = {name: name, author: author, genre: genre, year: year, album: album, lang: lang};
	console.log(dataPost);
	$.ajax({
	  type: "POST",
	  url: "../controller.php?id=add_song",
	  dataType: "json",
	  data: dataPost,
	  success: function(data){
	    console.log(data['error']);
	    if(data['error'] == 'this user register'){
	    	$('.result').html('<span style="color: red;">Такой пользователь уже существует</span>');
	    } else if(data['error'] == 'passwords do not match'){
	    	$('.result').html('<span style="color: red;">Пароли не совпадают</span>');
	    } else if(data['error'] == 'insert error'){
	    	$('.result').html('<span style="color: green;">Пожалуйста, обновите страницу</span>');
	    } else {
	    	document.location.href='http://myzon.sl/page/main.php';
	    }
	  }
	});
}

function registration(){
	$('.result').html('');
	var login = $('input[name="Login"]').val();
	var email = $('input[name="inputEmail"]').val();
	var password = $('input[name="inputPassword"]').val();
	var confirm = $('input[name="confirmPassword"]').val();
	var dataPost = {Login: login, inputEmail: email, inputPassword: password, confirmPassword: confirm};
	console.log(dataPost);
	$.ajax({
	  type: "POST",
	  url: "../controller.php?id=reg",
	  dataType: "json",
	  data: dataPost,
	  success: function(data){
	    console.log(data['error']);
	    if(data['error'] == 'this user register'){
	    	$('.result').html('<span style="color: red;">Такой пользователь уже существует</span>');
	    } else if(data['error'] == 'passwords do not match'){
	    	$('.result').html('<span style="color: red;">Пароли не совпадают</span>');
	    } else if(data['error'] == 'insert error'){
	    	$('.result').html('<span style="color: green;">Пожалуйста, обновите страницу</span>');
	    } else {
	    	document.location.href='http://myzon.sl';
	    }
	  }
	});
}

function login_form(){
	$('.result').html('');
	var login = $('input[name="login"]').val();
	var password = $('input[name="pass"]').val();
	var dataPost = {login: login, pass: password};
	console.log(dataPost);
	$.ajax({
	  type: "POST",
	  url: "../controller.php?id=login",
	  dataType: "json",
	  data: dataPost,
	  success: function(data){
	    if(data['error'] == 'not found user'){
	    	$('.result').html('<span style="color: red; padding-left: 270px;">Не верно введен логин или пароль. Повторите попытку</span>');
	    } else {
	    	document.location.href='http://myzon.sl/page/main.php';
	    }
	  }
	});
}

function reg_concert(){
	var d = $('input[name=calendar]').val();
	var dataPost = {date: d};
	console.log(dataPost);
	$.ajax({
	  type: "POST",
	  url: "../controller.php?id=reg_consert",
	  dataType: "json",
	  data: dataPost,
	  success: function(data){
	    if(data['error'] == 'can\'t inseret'){
	    	alert('Что то пошло не так, попробуйте еще раз');
	    } else {
	    	alert('Голосование законцится: '+d);
	    }
	  }
	});
}

function get_statistics(){
	$('.row').html('');
	$.ajax({
	  dataType: 'json',
	  url: '../controller.php?id=statistics',
	  success: function(jsondata){
	    //$('.results').html(jsondata);
	    console.log(jsondata);
	    var div = '';
	    if(jsondata === ""){
	    	$('.row').html('<span style="color: red;">Нет песен</span>');
	    } else if(jsondata['error'] == 'not found cid') {
	    	$('.row').html('<span style="color: red;">Голосование еще не назначено</span>');
	    } else {
	    	div += '<table class="table table-hover">'
	    		div += '<thead>'
	    		div += '<tr>'
	    			div += '<td align="center">id</td>'
	    			div += '<td align="center">Логин</td>'
	    			div += '<td align="center">Email</td>'
	    			div += '<td align="center">Голосов</td>'
	    			div += '<td align="center">№</td>'
	    			div += '<td align="center">Имя</td>'
	    			div += '<td align="center">Автор</td>'
	    			div += '<td align="center">Жанр</td>'
	    			div += '<td align="center">Год</td>'
	    			div += '<td align="center">Альбом</td>'
	    			div += '<td align="center">Язык</td>'
	    		div += '</tr>'
	    		div += '</thead>'
	    		div += '<tbody>'
	    		for(var index in jsondata){
	    			//console.log(jsondata[index]['user']);
	    			div += '<tr>'
	    			for(var key in jsondata[index]['user']){
			    		div += '<td align="center">'+jsondata[index]['user'][key]+'</td>'
		    		}
		    		for(var k in jsondata[index]['song']){
		    			div += '<td align="center">'+jsondata[index]['song'][k]+'</td>'
		    		}
		    		div += '</tr>'
	    		}
	    		div += '</tbody>'
	    	div += '</table>'
    	$('.row').html(div);
	    }
	  },
	  error: function(jqxhr, status, errorMsg) {
	  		console.log(errorMsg);
			}
	});
}

function like_song(id){
	var dataPost = {sid: id};
	$.ajax({
	  type: "POST",
	  url: "../controller.php?id=like",
	  dataType: "json",
	  data: dataPost,
	  success: function(data){
	    if(data['error'] == 'not found uid'){
	    	alert('Пожалуйста перезайдите, и повторите попытку');
	    } else if(data['error'] == 'not found cid') {
	    	alert('Вы не можете добавить песню, время голосования не назначено');
	    } else if(data['warning'] == 'you is vote'){
	    	alert('Вы уже добавили эту песню');
	    } else if(data['error'] == 'can\'t vote'){
	    	alert('Обновите страницу и повторите попытку');
	    } else {
	    	alert('Ваш голос засчитан');
	    }
	  }
	});
}

function set_concert(){
	var div = '<div class="form-group">'
			div += '<div class="input-group date" id="datetimepicker2">'
				div += '<input type="text" class="form-control" name="calendar"/>'
				div += '<span class="input-group-addon">'
					div += '<span class="glyphicon glyphicon-calendar" onclick="set_date();"></span>'
				div += '</span>'
			div += '</div>'
			div += '<button type="button" class="btn btn-default" onclick="reg_concert();">Начать голосование</button>'
		div += '</div>'

	$('.row').html(div);
}


function set_date(){
  $(function () {
    //Установим для виджета русскую локаль с помощью параметра language и значения ru
    $('#datetimepicker2').datetimepicker(
      {language: 'ru'}
    );
  });
}

