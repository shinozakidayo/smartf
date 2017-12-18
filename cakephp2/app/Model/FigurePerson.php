<?php
App::uses('Operator', 'Model');

class FigurePerson extends AppModel {
	// example_idは データベースのフィールド名
	public $useTable = 'figure_persons'; // このモデルは「figure_persons」というデータベース・テーブルを使います
	
	public $hasOne = array(
			'FigereLatlngLocationStart' => array(
					'className' => 'FigereLatlngLocationStart',
			),
			'FigereLatlngLocationTarget' => array(
					'className' => 'FigereLatlngLocationTarget',
			),
			'FigureLatlngPosition' => array(
					'className' => 'FigureLatlngPosition',
			)
	);
	
	function beforeFind($queryData) {
		
		// ここでバーチャルフィールドに別名つけないと正常に動作しない、ただモデルのコンストラクタに書く方法も試したい
		// ただbeforeSelectはアソシエーション側に書いても動作しない
		$this->FigereLatlngLocationStart->virtualFields = array(
				'lng' => 'X(FigereLatlngLocationStart.latlng)',
				'lat' => 'Y(FigereLatlngLocationStart.latlng)',
				'now' => 'NOW()'
		);
		$this->FigereLatlngLocationTarget->virtualFields = array(
				'lng' => 'X(FigereLatlngLocationTarget.latlng)',
				'lat' => 'Y(FigereLatlngLocationTarget.latlng)'
		);
		$this->FigureLatlngPosition->virtualFields = array(
				'lng' => 'X(FigureLatlngPosition.latlng)',
				'lat' => 'Y(FigureLatlngPosition.latlng)'
		);
		
		return true;
	}
}
