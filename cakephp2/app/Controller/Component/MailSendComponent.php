<?php
App::uses('CakeEmail','Network/Email');
App::uses('Component', 'Controller');

class MailSendComponent extends Component{
	
	public $components = array('Session');

	public function agency_honbu($inputText=""){
	
//		$Session = $this->Components->load('Session');
		
		$the_earth_id = $this->Session->read('the_earth_id');
		$entry_sei = $this->Session->read('entry_sei');
		$entry_mei = $this->Session->read('entry_mei');
		$email = $this->Session->read('email');
		$phone = $this->Session->read('phone');
		$entry_study_group_name = $this->Session->read('entry_study_group_name');
	
	
		$Email = new CakeEmail();
	
		$text = <<<EOT
{$entry_sei} {$entry_mei}様
	
このたびは、国際取引総合戦略研究所{$entry_study_group_name}の
活動代理店都道府県本部へお申し込みをいただき、
誠にありがとうございます。
	
以下のとおりお申し込みをお受けしました。
	
活動代理店の登録費用については、申込日より５日以内に入金のうえ、
下記URLの入金通知フォームよりご連絡をお願いいたします。
登録費用の入金が確認され次第、登録審査を開始いたします。
http://miyamoto-international-law.com/index.php?form-credit-advice
	
【払込取扱場所】
　金融機関名：みずほ銀行
　支店名：駒沢支店（店番号544）
　口座番号：普通　1059096
　名義人：宮本外国法事務弁護士事務所 宮本敏和
	
	
当研究部会の代理店登録が完了いたしましたら、ご連絡いたします。
	
	
今後とも国際取引総合戦略研究所をよろしくお願い申し上げます。
	
$inputText
	
入力内容を記載
	
	
----------------------------------
{$entry_sei} {$entry_mei}様が同意した規約は以下のとおりとなります。
----------------------------------
	
活動代理店都道府県本部規約
活動代理店都道府県本部取扱商品・サービス目録
活動代理店都道府県本部募集要項
	
	
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
	
※本Eメールは配信専用です。本Eメールアドレスに返信はできません。
※電話によるお問い合せは受け付けていません。
　お問い合わせは下記の【お問い合わせフォーム】よりご連絡ください。
（お問合せ先）：http://miyamoto-international-law.com/index.php?contactus
※本Eメールの無断転載・転用はご遠慮ください。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
	
※本Eメールの内容にお心当たりのない場合は、お手数ですが、
http://miyamoto-international-law.com/index.php?contactus　までご連絡ください。
	
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
	
宮本外国法事務弁護士事務所
国際取引総合戦略研究所
{$entry_study_group_name}
http://miyamoto-international-law.com/
	
EOT;
	
		$Email->from(array('shinozakidayo@nifty.com' => 'My Site'))
		->to('shinozakidayo@nifty.com')
		->subject('活動代理店都道府県本部の登録申し込み確認について')
		->send($text);
	
	}
	
