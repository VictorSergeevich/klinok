<?php
$component = new core\component();

//print_r($component->getElements());
preg_match('/sovet-([0-9]+)/', $_SERVER["REDIRECT_URL"], $id);
$ID_ELEMENT = $id[1];

if($ID_ELEMENT){
	$filter = "id = ".$ID_ELEMENT;
	$arResult = $component->getItems($filter,false,'sovet',false)[0];
	if($arResult["ID_CATEGORY"]){

		$arResult["DOP"] = $component->getItems("id_category = ".$arResult["ID_CATEGORY"],"ID,NAME,IMG",'sovet',array("LIMIT"=>4),"order by rand()");

		foreach ($arResult["DOP"] as $key => $item) {
			$arResult["DOP"][$key]["IMG"] = $component->resizeImage($item["IMG"],false,150,100);
		}

	}

	$title = ($arResult["TITLE"])?$arResult["TITLE"]:"Рецепт ".$arResult["NAME"];
	$description = ($arResult["DESCRIPTION"])?$arResult["DESCRIPTION"]:"Пошаговый рецепт приготовления. ".str_replace('"', '', $arResult["NAME"])." кулинарный рецепт приготовления с фото.";

	$GLOBALS["SEO_BUFFER"] = "\n<title>".$title."</title>";
	$GLOBALS["SEO_BUFFER"] .= "\n<meta name=\"description\" content=\"".$description."\" />";

}

if(empty($arResult)){
	$component->get404();
}
	//$component->elementUpdate();

$component->includeTemplate($arResult);

?>