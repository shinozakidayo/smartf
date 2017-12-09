<?php

namespace Util;

class Geometry {
	
	/**
	 * ２地点間の距離(m)を求める
	 * ヒュベニの公式から求めるバージョン
	 *
	 * @param float $lat1 緯度１
	 * @param float $lon1 経度１
	 * @param float $lat2 緯度２
	 * @param float $lon2 経度２
	 * @param boolean $mode 測地系 true:世界 false:日本
	 * @return float 距離(m)
	 */
	function distance_a($lat1, $lon1, $lat2, $lon2, $mode=true)
	{
		// 緯度経度をラジアンに変換
		$radLat1 = deg2rad($lat1); // 緯度１
		$radLon1 = deg2rad($lon1); // 経度１
		$radLat2 = deg2rad($lat2); // 緯度２
		$radLon2 = deg2rad($lon2); // 経度２
	
		// 緯度差
		$radLatDiff = $radLat1 - $radLat2;
	
		// 経度差算
		$radLonDiff = $radLon1 - $radLon2;
	
		// 平均緯度
		$radLatAve = ($radLat1 + $radLat2) / 2.0;
	
		// 測地系による値の違い
		$a = $mode ? 6378137.0 : 6377397.155; // 赤道半径
		$b = $mode ? 6356752.314140356 : 6356078.963; // 極半径
		//$e2 = ($a*$a - $b*$b) / ($a*$a);
		$e2 = $mode ? 0.00669438002301188 : 0.00667436061028297; // 第一離心率^2
		//$a1e2 = $a * (1 - $e2);
		$a1e2 = $mode ? 6335439.32708317 : 6334832.10663254; // 赤道上の子午線曲率半径
	
		$sinLat = sin($radLatAve);
		$W2 = 1.0 - $e2 * ($sinLat*$sinLat);
		$M = $a1e2 / (sqrt($W2)*$W2); // 子午線曲率半径M
		$N = $a / sqrt($W2); // 卯酉線曲率半径
	
		$t1 = $M * $radLatDiff;
		$t2 = $N * cos($radLatAve) * $radLonDiff;
		$dist = sqrt(($t1*$t1) + ($t2*$t2));
	
		return $dist;
	}
	
	/**
	 * ２地点間の距離を求める
	 *   GoogleMapAPIのgeometory.computeDistanceBetweenのロジック
	 *   浮動小数点の精度が足りないためGoogleより桁数が少ないかもしれません
	 *
	 * @param float $lat1 緯度１
	 * @param float $lon1 経度１
	 * @param float $lat2 緯度２
	 * @param float $lon2 経度２
	 * @return float 距離(m)
	 */
	public static function google_distance($lat1, $lon1, $lat2, $lon2) {
		// 緯度経度をラジアンに変換
		$radLat1 = deg2rad($lat1); // 緯度１
		$radLon1 = deg2rad($lon1); // 経度１
		$radLat2 = deg2rad($lat2); // 緯度２
		$radLon2 = deg2rad($lon2); // 経度２
	
		$r = 6378137.0; // 赤道半径
	
		$averageLat = ($radLat1 - $radLat2) / 2;
		$averageLon = ($radLon1 - $radLon2) / 2;
		return $r * 2 * asin(sqrt(pow(sin($averageLat), 2) + cos($radLat1) * cos($radLat2) * pow(sin($averageLon), 2)));
	}
	
	// 測地線航海算法
	function distance_b($lat1, $lon1, $lat2, $lon2)
	{
		// 緯度経度をラジアンに変換
		$radLat1 = deg2rad($lat1); // 緯度１
		$radLon1 = deg2rad($lon1); // 経度１
		$radLat2 = deg2rad($lat2); // 緯度２
		$radLon2 = deg2rad($lon2); // 経度２
	
		$A = 6378137.0; // 赤道半径
		$B = 6356752.314140356; // 極半径
		// $F = ($A - $B) / $A;
		$F = 0.003352858356825; // 扁平率
	
		$BdivA = 0.99664714164317; // $B/$A
		$P1 = atan($BdivA) * tan($lat1);
		$P2 = atan($BdivA) * tan($lat2);
	
		$sd = acos(sin($P1)*sin($P2) + cos($P1)*cos($P2)*cos($lon1-$lon2));
	
		$cos_sd = cos($sd/2);
		$sin_sd = sin($sd/2);
		$c = (sin($sd) - $sd) * pow(sin($P1)+sin($P2),2) / $cos_sd / $cos_sd;
		$s = (sin($sd) + $sd) * pow(sin($P1)-sin($P2),2) / $sin_sd / $sin_sd;
		$delta = $F / 8.0 * ($c - $s);
	
		return $A * ($sd + $delta);
	}
}