	public function agency_area($inputText=""){
	
		$the_earth_id = $this->Session->read('the_earth_id');
		$entry_sei = $this->Session->read('entry_sei');
		$entry_mei = $this->Session->read('entry_mei');
		$email = $this->Session->read('email');
		$phone = $this->Session->read('phone');
		$entry_study_group_name = $this->Session->read('entry_study_group_name');
		
	
		$Email = new CakeEmail();
	
		$text = <<<EOT
{$entry_sei} {$entry_mei}様

このたびは、国際取引総合戦略研究所{$entry_study_group_name}の
活動代理店市区町村支部へお申し込みをいただき、
誠にありがとうございます。

以下のとおりお申し込みをお受けしました。

活動代理店の登録費用については、申込日より５日以内に入金のうえ、
下記URLの入金通知フォームよりご連絡をお願いいたします。
登録費用の入金が確認され次第、登録審査を開始いたします。
http://miyamoto-international-law.com/index.php?form-credit-advice

【払込取扱場所】
　金融機関名：みずほ銀行
　支店名：駒沢支店（店番号544）
　口座番号：普通　1059096
　名義人：宮本外国法事務弁護士事務所 宮本敏和


当研究部会の代理店登録が完了いたしましたら、ご連絡いたします。


今後とも国際取引総合戦略研究所をよろしくお願い申し上げます。

$inputText

入力内容を記載


----------------------------------
○○様が同意した規約は以下のとおりとなります。
----------------------------------

活動代理店市区町村支部規約
活動代理店市区町村支部取扱商品・サービス目録
活動代理店市区町村支部募集要項


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

※本Eメールは配信専用です。本Eメールアドレスに返信はできません。
※電話によるお問い合せは受け付けていません。
　お問い合わせは下記の【お問い合わせフォーム】よりご連絡ください。
（お問合せ先）：http://miyamoto-international-law.com/index.php?contactus
※本Eメールの無断転載・転用はご遠慮ください。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

※本Eメールの内容にお心当たりのない場合は、お手数ですが、
http://miyamoto-international-law.com/index.php?contactus　までご連絡ください。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

宮本外国法事務弁護士事務所
国際取引総合戦略研究所
{$entry_study_group_name}
http://miyamoto-international-law.com/
		
EOT;
	
		$Email->from(array('shinozakidayo@nifty.com' => 'My Site'))
		->to('shinozakidayo@nifty.com')
		->subject('活動代理店市区町村支部の登録申し込み確認について')
		->send($text);
	}


	public function contact(){
	
		$the_earth_id = $this->Session->read('the_earth_id');
		$entry_sei = $this->Session->read('entry_sei');
		$entry_mei = $this->Session->read('entry_mei');
		$email = $this->Session->read('email');
		$phone = $this->Session->read('phone');
	
	
		$Email = new CakeEmail();
	
		$text = <<<EOT

{$entry_sei} {$entry_mei}様

お問い合わせフォームより、お問い合わせをお受けいたしました。

お問い合わせ内容を確認の上、◯◯研究部会よりご回答いたします。

内容によってはご回答まで数日かかる場合やご回答いたしかねる
場合がございますので、ご了承ください。


今後とも国際取引総合戦略研究所をよろしくお願い申し上げます。


----------------------


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

※本Eメールは配信専用です。本Eメールアドレスに返信はできません。
※電話によるお問い合せは受け付けていません。
　お問い合わせは下記の【お問い合わせフォーム】よりご連絡ください。
（お問合せ先）：http://miyamoto-international-law.com/index.php?contactus
※本Eメールの無断転載・転用はご遠慮ください。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

※本Eメールの内容にお心当たりのない場合は、お手数ですが、
http://miyamoto-international-law.com/index.php?contactus　までご連絡ください。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

宮本外国法事務弁護士事務所
国際取引総合戦略研究所
◯◯研究部会
http://miyamoto-international-law.com/
		
EOT;
	
		$Email->from(array('shinozakidayo@nifty.com' => 'My Site'))
		->to('shinozakidayo@nifty.com')
		->subject('お問い合わせについて')
		->send($text);
	}

	public function contactNotice($title,$mainTxt){
	
		$the_earth_id = $this->Session->read('the_earth_id');
		$entry_sei = $this->Session->read('entry_sei');
		$entry_mei = $this->Session->read('entry_mei');
		$email = $this->Session->read('email');
		$phone = $this->Session->read('phone');
	
	
		$Email = new CakeEmail();
	
		$text = <<<EOT
	
{$entry_sei} {$entry_mei}様から問い合わせがありました

メールアドレス：$email
タイトル:{$title}
本文:
$mainTxt
		
EOT;
	
	$Email->from(array('shinozakidayo@nifty.com' => 'My Site'))
	->to('shinozakidayo@nifty.com')
	->subject('お問い合わせお知らせメール')
	->send($text);
	}
	
	
	

