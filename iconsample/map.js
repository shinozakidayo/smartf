/**
 * 
 */

google.maps.event.addDomListener(window, 'load', function()
{
    // BRISK の位置
    var briskLatLng = new google.maps.LatLng(35.68869, 139.814157);

    // オプションの指定
    var mapOptions = {
        zoom: 16,  // 地図の初期表示の拡大率
        center: briskLatLng, // 地図の中心点の座標（緯度・経度）
        mapTypeId: google.maps.MapTypeId.ROADMAP  // MAPタイプの指定
    };
    // MAPオブジェクトの作成
    var mapObj = new google.maps.Map(document.getElementById('bokkuru'), mapOptions);

    // MARKERイメージを作成
    markerImg = new google.maps.MarkerImage(
        "./bokkuru.png",  // アイコン画像のパス
        new google.maps.Size(50, 60),   // アイコン画像の表示させたい範囲（サイズ）
        new google.maps.Point(0, 0),    // アイコン画像の表示させたい範囲の基準点（左上）
        new google.maps.Point(25, 60),  // アイコン画像内のアンカー点の位置
        new google.maps.Size(50, 60)    // アイコン画像の実際の表示サイズ
    );

    // MARKERオブジェクトを作成
    markerObj = new google.maps.Marker({
        position: briskLatLng, // アイコンのアンカー点の緯度・経度
        map: mapObj,           // 上で作成したMAPオブジェクトを指定
        icon: markerImg        // 上で作成したMARKERイメージを指定
    });

    /*** スタイルに関しての設定 start ***/
    // 白黒用スタイル
    var stylez = [
    {
    featureType: "all",
    elementType: "all",
    stylers: [ { saturation: -100 } ] 
    }
    ];
    // スタイルをマップにセット
    var styledMapOptions = {
        map: mapObj,
        name: "bokkuru"
    }
    var styledMapType = new google.maps.StyledMapType(stylez,styledMapOptions);
    mapObj.mapTypes.set('mono', styledMapType);
    mapObj.setMapTypeId('mono');
    /*** スタイルに関しての設定 end ***/
});