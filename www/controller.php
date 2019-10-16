<?php
header('Content-Type: text/html; charset=utf-8');
require_once($_SERVER['DOCUMENT_ROOT'].'/include/confing.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/include/class.sql.php');
session_start();
$sql = new db_sql();
switch ($_GET['id']) {
	case 'reg':
		if(isset($_POST)){
			$result = registration($_POST);
			if(isset($result['ok'])){
				$_SESSION['uid'] = intval($result['ok']);
			}
		} else {
			$result = array('error'=>'not found POST');
		}
		//$result = $_POST;
		break;
	case 'list':
		$result = list_songs();
		break;
	case 'top':
		if(isset($_SESSION['cid'])){
			$result = get_top(array('cid'=>$_SESSION['cid']));
		} else {
			$result = array('error'=>'not found cid');
		}
		break;
	case 'add_song':
		if(isset($_POST)){
			$result = add_song($_POST);
		} else {
			$result = array('error'=>'not found POST');
		}
		if($_SESSION['admin'] == 0){
			$ptm = user_like_song(array('sid'=>$result['ok'],'cid'=>$_SESSION['cid'],'uid'=>$_SESSION['uid']));
			$tmp = update_vote_user(array('uid'=>$_SESSION['uid']));
		}
		break;
	case 'login':
		if(isset($_POST)){
			$result = login($_POST);
			$_SESSION['admin'] = $result['priv'];
		} else {
			$result = array('error'=>'not found POST');
		}
		break;
	case 'reg_consert':
		if(isset($_POST)){
			$result = reg_concert($_POST);
			if(isset($result['ok'])){
				$_SESSION['cid'] = intval($result['ok']);
			}
		} else {
			$result = array('error'=>'not found POST');
		}
		break;
	case 'like':
		if(isset($_SESSION['cid'])){
			if(isset($_SESSION['uid'])){
				if(isset($_POST)){
					$result = user_like_song(array('cid'=>$_SESSION['cid'],'sid'=>$_POST['sid'],'uid'=>$_SESSION['uid']));
					$ptm = update_vote_user(array('uid'=>$_SESSION['uid']));
				} else {
					$result = array('error'=>'not found POST');
				}
			} else {
				$result = array('error'=>'not found uid');
			}
		} else {
			$result = array('error'=>'not found cid');
		}
		break;
	case 'statistics':
		if(isset($_SESSION['cid'])){
			$result = get_statistics($_SESSION['cid']);
		} else {
			$result = array('error'=>'not found cid');
		}
	//$result = get_statistics(1);
		break;
	case 'get_time':
		$result = get_time_concert();
		break;
	default:
		$result = array('error'=>'Не верный запрос');
		break;
}

function add_song($data){
	global $sql;
	$ans = array();
	if($sql->db_sql_insert('songs(name,author,genre,year,album,lang)','\''.$sql->escape_string($data['name']).'\',\''.$sql->escape_string($data['author']).'\',\''.$sql->escape_string($data['genre']).'\',\''.$sql->escape_string($data['year']).'\',\''.$sql->escape_string($data['album']).'\',\''.$sql->escape_string($data['lang']).'\'')){
		$ans = array('ok'=>$sql->last_insert());
	} else {
		$ans = array('error'=>'can\'t added song');
	}
	return $ans;
}

function list_songs(){
	global $sql;
	$ans = array();
	$step = '';
	if(isset($data['step'])){
		$step = 'LIMIT '.intval($data['step']*10).',10';
	}
	$sql->db_sql_select('id,name,author,genre,year,album,lang','songs');
	if($sql->d_select_count > 0){
		while($row = mysql_fetch_array($sql->d_select,MYSQL_ASSOC)){
			$ans[] = array('id'=>intval($row['id']),
						'name'=>$row['name'],
						'author'=>$row['author'],
						'genre'=>$row['genre'],
						'year'=>$row['year'],
						'album'=>$row['album'],
						'lang'=>$row['lang']);
		}
	}
	return $ans;
}