	public function payment(){
	
		$the_earth_id = $this->Session->read('the_earth_id');
		$entry_sei = $this->Session->read('entry_sei');
		$entry_mei = $this->Session->read('entry_mei');
		$email = $this->Session->read('email');
		$phone = $this->Session->read('phone');
	
	
		$Email = new CakeEmail();
	
		$text = <<<EOT
件名：【お知らせ】代理店登録費用の入金確認について

○○様

このたびは、国際取引総合戦略研究所◯◯研究部会の
代理店登録費用に関しまして、入金確認のご連絡を
いただき誠にありがとうございます。

入金通知フォームより、入金確認をお受けいたしました。


当研究部会の代理店登録が完了いたしましたら、改めてご連絡いたします。


今後とも国際取引総合戦略研究所をよろしくお願い申し上げます。


----------------------


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

※本Eメールは配信専用です。本Eメールアドレスに返信はできません。
※電話によるお問い合せは受け付けていません。
お問い合わせは下記の【お問い合わせフォーム】よりご連絡ください。
（お問合せ先）:http://miyamoto-international-law.com/index.php?contactus
※本Eメールの無断転載・転用はご遠慮ください。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

※本Eメールの内容にお心当たりのない場合は、お手数ですが、
http://miyamoto-international-law.com/index.php?contactus　までご連絡ください。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

宮本外国法事務弁護士事務所
国際取引総合戦略研究所
◯◯研究部会
http://miyamoto-international-law.com/		
EOT;
	
		$Email->from(array('shinozakidayo@nifty.com' => 'My Site'))
		->to('shinozakidayo@nifty.com')
		->subject('活動代理店都道府県本部の登録申し込み確認について')
		->send($text);
	}
	
	public function agency_introduction() {
		$the_earth_id = $this->Session->read('the_earth_id');
		$entry_sei = $this->Session->read('entry_sei');
		$entry_mei = $this->Session->read('entry_mei');
		$email = $this->Session->read('email');
		$phone = $this->Session->read('phone');
		
		
		$Email = new CakeEmail();
		
		$text = <<<EOT
件名：代理店紹介者の登録申し込み確認について

○○様

このたびは、国際取引総合戦略研究所◯◯研究部会の
代理店紹介者へお申し込みをいただき、誠にありがとうございます。

以下のとおりお申し込みをお受けしました。


当研究部会の代理店紹介者登録が完了いたしましたら、ご連絡いたします。


今後とも国際取引総合戦略研究所をよろしくお願い申し上げます。


----------お申込内容----------

入力内容を記載


----------------------------------
○○様が同意した規約は以下のとおりとなります。
----------------------------------

代理店紹介者規約
代理店紹介者募集要項


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

※本Eメールは配信専用です。本Eメールアドレスに返信はできません。
※電話によるお問い合せは受け付けていません。
　お問い合わせは下記の【お問い合わせフォーム】よりご連絡ください。
（お問合せ先）:http://miyamoto-international-law.com/index.php?contactus
※本Eメールの無断転載・転用はご遠慮ください。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

※本Eメールの内容にお心当たりのない場合は、お手数ですが、
http://miyamoto-international-law.com/index.php?contactus　までご連絡ください。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

宮本外国法事務弁護士事務所
国際取引総合戦略研究所
◯◯研究部会
http://miyamoto-international-law.com/
		
		
EOT;
	
		$Email->from(array('shinozakidayo@nifty.com' => 'My Site'))
		->to('shinozakidayo@nifty.com')
		->subject('活動代理店都道府県本部の登録申し込み確認について')
		->send($text);
		
	}
	

