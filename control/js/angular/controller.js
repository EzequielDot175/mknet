app.controller('FiltroController', ['$scope','ajax','$rootScope', function ($scope,ajax,rscp) {
	
	$scope.select_vendedores    = "all";
	$scope.select_prod_canjeado = "";
	$scope.vendedores           = [];
	$scope.filtroData           = [];
	$scope.byWeek				= false;
	$scope.byMonth				= false;
	// $scope.currentDate 		= true;


	/**
	 * Seteo  filtro
	 */
	 $scope.filtro = {
	 	clientes 			: '',
	 	cant_canjes 		: '',
	 	punt_disponibles 	: '',
	 	prod_canjeado 		: '',
	 	estado 				: '',
	 	desde 				: '',
		hasta				: '',
	 	typeSearch 			: ''
	 };


	/**
	 * Seteo los options de vendedores
	 */
	ajax.post({get: 'vendedores'},function(a){
		// console.info('Reporting vendedores:', a);
		$scope.vendedores =	a ;
	});

	$scope.clearByType = function () {
		$scope.filtro.typeSearch = "";
		console.info("filtrado", $scope.filtro);
	}

	/**
	 * Seteo los options de productos canjeados
	 */
	ajax.post({get: 'ProdOptions'},function(a){
		// console.info('Reporting prod options:', a);
		$scope.select_prod_canjeado = a;
	});

	/**
	 * Seteo cliente on change
	 */
	$scope.setCliente = function (){
		var id = $scope.select_vendedores || 'all';
		ajax.post({get: 'clientes',id: id},function(a){
			console.info('setCliente', a);

			$scope.clientes = a ;
		});
	}
	$scope.setCliente();

	/**
	 * Envio el formulario 
	 */
	
	$scope.filter = function(){

		ajax.post({get: 'filtrado' , parameters: $scope.filtro},function(a){
			rscp.$emit('resultSuccess',a);
			$scope.filtroData = a;
		});

	}

	$scope.setSearchType = function (a) {
		if($scope.byMonth){
			$scope.byWeek = false;
			$scope.filtro.typeSearch = "byMonth";
		}else if($scope.byWeek){
			$scope.byMonth = false;
			$scope.filtro.typeSearch = "byWeek";
		}else if(!$scope.byWeek && !$scope.byMonth){
			$scope.filtro.typeSearch = "";
		}

	}
	
	$scope.estado = function(estate){

		switch(estate){
			case '1':
				return 'PEDIDO REALIZADO';
				break;
			case '2':
				return 'PEDIDO EN PROCESO';
				break;
			case '3':
				return 'PEDIDO ENVIADO';
				break;
			case '4':
				return 'PEDIDO ENTREGADO';
				break;
			default:
				return 'SIN ESTADO';
				break;
		}
	}

	$scope.isExcelFile = function(name){
		if(name.search(/\w+\.xlsx/ig) != -1){
			return true;
		}else{
			return false;
		}
	}

	$scope.excel = function(){
		console.info('send excel', $scope.filtroData);

		if($scope.filtroData.length == 0){
			alert("Primero debe realizar una busqueda");
			return;
		}
		ajax.excel($scope.filtroData, function(data){

			console.info("response excel", data);

			if (data != "false" && $scope.isExcelFile(data)) {
				window.location.href = "../excel/"+data;
			};
		});
	}



}]);






app.controller('ResultsController', ["$scope","$rootScope",function(scp,rscp){
	scp.results = [];

	scp.status = function (num) {
		var status = parseInt(num);
		switch(status){
			case 1:
				return "PEDIDO REALIZADO";
				break;
			case 2:
				return "PEDIDO EN PROCESO";
				break;
			case 3:
				return "PEDIDO ENVIADO";
				break;
			case 4:
				return "PEDIDO ENTREGADO";
				break;
			default:
				return 'SIN ESTADO';
				break;
		}
	}
	
	rscp.$on('resultSuccess',function(event,data){
		var collection = [];

		/*console.info("data", data);
		return;*/

		angular.forEach(data,function(elem,key){


			var item = {};
			//console.log(elem[0].strEmpresa);
			item.date = new Date(elem[0].fecha);
			item.company = elem[0].strEmpresa;
			item.seller = elem[0].v_nombre+" "+elem[0].v_apellido;
			item.details = [];

			angular.forEach(elem,function(child,childKey){
				console.info("child", child);
				if(childKey != "total") {
					var details = {
						img: child.imagen,
						name: child.prod_nombre,
						price: child.precio,
						total: child.pagado,
						colour: child.color,
						count: child.cantidad,
						size: child.talle,
						refer: child.remito,
						status: scp.status(child.estado)
					};
					item.details.push(details);
				}

			});
			collection.push(item);
		});
		console.info(' collection', collection);
		scp.results = collection;
	});
	


}]);