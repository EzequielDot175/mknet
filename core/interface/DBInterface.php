			<?php 
			
			interface DBInterface {

			/**
			 *
			 *	INTEFACE: DBInterface 
			 * 	
			 * 	
			 * 	
			 * 	
			 * 	
			 * 	
			 * 	FUNCTION: La funcion de esta interfaz es tener un store de los sql utilizados por todas las clases a modo organizativo.
			 *
			 *
			 *
			 *
			 * 	VENTAJAS: Llamada de una sql completa mediante self::[QUERY CONSTANT].
			 * 	Reemplazando las variables necesarias mediante PDO::BINDPARAM -> VER PHP.NET
			 *
			 *
			 *
			 *
			 *
			 *
			 * 
			 */


			/**
			 * @internal $sql generales
			 */
			const QUERY_ALL_TABLE = "SELECT * FROM :tb ";

			/**
			 * @internal Class: Producto
			 */
			const PRODUCTO_ALL                  = "SELECT * FROM productos ORDER BY idProducto DESC";
			const PRODUCTO_ALLBYID 				= "SELECT * FROM productos WHERE idProducto = :id";
			const PRODUCTO_BYTYPE 				= "SELECT
			ct.idCategorias as id_cat,
			ct.strDescripcion as description,
			ct.talles as type
			FROM
			productos as prd
			LEFT JOIN
			categorias as ct ON ct.idCategorias = prd.intCategoria
			WHERE
			prd.idProducto = :id ";
			const PRODUCTO_TALLESBYPROD 		= "SELECT tp.cantidad, talles.nombre_talle as talle , tp.id_talle as id FROM talles_productos as tp NATURAL JOIN talles WHERE tp.id_producto = :id ";
			const PRODUCTO_COLORESBYPROD 		= "SELECT cp.cantidad, colores.nombre_color as color , cp.id_color as id FROM colores_productos as cp NATURAL JOIN colores WHERE cp.id_producto = :id ";
			const PRODUCTO_TALLES_COLORESBYPROD = "SELECT * FROM colores_talles as ct NATURAL JOIN colores NATURAL JOIN talles WHERE ct.id_producto = :id"; 
			const PRODUCTO_CATEGORIAS 			= "SELECT * FROM categorias ";
			const PRODUCTO_ALLCOLORES 			= "SELECT * FROM colores ";
			const PRODUCTO_ALLTALLES  			= "SELECT * FROM talles ";
			const PRODUCTO_UPDCAT 				= "UPDATE productos SET intCategoria = :cat WHERE idProducto = :prod";
			const PRODUCTO_STOCKSUMTALLE 		= "SELECT SUM(IF(ISNULL(talles.nombre_talle), 0 , tal_prod.cantidad)) as stock FROM talles_productos as tal_prod LEFT JOIN talles ON talles.id_talle = tal_prod.id_talle WHERE tal_prod.id_producto = :id";
			const PRODUCTO_STOCKSUMCOLOR 		= "SELECT SUM(IF(ISNULL(colores.nombre_color), 0 , col_prod.cantidad)) as stock FROM colores_productos as col_prod LEFT JOIN colores ON colores.id_color = col_prod.id_color WHERE col_prod.id_producto = :id";
			const PRODUCTO_STOCKSUMTALLECOLOR	= "SELECT SUM(cantidad) as stock FROM colores_talles WHERE id_producto = :id";
			const PRODUCTO_UPD_IMAGE 			= "UPDATE productos SET strImagen = :img WHERE idProducto = :id";
			const PRODUCTO_CREATE_COLOURS 		= "INSERT INTO colores_productos SET id_producto = :prod , id_color = :colour, cantidad = :cnt ;";
			const PRODUCTO_CREATE_SIZECLOTHES	= "INSERT INTO talles_productos SET id_producto = :prod , id_talle = :sizeid, cantidad = :cnt ;";
			const PRODUCTO_CREATE_COLOUR_SIZECLOTHES	= "INSERT INTO colores_talles SET id_producto = :prod , id_color = :colour ,id_talle = :sizeid, cantidad = :cnt ;";

				/**
			* @param carrito
			*/
			const CARRITO_BYID                  = "SELECT * FROM carrito WHERE intContador = :id";
			

			/**
			 * @param  tempStock
			 */
			const TEMPSTOCK_UPDATE_SIZE			= "UPDATE talles_productos as tp SET tp.cantidad = tp.cantidad - :count WHERE id_producto = :prod && id_talle = :size";
			const TEMPSTOCK_INSERT_TEMPL		= "INSERT INTO stock (id_product,id_talle,cantidad,requiere_talle,date,id_user) VALUES ";

			/**
			 * @param CLASS: Auth
			 */
			const AUTH_USER 					= "SELECT * FROM usuarios WHERE idUsuario = :id"; 
			const AUTH_USEDPOINTS				= "SELECT SUM(dblTotal) as total FROM compra WHERE idUsuario = :id ";
			const AUTH_USERADMIN 				= "SELECT * FROM personal WHERE id = :id";
			const AUTH_RESTPOINTS 				= "UPDATE usuarios SET dblCredito = dblCredito - :num WHERE idUsuario = :id";
			const AUTH_SUMCOMSUMED				= "UPDATE usuarios SET dblAsignado = dblAsignado + :num WHERE idUsuario = :id";
			
			/**
			* @param class TempMaxCompra
			*/
			const MAXCOMPRA_ALL                 = "SELECT idProducto as id,intMaxCompra as max FROM productos WHERE intStock > 0";
			const MAXCOMPRA_VERIFY              = "SELECT COUNT(id) as sum FROM tempmaxcompra WHERE user = ";
			const MAXCOMPRA_INSERT              = "INSERT INTO tempmaxcompra (user,prod,cant) VALUES ";
			const MAXCOMPRA_INSERTFROMPROD      = "INSERT INTO tempmaxcompra (user,prod,cant) VALUES (:user,:prod,(SELECT intMaxCompra FROM productos WHERE idProducto = :prod  ))";
			const MAXCOMPRA_HAVELIMITCOMPRA     = "SELECT cant FROM tempmaxcompra WHERE user = :user AND prod = :prod";
			const MAXCOMPRA_LIMITBYPROD         = "SELECT intMaxCompra as result FROM productos WHERE idProducto = :prod";
			const MAXCOMPRA_UPDATELIMIT         = "UPDATE tempmaxcompra SET cant = :cant WHERE user = :user AND prod = :prod";
			const MAXCOMPRA_UPDATELIMITFROMPROD = "UPDATE tempmaxcompra SET cant = (SELECT intMaxCompra FROM productos WHERE idProducto = :prod  ) WHERE user = :user AND prod = :prod";
			const MAXCOMPRA_GETMAXCOMPRA        = "SELECT SUM(IFNULL(cant,0) - used) as max, cant FROM tempmaxcompra WHERE prod = :prod AND user = :user";
			const MAXCOMPRA_UPDATEMAXCOMPRA     = "UPDATE tempmaxcompra  SET cant = cant - :cant  WHERE user = :user AND prod = :prod";
			const MAXCOMPRA_VERIFYCURRENTLIMIT  = "SELECT IF (cant = (SELECT intMaxCompra from productos WHERE idProducto = :prod ), '1', '0') as result FROM tempmaxcompra WHERE user = :user AND prod = :prod";
			const MAXCOMPRA_PRODUCTROWEXIST     = "SELECT COUNT(id) AS result FROM tempmaxcompra WHERE user = :user AND prod = :prod";
			const MAXCOMPRA_STORESUM            = "UPDATE tempmaxcompra SET used = used + :used WHERE user = :user AND prod = :prod";
			const MAXCOMPRA_STOREMAINS          = "UPDATE tempmaxcompra SET used = used - :used WHERE user = :user AND prod = :prod";
			const MAXCOMPRA_MAXPROD             = "SELECT intMaxCompra FROM productos WHERE idProducto = :prod";
			const MAXCOMPRA_USED 				= "SELECT used FROM `tempmaxcompra` WHERE `user` = :user AND `prod` = :prod ";
			const MAXCOMPRA_MIN_PROD 			= "SELECT intMinCompra FROM productos WHERE idProducto = :prod";
			const MAXCOMPRA_GETEXPIRED			= "SELECT *  FROM `carrito` WHERE timediff(NOW(),creation) >= :expiration";
			const MAXCOMPRA_GETBYCOLORANDSIZE	= "SELECT cantidad FROM colores_talles WHERE id_producto = :id AND id_color = :color AND id_talle = :talle";
			


			/**
			 * @param class: Historiales
			 */
			const HISTORIAL_ADD 				= "INSERT INTO historiales (id_usuario,fecha,realizado_por,tipo_modificacion,monto_modificado) VALUES (:id,:date,:by,:modif,:mounth) ";


			/**
			* @param class: Compra
			*/
			// const COMPRA_BYID                      = "SELECT "
			const COMPRA_EMPTY = "SELECT IF(COUNT(id_compra) = 0 , '1' , '0' ) as empty FROM detalles_compras WHERE id_compra = :id";
			const COMPRA_DELETE = "DELETE FROM compra WHERE idCompra = :id";
			const COMPRA_CREATE = "INSERT INTO compra (idUsuario,fthCompra,dblTotal,estado) VALUES (:user,:date,:total,1)";
			const COMPRA_ALL = "SELECT
			 compra.fthCompra,
			 compra.dblTotal,
			 compra.idCompra as id_compra,
			 compra.estado,
			 dt.nombre as prodNombre,
			 dt.remito,
			 dt.color,
			 dt.talle,
			 dt.precio_pagado,
			 dt.cantidad,
			 dt.estado_producto as estado_detalle,
			 dt.id as id_detalle,
			 usr.strNombre as nombre,
			 usr.strEmpresa as empresa,
			 usr.strApellido as apellido,
			 usr.strEmail as email,
			 usr.strEmpresa as empresa,
             usr.idUsuario as user_id,
             prs.nombre as v_nombre,
             prs.apellido as v_apellido,
             prs.id as v_id,
             prod.strNombre as prod_nombre,
             prod.strImagen as prod_imagen

			FROM
				compra
			LEFT JOIN
				detalles_compras as dt ON dt.id_compra = compra.idCompra
			LEFT JOIN
				usuarios as usr ON usr.idUsuario = compra.idUsuario
            LEFT JOIN
            	personal as prs ON prs.id = usr.vendedor
           	LEFT JOIN 
           		productos as prod ON prod.idProducto = dt.id_producto ";
           	const COMPRA_REFUND_CONS = "UPDATE usuarios SET dblConsumido = dblConsumido - :cant WHERE idUsuario = :id";

           	const COMPRA_ALL_BY_STATE = "SELECT
			 compra.fthCompra,
			 compra.dblTotal,
			 compra.idCompra as id_compra,
			 compra.estado,
			 dt.nombre as prodNombre,
			 dt.remito,
			 dt.color,
			 dt.talle,
			 dt.precio_pagado,
			 dt.cantidad,
			 dt.estado_producto as estado_detalle,
			 dt.id as id_detalle,
			 usr.strNombre as nombre,
			 usr.strApellido as apellido,
			 usr.strEmail as email,
			 usr.strEmpresa as empresa,
             usr.idUsuario as user_id,
             prs.nombre as v_nombre,
             prs.apellido as v_apellido,
             prs.id as v_id,
             prod.strNombre as prod_nombre,
             prod.strImagen as prod_imagen

			FROM
				compra
			LEFT JOIN
				detalles_compras as dt ON dt.id_compra = compra.idCompra
			LEFT JOIN
				usuarios as usr ON usr.idUsuario = compra.idUsuario
            LEFT JOIN
            	personal as prs ON prs.id = usr.vendedor
           	LEFT JOIN 
           		productos as prod ON prod.idProducto = dt.id_producto WHERE dt.estado_producto = :estado ";



           	const COMPRA_ALL_BY_VENDEDOR = "SELECT
			 compra.fthCompra,
			 compra.dblTotal,
			 compra.idCompra as id_compra,
			 compra.estado,
			 dt.nombre as prodNombre,
			 dt.remito,
			 dt.color,
			 dt.talle,
			 dt.precio_pagado,
			 dt.cantidad,
			 dt.estado_producto as estado_detalle,
			 dt.id as id_detalle,
			 usr.strNombre as nombre,
			 usr.strApellido as apellido,
			 usr.strEmail as email,
			 usr.strEmpresa as empresa,
             usr.idUsuario as user_id,
             prs.nombre as v_nombre,
             prs.apellido as v_apellido,
             prs.id as v_id,
             prod.strNombre as prod_nombre,
             prod.strImagen as prod_imagen

			FROM
				compra
			LEFT JOIN
				detalles_compras as dt ON dt.id_compra = compra.idCompra
			LEFT JOIN
				usuarios as usr ON usr.idUsuario = compra.idUsuario
            LEFT JOIN
            	personal as prs ON prs.id = usr.vendedor
           	LEFT JOIN 
           		productos as prod ON prod.idProducto = dt.id_producto WHERE prs.id = :id ";

           	const COMPRA_ALL_BY_CLIENTE = "SELECT
			 compra.fthCompra,
			 compra.dblTotal,
			 compra.idCompra as id_compra,
			 compra.estado,
			 dt.nombre as prodNombre,
			 dt.remito,
			 dt.color,
			 dt.talle,
			 dt.precio_pagado,
			 dt.cantidad,
			 dt.estado_producto as estado_detalle,
			 dt.id as id_detalle,
			 usr.strNombre as nombre,
			 usr.strApellido as apellido,
			 usr.strEmail as email,
			 usr.strEmpresa as empresa,
             usr.idUsuario as user_id,
             prs.nombre as v_nombre,
             prs.apellido as v_apellido,
             prs.id as v_id,
             prod.strNombre as prod_nombre,
             prod.strImagen as prod_imagen

			FROM
				compra
			LEFT JOIN
				detalles_compras as dt ON dt.id_compra = compra.idCompra
			LEFT JOIN
				usuarios as usr ON usr.idUsuario = compra.idUsuario
            LEFT JOIN
            	personal as prs ON prs.id = usr.vendedor
           	LEFT JOIN 
           		productos as prod ON prod.idProducto = dt.id_producto WHERE usr.idUsuario = :id ";

           	const COMPRA_ALL_BY_CLIENTE_BY_STATE = "SELECT
			 	compra.fthCompra,
			 	compra.dblTotal,
			 	compra.idCompra as id_compra,
			 	compra.estado,
			 	dt.nombre as prodNombre,
			 	dt.remito,
			 	dt.color,
			 	dt.talle,
			 	dt.precio_pagado,
			 	dt.cantidad,
			 	dt.estado_producto as estado_detalle,
			 	dt.id as id_detalle,
			 	usr.strNombre as nombre,
			 	usr.strApellido as apellido,
			 	usr.strEmail as email,
			 	usr.strEmpresa as empresa,
             	usr.idUsuario as user_id,
             	prs.nombre as v_nombre,
             	prs.apellido as v_apellido,
             	prs.id as v_id,
             	prod.strNombre as prod_nombre,
             	prod.strImagen as prod_imagen

			FROM
				compra
			LEFT JOIN
				detalles_compras as dt ON dt.id_compra = compra.idCompra
			LEFT JOIN
				usuarios as usr ON usr.idUsuario = compra.idUsuario
            LEFT JOIN
            	personal as prs ON prs.id = usr.vendedor
           	LEFT JOIN 
           		productos as prod ON prod.idProducto = dt.id_producto WHERE usr.idUsuario = :id AND dt.estado_producto = :estado ";


			
			const COMPRA_ALL_BY_VENDEDOR_BY_STATE = "SELECT
			 compra.fthCompra,
			 compra.dblTotal,
			 compra.idCompra as id_compra,
			 compra.estado,
			 dt.nombre as prodNombre,
			 dt.remito,
			 dt.color,
			 dt.talle,
			 dt.precio_pagado,
			 dt.cantidad,
			 dt.estado_producto as estado_detalle,
			 dt.id as id_detalle,
			 usr.strNombre as nombre,
			 usr.strApellido as apellido,
			 usr.strEmail as email,
			 usr.strEmpresa as empresa,
             usr.idUsuario as user_id,
             prs.nombre as v_nombre,
             prs.apellido as v_apellido,
             prs.id as v_id,
             prod.strNombre as prod_nombre,
             prod.strImagen as prod_imagen

			FROM
				compra
			LEFT JOIN
				detalles_compras as dt ON dt.id_compra = compra.idCompra
			LEFT JOIN
				usuarios as usr ON usr.idUsuario = compra.idUsuario
            LEFT JOIN
            	personal as prs ON prs.id = usr.vendedor
           	LEFT JOIN 
           		productos as prod ON prod.idProducto = dt.id_producto WHERE prs.id = :id AND dt.estado_producto = :estado ";

           	const COMPRA_COUNT = "SELECT COUNT(idCompra) AS count FROM compra";
			
			/**
			* @param class: DetalleCompra
			*/
			const DTCOMPRA_BYID                       = "SELECT * FROM detalles_compras WHERE id = :id";
			const DTCOMPRA_CREATE 					  = "INSERT INTO 
															detalles_compras (id_compra,id_producto,nombre,detalle,cantidad,precio_pagado,estado_producto,talle,color) 
																VALUES (:compra,:producto,:nombre, (SELECT strDetalle FROM productos WHERE idProducto = :producto LIMIT 1) ,:cantidad,:precio,1,:talle,:color)";
			const DTCOMPRA_JOINCOMPRA                 = "SELECT 
			compra.idCompra as compra,
			compra.idUsuario as user,
			compra.dblTotal as total,
			dtcompra.id_producto as producto,
			dtcompra.cantidad as cantidad,
			dtcompra.precio_pagado as pagado,
			talles.id_talle as talle,
			colores.id_color as color
			FROM 
			detalles_compras as dtcompra
			LEFT JOIN compra ON compra.idCompra       = dtcompra.id_compra
			LEFT JOIN talles ON talles.nombre_talle   = dtcompra.talle
			LEFT JOIN colores ON colores.nombre_color = dtcompra.color
			WHERE 
			id                                        = :id";
			const DTCOMPRA_SET_TOTAL                  = "UPDATE compra SET dblTotal  = :num WHERE idUsuario = :user && idCompra = :id ";
			const DTCOMPRA_DELETE                     = "DELETE FROM detalles_compras WHERE id = :id";
			const DTCOMPRA_UPDESTADO 				  = "UPDATE detalles_compras as dt SET dt.estado_producto = :estado, dt.remito = :remito WHERE dt.id = :dtid";
			const DTCOMPRA_ALLDETAILSBYID 			  = 'SELECT
																dt.cantidad,
																dt.detalle,
																dt.nombre,
																dt.estado_producto as estado,
																dt.talle,
																dt.color,
																dt.remito,
																prod.strImagen as img,
																DATE_FORMAT(compra.fthCompra,"%d/%m/%Y") as fecha,
																compra.dblTotal as total,
																prod.dblPrecio as precio,
																CONCAT(usr.strNombre, " ",usr.strApellido ) as usuario,
																CONCAT(per.nombre, " ",per.apellido) as vendedor

															FROM
																detalles_compras as dt
															LEFT JOIN compra ON compra.idCompra = dt.id_compra
															LEFT JOIN usuarios as usr ON usr.idUsuario = compra.idUsuario
															LEFT JOIN personal as per ON per.id = usr.vendedor
															LEFT JOIN productos as prod ON prod.idProducto = dt.id_producto
															WHERE dt.id = :id';
			
			
			
			
			/**
			* @param class: Usuario
			*/
			
			const USUARIO_BY_VENDEDOR 				 = "SELECT * FROM usuarios WHERE vendedor = :id ORDER BY idUsuario DESC";
			const USUARIO_CHECK_INIT 				 = "SELECT init FROM usuarios WHERE idUsuario = :id";
			const USUARIO_BY_CLIENTE 				 = "SELECT * FROM usuarios WHERE idUsuario = :id ORDER BY idUsuario DESC";
			const USUARIO_ALL						 = "SELECT * FROM usuarios  ORDER BY idUsuario DESC  LIMIT :off,:lim";
			const USUARIO_ALL_NOT_LIMIT				 = "SELECT * FROM usuarios";
			const USUARIO_PAGES 					 = "SELECT ROUND(COUNT(idUsuario) / :lim) as pages FROM usuarios";
			const USUARIO_SUMCREDITO                 = "UPDATE usuarios SET dblCredito = dblCredito + :num WHERE idUsuario = :user";
			const USUARIO_EDIT 						 = "UPDATE usuarios :QUERY WHERE idUsuario = :id";
			const USUARIO_BY_ID 					 = "SELECT * FROM usuarios WHERE idUsuario = :id";
			const USUARIO_SUM_DBLCONSUMIDO_FROM_SHOP = "UPDATE usuarios SET dblConsumido = dblConsumido + (SELECT SUM(prod.dblPrecio * carr.intCantidad) FROM productos as prod NATURAL JOIN carrito as carr  WHERE idUsuario = :id LIMIT 1) WHERE idUsuario = :id ";
			const USUARIO_GET_MAIL 					 = "SELECT strEmail as mail FROM usuarios WHERE idUsuario = :id ";
			
			/**
			 * @internal
			 * class: Talles
			 */
			const TALLES_GETBYID 					 = "SELECT tp.*, talles.nombre_talle as nombre FROM talles_productos as tp LEFT JOIN talles ON talles.id_talle = tp.id_talle WHERE tp.id_producto = :id";
			const TALLES_TAKESIZECHOTHING 			 = "UPDATE talles_productos SET cantidad = :count WHERE id_producto = :prod AND id_talle = :size";
			const TALLES_GETSTOCK 					 = "SELECT cantidad FROM talles_productos WHERE id_producto = :prod AND id_talle = :size";
			
			/**
			* @internal class: Stock
			*/
			
			const STOCK_SUMSTOCK_TALLE                = "UPDATE talles_productos SET cantidad = cantidad + :num WHERE id_talle = :talle AND id_producto = :prod ";
			const STOCK_SUMSTOCK_COLOR                = "UPDATE colores_productos SET cantidad = cantidad + :num WHERE id_color = :color AND id_producto = :prod";
			const STOCK_SUMSTOCK_TALLECOLOR           = "UPDATE colores_talles SET cantidad = cantidad + :num WHERE id_color = :color AND id_talle = :talle AND id_producto = :prod";
			const STOCK_SUMSTOCK_PROD 				  = "UPDATE productos SET intStock = intStock + :num WHERE idProducto = :prod";


				/**
				 * @internal class: Colours
				 */
				const COLOURS_ALL 					= "SELECT * FROM colores";



				/**
			 * @internal
			 */
			const SHOPPINGCART_ALL = "SELECT 
				cart.idProducto as id_prod,
			    cart.intCantidad as cantidad,
			    cart.talle as id_talle,
			    cart.color as id_color,
			    cart.intContador as id,
			    tal.nombre_talle as talle,
			    clr.nombre_color as color,
                prod.strImagen as img,
                prod.strNombre as name,
                prod.dblPrecio as precio
			    
			FROM carrito as cart
			LEFT JOIN
				colores as clr ON clr.id_color = cart.color
			LEFT JOIN
				talles as tal ON tal.id_talle = cart.talle
            LEFT JOIN 
            	productos as prod ON prod.idProducto = cart.idProducto
			WHERE 
				cart.idUsuario = :id";
			const SHOPPINGCART_REMOVE_ALL =  "DELETE FROM carrito WHERE idUsuario = :id";
			const SHOPPINGCART_SUM = "SELECT IFNULL(SUM(intCantidad),0) as cantidad FROM carrito WHERE idUsuario = :id";
			const SHOPPINGCART_REMOVE = "DELETE FROM carrito WHERE intContador = :id";
			const SHOPPINGCART_CHECKSIZE = "SELECT IF(COUNT(intContador) > 0, 1, 0) as exist FROM carrito WHERE idUsuario = :user AND idProducto  = :prod AND talle = :size ";
			const SHOPPINGCART_SUMSTOCK = "UPDATE carrito SET intCantidad = intCantidad + :cant WHERE idUsuario = :user AND idProducto  = :prod AND talle = :size ";
			const SHOPPINGCART_CLOTHINGSIZEINSERT = "INSERT INTO carrito (idUsuario,idProducto,intCantidad,talle) VALUES (:id,:prod,:count,:size)";


			/**
			 * @internal
			 * Historial
			 */
			
			const HISTORIAL_GET = "SELECT 
				compra.idCompra,
				compra.fthCompra as fecha,
				compra.dblTotal as total,
			    dt.estado_producto as estado,
			    dt.cantidad,
			    dt.talle,
			    dt.color,
			    dt.precio_pagado,
			    dt.remito,
			    dt.id as id_detalle,
                prod.strNombre as nombre,
                prod.strImagen as img
			FROM 
				compra
			LEFT JOIN
				detalles_compras as dt ON dt.id_compra = compra.idCompra
			LEFT JOIN
            	productos as prod ON prod.idProducto = dt.id_producto	
			WHERE
				idUsuario = :id";

			const HISTORIAL_OPTIONS_PRODUCTOS = "SELECT 
						dt.id_producto as value,
					    dt.nombre as text
					FROM 
						detalles_compras as dt
					LEFT JOIN
						compra ON compra.idCompra = dt.id_compra
					

					WHERE compra.idUsuario = :id GROUP BY dt.id_producto";



			const HISTORIAL_REMITOS_BY_AUTH = "SELECT dt.remito as text, dt.remito as value  FROM detalles_compras as dt LEFT JOIN compra ON compra.idCompra = dt.id_compra WHERE compra.idUsuario = :id";
			


			const HISTORIAL_AUTH_BY_PROD = "SELECT 
				compra.idCompra,
				compra.fthCompra as fecha,
				compra.dblTotal as total,
			    dt.estado_producto as estado,
			    dt.cantidad,
			    dt.talle,
			    dt.color,
			    dt.precio_pagado,
			    dt.remito,
			    dt.id as id_detalle,
                prod.strNombre as nombre,
                prod.strImagen as img
			FROM 
				compra
			LEFT JOIN
				detalles_compras as dt ON dt.id_compra = compra.idCompra
			LEFT JOIN
            	productos as prod ON prod.idProducto = dt.id_producto	
			WHERE compra.idUsuario = :id AND dt.id_producto = :id_prod";


			const HISTORIAL_AUTH_BY_STATE = "SELECT 
				compra.idCompra,
				compra.fthCompra as fecha,
				compra.dblTotal as total,
			    dt.estado_producto as estado,
			    dt.cantidad,
			    dt.talle,
			    dt.color,
			    dt.precio_pagado,
			    dt.remito,
			    dt.id as id_detalle,
                prod.strNombre as nombre,
                prod.strImagen as img
			FROM 
				compra
			LEFT JOIN
				detalles_compras as dt ON dt.id_compra = compra.idCompra
			LEFT JOIN
            	productos as prod ON prod.idProducto = dt.id_producto	
			WHERE compra.idUsuario = :id AND dt.estado_producto = :id_state";

			const HISTORIAL_AUTH_BY_REF = "SELECT 
				compra.idCompra,
				compra.fthCompra as fecha,
				compra.dblTotal as total,
			    dt.estado_producto as estado,
			    dt.cantidad,
			    dt.talle,
			    dt.color,
			    dt.precio_pagado,
			    dt.remito,
			    dt.id as id_detalle,
                prod.strNombre as nombre,
                prod.strImagen as img
			FROM 
				compra
			LEFT JOIN
				detalles_compras as dt ON dt.id_compra = compra.idCompra
			LEFT JOIN
            	productos as prod ON prod.idProducto = dt.id_producto	
			WHERE compra.idUsuario = :id AND dt.remito = :id_ref";

			const HISTORIAL_AUTH_BY_DATE = "SELECT 
				compra.idCompra,
				compra.fthCompra as fecha,
				compra.dblTotal as total,
			    dt.estado_producto as estado,
			    dt.cantidad,
			    dt.talle,
			    dt.color,
			    dt.precio_pagado,
			    dt.remito,
			    dt.id as id_detalle,
                prod.strNombre as nombre,
                prod.strImagen as img
			FROM 
				compra
			LEFT JOIN
				detalles_compras as dt ON dt.id_compra = compra.idCompra
			LEFT JOIN
            	productos as prod ON prod.idProducto = dt.id_producto	
			WHERE compra.idUsuario = :id AND compra.fthCompra LIKE :fecha ";




			/**
			 * @internal
			 * Consultas
			 */

			const CONSULTA_GET = "SELECT cons.*, usr.strNombre FROM consultas as cons LEFT JOIN usuarios as usr ON usr.idUsuario = cons.idUsuario WHERE cons.idUsuario = :id";
			const CONSULTA_LAST = "SELECT * FROM consultas WHERE idUsuario = :id ORDER BY idConsulta DESC LIMIT 1";
			const CONSULTA_GETRESPONSE = "SELECT 
					cons.strCampo as texto,
				    cons.fecha,
				    usr.strNombre
				FROM consultas as cons
				LEFT JOIN  
					usuarios as usr ON usr.idUsuario =  cons.idUsuario

				WHERE
					cons.respuesta_de = :id";
			const CONSULTA_NEW = "INSERT INTO consultas (idUsuario,strAsunto,strCampo,fecha,respondido,tipo,respuesta_de) VALUES (:id,:asunto,:campo,NOW(),0,1,0) ";
			const CONSULTA_GET_USER_BY_CONS = "SELECT 
						usr.strNombre,
					   	usr.strApellido,
					   	usr.strEmail,
					FROM 
						consultas as cons
					LEFT JOIN 
						usuarios as usr ON usr.idUsuario = cons.idUsuario
					WHERE 
						idConsulta = :id";
			const CONSULTA_BY_ID = "SELECT * FROM consultas WHERE idConsulta = :id";
			const CONSULTA_ALL 	= "SELECT
						cons.*,
					    usr.strEmpresa,
					    usr.vendedor
					FROM
						consultas as cons
					LEFT JOIN
						usuarios as usr ON usr.idUsuario = cons.idUsuario
					ORDER BY cons.fecha DESC";
			const CONSULTA_BYSTATE 	= "SELECT
						cons.*,
					    usr.strEmpresa,
					    usr.vendedor
					FROM
						consultas as cons
					LEFT JOIN
						usuarios as usr ON usr.idUsuario = cons.idUsuario
					WHERE cons.respondido = :status
					ORDER BY cons.fecha DESC";
			const CONSULTA_BYSELLER 	= "SELECT
						cons.*,
					    usr.strEmpresa,
					    usr.vendedor
					FROM
						consultas as cons
					LEFT JOIN
						usuarios as usr ON usr.idUsuario = cons.idUsuario
					WHERE usr.vendedor = :seller
					ORDER BY cons.fecha DESC";
			const CONSULTA_CREATE_RESPONSE = "INSERT INTO consultas (strCampo,fecha,respondido,tipo,respuesta_de) VALUES (:msg,NOW(),0,2,:id)";
			const CONSULTA_UPDATE_STATUS   = "UPDATE consultas SET respondido = 1 WHERE idConsulta = :id";
			const CONSULTA_BY_ID_AND_STATUS 	= "SELECT
						cons.*,
					    usr.strEmpresa,
					    usr.vendedor
					FROM
						consultas as cons
					LEFT JOIN
						usuarios as usr ON usr.idUsuario = cons.idUsuario
					WHERE usr.vendedor = :seller AND  cons.respondido = :status
					ORDER BY cons.fecha DESC";
				const CONSULTA_FULL_BY_ID = "SELECT
						cons.*,
					    usr.strEmpresa,
					    usr.vendedor
					FROM
						consultas as cons
					LEFT JOIN
						usuarios as usr ON usr.idUsuario = cons.idUsuario
					WHERE
						cons.idConsulta = :id OR respuesta_de = :id
					ORDER BY cons.fecha DESC";

			/**
			 * @internal 
			 * Clientes
			 */
			
			const CLIENTE_OPTIONS = "SELECT idUsuario as id, strEmpresa FROM usuarios GROUP BY strEmpresa ORDER BY strEmpresa ASC ";
			const CLIENTE_BYVENDEDOR = "SELECT idUsuario as id, strEmpresa FROM usuarios WHERE vendedor = :id GROUP BY strEmpresa ORDER BY strEmpresa ASC";

			/**
			 * @internal
			 * Vendores
			 */
			
			const VENDEDOR_OPTIONS  = "SELECT id , nombre, apellido FROM personal WHERE role = 3";
			const VENDEDOR_GET_ROLE = "SELECT role FROM personal WHERE id = :id";
			const VENDEDOR_GET_MAIL = "SELECT login FROM personal WHERE id = :id";


				/**
			 * @internal
			 * Vendedor Estrella
			 */
			const VE_HASFACTURACION         = "SELECT IF(COUNT(id) = 0, 0, 1) as result FROM `facturacion` WHERE id_user = :id ";
			const VE_INSERT                 = "INSERT INTO facturacion (id_user,data,start_year, end_year) VALUES (:id,:data, :start, :end)";		
			const VE_GETFACTURACION         = "SELECT * FROM facturacion WHERE id_user = :id";
			const VE_ANUAL                  = "SELECT DATE_FORMAT(fecha_inicio, '%Y-%m-%d') as inicio, DATE_FORMAT(fecha_fin, '%Y-%m-%d') as fin FROM ve_registro_anual GROUP BY fecha_inicio, fecha_fin ";
			const VE_ALL_NO_DATE            = "SELECT ve.*, IF(usr.gold = 1, 'NUFARM MAX GOLD' , 'NUFARM MAX' ) AS gold FROM ve_registro_anual as ve LEFT JOIN usuarios as usr ON usr.idUsuario = id_cliente WHERE id_vendedor = :id";
			const VE_ALL_DATE               = "SELECT ve.*, IF(usr.gold = 1, 'NUFARM MAX GOLD' , 'NUFARM MAX' ) AS gold FROM ve_registro_anual as ve LEFT JOIN usuarios as usr ON usr.idUsuario = id_cliente WHERE id_vendedor = :id AND fecha_inicio >= :inicio AND fecha_fin <= :fin";
			const VE_ALL_DATE_BY_CLIENT     = "SELECT ve.*, IF(usr.gold = 1, 'NUFARM MAX GOLD' , 'NUFARM MAX' ) AS gold FROM ve_registro_anual as ve LEFT JOIN usuarios as usr ON usr.idUsuario = id_cliente WHERE id_cliente = :id AND fecha_inicio >= :inicio AND fecha_fin <= :fin";
			const VE_CATPREMIOS             = "SELECT * FROM categorias_premios";
			const VE_USERFACTURACION        = "SELECT usr.idUsuario, fact.id_user, usr.vendedor  FROM `usuarios` as usr LEFT JOIN facturacion as fact ON fact.id_user = usr.idUsuario WHERE usr.vendedor = :id";
			const VE_ALL_USERFACTURACION    = "SELECT usr.idUsuario, fact.id_user, usr.vendedor  FROM `usuarios` as usr LEFT JOIN facturacion as fact ON fact.id_user = usr.idUsuario ";
			const VE_INS_FACT_INCIAL        = "INSERT INTO facturacion (id_user,id_vendedor,data,fact_total,fact_prod_clave,periodo_inicial,periodo_final) VALUES (:id,:vendedor, :data, 0, 0, :start, :end)"; 
			const VE_CLIENTFACTBYID         = "SELECT
													fact.id,
													fact.data as facturacion,
													fact.fact_total as total,
												    fact.fact_prod_clave as total_prod_clave,
												    usr.strEmpresa as cliente,
												    IF(usr.gold = 1,'NUFARM MAXX GOLD' , 'NUFARM MAXX') AS gold,
												    CONCAT(per.nombre,' ',per.apellido) as vendedor,
												    (SELECT total FROM ve_registro_anual WHERE fecha_inicio = :periodo_anterior AND id_cliente = fact.id_user) as ultimo_total,
												    (SELECT total_prod_clave FROM ve_registro_anual WHERE fecha_inicio = :periodo_anterior AND id_cliente = fact.id_user) as ultimo_prod_clave
												FROM 
													facturacion as fact
												LEFT JOIN
													usuarios as usr ON usr.idUsuario = fact.id_user
												LEFT JOIN
													personal as per ON per.id = usr.vendedor
												WHERE
													fact.id_user = :id  GROUP BY usr.idempresa";
			const VE_ALL_CLIENTES_VENDEDORES   = "SELECT
													fact.id,
													fact.data as facturacion,
													fact.fact_total as total,
												    fact.fact_prod_clave as total_prod_clave,
												    usr.strEmpresa as cliente,
												    IF(usr.gold = 1,'NUFARM MAXX GOLD' , 'NUFARM MAXX') AS gold,
												    CONCAT(per.nombre,' ',per.apellido) as vendedor,
												    (SELECT total FROM ve_registro_anual WHERE fecha_inicio = :periodo_anterior AND id_cliente = fact.id_user) as ultimo_total,
												    (SELECT total_prod_clave FROM ve_registro_anual WHERE fecha_inicio = :periodo_anterior AND id_cliente = fact.id_user) as ultimo_prod_clave
												FROM
													facturacion as fact
												LEFT JOIN
													usuarios as usr ON usr.idUsuario = fact.id_user
												LEFT JOIN
													personal as per ON per.id = usr.vendedor ";
			const VE_ALL_CLIENTES_VENDEDORES_BY_PERIOD = "SELECT ve.*,  IF(usr.gold = 1,'NUFARM MAXX GOLD' , 'NUFARM MAXX') AS gold FROM ve_registro_anual as ve LEFT JOIN usuarios as usr ON usr.idUsuario = ve.id_vendedor WHERE fecha_inicio = :inicio AND fecha_fin = :fin";
			const VE_CLIENTFACTBYIDROW         = "SELECT
													fact.id,
													fact.data as facturacion,
													fact.fact_total as total,
												    fact.fact_prod_clave as total_prod_clave,
												    usr.strEmpresa as cliente,
												    IF(usr.gold = 1,'NUFARM MAXX GOLD' , 'NUFARM MAXX') AS gold,
												    CONCAT(per.nombre,' ',per.apellido) as vendedor,
												    (SELECT total FROM ve_registro_anual WHERE fecha_inicio = :periodo_anterior AND id_cliente = fact.id_user) as ultimo_total,
												    (SELECT total_prod_clave FROM ve_registro_anual WHERE fecha_inicio = :periodo_anterior AND id_cliente = fact.id_user) as ultimo_prod_clave
												FROM
													facturacion as fact
												LEFT JOIN
													usuarios as usr ON usr.idUsuario = fact.id_user
												LEFT JOIN
													personal as per ON per.id = usr.vendedor
												WHERE
													fact.id = :id  GROUP BY usr.idempresa";
			const VE_CLIENTFACTBYIDVENDEDOR = "SELECT 
													fact.id,
													fact.data as facturacion,
													fact.fact_total as total,
												    fact.fact_prod_clave as total_prod_clave,
												    usr.strEmpresa as cliente,
												    IF(usr.gold = 1,'NUFARM MAXX GOLD' , 'NUFARM MAXX') AS gold,
												    CONCAT(per.nombre,' ',per.apellido) as vendedor,
												    (SELECT total FROM ve_registro_anual WHERE fecha_inicio = :periodo_anterior AND id_cliente = fact.id_user) as ultimo_total,
												    (SELECT total_prod_clave FROM ve_registro_anual WHERE fecha_inicio = :periodo_anterior AND id_cliente = fact.id_user) as ultimo_prod_clave
												FROM 
													facturacion as fact
												LEFT JOIN
													usuarios as usr ON usr.idUsuario = fact.id_user
												LEFT JOIN
													personal as per ON per.id = usr.vendedor
												WHERE
													fact.id_vendedor = :id  GROUP BY usr.idempresa";
			const VE_TOTAL_BY_PERIOD 		= "SELECT SUM(total) as total, SUM(total_prod_clave) as producto_clave FROM ve_registro_anual WHERE id_vendedor = :id AND fecha_inicio >= :inicio AND fecha_fin <= :fin";
			const VE_TOTAL_BY_CURRENT_PERIOD 		= "SELECT SUM(fact_total) as total, SUM(fact_prod_clave) as producto_clave FROM facturacion WHERE id_vendedor = :id";
			const VE_UPDATE_CURRENT_PERIOD_BYID = "UPDATE facturacion SET data = :data , fact_total = :total, fact_prod_clave = :fact_prod_clave WHERE id = :id";
			const VE_SEL_FACT_BY_ID 			= "SELECT * FROM facturacion WHERE id = :id";
			const VE_ALL_CLIENTES 				= "SELECT idUsuario AS id, strEmpresa FROM usuarios  GROUP BY usuarios.idempresa";
			const VE_SEL_FACT_BY_IDUSER 		= "SELECT * FROM facturacion WHERE id_user = :id";
			const VE_CATEGORY_OLD_PERIOD_BY_USER = "SELECT 
				  ROUND( ( ve.total_prod_clave / ve.total ) * 100 ) as porcentaje
			FROM 
				ve_registro_anual as ve 
			WHERE 
				ve.id_cliente = :id AND ve.fecha_inicio = :fecha_inicio  GROUP BY usr.idempresa";
					}



		?>

