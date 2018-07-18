<?php
$component = new core\component();
// если в $_REQUEST пришел номер страницы то подставляем его, по умолчанию будет всегда 1 старница
if($_REQUEST["page"]){	$num = $_REQUEST["page"]; }else{ $num = 1; }
// здесь мы указываем два параметра пагинации
$filter = false;

$search = str_replace("рецепт", "", $_REQUEST["search"]);

//if($search){
// $filter = "NAME LIKE '%".$search."%' OR NAME LIKE '".$search."%' OR NAME LIKE '".mb_substr($search,0,-1)."%' OR NAME LIKE '%".mb_substr($search,0,-1)."%'";
//}

//$arResult["COUNT"] = count($component->getItems($filter,"ID",'elements',false));

$filter_mass = array();

$explode = explode(" ",$search);
if($explode[1]){
  foreach ($explode as $key => $item) {
    if(strlen($item) > 3){
      $filter_mass []= "NAME LIKE '%".$item."%' OR NAME LIKE '".$item."%' OR NAME LIKE '".mb_substr($item,0,-2)."%' OR NAME LIKE '%".mb_substr($item,0,-2)."%'";
    }
  }
}else{
 $filter = "NAME LIKE '%".$search."%' OR NAME LIKE '".$search."%' OR NAME LIKE '".mb_substr($search,0,-2)."%' OR NAME LIKE '%".mb_substr($search,0,-2)."%'";
}

if(!empty($filter_mass)){
  foreach ($filter_mass as $item) {
    if(end($filter_mass) == $item){
      $filter .= $item;
    }else{
      $filter .= $item." OR ";
    }
  }
}

$pagination = array("NUM" => $num, "COUNT" => 15); // NUM = номер страницы, COUNT - количество записей на странице

$arResult["ITEMS"] = $component->getItems($filter,"ID,NAME,IMG,PREVIEW_TEXT",'elements',$pagination);
$arResult["COUNT"] = (empty($arResult["COUNT"]))?count($component->getItems($filter,"ID",'elements',false)):$arResult["COUNT"];
$arResult["CNT"] = ceil($arResult["COUNT"]/$pagination["COUNT"]);

if(empty($arResult["ITEMS"])){  
header("HTTP/1.0 404 Not Found");
}

if($_REQUEST["page"]){ $page = " - страница ".$_REQUEST["page"]; }
$GLOBALS["SEO_BUFFER"] = "\n<title>Кулинарный поиск - найти любимый рецепт с фото{$page}</title>";
$GLOBALS["SEO_BUFFER"] .= "\n<meta name=\"description\" content=\"Поиск кулинарных рецептов с фото, онлайн каталог кулинарных рецептов с пошаговым приготовлением{$page}\" />";

if($search){
$GLOBALS["SEO_BUFFER"] = "\n<title>{$search} рецепты с фото{$page}</title>";
$GLOBALS["SEO_BUFFER"] .= "\n<meta name=\"description\" content=\"{$search} поиск рецепта. Онлайн каталог кулинарных рецептов с пошаговым приготовлением{$page}\" />";  
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