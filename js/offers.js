/*
chooseOffers - плагин для выбора торговых предложений. Может использоваться множественно на странице.
Для работы плагину должны быть правильно переданы параметры.
var offers = new chooseOffer(
  [
	  {children:'элементы выбора'},
	  {children:'элементы выбора'},
  ],
  {
	  debag:false,
	  wrapper:'document',
	  disabledClass: 'offer-disabled',//по умолчанию
	  enabledClass: 'offer-enabled',//по умолчанию
	  choosenClass: 'offer-choosen'//по умолчанию
  },
  объект с ценами в сормате {offer_id:[массив]}
);



События плагина:
	- disableSelector (selector, name, enabledID) - когда сбрасывается какой-то селектор, передается имя селектора и массив с доступными для выбора ID
	- findOffer (id,prices) - когда мы определили ID предложения. Prices возвращает если у каждого предложения цена разная и цены переданы
	- loseOffer () - когда предложение было сброшено или не выбрано
	
Параметры:
	- disabledClass - класс для отключенного элемента
	- enabledClass - класс для включенного элемента
	- choosenClass - класс для выбранного элемента
	- debag - включить или отключить дебаг
	- wrapper - селектор внутри которого происходит отлов элементов, это нужно для того, если на странице много товаров с мыбором предложений
	по умолчанию враппером является documen, так же на этот элемент приходят все триггеры

Цены предложений:
	- массив вида ID масива, массив параметров цены. Отдается в событии findOffer, необходимый массив цен.
	Может быть пустым, если цена одна на все предложения
	
	
	
Передаваемые параметры
*/

