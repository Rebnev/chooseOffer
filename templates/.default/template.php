<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<div id="<?=$arResult['WRAPPER']?>">

	<? foreach($arResult['OFFERS_SELECT'] as $selectorName => $selector):?>
        <div class='offer_selector'>
            <label><?=$selector['NAME']?></label>
            
            <ul class='selector'>
            <? foreach($selector['VALUE'] as $elementCode => $element):?>
                <li class="option selector-<?=$selectorName?>" data-value="<?=$element['NAME']?>" data-id="<?=implode(',',$element['ID'])?>" data-name="<?=$selectorName?>">
                	<p class="name"><?=$element['NAME']?></p>
                </li>
            <? endforeach?>
            </ul>
        </div>
    <? endforeach?>
	
    
    <div class="ADDTOCART">добавить в корзину</div>
</div>






<script>
$(document).ready(function(e) {
	//нужно определить селекты которые влияют на выбор, они будут нашими эталонами
	var offers = new chooseOffer(
		[
			<? foreach($arResult['OFFERS_SELECT'] as $selectorName => $selector):?>
			{children:'.selector-<?=$selectorName?>'},
			<? endforeach?>
		],
		{
			debag:false,
			wrapper:'#<?=$arResult['WRAPPER']?>',
			disabledClass: 'offer-disabled',//default value
			enabledClass: 'offer-enabled',//default value
			choosenClass: 'offer-choosen',//default value
		},
		<?=$arResult['OFFERS_PRICES_JS']?>
	);

	var wrapper = $('#<?=$arResult['WRAPPER']?>');
	var addToCart = wrapper.find('.ADDTOCART');
	
	wrapper.on('disableSelector',function(event,selectorName,enabledID){
		//следим за сбросом, если нужно
	})
	wrapper.on('findOffer',function(event,offerID){
		//активируемкнопку и добавляем ID предложения
		addToCart.attr('id',offerID).addClass('active');

	})
	wrapper.on('loseOffer',function(event,selectorName){
		//деактивируем кнопку и удаляем ID предложения
		addToCart.removeAttr('id').removeClass('active');
	})
	

	
});

</script>


