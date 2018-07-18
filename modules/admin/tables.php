<?php
use core\Core as Core;

$request = "?";
if($_REQUEST["id_user"]){
	$filter = "ID = ".$_REQUEST["id_user"];
	$request .= "id_user=".$_REQUEST["id_user"]."&";
	//$filter = array("AND" => array("ID > 1","ID < 5"));
}
if($_REQUEST["name"]){
	$filter = "NAME LIKE '%".$_REQUEST["name"]."%'";
	$request .= "name=".$_REQUEST["name"]."&";
}
if($_REQUEST["table"]){
	$table = $_REQUEST["table"];
	$request .= "table=".$_REQUEST["table"]."&";
}else{
	$table = false;	
}

if($_REQUEST["cnt"]){
	$request .= "cnt=".$_REQUEST["cnt"]."&";
}

if(empty($filter)){
	$filter = false;
}

if($_REQUEST["page"]){	$num = $_REQUEST["page"]; }else{ $num = 1; }

$pagination = array("NUM" => $num, "COUNT" => 3);

if($_REQUEST["cnt"]){
	$pagination["COUNT"] = $_REQUEST["cnt"];
}

$tables = Core::getTables();
$count = Core::getItems($filter, "ID", $table);
$res = Core::getItems($filter, "ID,NAME", $table, $pagination);

$e_count = array(3,5,10,20,50,100);
?>
<form action="/admin/filter/" method="GET" class="another_form">
<input type="text" value="<?=$_REQUEST["id_user"];?>" name="id_user" placeholder="Введите ID пользователя">
<input type="text" value="<?=$_REQUEST["name"];?>" name="name" placeholder="Введите Имя">
<select name="table">
	<option value="">Выберите таблицу</option>
	<? foreach ($tables as $item) { ?>
		<option <?if($_REQUEST["table"] == $item["Name"]):?>selected="selected"<?endif;?> value="<?=$item["Name"];?>"><?=$item["Name"];?></option>
	<? } ?>
	<?/*<option <?if($_REQUEST["table"] == "users"):?>selected="selected"<?endif;?> value="users">Пользователи</option>
	<option <?if($_REQUEST["table"] == "elements"):?>selected="selected"<?endif;?> value="elements">Элементы</option>*/?>
</select>
<select name="cnt">
	<option value="">Количество элемнетов</option>
	<? foreach ($e_count as $i) { ?>
		<option <?if($_REQUEST["cnt"] == "$i"):?>selected="selected"<?endif;?> value="<?=$i;?>">Показывать по <?=$i;?></option>
	<? } ?>
</select>
<input type="submit" value="Показать">
</form>
<?if($tables):?>
<table border="1" cellpadding="7" cellspacing="0" class="admin-table-users">
<tr>
<th>
	Название таблицы
</th>
<th>
	Количество полей
</th>
</tr>
<? foreach ($tables as $item) { ?>
	<tr>
		<td><?=$item["Name"];?></td>
		<td><?=$item["Rows"];?></td>
	</tr>
<? } ?>
</table>
<?
$pages = count($count)/$pagination["COUNT"]+1;
?>
<?if($pages && $pages >= 2):?>
<div class="pagintaion">
<ul>
<li>Страница</li>
<?
for ($x=1; $x<$pages; $x++){
	if($x == $_REQUEST["page"] or empty($_REQUEST["page"]) && $x == 1){ $active = " class='active'"; }else{ $active = "";}
	echo"<li".$active."><a href=\"".$request."&page=".$x."\">".$x."</a></li>";
}
?>
</ul>
</div>
<?endif;?>
<?else:?>
<div class="error">
Ни одного подходящего резултата по вашему запросу не найдено.
</div>
<?endif;?>