<?php
App::uses('AppModel', 'Model');

class FigureLatlngPosition extends AppModel {

    public $useTable = 'figure_latlng_positions'; // このモデルは「exmp」というデータベース・テーブルを使います
	
    var $virtualFields = array(
    		'lng' => 'X(latlng)',
    		'lat' => 'Y(latlng)'
    );
    
    public function insertgeom($figurePersonId,$lat,$lan){
    
//    	echo("insert into {$this->useTable}(figure_person_id,latlng)  values('{$figurePersonId}',GeomFromText('POINT({$lat} {$lan})'));");
    
    	$latlng = $this->query("insert into {$this->useTable}(figure_person_id,latlng,created,starttime)  values('{$figurePersonId}',GeomFromText('POINT({$lat} {$lan})'),now(),now());");
    
    	return true;
    }
    
/*    public function t(){
    	echo("test1");
    	$latlng = $this->query("insert into {$this->useTable}(figure_person_id,latlng)  values('1',GeomFromText('POINT(0.1 0.1)'));");
    	echo("test1");
    } */
    
    public function updategeom($figurePersonId,$lat,$lan){
    
    	$latlng = $this->query("update {$this->useTable} set latlng = GeomFromText('POINT({$lat} {$lan})'),modified = now(),starttime = now() where figure_person_id = '{$figurePersonId}';");
    
    	return true;
    }
}
