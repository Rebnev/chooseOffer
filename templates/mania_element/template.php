<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div id="offer_wrapper">
    <div class="item-content__size">
        
        <div class="item-content__size-select">
    
            <select class="selectit">
            <? foreach($arResult['OFFERS_SELECT']['RAZMER']['VALUE'] as $k=>$v):?>
            	<option class='null' value="null"></option>
                <? if($v['PROPERTIES']['IN_CART']):?>
                    <option data-value="<?=$k?>" data-id="<?=implode(',',$v['ID'])?>" data-name="razmer" class="select-in-cart selectsize" value="<?=$k?>"><?=$v['NAME']?></option>
                <? elseif($v['PROPERTIES']['Q'] <= 0):?>
                    <option class="selectsize" disabled value="<?=$k?>"><?=$v['NAME']?></option>
                <? elseif($v['PROPERTIES']['Q'] == 1):?>
                    <option data-value="<?=$k?>" data-id="<?=implode(',',$v['ID'])?>" data-name="razmer" class="select-last-size selectsize" value="<?=$k?>"><?=$v['NAME']?></option>
                <? elseif($k):?>
                    <option data-value="<?=$k?>" data-id="<?=implode(',',$v['ID'])?>" data-name="razmer" class="selectsize" value="<?=$k?>"><?=$v['NAME']?></option>
                <? endif?> 
            <? endforeach?>
            </select>
    
        </div>
    
        <table class="item-content__size-massive">
    
            <tr class="size-massive__name">
                <td>Rus</td>
                <td>Eu</td>
                <td>Us</td>
                <td>Uk</td>
            </tr>
    
            <tr class="size-massive__value">
                <td class="item-content__size-value"><?=$arResult['SIZE_TABLE_FROW']['RUS']?></td>
                <td class="item-content__size-value"><?=$arResult['SIZE_TABLE_FROW']['EU']?></td>
                <td class="item-content__size-value"><?=$arResult['SIZE_TABLE_FROW']['US']?></td>
                <td class="item-content__size-value"><?=$arResult['SIZE_TABLE_FROW']['UK']?></td>
            </tr>
            <script>
                window.sizeTable = <?=CUtil::PhpToJSObject($arResult['SIZE_TABLE'], false, true); ?>;
            </script>
        </table>
    
        <div class="item-content__size-help">
    
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                 xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" width="73px" height="22px"
                 viewBox="0 0 73 22" version="1.1">
                <title>Size2 [Converted]</title>
                <desc>Created with Sketch.</desc>
                <defs/>
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                   sketch:type="MSPage">
                    <g id="Детально-" sketch:type="MSArtboardGroup"
                       transform="translate(-213.000000, -853.000000)">
                        <g id="36-размер" sketch:type="MSLayerGroup"
                           transform="translate(20.000000, 777.000000)">
                            <g id="Подобрать-размер" transform="translate(0.000000, 67.000000)"
                               sketch:type="MSShapeGroup">
                                <g id="Size2-[Converted]" transform="translate(194.000000, 10.000000)">
                                    <path d="M67.95,18.3648558 L66.936,18.3648558 L66.936,8.77291851 L67.95,8.77291851 L67.95,18.3648558 L67.95,18.3648558 Z"
                                          id="Shape" fill="#000000"/>
                                    <path d="M63.894,19.9320175 L62.88,19.9320175 L62.88,9.73201766 L63.894,9.73201766 L63.894,19.9320175 L63.894,19.9320175 Z"
                                          id="Shape" fill="#000000"/>
                                    <path d="M59.837,20.284 L58.823,20.284 L58.823,9.73201766 L59.837,9.73201766 L59.837,20.284 L59.837,20.284 Z"
                                          id="Shape" fill="#000000"/>
                                    <path d="M55.78,19.3249009 L54.766,19.3249009 L54.766,9.73201766 L55.78,9.73201766 L55.78,19.3249009 L55.78,19.3249009 Z"
                                          id="Shape" fill="#000000"/>
                                    <path d="M51.723,17.8989727 L50.709,17.8989727 L50.709,8.77197266 L51.723,8.77197266 L51.723,17.8989727 L51.723,17.8989727 Z"
                                          id="Shape" fill="#000000"/>
                                    <path d="M65.922,19.0239326 L64.908,19.0239326 L64.908,14.7572371 L65.922,14.7572371 L65.922,19.0239326 L65.922,19.0239326 Z"
                                          id="Shape" fill="#B2B2B2"/>
                                    <path d="M61.865,20.4456971 L60.851,20.4456971 L60.851,16.1804037 L61.865,16.1804037 L61.865,20.4456971 L61.865,20.4456971 Z"
                                          id="Shape" fill="#B2B2B2"/>
                                    <path d="M57.809,20.4456971 L56.795,20.4456971 L56.795,16.1804037 L57.809,16.1804037 L57.809,20.4456971 L57.809,20.4456971 Z"
                                          id="Shape" fill="#B2B2B2"/>
                                    <path d="M53.752,19.0239326 L52.738,19.0239326 L52.738,13.3354727 L53.752,13.3354727 L53.752,19.0239326 L53.752,19.0239326 Z"
                                          id="Shape" fill="#B2B2B2"/>
                                    <path d="M69.979,16.227 C72.0761721,14.435791 67.051,20.284 59.837,20.284 C52.623,20.284 49.0262451,15.7999268 49.0262451,15.7999268"
                                          id="Shape" stroke="#000000"/>
                                    <path d="M69.979,7.1 L70.993,7.1 L70.993,16.227 L69.979,16.227 L69.979,7.1 L69.979,7.1 Z"
                                          id="Shape" fill="#000000"/>
                                    <path d="M48.681,7.1 L49.695,7.1 L49.695,16.227 L48.681,16.227 L48.681,7.1 L48.681,7.1 Z"
                                          id="Shape" fill="#000000"/>
                                    <path d="M51.1135254,2.35681154 C54.7341309,1.37658691 57.3857783,1.69731837 60.6401367,2.14233399 C64.5343126,2.67484113 68.085,4.479 63.894,6.086 C62.333,6.685 56.6311309,7.47004997 54.7341309,6.45104997 C52.9891309,5.51304997 56.3956299,3.54724125 59.8369999,4.05800001"
                                          id="Shape" stroke="#000000"/>
                                    <path d="M70.993,5.578 C70.993,8.098 65.998,10.142 59.837,10.142 C53.676,10.142 48.681,8.099 48.681,5.578 C48.681,3.057 53.676,0 59.837,0 C65.998,0 70.993,3.057 70.993,5.578 Z"
                                          id="Shape" stroke="#000000"/>
                                    <path d="M43.61,15.8999996 L42.596,15.8999996 L42.596,5.5 L43.61,5.5 L43.61,15.8999996 L43.61,15.8999996 Z"
                                          id="Shape" fill="#000000"/>
                                    <path d="M37.525,15.8999996 L36.511,15.8999996 L36.511,5.5 L37.525,5.5 L37.525,15.8999996 L37.525,15.8999996 Z"
                                          id="Shape" fill="#000000"/>
                                    <path d="M31.44,15.8999996 L30.426,15.8999996 L30.426,5.5 L31.44,5.5 L31.44,15.8999996 L31.44,15.8999996 Z"
                                          id="Shape" fill="#000000"/>
                                    <path d="M25.355,15.8999996 L24.34,15.8999996 L24.34,5.5 L25.354,5.5 L25.354,15.8999996 L25.355,15.8999996 Z"
                                          id="Shape" fill="#000000"/>
                                    <path d="M19.27,15.8999996 L18.256,15.8999996 L18.256,5.5 L19.27,5.5 L19.27,15.8999996 L19.27,15.8999996 Z"
                                          id="Shape" fill="#000000"/>
                                    <path d="M12.17,15.8999996 L12.17,5.5 L13.184,5.5 L13.184,15.8999996 L12.17,15.8999996 Z"
                                          id="Shape" fill="#000000"/>
                                    <path d="M46.653,16.3646089 L45.639,16.3646089 L45.639,12.3076089 L46.653,12.3076089 L46.653,16.3646089 L46.653,16.3646089 Z"
                                          id="Shape" fill="#B2B2B2"/>
                                    <path d="M40.568,16.3646089 L39.554,16.3646089 L39.554,12.3076089 L40.568,12.3076089 L40.568,16.3646089 L40.568,16.3646089 Z"
                                          id="Shape" fill="#B2B2B2"/>
                                    <path d="M34.482,16.3646089 L33.468,16.3646089 L33.468,12.3076089 L34.482,12.3076089 L34.482,16.3646089 L34.482,16.3646089 Z"
                                          id="Shape" fill="#B2B2B2"/>
                                    <path d="M28.397,16.3646089 L27.383,16.3646089 L27.383,12.3076089 L28.397,12.3076089 L28.397,16.3646089 L28.397,16.3646089 Z"
                                          id="Shape" fill="#B2B2B2"/>
                                    <path d="M22.312,16.3646089 L21.298,16.3646089 L21.298,12.3076089 L22.312,12.3076089 L22.312,16.3646089 L22.312,16.3646089 Z"
                                          id="Shape" fill="#B2B2B2"/>
                                    <path d="M16.227,16.3646089 L15.213,16.3646089 L15.213,12.3076089 L16.227,12.3076089 L16.227,16.3646089 L16.227,16.3646089 Z"
                                          id="Shape" fill="#B2B2B2"/>
                                    <path d="M10.142,16.3646089 L9.128,16.3646089 L9.128,12.3076089 L10.142,12.3076089 L10.142,16.3646089 L10.142,16.3646089 Z"
                                          id="Shape" fill="#B2B2B2"/>
                                    <path d="M6.085,16.227 L5.071,16.227 L5.071,5.071 L6.085,5.071 L6.085,16.227 L6.085,16.227 Z"
                                          id="Shape" fill="#000000"/>
                                    <path d="M48.9000015,5.071 L48.9000015,16.227 L1.99555696,16.227 C0.89347422,16.227 0,15.319 0,14.199 L0,7.1 C0,5.979 0.89347422,5.071 1.99555696,5.071 L48.9000015,5.071 Z"
                                          id="Shape" stroke="#000000"/>
                                </g>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
    
            <div class="item-content__text-small">
                Подобрать размер
            </div>
    
        </div>
    
    </div>
    
    
    
    <div class="item-content__decor mobile"></div>
    
    <? if(!empty($arResult['OFFERS_SELECT']['TSVETOSNOVNOY'])):?>
    <div class="item-content__color desctop">
    
        <ul class="cart__item-color filter__checkbox--color">
        <? foreach($arResult['OFFERS_SELECT']['TSVETOSNOVNOY']['VALUE'] as $k=>$v):?>
            <li data-value="<?=$k?>" data-id="<?=implode(',',$v['ID'])?>" data-name="color">
                <div class="filter__check-four-item">
                    <img src="<?=$v['PROPERTIES']['PREVIEW_PICTURE']['src']?>" title="<?=$v['NAME']?>" alt="<?=$v['NAME']?>">
                    <div class="selected"></div>
                </div>
            </li>
        <? endforeach?>
        </ul>
    
    </div>
    <? endif?>
    
    
    
    <div class="item-content__service desctop">
    
        <ul class="item-content__service-list">
    
            <li class="item-content__service-item">
    
                <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"
                     height="29" width="62" viewBox="0 0 62 29">
                    <path stroke-linejoin="miter" stroke-linecap="butt" stroke-width="1"
                          stroke="#cccccc" fill="none" fill-rule="evenodd"
                          d="M 0.93 22.28 C 0.93 22.28 0.2 17.36 1.67 14.88 C 3.14 12.4 4.26 11.09 8 11 C 6.33 11.04 43 11 43 11 C 43 11 52.04 12.42 56.81 14.51 C 59.91 15.87 61.54 21.05 61.62 22.65 C 61.69 24.25 61.62 24.87 61.62 24.87"/>
                    <path stroke-linejoin="miter" stroke-linecap="butt" stroke-width="1"
                          stroke="#cccccc" fill="none" fill-rule="evenodd"
                          d="M 43.11 10.81 C 43.11 10.81 35.71 1.93 35.71 1.93 C 35.71 1.93 8.33 1.93 8.33 1.93"/>
                    <path stroke-linejoin="miter" stroke-linecap="butt" stroke-width="1"
                          stroke="#cccccc" fill="none" fill-rule="evenodd"
                          d="M 44 15 C 44 15 41 15 41 15"/>
                    <path stroke-linejoin="miter" stroke-linecap="butt" stroke-width="1"
                          stroke="#cccccc" fill="none" fill-rule="evenodd"
                          d="M 42 25 C 42 25 19 25 19 25"/>
                    <path stroke-linejoin="miter" stroke-linecap="butt" stroke-width="1"
                          stroke="#cccccc" fill="none" fill-rule="evenodd"
                          d="M 11.29 1.93 C 11.29 1.93 9.21 3.77 7.96 5.63 C 6.94 7.15 5.74 10.81 5.74 10.81"/>
                    <path stroke-linejoin="miter" stroke-linecap="butt" stroke-width="1"
                          stroke="#cccccc" fill="none" fill-rule="evenodd"
                          d="M 52.06 18 C 55.08 18 57.53 20.45 57.53 23.47 C 57.53 26.49 55.08 28.94 52.06 28.94 C 49.04 28.94 46.59 26.49 46.59 23.47 C 46.59 20.45 49.04 18 52.06 18 Z"/>
                    <path stroke-linejoin="miter" stroke-linecap="butt" stroke-width="1"
                          stroke="#cccccc" fill="none" fill-rule="evenodd"
                          d="M 10.47 18 C 13.49 18 15.94 20.45 15.94 23.47 C 15.94 26.49 13.49 28.94 10.47 28.94 C 7.45 28.94 5 26.49 5 23.47 C 5 20.45 7.45 18 10.47 18 Z"/>
                </svg>
                <div class="item-content__service-name">Удобная доставка</div>
    
            </li>
    
            <li class="item-content__service-item">
    
                <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"
                     height="24" width="27" viewBox="0 0 27 24">
                    <path fill="#ccc" fill-rule="evenodd"
                          d="M 1.24 1.22 L 1.24 0 L 21.16 0 L 21.16 1.22 L 1.24 1.22 L 1.24 1.22 Z M 1.24 1.22"></path>
                    <path fill="#ccc" fill-rule="evenodd"
                          d="M 19.91 0 L 21.16 0 L 21.16 3.65 L 19.91 3.65 L 19.91 0 L 19.91 0 Z M 19.91 0"></path>
                    <path fill="#ccc" fill-rule="evenodd"
                          d="M 23.65 4.87 L 24.89 4.87 L 24.89 10.95 L 23.65 10.95 L 23.65 4.87 L 23.65 4.87 Z M 23.65 4.87"></path>
                    <path fill="#ccc" fill-rule="evenodd"
                          d="M 24.89 23.12 L 23.65 23.12 L 23.65 17.04 L 24.89 17.04 L 24.89 23.12 L 24.89 23.12 Z M 24.89 23.12"></path>
                    <path fill="#ccc" fill-rule="evenodd"
                          d="M 26.14 15.82 L 26.14 17.04 L 19.91 17.04 L 19.91 15.82 L 26.14 15.82 L 26.14 15.82 Z M 26.14 15.82"></path>
                    <path fill="#ccc" fill-rule="evenodd"
                          d="M 24.89 9.74 L 26.14 9.74 L 26.14 15.82 L 24.89 15.82 L 24.89 9.74 L 24.89 9.74 Z M 24.89 9.74"></path>
                    <path fill="#ccc" fill-rule="evenodd"
                          d="M 23.65 9.74 L 23.65 10.95 L 19.91 10.95 L 19.91 9.74 L 23.65 9.74 L 23.65 9.74 Z M 23.65 9.74"></path>
                    <path fill="#ccc" fill-rule="evenodd"
                          d="M 19.91 10.95 L 21.16 10.95 L 21.16 15.82 L 19.91 15.82 L 19.91 10.95 L 19.91 10.95 Z M 19.91 10.95"></path>
                    <path fill="#ccc" fill-rule="evenodd"
                          d="M 0 0 L 1.24 0 L 1.24 23.12 L 0 23.12 L 0 0 L 0 0 Z M 0 0"></path>
                    <path fill="#ccc" fill-rule="evenodd"
                          d="M 0 4.87 L 0 3.65 L 24.89 3.65 L 24.89 4.87 L 0 4.87 L 0 4.87 Z M 0 4.87"></path>
                    <path fill="#ccc" fill-rule="evenodd"
                          d="M 0 23.12 L 0 21.91 L 24.89 21.91 L 24.89 23.12 L 0 23.12 L 0 23.12 Z M 0 23.12"></path>
                    <path fill="#ccc" fill-rule="evenodd"
                          d="M 5.05 9.24 L 5.05 10.08 L 15.51 10.08 L 15.51 9.24 L 5.05 9.24 L 5.05 9.24 Z M 5.05 9.24"></path>
                    <path fill="#ccc" fill-rule="evenodd"
                          d="M 15.2 10.38 L 15.83 9.78 L 12.28 6.43 L 11.65 7.02 L 15.2 10.38 L 15.2 10.38 Z M 15.2 10.38"></path>
                    <path fill="#ccc" fill-rule="evenodd"
                          d="M 15.83 9.54 L 15.2 8.94 L 11.65 12.3 L 12.28 12.89 L 15.83 9.54 L 15.83 9.54 Z M 15.83 9.54"></path>
                    <path fill="#ccc" fill-rule="evenodd"
                          d="M 16 16.79 L 16 17.63 L 5.54 17.63 L 5.54 16.79 L 16 16.79 L 16 16.79 Z M 16 16.79"></path>
                    <path fill="#ccc" fill-rule="evenodd"
                          d="M 5.85 17.93 L 5.23 17.34 L 8.78 13.98 L 9.4 14.57 L 5.85 17.93 L 5.85 17.93 Z M 5.85 17.93"></path>
                    <path fill="#ccc" fill-rule="evenodd"
                          d="M 5.23 17.09 L 5.85 16.5 L 9.4 19.86 L 8.78 20.45 L 5.23 17.09 L 5.23 17.09 Z M 5.23 17.09"></path>
                </svg>
                <div class="item-content__service-name">Удобный возврат</div>
    
            </li>
    
            <li class="item-content__service-item">
    
                <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"
                     height="34" width="30" viewBox="0 0 30 34">
                    <path stroke-linejoin="miter" stroke-linecap="butt" stroke-width="0.68"
                          stroke="#cccccc" fill="none" fill-rule="evenodd"
                          d="M 9.12 16.9 C 9.12 16.9 0.24 30.06 0.24 30.06 C 0.24 30.06 6.6 27.53 6.6 27.53 C 6.6 27.53 7.97 33.7 7.97 33.7 C 7.97 33.7 15.68 20.35 15.68 20.35 C 15.68 20.35 9.12 16.9 9.12 16.9 Z"/>
                    <path stroke-linejoin="miter" stroke-linecap="butt" stroke-width="0.68"
                          stroke="#cccccc" fill="none" fill-rule="evenodd"
                          d="M 20.88 16.9 C 20.88 16.9 29.76 30.06 29.76 30.06 C 29.76 30.06 23.4 27.53 23.4 27.53 C 23.4 27.53 22.03 33.7 22.03 33.7 C 22.03 33.7 14.32 20.35 14.32 20.35 C 14.32 20.35 20.88 16.9 20.88 16.9 Z"/>
                    <path stroke-linejoin="miter" stroke-linecap="butt" stroke-width="1"
                          stroke="#cccccc" fill="#ffffff" fill-rule="evenodd"
                          d="M 19.64 23.35 C 17.09 27.91 14.35 28.02 11.44 23.68 C 6.41 25.09 4.4 23.23 5.41 18.11 C 0.85 15.55 0.74 12.81 5.08 9.9 C 3.67 4.87 5.53 2.86 10.65 3.87 C 13.21 -0.69 15.95 -0.8 18.86 3.54 C 23.89 2.13 25.9 3.99 24.89 9.11 C 29.45 11.67 29.56 14.41 25.22 17.32 C 26.63 22.35 24.77 24.36 19.64 23.35 Z"/>
                    <path fill="#999999" fill-rule="evenodd"
                          d="M 21.79 9.8 C 21.79 9.8 14.2 17.4 14.2 17.4 C 14.2 17.4 14.3 17.5 14.3 17.5 C 14.3 17.5 13.81 17.98 13.81 17.98 C 13.81 17.98 13.71 17.88 13.71 17.88 C 13.71 17.88 13.61 17.98 13.61 17.98 C 13.61 17.98 13.13 17.5 13.13 17.5 C 13.13 17.5 13.23 17.4 13.23 17.4 C 13.23 17.4 8.36 12.53 8.36 12.53 C 8.36 12.53 8.84 12.04 8.84 12.04 C 8.84 12.04 13.71 16.91 13.71 16.91 C 13.71 16.91 21.31 9.32 21.31 9.32 C 21.31 9.32 21.79 9.8 21.79 9.8 Z"/>
                </svg>
                <div class="item-content__service-name">Подлинное качество</div>
    
            </li>
    
        </ul>
    
    </div>
    
    
    <div class="item-content__order">
    
        <div class="item-content__buy">
    
            <a href="#" class="btn item-content__fast-order">быстрый заказ</a>
    
            <a href="#" class="btn item-content__add-cart addtocart" id="<?=$arResult['DEFAULT_ID']?>">добавить в корзину</a>
    
        </div>
    
        <div class="item-content__price desctop">
            <? if($arResult['PRICE_OLD']):?>
            <div class="item-content__last-price"><?=$arResult['PRICE_OLD']?></div>
            <? endif?>
            <div class="item-content__price-now"><?=$arResult['PRICE']?>.-</div>
            
            <? if($arResult['PRICE_OLD']):?>
            <div class="label__sale">
                <div class="label__text">–30%</div>
            </div>
            <? endif?>
        </div>
    
    </div>
    
    <div class="mobile item-content__favorite-mobile">
    
        <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" height="21" width="23" viewBox="0 0 23 21">
            <path stroke-linejoin="miter" stroke-linecap="butt" stroke-width="1" stroke="#cfb5a7" fill="none" fill-rule="evenodd" d="M 11.5 19.74 L 10.03 18.35 C 4.57 13.76 1 10.67 1 6.88 C 1 3.79 3.52 1.4 6.78 1.4 C 8.56 1.4 10.35 2.2 11.5 3.49 C 12.66 2.2 14.44 1.4 16.22 1.4 C 19.48 1.4 22 3.79 22 6.88 C 22 10.67 18.43 13.76 12.97 18.35 L 11.5 19.74 L 11.5 19.74 Z M 11.5 19.74"></path>
        </svg>
    
        <a class="item-content__favorite-text">
            Добавить в избранное
        </a>
    
    </div>
