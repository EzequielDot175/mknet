(function($){
	$.fn.modalNufarm = function(){
		var content = $("#modal-alert");
		var opened = false;
		var btn_open = $("a[id^='delete-item-']");
		var deleteUrl = "delete_compras.php?id=";

		var getInfoById = function (id,callback) {
			$.post("../ajax.front.php",{frontAjax: "",method: "getInfoCompraById",id: id}, function (data) {
				var data = $.parseJSON(data);
				callback.call("data",data);
			});
		}



		var putContentById = function (id,content) {
			var prefix = "#sub-content-prod-";
			$(prefix+id).html(content);
		}

		var changeSrc = function(id,source){
			var prefix = "#sub-content-prod-";
			if (source != "") {
				$(prefix+id).attr("src","../../images_productos/"+source);
			}
		}

		var putContent = function(id){
			getInfoById(id,function(data){
				console.info('data', data);
				putContentById("name",data.nombre+"<span>"+data.fecha+"</span>");
				putContentById("reference","<span>Remito</span> : "+data.remito);
				putContentById("username","<span>Usuario</span> : "+data.usuario);
				putContentById("seller","<span>Vendedor</span> : "+data.vendedor);
				putContentById("count","<span>Cantidad</span> : "+data.cantidad);
				putContentById("price","<span>Puntos por unidad</span> : "+data.precio);
				putContentById("colour","<span>Color</span> : "+data.color);
				putContentById("size","<span>Talle</span> : "+data.talle);
				putContentById("refund","<span>Puntos restablecidos al cliente:</span> : "+( parseInt(data.cantidad) * parseInt(data.precio) )+"p");
				changeSrc("image",data.img);
				open();

			});

		};

		var closeBox = function(){
			content.animate({opacity: 0},500,function(){
				opened = false;
				content.css({zIndex: -1000});
			});
		};

		var open = function(){
			content.css({zIndex: 100});
			content.animate({opacity: 1},500);
			opened = true;
		};

		var closeOnOutArea = function(){
			var liteBox = $(".modal-alert .box-alert");
			var pos = liteBox.offset();
			var positions = {
				top: pos.top,
				left: pos.left,
				right: pos.left + liteBox.width(),
				bottom: pos.top + liteBox.height(),
				w: liteBox.width(),
				h: liteBox.height()
			};

			content.click(function(event){
				if(opened){

					var cursor = {
						x: event.clientX,
						y: event.clientY
					}
					var xBoolean = (cursor.x >= positions.left && cursor.x <= positions.right);
					var yBoolean = (cursor.y >= positions.top && cursor.y <= positions.bottom);

					if ( !(xBoolean && yBoolean) ) {
						closeBox();
					}
				}

			});

		};

		var setCancel = function () {
			var cancelBtn = $(".box-alert-deny");
				cancelBtn.click(closeBox);
		}
		var setAccept = function(id){
			var accept = $(".box-alert-accept");
			accept.click(function(){
				if(opened){
					window.location.href = deleteUrl+id;
				}
			});
		}


		closeOnOutArea();
		setCancel();





		btn_open.click(function (event) {
			event.preventDefault();
			id = $(this).attr("id");
			id = parseInt(id.replace(/delete-item-/ig,''));
			if (!isNaN(id)) {
				putContent(id);
				setAccept(id);
			}

		});


		/** center modal on window */
		$(window).scroll(function(event) {
			/* Act on the event */
			content.css({top: $(this).scrollTop()});
			//console.info('Reporting :', $(this).scrollTop());
		});

	}
	
	
	$.fn.collapseById = function(params){

		var btnCollection = $("*[id^='"+params.btn+"']");
		var toggleItems = $("*[id^='"+params.item+"']");

		var getItemToggleElement = function (el) {
			var id = $(el).attr("id");
				id = id.split("-").pop();
			return $("#"+params.item+id);
		}

		var getBtnCollapseItem = function (el) {
			var id = $(el).attr("id");
			id = id.split("-").pop();
			return $("#"+params.item_btn+id);
		}

		var hiddeAllToggleItems = function () {
			toggleItems.each(function(ind,el){
				if(!$(el).hasClass("toggle-item-active")){
					$(el).show();
				}
			});
		}

		var assignToggleElements = function () {
			btnCollection.each(function(ind,el){
				$(this).hide();
				var collapseItem = getItemToggleElement(el);
				var btnCollapseItem = getBtnCollapseItem(el);
				$(el).click(function(){
					collapseItem.toggle();
					$(this).toggle();
				});
				btnCollapseItem.click(function () {
					$(el).toggle();
					collapseItem.toggle();
				});

			});
		}




		/** Init **/
		hiddeAllToggleItems();
		assignToggleElements();
	}

	$.fn.collapse = function(){
		var btn = $("*[collapse-btn]");
		var item = $("*[collapse-item]");
		var toggle = $("*[collapse-toggle]");

			item.hide();


		btn.click(function(){
			var id = $(this).attr("collapse-btn");
			$(this).toggle();
			$("*[collapse-item="+id+"]").toggle();
		});

		toggle.click(function(){
			var id = $(this).attr("collapse-toggle");
			$("*[collapse-btn="+id+"]").toggle();
			$("*[collapse-item="+id+"]").toggle();
		});
		console.info("btn", btn);
		console.info("item", item);
		console.info("toggle", toggle);
	}


	$.fn.cloneWidth = function(params){
		var parent = $("*[clone-width-parent]");
		var child = $("*[clone-width-child]");

		var options = $.fn.extend({
			padLeft : 0,
			padRight : 0
		},params);

		child.width(parent.width() + options.padLeft +options.padRight);
		$(window).on('resize', function () {
			child.width(parent.width() + options.padLeft + options.padRight);
		})
	}

})(jQuery);