	public function judge_ng() {
		$the_earth_id = $this->Session->read('the_earth_id');
		$entry_sei = $this->Session->read('entry_sei');
		$entry_mei = $this->Session->read('entry_mei');
		$email = $this->Session->read('email');
		$phone = $this->Session->read('phone');
		$entry_study_group_name = $this->Session->read('entry_study_group_name');
		
	
	
		$Email = new CakeEmail();
	
		$text = <<<EOT
{$entry_sei} {$entry_mei}様

この度は、活動代理店◯◯◯◯にお申し込みいただき、
誠にありがとうございました。

お申込内容を審査したところ、
誠に残念ではございますが、
今回のご登録は見送らせていただきます。

審査に関するご質問に関しましては、下記URLの
お問い合わせフォームより、研究部会へご連絡ください。

【お問い合わせフォーム】
http://miyamoto-international-law.com/index.php?agency-contactus


今後とも、当研究部会をよろしくお願い申し上げます。


----------------------


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

※本Eメールは配信専用です。本Eメールアドレスに返信はできません。
※電話によるお問い合せは受け付けていません。
　お問い合わせは下記の【お問い合わせフォーム】よりご連絡ください。
（お問合せ先）:http://miyamoto-international-law.com/index.php?contactus
※本Eメールの無断転載・転用はご遠慮ください。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

※本Eメールの内容にお心当たりのない場合は、お手数ですが、
http://miyamoto-international-law.com/index.php?contactus　までご連絡ください。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

宮本外国法事務弁護士事務所
国際取引総合戦略研究所
{$entry_study_group_name}
http://miyamoto-international-law.com/
		
EOT;
	
		$Email->from(array('shinozakidayo@nifty.com' => 'My Site'))
		->to('shinozakidayo@nifty.com')
		->subject('活動代理店のお申込に関しまして')
		->send($text);
	
	}

	public function agency_honbu_judge_ok() {
		$the_earth_id = $this->Session->read('the_earth_id');
		$entry_sei = $this->Session->read('entry_sei');
		$entry_mei = $this->Session->read('entry_mei');
		$email = $this->Session->read('email');
		$phone = $this->Session->read('phone');
		$introducer_no = $this->Session->read('introducer_no');
		$disp_target = $this->Session->read('disp_target');
		
	
		$entry_study_group_name = $this->Session->read('entry_study_group_name');
	
	
	
		$Email = new CakeEmail();
	
		$text = <<<EOT

件名：

{$entry_sei} {$entry_mei}様

このたびは、国際取引総合戦略研究所{$entry_study_group_name}の
活動代理店都道府県本部へお申し込みをいただき、
誠にありがとうございます。

お申し込みいただいた情報と入金の確認が完了し、
登録を承認させていただきました。

活動代理店IDは下記の通りです。
×××××××××


ご不明な点がございましたら、{$entry_study_group_name}へ
お問い合わせください。

今後とも国際取引総合戦略研究所をよろしくお願い申し上げます。


----------------------


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

※本Eメールは配信専用です。本Eメールアドレスに返信はできません。
※電話によるお問い合せは受け付けていません。
　お問い合わせは下記の【お問い合わせフォーム】よりご連絡ください。
（お問合せ先）:http://miyamoto-international-law.com/index.php?contactus
※本Eメールの無断転載・転用はご遠慮ください。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

※本Eメールの内容にお心当たりのない場合は、お手数ですが、
http://miyamoto-international-law.com/index.php?contactus　までご連絡ください。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

宮本外国法事務弁護士事務所
国際取引総合戦略研究所
{$entry_study_group_name}
http://miyamoto-international-law.com/
		
EOT;
	
	$Email->from(array('shinozakidayo@nifty.com' => 'My Site'))
	->to('shinozakidayo@nifty.com')
	->subject('活動代理店都道府県本部の登録完了に関するお知らせ')
	->send($text);
	
	}