</div>
<script>
$(document).ready(function(e) {
	//нужно определить селекты которые влияют на выбор, они будут нашими эталонами
	var offers = window.chooseOffer(
		[
			{children:'.selectsize'},
			{children:'.cart__item-color > li'},
		],
		{
			debag:false,
			wrapper:'#offer_wrapper'
		},
		<?=$arResult['OFFERS_PRICES_JS']?>
	);

	var wrapper = $('#offer_wrapper');
	var FATC = $('.item-content__fast-order');
	var ATC = $('.item-content__add-cart');
	
	wrapper.on('disableSelector',function(event,selectorName,selectorID){
		if(selectorName == 'razmer'){
			//у размера свой способ скинуть результат
			wrapper.find('.jq-selectbox__dropdown li:first').trigger('click');
		}
	})
	wrapper.on('findOffer',function(event,offerID){
		FATC.attr('id',offerID).addClass('active');
		ATC.attr('id',offerID).addClass('active');
	})
	wrapper.on('loseOffer',function(event,selectorName){
		FATC.removeAttr('id').removeClass('active');
		ATC.removeAttr('id').removeClass('active');
	})
	

	
});

</script>

<script>
$(document).ready(function(e) {
	//нужно определить селекты которые влияют на выбор, они будут нашими эталонами
	var offers = window.chooseOffer(
		[
			{children:'.selectsize'},
			{children:'.cart__item-color > li'},
		],
		{
			debag:false,
			wrapper:'#offer_wrapper'
		}
	);
	var wrapper = $('#offer_wrapper');
	var FATC = $('.item-content__fast-order');
	var ATC = $('.item-content__add-cart');
	
	wrapper.on('disableSelector',function(event,selectorName,enabledID){
		if(selectorName == 'razmer'){
			//у размера свой способ скинуть результат
			wrapper.find('.jq-selectbox__dropdown li:first').trigger('click');
		}
	})
	wrapper.on('findOffer',function(event,offerID){
		FATC.attr('id',offerID).addClass('active');
		ATC.attr('id',offerID).addClass('active');
	})
	wrapper.on('loseOffer',function(event,selectorName){
		FATC.removeAttr('id').removeClass('active');
		ATC.removeAttr('id').removeClass('active');
	})
	
	//просто отрабатываем по клику все и будет очень универсально
	
});

</script>