function user_like_song($data){
	global $sql;
	$ans = array();
	$sid = 0;
	$cid = 0;
	$uid = 0;
	if(isset($data['sid'])){
		$sid = intval($data['id']);
	}
	if(isset($data['cid'])){
		$cid = intval($data['cid']);
	}
	if(isset($data['uid'])){
		$uid = intval($uid);
	}
	if(check_vote(array('cid'=>$cid,'sid'=>$sid,'uid'=>$uid))){
		$ans = array('warning'=>'you is vote');
	} else {
		if($sql->db_sql_insert('vote(cid,sid,uid)',$cid.','.$sid.','.$uid)){
			$ans = array('ok'=>'vote ok');
		} else {
			$ans = array('error'=>'can\'t vote');
		}
	}
	return $ans;
}

function check_vote($data){
	global $sql;
	$ans = false;
	$cid = 0;
	$sid = 0;
	$uid = 0;
	if(isset($data['cid'])){
		$cid = intval($data['cid']);
	}
	if(isset($data['sid'])){
		$sid = intval($data['sid']);
	}
	if(isset($data['uid'])){
		$uid = intval($data['uid']);
	}
	$sql->db_sql_select('id','vote','WHERE cid='.$cid.' && sid='.$sid.' && uid='.$uid);
	if($sql->d_select_count > 0){
		$ans = true;
	}
	return $ans;
}

function update_vote_user($data){
	global $sql;
	$ans = array();
	$uid = 0;
	$vote = 0;
	if(isset($data['uid'])){
		$uid = intval($uid);
	}
	$sql->db_sql_select('vote','users','WHERE id='.$uid);
	if($sql->d_select_count > 0){
		$row = mysql_fetch_array($sql->d_select,MYSQL_ASSOC);
		$vote = intval($vote);
		$vote++;
	}
	if($vote != 0){
		if($sql->db_sql_update('users','vote='.$vote,'WHERE id='.$uid)){
			$ans = array('ok'=>'update vote users');
		} else {
			$ans = array('error'=>'error update');
		}
	} else {
		$ans = array('error'=>'not found users');
	}
	return $ans;
}

function login($data){
	global $sql;
	$ans = array();
	$sql->db_sql_select('id,priv,vote','users','WHERE login=\''.$sql->escape_string($data['login']).'\' && password=\''.$sql->escape_string(base64_encode($data['pass'])).'\'');
	if($sql->d_select_count > 0){
		$row = mysql_fetch_array($sql->d_select,MYSQL_ASSOC);
		$ans = array('id'=>intval($row['id']), 'priv'=>intval($row['priv']),'vote'=>intval($row['vote']));
	} else {
		$ans = array('error'=>'not found user');
	}
	return $ans;
}

function registration($data){
	global $sql;
	$ans = array();
	$login = '';
	$password = '';
	$email = '';
	$flag_pass = false;
	$match = true;
	if(isset($data['Login'])){
		$login = $data['Login'];
	}
	if(isset($data['inputEmail'])){
		$email = $data['inputEmail'];
	}
	if(isset($data['inputPassword']) && isset($data['confirmPassword'])){
		if($data['inputPassword'] == $data['confirmPassword']){
			$password = base64_encode($data['inputPassword']);
			$flag_pass = true;
		} else {
			$ans = array('error'=>'passwords do not match');
			$match = false;
		}
	}
	if($match){
		$sql->db_sql_select('id','users','WHERE login=\''.$sql->escape_string($login).'\' && password=\''.$sql->escape_string($password).'\'');
		if($sql->d_select_count > 0){
			$flag_pass = false;
			$ans = array('error'=>'this user register');
		}
	}
	if($flag_pass){
		if($sql->db_sql_insert('users(login,password,email)','\''.$sql->escape_string($login).'\',\''.$sql->escape_string($password).'\',\''.$sql->escape_string($email).'\'')){
			$ans = array('ok'=>$sql->last_insert());
		} else {
			$ans = array('error'=>'insert error');
		}
	}
	
	return $ans;
}

