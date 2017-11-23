<?php
App::uses('Component', 'Controller');
App::uses('HttpSocket', 'Network/Http');

class CommonComponent extends Component{
	
//	CONST ACCESS_MAKE_WORD_PRESS_USER_URL = "https://cranky-shinozaki.ssl-lolipop.jp/lt01/wpusermake.php";

	CONST ACCESS_MAKE_WORD_PRESS_USER_URL = "http://www.dev-yui.work/shinousermake.php";
	
	
	public function makeInputText($data){
	
		$pdata = "紹介者会員番号:" .  $data["YuiUser"]["introducer_no"] . PHP_EOL;
		$pdata .= "紹介者名:" .  $data["YuiUser"]["introducer_sei"] . " " . $this->request->data["YuiUser"]["introducer_mei"] . PHP_EOL;
		$pdata .= "郵便番号：" .  $data["YuiUser"]["zip_code1"] . "  " . $this->request->data["YuiUser"]["zip_code2"] . PHP_EOL;
		$pdata .= "都道府県:" .  $data["YuiUser"]["prefectures_name"] . PHP_EOL;
		$pdata .= "市区町村:" .  $data["YuiUser"]["city_name"] . PHP_EOL;
		$pdata .= "住所その他:" .  $data["YuiUser"]["street_address"] . PHP_EOL;
		$pdata .= "銀行コード:" .  $data["YuiUser"]["bank_code"] . PHP_EOL;
		$pdata .= "口座種別:" .  $data["YuiUser"]["bank_account_type"] . PHP_EOL;
		$pdata .= "支店番号（半角数字）:" .  $data["YuiUser"]["bank_branch_no"] . PHP_EOL;
		$pdata .= "口座番号（半角数字）:" .  $data["YuiUser"]["bank_account_no"] . PHP_EOL;
		$pdata .= "口座名義（漢字）:" .  $data["YuiUser"]["bank_account_name"] . PHP_EOL;
		$pdata .= "口座名義（全角カナ）:" .  $data["YuiUser"]["bank_account_name_kana"] . PHP_EOL;

		return $pdata;
	}
	
	public function makeWordpressUser($userTel,$userPass,$userMail,$entrySei,$entryMei,$entrySeiKana,$entryMeiKana,$zipCode,$prefectureName,$cityName,$streetAddress){
		
/*		name="member[name1]"
		name="member[name2]"
		name="member[name3]"
		name="member[name4]"
		name="member[zipcode]"
		name="member[country]"
		name="member[address1]"
		name="member[address2]"
		name="member[address3]"
		name="member[tel]"
		name="member[fax]"
		name="member[mailaddress1]"
		name="member[mailaddress2]"
		name="member[password1]"
		name="member[password2]" */
		
		
		
		
		
		$url = self::ACCESS_MAKE_WORD_PRESS_USER_URL;
		$data = array(
				
				'member[name1]' => $entrySei,
				'member[name2]' => $entryMei,
				'member[name3]' => $entrySeiKana, 
				'member[name4]' => $entryMeiKana,
				'member[tel]' => $userTel,
				'member[fax]' => "",
				'member[zipcode]' => $zipCode,
				'member[country]' => $prefectureName,
				'member[address1]' => $cityName,
				'member[address2]' => $streetAddress,
				'member[address3]' => "",
				'member[password1]' => $userPass,
				'member[password2]' => $userPass,
				'member[mailaddress1]' => $userMail,
				'member[mailaddress2]' => $userMail,
		);
		
		App::uses('HttpSocket', 'Network/Http');
		$HttpSocket = new HttpSocket();
		$response = $HttpSocket->post($url, $data);
		
		return $response->body;
		
	}
	
	function getPrefname($id){
		$preflist = array(
			"1" =>'北海道',
			"2" =>'青森県',
			"3" =>'岩手県',
			"4" =>'宮城県',
			"5" =>'秋田県',
			"6" =>'山形県',
			"7" =>'福島県',
			"8" =>'茨城県',
			"9" =>'栃木県',
			"10" =>'群馬県',
			"11" =>'埼玉県',
			"12" =>'千葉県',
			"13" =>'東京都',
			"14" =>'神奈川県',
			"15" =>'新潟県',
			"16" =>'富山県',
			"17" =>'石川県',
			"18" =>'福井県',
			"19" =>'山梨県',
			"20" =>'長野県',
			"21" =>'岐阜県',
			"22" =>'静岡県',
			"23" =>'愛知県',
			"24" =>'三重県',
			"25" =>'滋賀県',
			"26" =>'京都府',
			"27" =>'大阪府',
			"28" =>'兵庫県',
			"29" =>'奈良県',
			"30" =>'和歌山県',
			"31" =>'鳥取県',
			"32" =>'島根県',
			"33" =>'岡山県',
			"34" =>'広島県',
			"35" =>'山口県',
			"36" =>'徳島県',
			"37" =>'香川県',
			"38" =>'愛媛県',
			"39" =>'高知県',
			"40" =>'福岡県',
			"41" =>'佐賀県',
			"42" =>'長崎県',
			"43" =>'熊本県',
			"44" =>'大分県',
			"45" =>'宮崎県',
			"46" =>'鹿児島県',
			"47" =>'沖縄県',
		);
		
		return $preflist[$id];
	}
}