	public function agency_area_judge_ok() {
		$the_earth_id = $this->Session->read('the_earth_id');
		$entry_sei = $this->Session->read('entry_sei');
		$entry_mei = $this->Session->read('entry_mei');
		$email = $this->Session->read('email');
		$phone = $this->Session->read('phone');
		$introducer_no = $this->Session->read('introducer_no');
		
		$entry_study_group_name = $this->Session->read('entry_study_group_name');
		
	
	
		$Email = new CakeEmail();
	
		$text = <<<EOT
{$entry_sei} {$entry_mei}様

このたびは、国際取引総合戦略研究所{$entry_study_group_name}の
代理店紹介者へお申し込みをいただき、
誠にありがとうございます。

お申し込みいただいた情報の確認が完了し、
登録を承認させていただきました。

代理店紹介者IDは下記の通りです。
{$introducer_no}


ご不明な点がございましたら、{$entry_study_group_name}へ
お問い合わせください。

今後とも国際取引総合戦略研究所をよろしくお願い申し上げます。


----------------------


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

※本Eメールは配信専用です。本Eメールアドレスに返信はできません。
※電話によるお問い合せは受け付けていません。
　お問い合わせは下記の【お問い合わせフォーム】よりご連絡ください。
（お問合せ先）:http://miyamoto-international-law.com/index.php?contactus
※本Eメールの無断転載・転用はご遠慮ください。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

※本Eメールの内容にお心当たりのない場合は、お手数ですが、
http://miyamoto-international-law.com/index.php?contactus　までご連絡ください。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

宮本外国法事務弁護士事務所
国際取引総合戦略研究所
{$entry_study_group_name}
http://miyamoto-international-law.com/
		
EOT;
	
		$Email->from(array('shinozakidayo@nifty.com' => 'My Site'))
		->to('shinozakidayo@nifty.com')
		->subject('代理店紹介者の登録完了に関するお知らせ')
		->send($text);
	
	}

	public function introducer_person_judge_ok() {
		$the_earth_id = $this->Session->read('the_earth_id');
		$entry_sei = $this->Session->read('entry_sei');
		$entry_mei = $this->Session->read('entry_mei');
		$email = $this->Session->read('email');
		$phone = $this->Session->read('phone');
		$introducer_no = $this->Session->read('introducer_no');
	
		$entry_study_group_name = $this->Session->read('entry_study_group_name');
	
	
	
		$Email = new CakeEmail();
	
		$text = <<<EOT
{$entry_sei} {$entry_mei}様
	
このたびは、国際取引総合戦略研究所{$entry_study_group_name}の
代理店紹介者へお申し込みをいただき、
誠にありがとうございます。
	
お申し込みいただいた情報の確認が完了し、
登録を承認させていただきました。
	
代理店紹介者IDは下記の通りです。
{$introducer_no}
	
	
ご不明な点がございましたら、{$entry_study_group_name}へ
お問い合わせください。
	
今後とも国際取引総合戦略研究所をよろしくお願い申し上げます。
	
	
----------------------
	
	
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
	
※本Eメールは配信専用です。本Eメールアドレスに返信はできません。
※電話によるお問い合せは受け付けていません。
　お問い合わせは下記の【お問い合わせフォーム】よりご連絡ください。
（お問合せ先）:http://miyamoto-international-law.com/index.php?contactus
※本Eメールの無断転載・転用はご遠慮ください。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
	
※本Eメールの内容にお心当たりのない場合は、お手数ですが、
http://miyamoto-international-law.com/index.php?contactus　までご連絡ください。
	
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
	
宮本外国法事務弁護士事務所
国際取引総合戦略研究所
{$entry_study_group_name}
http://miyamoto-international-law.com/
	
EOT;
	
	$Email->from(array('shinozakidayo@nifty.com' => 'My Site'))
	->to('shinozakidayo@nifty.com')
	->subject('代理店紹介者の登録完了に関するお知らせ')
	->send($text);
	
	}

