<?php
$component = new core\component();

//print_r($component->getElements());
preg_match('/^\/([a-z]{3})\/$/i', $_SERVER["REDIRECT_URL"], $city);
$CODE = $city[1];

if($CODE){
	$filter = "CODE = '".$CODE."' AND CODE != ''";
	$arResult = $component->getItems($filter,false,'cities',false)[0];

	if($_REQUEST["page"]){ $page = " - страница ".$_REQUEST["page"]; }
	$title = "Кулинарные рецепты в ".$arResult["GDE"].$page;
	$description = "Кулинарные рецепты с фото, онлайн каталог кулинарных рецептов в ".$arResult["GDE"].$page;

	$arResult["DESCRIPTION"] = $description;

	$GLOBALS["SEO_BUFFER"] = "\n<title>".$title."</title>";
	$GLOBALS["SEO_BUFFER"] .= "\n<meta name=\"description\" content=\"".$description."\" />";

}

if(empty($arResult["NAME"])){
	$component->get404();
}
	//$component->elementUpdate();

$component->includeTemplate($arResult);

?>