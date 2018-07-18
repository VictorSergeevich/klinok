<?php
$component = new core\component();
// если в $_REQUEST пришел номер страницы то подставляем его, по умолчанию будет всегда 1 старница
if($_REQUEST["page"]){	$num = $_REQUEST["page"]; }else{ $num = 1; }
// здесь мы указываем два параметра пагинации
$filter = false;
if($GLOBALS["arParams"]["category"]){
 $filter = "ID_CATEGORY = ".$GLOBALS["arParams"]["category"];
}
$pagination = array("NUM" => $num, "COUNT" => 15); // NUM = номер страницы, COUNT - количество записей на странице

$arResult["ITEMS"] = $component->getItems($filter,"ID,NAME,IMG",'elements',$pagination);
$arResult["COUNT"] = count($component->getItems($filter,"ID",'elements',false));
$arResult["CNT"] = ceil($arResult["COUNT"]/$pagination["COUNT"]);

if($_REQUEST["page"] > $arResult["CNT"]){  
header('Location: /?page='.$arResult["CNT"]);
exit;
}

if($_REQUEST["page"]){ $page = " - страница ".$_REQUEST["page"]; }
$GLOBALS["SEO_BUFFER"] = "\n<title>Кулинарные рецепты - просто значит вкусно{$page}</title>";
$GLOBALS["SEO_BUFFER"] .= "\n<meta name=\"description\" content=\"Кулинарные рецепты с фото, онлайн каталог кулинарных рецептов с пошаговым приготовлением{$page}\" />";

if($GLOBALS["arParams"]["category"] == 1){
$GLOBALS["SEO_BUFFER"] = "\n<title>Рецепты супов. Супы рецепты с фото{$page}</title>";
$GLOBALS["SEO_BUFFER"] .= "\n<meta name=\"description\" content=\"Рецепт супа пошагово с фото. Вкусные пошаговые рецепты супов от amcook.ru{$page}\" />";
}

if($GLOBALS["arParams"]["category"] == 2){
$GLOBALS["SEO_BUFFER"] = "\n<title>Салаты. Рецепты салатов{$page}</title>";
$GLOBALS["SEO_BUFFER"] .= "\n<meta name=\"description\" content=\"Рецепты салатов простые и вкусные, пошаговые рецепты салатов с фото от amcook.ru{$page}\" />";
}

if($GLOBALS["arParams"]["category"] == 3){
$GLOBALS["SEO_BUFFER"] = "\n<title>Горячие блюда. Рецепты горячих блюд{$page}</title>";
$GLOBALS["SEO_BUFFER"] .= "\n<meta name=\"description\" content=\"Горячие блюда простые и вкусные, пошаговые рецепты горячих блюд с фото от amcook.ru{$page}\" />";
}

if($GLOBALS["arParams"]["category"] == 4){
$GLOBALS["SEO_BUFFER"] = "\n<title>Десерты. Рецепты десертов{$page}</title>";
$GLOBALS["SEO_BUFFER"] .= "\n<meta name=\"description\" content=\"Десерты простые и вкусные, пошаговые рецепты десертов с фото от amcook.ru{$page}\" />";
}

if(strripos($_SERVER["REQUEST_URI"],"redkie-blyuda") !== false){  
$GLOBALS["SEO_BUFFER"] = "\n<title>Редкие блюда. Рецепты эксклюзивных блюд{$page}</title>";
$GLOBALS["SEO_BUFFER"] .= "\n<meta name=\"description\" content=\"Редкие рецепты блюд, пошаговые рецепты эксклюзивных блюд с фото от amcook.ru{$page}\" />";
}

if($_REQUEST["page"]){
  if($_REQUEST["page"] == 2){
  	$GLOBALS["SEO_BUFFER"] .= "\n<link rel=\"prev\" href=\"/\" />";
  	$GLOBALS["SEO_BUFFER"] .= "\n<link rel=\"next\" href=\"/?page=3\" />";
  }else{
  	$page_minus = $_REQUEST["page"]-1;
  	$page_plus = $_REQUEST["page"]+1;
  	$GLOBALS["SEO_BUFFER"] .= "\n<link rel=\"prev\" href=\"/?page={$page_minus}\" />";
  	if($_REQUEST["page"] != $arResult["CNT"]){
  		$GLOBALS["SEO_BUFFER"] .= "\n<link rel=\"next\" href=\"/?page={$page_plus}\" />";
  	}
  }
}else{
  $GLOBALS["SEO_BUFFER"] .= "\n<link rel=\"next\" href=\"/?page=2\" />";
}

$component->includeTemplate($arResult);

?>