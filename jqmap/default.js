/**
 * 
 */

// DOMを全て読み込んだあとに実行される
$(function () {
    // 「#execute」をクリックしたとき
    $('#execute').click(function () {
        // Ajax通信を開始する
        $.ajax({
            url: 'ajaxphp.php',
            type: 'post', // getかpostを指定(デフォルトは前者)
            dataType: 'json', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
            data: { // 送信データを指定(getの場合は自動的にurlの後ろにクエリとして付加される)
                age: $('#age').val(),
                job: $('#job').val(),
            },
        })
        // ・ステータスコードは正常で、dataTypeで定義したようにパース出来たとき
        .done(function (response) {
            $('#result').val('成功');
            $('#detail').val(response.data);
        })
        // ・サーバからステータスコード400以上が返ってきたとき
        // ・ステータスコードは正常だが、dataTypeで定義したようにパース出来なかったとき
        // ・通信に失敗したとき
        .fail(function () {
            $('#result').val('失敗');
            $('#detail').val('');
        });
    });
});