window.chooseOffer = function (selections,options,offersPrices){
	this.options = {
		disabledClass: 'offer-disabled',
		enabledClass: 'offer-enabled',
		choosenClass: 'offer-choosen',
		debag: false,//console log disable,
		wrapper: 'document',
	};
	this.wrapper = {};//сам объект
	this.wrapperSelector = '';//срока для вызова объекта, селектор
	this.body = $('body');
	this.selections = [];
	this.selectionsCNT = 0;
	//результаты выбранных свойств
	this.results = {};
	//массивы цен
	this.prices = false;
	
	




	this.init = function(){
		
		
		var selection;
		var selectionParent;
		var selectionChildren;
		for(var i = 0;i < this.selectionsCNT; i++){
			selection = selections[i];


			if(typeof selection.children != 'string'){
				this.log('chosenOffers: не верно переданы данные селектора');	
				return false;
			}
			
			//ищем в документе и селектором является wrapper и сами элементы
			this.body.on('click',this.wrapperSelector+' '+selection.children,{broSelector:this.wrapperSelector+' '+selection.children,thisObj:this},function(event){
				event.preventDefault;
				
				var thisObj = event.data.thisObj;//объект текущего плагина
				var selector = event.data.parent;
				var el = $(this);
				var bro = $(event.data.broSelector).not(el[0]);
				var value = el.data('value');
				var id = el.data('id')+'';//make string
				var name = el.data('name');
				
				
				
				
				
				if(typeof value == 'undefined' && !id.length && typeof name == 'undefined'){
					//такой элемента не обрабатывается просто
					return false;	
				}else if(typeof value == 'undefined' || !id.length || typeof name == 'undefined'){
					thisObj.log('chosenOffers: у элемента нет value или id или name');	
					return false;	
				}
				

				//у братанов удаляем активность
				bro.removeClass(thisObj.options.choosenClass);
				//элементу добавляем
				el.addClass(thisObj.options.choosenClass);
				
				//id может быть массивом и должен быть им, так как передается строка, разделитеоь ","
				if(id.indexOf(',') >=0){id = id.split(',');}else{id = [id];	}
				//добавляем результат
				thisObj.results[name] = id;
				
				//если кликнули по отключенному, то проверяем какие лелекторы были сброшены и передаем их дальше
				//так как они нужны для определения активности элементов
				var nulledSelectors = false;
				if(el.hasClass(thisObj.options.disabledClass)){
					//возвращает отключенные селекторы, их имена
					nulledSelectors = thisObj.setNull(name);
				}
				
				//передаем название селектора который был сменен и передаем название селекторов, которые были обнулены, если были
				thisObj.setDisabled(name,nulledSelectors);
				
				//проверяем, удалось ли нам определить конечное предложение или нет
				thisObj.isFinish();
			})
		}

		
		//в конце возвращаем сам объект, чтобы можно было пользоваться его методами
		return this;
	};
	
	//log
	this.log = function(text){
		if(!text.length || !this.options.debag) return;
		console.log('chooseOffers: '+text);
	};
	
	
	//сбрасывает значение
	//функция должна быть выполнена перед setDisabled и isFinish
	this.setNull = function(name){
		//получаем название селектора которая сделала сброс, была disabled
		//перебираем все значения в которых нет ID переданного в result[name]
		var needToDisable;
		
		var mainID = 0;
		var mainIDtimes = 0;
		var popular = {};
		//сначала мы ищем наиболее встречаемое значение, которое ест ьв обнуляемом элементе
		for(var i = 0; i < this.results[name].length; i++){
			//this.results[name][i]
			popular[this.results[name][i]] = 0;
			for(var selector in this.results) {
				if(this.results[selector].indexOf(this.results[name][i]) >= 0){
					popular[this.results[name][i]]++;
				}
			}
		}
		//сводим значение к одному, потому что может быть несколкьо ID с повторяющимся количеством нахождений
		for(var id in popular) {
			if(popular[id] > mainIDtimes){
				mainID = id;
				mainIDtimes = popular[id];
			}
		}
		
		var nulledSelectors = [];
		//проверяем, если популярный в селекторе, если нет, сбрасываем
		for(var selector in this.results) {
			if(this.results[selector].indexOf(mainID) < 0){
				this.wrapper.trigger('disableSelector',[selector,this.results[selector]]);
				this.log('Обнулен селектор - '+selector);
				
				//запоминаем что было обнулено
				nulledSelectors.push(selector);
				delete this.results[selector];
			}	
			
		}
		if(nulledSelectors.length){
			//возвращаем массив жоступных для выбора ID после сброса
			return nulledSelectors;
		}else{
			return false;	
		};

	};
	
	//поределяет не подходящие предложение и ставит им класс disabled
	this.setDisabled = function(selectorName,nulledSelectors){
		
		var allSelected = [];
		var allSelectedDirty = [];
		var thisObj = this;
		
		//получаем все быбранные ID
		var selectedCNT = 0;
		for(selector in this.results) {
			allSelectedDirty = allSelectedDirty.concat(this.results[selector]);
			selectedCNT++;
		}

		//считаем количество повторений
		var counts = {};
		allSelectedDirty.forEach(function(x) { counts[x] = (counts[x] || 0)+1; });

		
		//определяем элементы
		var select = [];
		for(var i = 0;i < this.selectionsCNT; i++){select.push(this.wrapperSelector+' '+selections[i].children);}
		select = $(select.join(', '));
		
		//перебираем элементы всех селекторов и проверяим их на активность
		select.each(function(i,e){
			var self = $(this);
			var value = self.data('value');
			var name = self.data('name');
			var id = self.data('id')+'';//string
			
			//игнорируем, если заполнено не правильно
			if(typeof value == 'undefined' || !id.length || typeof name == 'undefined') return;
			//превращаем в массив с ID доступными для элемента
			if(id.indexOf(',') >=0){id = id.split(',');}else{id = [id];}
			
			
			//определяем активно свойство или нет
			//один из ключевых моментов плагина
			var enabled = false;
			for(var i = 0; i < id.length; i++){
				if(nulledSelectors && nulledSelectors.indexOf(name) >= 0){
					//работаем эли этот элемент относится к обнуляемому, оставляем доступным, если подходит
					if(thisObj.results[selectorName].indexOf(id[i]) >= 0 && counts[id[i]] == selectedCNT){
						enabled = true;
						break;
					}
				}else{
					if(typeof thisObj.results[name] == 'undefined'){
						//если этот селектор не выбран, то самый популярный результат исключает лишнее
						if(counts[id[i]] == selectedCNT){
							enabled = true;
							break;
						}
					}else{
						//если селектор выбран
						if(counts[id[i]] >= selectedCNT-1 || (selectedCNT == 1 && name == selectorName)){
							enabled = true;
							break;
						}
					}
				}

			}
			
			

			//результат
			if(enabled){
				thisObj.log('Включен элемент - '+self);
				self.addClass(thisObj.options.enabledClass).removeClass(thisObj.options.disabledClass);		
			}else{
				thisObj.log('Оключены элемент - '+self);
				self.addClass(thisObj.options.disabledClass).removeClass(thisObj.options.enabledClass).removeClass(thisObj.options.choosenClass);	
			}
			
			
		})	
	};
	
	
	
	
	
	
	//функция проверяет, пришли ли мы к единому предложению, зналем ли мы финальный ID
	this.isFinish = function(){
		var setSelectorsCNT = Object.keys(this.results).length;
		var final = false;
		//если количество свойств равно установленным свойствам
		if(setSelectorsCNT == this.selectionsCNT){
			//определяем финальный ID
			var allSelected = [];
			for(selector in this.results) {
				//для первого мы заполняем, остальыне убирают лишнее
				allSelected = allSelected.concat(this.results[selector]);
			}
			
			//считаем количество повторений
			var counts = {};
			allSelected.forEach(function(x) { counts[x] = (counts[x] || 0)+1; });
			
			//если количество повторений равно количеству слекторов,то все
			for(id in counts) {
				if(counts[id] == this.selectionsCNT){
					//для первого мы заполняем, остальыне убирают лишнее
					final = id;
					break;
				}
			}
			
		
			
			//вызываем триггер, что событие было выбрано предложение или наоборот, предложение было не выбрано
			if(final){
				//передаем массив с ценами, если они доступны
				var triggerAr = [final];
				if(this.prices && this.prices[final]){
					triggerAr.push(this.prices[final]);	
				}
				
				this.wrapper.trigger('findOffer',triggerAr);
				this.log('Предложение найдено - '+final);
			}else{
				this.wrapper.trigger('loseOffer');
				this.log('Предложение сброшено или не найдено');
			}
			
			

			
		}else{
			//deactive	
			this.wrapper.trigger('loseOffer');
			this.log('Предложение сброшено или не найдено');
		}
	}
	
	
	//перезагрузить плагин
	this.reload = function(){
		return false;
	}

	
	
	
	
	
	
	
	
	
	
	
	//нужен jquery
	if(!window.jQuery){
		this.log('Не подключен Jquery');	
		return false;
	}

	//объекты
	if(typeof selections != 'object'){
		this.log('массив с параметрами не передан');	
		return false;
	}else{
		//смешиваем дефолтные параметры и переданные
		this.selections = selections;
		this.selectionsCNT = selections.length;
	}
	
	//для предложений, если предложение определено и цена на каждое разная, то вернет в событии стоимость
	if(offersPrices){
		this.prices = offersPrices;	
	}
	
	
	//параметры по умолчанию
	if(typeof options == 'object'){
		//смешиваем дефолтные параметры и переданные
		jQuery.extend(this.options, options);
		
		this.wrapperSelector = this.options.wrapper;
		this.wrapper = $(this.options.wrapper);
		
		if(!this.wrapper.length){
			this.log('не удалось задать wrapper');	
		}
	}
	
	this.init();
};