	public function provisional_registration($name,$to,$url) {
	
		$Email = new CakeEmail();
	
		$text = <<<EOT
この度は、「情報応用技術推進機構」にお申し込み頂きまして
誠にありがとうございます。

ご本人様確認のため、下記URLへアクセスし
アカウントの仮登録を完了させて下さい。
$url

※お使いのメールソフトによってはURLが途中で改行されることがあります。
　その場合は、最初の「http://」から末尾の英数字までをブラウザに
　直接コピー＆ペーストしてアクセスしてください。

※当メールは送信専用メールアドレスから配信されています。
　このままご返信いただいてもお答えできませんのでご了承ください。

※当メールに心当たりの無い場合は、誠に恐れ入りますが
　破棄して頂けますよう、よろしくお願い致します。
EOT;
	
	$Email->from(array('shinozakidayo@nifty.com' => '【情報応用技術推進機構】'))
	->to($to)
	->subject('【情報応用技術推進機構】メール確認')
	->send($text);
	
	}
	
	
	public function provisional_registration_next($to) {
	
		$Email = new CakeEmail();
	
		$text = <<<EOT
この度は、「情報応用技術推進機構」へ仮登録して頂きまして
誠にありがとうございます。

仮登録の内容を審査させていただきまして、
内容に不備がなければ本登録完了のメールを通知させていただきます。

審査に2～3営業日いただく場合がございますが、何卒ご了承くださいます
ようお願いいたします。

※当メールは送信専用メールアドレスから配信されています。
　このままご返信いただいてもお答えできませんのでご了承ください。

※当メールに心当たりの無い場合は、誠に恐れ入りますが
　破棄して頂けますよう、よろしくお願い致します。
EOT;

		$Email->from(array('shinozakidayo@nifty.com' => '【情報応用技術推進機構】'))
		->to($to)
		->subject('【情報応用技術推進機構】仮登録完了')
		->send($text);
	
	}
	
	
	
	public function resultNg($name=null,$to=null,$body=null,$url=null) {
	
		$Email = new CakeEmail();
	
		$text = <<<EOT

★登録情報不備による審査NG

件名：【情報応用技術推進機構】登録情報不備
本文：

この度は仮登録をしていただき、ありがとうございました。

登録して頂いた内容に不備があります。
以下、不備項目です。
{$body}

下記のURLへアクセスし、登録内容の修正をお願いいたします。
https://○○○/○○○

※当メールは送信専用メールアドレスから配信されています。
　このままご返信いただいてもお答えできませんのでご了承ください。

※当メールに心当たりの無い場合は、誠に恐れ入りますが
　破棄して頂けますよう、よろしくお願い致します。
EOT;
	
	$Email->from(array('norep@nifty.com' => '【情報応用技術推進機構】'))
	->to($to)
	->subject('【情報応用技術推進機構】登録情報不備')
	->send($text);
	
	}

	public function rejectNg($name=null,$to=null) {
	
		$Email = new CakeEmail();
	
		$text = <<<EOT
この度は仮登録をしていただき、ありがとうございました。

厳正なる審査の結果、誠に残念ではありますが、
今回は採用を見合わせていただくことになりました。

ご希望に添えず恐縮ですが、なにとぞご了承くださいますよう
お願い申し上げます。



※当メールは送信専用メールアドレスから配信されています。
　このままご返信いただいてもお答えできませんのでご了承ください。

※当メールに心当たりの無い場合は、誠に恐れ入りますが
　破棄して頂けますよう、よろしくお願い致します。
EOT;
	
	$Email->from(array('shinozakidayo@nifty.com' => '【情報応用技術推進機構】'))
	->to($to)
	->subject('【情報応用技術推進機構】本登録不採用通知')
	->send($text);
	
	}
	
	
	public function resultOk($name=null,$to=null,$tel=null) {
	
		$Email = new CakeEmail();
	
		$text = <<<EOT
「情報応用技術推進機構」本登録が完了いたしました。

アカウント情報は以下となります。

　ログインID：{$tel}
　パスワード：個人情報のため表示を伏せています

下記のURLへアクセスしログインを行ってください。
https://○○○/○○○


※当メールは送信専用メールアドレスから配信されています。
　このままご返信いただいてもお答えできませんのでご了承ください。

※当メールに心当たりの無い場合は、誠に恐れ入りますが
　破棄して頂けますよう、よろしくお願い致します。
EOT;
	
	$Email->from(array('shinozakidayo@nifty.com' => 'My Site'))
	->to($to)
	->subject('【情報応用技術推進機構】本登録採用通知')
	->send($text);
	
	}
	

