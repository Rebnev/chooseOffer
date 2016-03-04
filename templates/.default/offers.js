
/*
events:
	- disableSelector (selector name) - когда сбрасывается какой-то селектор, передается имя селектора
	- findOffer (id) - когда мы определили ID предложения
	- loseOffer () - когда предложение было сброшено или не выбрано
	
options:
	- disabledClass - класс для отключенного элемента
	- enabledClass - класс для включенного элемента
	- choosenClass - класс для выбранного элемента
	- debag - включить или отключить дебаг

*/


window.chooseOffer = function (selections,options){
	this.options = {
		disabledClass: 'offer-disabled',
		enabledClass: 'offer-enabled',
		choosenClass: 'offer-choosen',
		debag:false,//console log disable
	};
	this.body = $('body');
	this.selections = [];
	this.selectionsCNT = 0;
	//результаты выбранных свойств
	this.results = {};
	
	
	
	/*________________functions________________*/
	this.init = function(){
		//data (value,id,name)
		
		
		var selection;
		var selectionParent;
		var selectionChildren;
		for(var i = 0;i < this.selectionsCNT; i++){
			selection = selections[i];
			//selectionChildren = $(selection.children);
			

			if(typeof selection.children != 'string'){
				console.log('chosenOffers: не верно переданы данные селектора');	
				return false;
			}
			
			this.body.on('click',selection.children,{broSelector:selection.children,thisObj:this},function(event){
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
					console.log('chosenOffers: у элемента нет value или id или name');	
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
				
				//проверяем, если кликнули по недостпному элементу (исключенному по ID)
				//то тогда нам нужно сблосить значения других селекторов, если у них нет в возможных результатах нужных ID
				//там же диапазон ID может быть.в резуьтатах, если в этом диапазоне нет нахождений, то очищаем результат
				//о того что мы очистим результат все сработает ок, так как дальше идет проверка на длоступность по резуьтату
				if(el.hasClass(thisObj.options.disabledClass)){
					thisObj.setNull(name);
				}
				
				//передаем название, чтобы если было обнуление, то отключаться могли 
				//только те элементы, которые не пренадлежат свойству, которое было обнулено
				thisObj.setDisabled(name);
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
		for(selector in this.results) {
			//для первого мы заполняем, остальыне убирают лишнее

			needToDisable = true;
			for(var i = 0; i < this.results[selector].length; i++){
				if(this.results[name].indexOf(this.results[selector][i]) >= 0){
					needToDisable = false;
					break;
				}
			}
			
			//значит соответствий не найдено, отключаем
			if(needToDisable){
				this.el.document.trigger('disableSelector',[selector]);
				this.log('Обнулен селектор - '+selector);
				delete this.results[selector];
			}
		}
	
	};
	
	//поределяет не подходящие предложение и ставит им класс disabled
	this.setDisabled = function(selectorName){
		var allSelected = [];
		//получаем все быбранные ID
		
		for(selector in this.results) {
			allSelected = allSelected.concat(this.results[selector]);
		}
		//удаляем дубликаты
		allSelected = allSelected.filter(function(item, pos) {
			return allSelected.indexOf(item) == pos;
		})
		
		var thisObj = this;
		//перебираем всех детей и если у них нет ID развное выбранному, значит это заблокированное свойство
		//так как у нас нет жесткой привязки к элементам, выборка актуальных будет производиться каждый раз
		//такая конструкция позворляет динамически добавлять элементы
		var select = [];
		for(var i = 0;i < this.selectionsCNT; i++){select.push(selections[i].children);}
		select = $(select.join(', '));
		select.each(function(i,e){
			var self = $(this);
			var value = self.data('value');
			var name = self.data('name');
			var id = self.data('id')+'';
			
			
			//игнорируем, если заполнено не правильно
			if(typeof value == 'undefined' || !id.length || typeof name == 'undefined') return;
			//превращаем в массив с ID доступными для элемента
			if(id.indexOf(',') >=0){id = id.split(',');}else{id = [id];}
			
			//определяем активно свойство или нет
			var enabled = false;
			for(var i = 0; i < id.length; i++){
				if(allSelected.indexOf(id[i]) >= 0){
					enabled = true;
					break;
				}
			}
			
			//результат
			//если у нас выбрано только одно свойство, не т сымысла блоки ровать его братьев, это не красиво
			if(!enabled && name != selectorName){
				thisObj.log('Оключены элемент - '+self);
				self.addClass(thisObj.options.disabledClass).removeClass(thisObj.options.enabledClass);	
			}else{
				thisObj.log('Включен элемент - '+self);
				self.addClass(thisObj.options.enabledClass).removeClass(thisObj.options.disabledClass).removeClass(thisObj.options.choosenClass);	
			}
			
			
		})
		//console.log(select);
		
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
					final = counts[id];
					break;
				}
			}
			
			//вызываем триггер, что событие было выбрано предложение или наоборот, предложение было не выбрано
			if(final){
				this.el.document.trigger('findOffer',[final]);
				this.log('Предложение найдено - '+final);
			}else{
				this.el.document.trigger('loseOffer');
				this.log('Предложение сброшено или не найдено');
			}
			
			

			
		}else{
			//deactive	
			this.el.document.trigger('loseOffer');
			this.log('Предложение сброшено или не найдено');
		}
	}
	

	/*________________functions________________*/
	
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
	
	
	//параметры по умолчанию
	if(typeof options == 'object'){
		//смешиваем дефолтные параметры и переданные
		jQuery.extend(this.options, options);
	}
	
	this.init();
};
