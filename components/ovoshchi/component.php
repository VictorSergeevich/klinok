<?php
$component = new core\component();
// если в $_REQUEST пришел номер страницы то подставляем его, по умолчанию будет всегда 1 старница
if($_REQUEST["page"]){	$num = $_REQUEST["page"]; }else{ $num = 1; }
// здесь мы указываем два параметра пагинации
$pagination = array("NUM" => $num, "COUNT" => 20); // NUM = номер страницы, COUNT - количество записей на странице

$arResult["ITEMS"] = $component->getItems(false,"ID,NAME,IMG,PREVIEW_TEXT",'ovoshchi',$pagination);
$arResult["COUNT"] = count($component->getItems(false,"ID",'ovoshchi',false));
$arResult["CNT"] = ceil($arResult["COUNT"]/$pagination["COUNT"]);

if($_REQUEST["page"] > $arResult["CNT"]){  
header('Location: /?page='.$arResult["CNT"]);
exit;
}

if($_REQUEST["page"]){ $page = " - страница ".$_REQUEST["page"]; }
$GLOBALS["SEO_BUFFER"] = "\n<title>Кулинарные рецепты - просто значит вкусно{$page}</title>";
$GLOBALS["SEO_BUFFER"] .= "\n<meta name=\"description\" content=\"Кулинарные рецепты с фото, онлайн каталог кулинарных рецептов с пошаговым приготовлением{$page}\" />";

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