<?php

if(!function_exists('show_alert')){
	function show_alert($message, $status = 'danger'){
		return '<div class="alert alert-'.$status.' alert-dismissible">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				  '.$message.'
				</div>';
	}
}

if(!function_exists('is_login')){
	function is_login(){
		if(Session::has('user')) return true;
		return false;
	}
}


if(!function_exists('is_admin')){
	function is_admin(){
		if(!is_login()) return false;
		if(Session::get('user')->role == 'admin') return true;

		return false;
	}
}

if(!function_exists('is_instructor')){
	function is_instructor(){
		if(!is_login()) return false;
		if(Session::get('user')->role == 'instructor') return true;

		return false;
	}
}

if(!function_exists('is_user')){
	function is_user(){
		if(!is_login()) return false;
		if(Session::get('user')->role == 'user') return true;

		return false;
	}
}

if(!function_exists('format_rp')){
	function format_rp($nominal, $prefix = "Rp"){
		return $prefix." ".number_format($nominal, 0, ',', '.');
	}
}

function get_monthname($number, $is_short = false){
	if($number == 1 or $number ==  "01"){
		return "Januari";
	}else if($number == 2 or $number == "02"){
		return "Februari";
	}else if($number == 3 or $number ==  "03"){
		return "Maret";
	}else if($number == 4 or  $number == "04"){
		return "April";
	}else if($number == 5 or  $number == "05"){
		return "Mei";
	}else if($number == 6 or  $number == "06"){
		return "Juni";
	}else if($number == 7 or  $number == "07"){
		return "Juli";
	}else if($number == 8 or  $number == "08"){
		return "Agustus";
	}else if($number == 9 or $number == "09"){
		return "September";
	}else if($number == "10"){
		return "Oktober";
	}else if($number == "11"){
		return "November";
	}else if($number == "12"){
		return "Desember";
	}
}

function get_short_month($number){
	if($number == 1 or $number ==  "01"){
		return "Jan";
	}else if($number == 2 or $number == "02"){
		return "Feb";
	}else if($number == 3 or $number ==  "03"){
		return "Mar";
	}else if($number == 4 or  $number == "04"){
		return "Apr";
	}else if($number == 5 or  $number == "05"){
		return "Mei";
	}else if($number == 6 or  $number == "06"){
		return "Jun";
	}else if($number == 7 or  $number == "07"){
		return "Jul";
	}else if($number == 8 or  $number == "08"){
		return "Ags";
	}else if($number == 9 or $number == "09"){
		return "Sep";
	}else if($number == "10"){
		return "Okt";
	}else if($number == "11"){
		return "Nov";
	}else if($number == "12"){
		return "Des";
	}
}

function get_romawi($number){
	if($number == 1 or $number ==  "01"){
		return "I";
	}else if($number == 2 or $number == "02"){
		return "II";
	}else if($number == 3 or $number ==  "03"){
		return "III";
	}else if($number == 4 or  $number == "04"){
		return "IV";
	}else if($number == 5 or  $number == "05"){
		return "V";
	}else if($number == 6 or  $number == "06"){
		return "VI";
	}else if($number == 7 or  $number == "07"){
		return "VII";
	}else if($number == 8 or  $number == "08"){
		return "VIII";
	}else if($number == 9 or $number == "09"){
		return "IX";
	}else if($number == 10 or $number == "10"){
		return "X";
	}else if($number == 11 or $number == "11"){
		return "XI";
	}else if($number == 12 or $number == "12"){
		return "XII";
	}
}

function indonesian_date($string, $with_time = false, $is_string = true, $is_short = false){
	$time = $string;
	if($is_string){
		$time = strtotime($string);
	}
	$tgl = date('d', $time);

	if(!$is_short){
		$bln = get_monthname(date('m', $time));
	}else{
		$bln = get_short_month(date('m', $time));
	}
	
	$thn = date('Y', $time);
	$txt = $tgl." ".$bln." ".$thn;

	if($with_time){
		$jam = date('H:i', $time);
		$txt .= ", ".$jam;
	}
	return $txt;
}

function numToAlphabet($num){
	$arr = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
	$index = $num - 1;

	if(!isset($arr[$index])){
		return '';
	}

	return $arr[$index];
}
