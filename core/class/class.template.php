<?php 
	/**
	* @class template
	*/
	class Template
	{
		private $html = "";
		private $dirname;
		private $file_exist = true;

		public function __construct($name,$array)
		{
			$this->dirname = APP_DIR.'/core/views/'.$name.".html";
			$this->vars = $array;
			if(!$this->exist()):
				throw new Exception("La vista configurada noe existe", 1);
			else:
				$this->html = file_get_contents($this->dirname);
			endif;

			$this->matchAndReplace();
		}


		public function matchAndReplace(){
			$whiteSpace = [];
			preg_match_all("{{(\w+)}}", $this->html, $matches);
			$matches = array_pop($matches);

			foreach($matches as $key => $val):
				$this->html = str_replace("{{".$val."}}", $this->prevent($this->vars[$val]), $this->html);
			endforeach;
			
		}

		public static function  itemPedido($array){
			$html = "";

			foreach($array as $key => $val):
			
			$html .= '<div style="width:360px;padding-left: 72px;">
					<img style="float:left;" src="http://nufarm-maxx.com/marketingNet/imagenes/arrow-06.png"/>

					<p style="margin: 3px;margin-top: 10px;">'.$val->name.'</p>
					<p style="margin: 3px;padding-left: 10px;">CANT: '.$val->cantidad.'</p>
					'.($val->color != "" ? '<p style="margin: 3px;padding-left: 10px;">COLOR: 4</p>' : '' ).'
					<p style="margin: 3px;padding-left: 10px;">'.$val->precio.' Puntos</p>
					<p style="margin: 3px;padding-left: 10px;font-weight: bold;">TOTAL: '.$val->precio*$val->cantidad.' Puntos</p>
				</div>';

			endforeach;

			return $html;
		}

		private function prevent($val){
			if (empty($val) || is_null($val)) {
				return '';
			}else{
				return $val;
			}
		}

		private function exist(){
			if(file_exists($this->dirname)):
				return true;			
			else: 
				return false;
			endif;
		}

		public function get(){
			return $this->html;
		}

		private function matchOnTemplate(){

		}
	}
 ?>