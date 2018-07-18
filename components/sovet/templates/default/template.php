<div class="detail" data-id="<?=$arResult["ID"];?>">
<div class="navigated">
		<? $http_referer = (strripos($_SERVER["HTTP_REFERER"],"amcook.ru") === false) ? "/" : $_SERVER["HTTP_REFERER"] ;?>
		<a href="<?=($http_referer)?$http_referer:"/";?>"><< назад</a>
		<ul class="breadcrumbs">
			<li><a href="/">Главная</a></li>
			<li><?=$arResult["TITLE"];?></li>
		</ul>
</div>
	<div class="item">
	<div class="zagolovok">
		<h1><?=$arResult["NAME"];?></h1>
	</div>
	<div class="right-block">
	<div class="img">
		<?if(!empty($arResult["IMG"]) && file_exists($_SERVER["DOCUMENT_ROOT"] . $arResult["IMG"])):?>
			<img src="<?=$arResult["IMG"];?>" alt="<?=$arResult["NAME"];?>" title="<?=$arResult["NAME"];?> фото №1">
		<?endif;?>
	</div>
	<?
	$rating_votes_sum = preg_replace('~[^0-9]+~','',$arResult["VOTE_SUM"]);
	$rating_votes_cnt = preg_replace('~[^0-9]+~','',$arResult["VOTES_CNT"]);
	$rating_val = round($rating_votes_sum/$rating_votes_cnt, 1);
	if($rating_val > 5): $rating_val = 5; $rating_votes_sum = $rating_votes_cnt*5; endif;?>
	<div class="rating" data-sum="<?=$rating_votes_sum;?>" data-cnt="<?=$rating_votes_cnt;?>">
		<div id="rating" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
		    <input name="best" value="5" type="hidden">
		    <input name="val" value="<?=$rating_val;?>" type="hidden">
		    <input name="votes" value="<?=$rating_votes_cnt;?>" type="hidden">
			<span class="ratingCount" itemprop="bestRating">5</span>
			<span class="ratingCount" itemprop="ratingValue"><?=$rating_val;?></span>
			<span class="ratingCount" itemprop="ratingCount"><?=$rating_votes_cnt;?></span>
		</div>
	</div>
	</div>
	<div class="text">
		<?=$arResult["TEXT"];?>
	</div>
	<?if(!empty($arResult["DOP"])):?>
	<div class="pohogie">
		<h4>Смотрите так же</h4>
		<? foreach ($arResult["DOP"] as $key => $item) { ?>
			<div class="item">
				<a href="/recipe-<?=$item["ID"];?>/">
				<div class="img">
					<?if($item["IMG"]):?><img src="<?=$item["IMG"];?>" alt="<?=$item["NAME"];?> фото"><?endif;?>
				</div>
				<div class="content">
					<div class="name"><?=$item["NAME"];?></div>
				</div>
				</a>
			</div>
		<? } ?>
	</div>
	<?endif;?>
	</div>
		<div class="seo-text">
			<?=$arResult["DESCRIPTION"];?>
		</div>

	<div id="hypercomments_widget"></div>
	<script type="text/javascript">
	_hcwp = window._hcwp || [];
	_hcwp.push({widget:"Stream", widget_id: 96963});
	(function() {
	if("HC_LOAD_INIT" in window)return;
	HC_LOAD_INIT = true;
	var lang = (navigator.language || navigator.systemLanguage || navigator.userLanguage || "en").substr(0, 2).toLowerCase();
	var hcc = document.createElement("script"); hcc.type = "text/javascript"; hcc.async = true;
	hcc.src = ("https:" == document.location.protocol ? "https" : "http")+"://w.hypercomments.com/widget/hc/96963/"+lang+"/widget.js";
	var s = document.getElementsByTagName("script")[0];
	s.parentNode.insertBefore(hcc, s.nextSibling);
	})();
	</script>

</div>
<script src="<?=PAGE_TEMPLATE;?>js/jquery.js"></script>
<script src="<?=PAGE_TEMPLATE;?>js/jquery.rating-2.0.min.js"></script>
<script src="/components/sovet/templates/default/script.js"></script>