	public function pita_provisional_registration($name,$to,$url) {
	
		$Email = new CakeEmail();
	
		$text = <<<EOT
この度は、クラブ会員に申し込み頂きまして
誠にありがとうございます。

ご本人様確認のため、下記URLへアクセスし
アカウントの仮登録を完了させて下さい。
$url
		
※お使いのメールソフトによってはURLが途中で改行されることがあります。
　その場合は、最初の「http://」から末尾の英数字までをブラウザに
　直接コピー＆ペーストしてアクセスしてください。

※当メールは送信専用メールアドレスから配信されています。
　このままご返信いただいてもお答えできませんのでご了承ください。

※当メールに心当たりの無い場合は、誠に恐れ入りますが
　破棄して頂けますよう、よろしくお願い致します。EOT;
EOT;

$Email->from(array('shinozakidayo@nifty.com' => 'Pita&Co'))
		->to($to)
		->subject('【クラブ会員】仮登録')
		->send($text);
	
	}
	

	public function pita_provisional_registration_next($to) {
	
		$Email = new CakeEmail();
	
		$text = <<<EOT
平素よりお世話になっています。

下記のとおり、クラブ登録の申し込みを受け付けました。

お申し込みいただいた入会金・年会費の費用は、
以下の指定口座へ3営業日以内にご入金いただくようお願いします。

ご入金いただいた後、弊社にて確認・審査を行い、5営業日前後で承認可否のメールを送信します。
ただし、お客様の登録情報不足や弊社の登録受付の混雑により、審査期間が延びる場合もあります。
なお、審査結果の理由については一切お答えできませんので、あらかじめご了承ください。


--------------------
振込先口座情報

会社名： ○○○○
　　　　　カ）カタカナ
銀行名： ○○○○
支店名： ○○○○
口座種類： 普通
口座番号： ○○○○

※3営業日以内のご入金をお願いいたします。

・入金通知URL
　https://www.bee-community.org/index.php?form-advice-of-credit
  ※FAXにて振込明細を送信される場合は、上記URLからの通知は不要です。

----------------------------------

※当メールは送信専用メールアドレスから配信されています。
　このままご返信いただいてもお答えできませんのでご了承ください。

※当メールに心当たりの無い場合は、誠に恐れ入りますが
　破棄して頂けますよう、よろしくお願い致します。
		
		
EOT;
	
		$Email->from(array('shinozakidayo@nifty.com' => 'Pita&Co'))
		->to($to)
		->subject('【クラブ会員】受付')
		->send($text);
	
	}
	

	public function pita_registration_jointventure($to) {
	
		$Email = new CakeEmail();
	
		$text = <<<EOT
この度は、「情報応用技術推進機構」へ仮登録して頂きまして
誠にありがとうございます。
	
仮登録の内容を審査させていただきまして、
内容に不備がなければ本登録完了のメールを通知させていただきます。
	
審査に2～3営業日いただく場合がございますが、何卒ご了承くださいます
ようお願いいたします。
	
※当メールは送信専用メールアドレスから配信されています。
　このままご返信いただいてもお答えできませんのでご了承ください。
	
※当メールに心当たりの無い場合は、誠に恐れ入りますが
　破棄して頂けますよう、よろしくお願い致します。
EOT;
	
		$Email->from(array('shinozakidayo@nifty.com' => 'Pita&Co'))
		->to($to)
		->subject('【共働事業者】受付')
		->send($text);
	
	}
	
	
	
}
