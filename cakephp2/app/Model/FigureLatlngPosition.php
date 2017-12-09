<?php
App::uses('AppModel', 'Model');

class FigureLatlngPosition extends AppModel {

    public $useTable = 'figure_latlng_positions'; // このモデルは「exmp」というデータベース・テーブルを使います
	
    var $virtualFields = array(
    		'lng' => 'X(latlng)',
    		'lat' => 'Y(latlng)'
    );
    
/*	public function addData($figureId,$lat,$lan){
		
		echo("insert into {$this->useTable} (figure_id,latlng) ('{$figureId}',GeomFromText('POINT({$lat} {$lan}'));");
		
		$this->query("insert into {$this->useTable} (figure_id,latlng) ('{$figureId}',GeomFromText('POINT({$lat} {$lan}));");
		
		$this->insert($this->useDbConfig, [
			'figure_id' => $figureId,
			'latlng' => "GeomFromText('POINT({$lat} {$lan})')"
			]);
	} */
	public function insertgeom($figureId,$lat,$lan){
//		$latlng = $this->query("SELECT GeomFromText('POINT(35.689　139.691)') as latlng");
		
//		$latlng = $this->query("SELECT GeomFromText('POINT(137.10 35.20)')");

		if(is_numeric($figureId) == false || is_numeric($lat) == false || is_numeric($lan) == false){
			return false;
		}
		
		$latlng = $this->query("insert into {$this->useTable}(figure_id,latlng)  values('{$figureId}',GeomFromText('POINT({$lat} {$lan})'));");

		return true;
		
//		var_dump($latlng);
	}
	
	public function updategeom($figureId,$lat,$lan){
	
		$latlng = $this->query("update {$this->useTable} set latlng = GeomFromText('POINT({$lat} {$lan})') where figure_id = '{$figureId}';");
		
	}
	
	
}