function reg_concert($data){
	global $sql;
	$ans = array();
	$date = time();
	if(isset($data['date'])){
		$string_date = strtotime($data['date']);
		$date = intval($string_date);
	}
	if($sql->db_sql_insert('concert(time_start,time_end)',time().','.$date)){
		$ans = array('ok'=>$sql->last_insert());
	} else {
		$ans = array('error'=>'can\'t inseret');
	}
	return $ans;
}

function get_top($data){
	global $sql;
	//последнее значение count
	$cid = 0;
	if(isset($data['cid'])){
		$cid = intval($data['cid']);
	}
	$sql->db_sql_select('songs.id,songs.name,songs.author,songs.genre,songs.year,songs.album,songs.lang,users.id as uid','vote',
		'LEFT JOIN songs ON vote.sid = songs.id
		LEFT JOIN users ON vote.uid = users.id
		WHERE vote.cid='.$cid);
	if($sql->d_select_count > 0){
		$top = $sql->d_select;
		while($row = mysql_fetch_array($top,MYSQL_ASSOC)){
			$ans[] = array('id'=>intval($row['id']),
							'name'=>$row['name'],
							'author'=>$row['author'],
							'genre'=>$row['genre'],
							'year'=>$row['year'],
							'album'=>$row['album'],
							'lang'=>$row['lang'],
							'count'=>count_vote(array('cid'=>$cid,'uid'=>$row['uid'])));
		}
	}
	$ans = array();
	return $ans;
}

function count_vote($data){
	global $sql;
	$ans = 0;
	$uid = 0;
	$cid = 0;
	if(isset($data['uid'])){
		$uid = intval($data['uid']);
	}
	if(isset($data['cid'])){
		$cid = intval($data['cid']);
	}
	$sql->db_sql_select('COUNT(id)','vote','WHERE uid='.$uid.' && cid='.$cid);
	if($sql->d_select_count > 0){
		$row = mysql_fetch_array($sql->d_select,MYSQL_ASSOC);
		$ans = intval($row['COUNT(id)']);
	}
	return $ans;
}

function get_statistics($data){
	global $sql;
	$ans = array();
	$cid = 0;
	if(isset($data['cid'])){
		$cid = intval($data['cid']);
	}
	$sql->db_sql_select('songs.id,songs.name,songs.author,songs.genre,songs.year,songs.album,songs.lang,users.id as uid, users.login, users.email, users.vote','vote',
		'LEFT JOIN songs ON vote.sid = songs.id
		LEFT JOIN users ON vote.uid = users.id
		WHERE cid='.$cid.' ORDER BY sid');
	if($sql->d_select_count > 0){
		$stat = $sql->d_select;
		while($row = mysql_fetch_array($stat,MYSQL_ASSOC)){
			$user = array('id'=>intval($row['uid']),
						  'login'=>$row['login'],
						  'email'=>$row['email'],
						  'vote'=>intval($row['vote']));
			$song = array('id'=>intval($row['id']),
						'name'=>$row['name'],
						'author'=>$row['author'],
						'genre'=>$row['genre'],
						'year'=>$row['year'],
						'album'=>$row['album'],
						'lang'=>$row['lang']);
			$ans[] = array('user'=>$user,'song'=>$song);
		}
	}
	return $ans;
}

function get_time_concert(){
	global $sql;
	$ans = array();
	$time = 0;
	$sql->db_sql_select('time_end','concert','ORDER BY id DESC LIMIT 1');
	if($sql->d_select_count > 0){
		$row = mysql_fetch_array($sql->d_select,MYSQL_ASSOC);
		$time = intval($row['time_end']);
		if($time < time()){
			$ans = array('error'=>'vote is complite');
		} else {
			$date = date('Y-m-d H:i:s', $time);
			$ans = array('ok'=>$date);
		}
	} else {
		$ans = array('warning'=>'not found concert');
	}
	return $ans;
}

print json_encode($result);
//print_r($result);
?>