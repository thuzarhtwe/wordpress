/**
 * smoothUp.js
 *
 */
// スピードなどの設定
var options = {
	pageTopBtn : 'pagetop', // トップへ戻るボタンのID名（”名”のみで＃はつけない）
	showScroll : 200, // ボタンの出現するスクロール位置 PX単位
	scrollSpeed : 10, //早い→5　普通→10 ゆっくり→20
	fadeSpeed : 10 // 早い 5 〜 30 ゆっくり
};

window.onload = function() {

	var btn = document.getElementById(options.pageTopBtn) ;

	// ページトップへ戻るアニメーション
	var scroll_timer;
	function pageTop(x, y) {
		if (y >= 1) {
			var scTop = Math.floor(y - (y / (options.scrollSpeed * 2)));
			window.scrollTo(x, scTop);
			scroll_timer = setTimeout(function(){pageTop(x, scTop);}, options.scrollSpeed);
			// ↑ y の値が1以下になるまで 少しの数値分だけスクロールアップするのを
			// scrollSpeed の設定時間ごとに繰り返す
		} else {
			clearTimeout(scroll_timer);
			// ↑ y の値が1以下になったらタイマーを止めて数値を引くのをやめる
			window.scrollTo(x, 0);
		}
	}

	// フェイドインアニメーション設定
	var fadeIn_timer;
	function fadeInTimer(opaValue){
		if (opaValue < 1) {
			opaValue = opaValue + 0.05;
			btn.style.filter = "alpha(opacity:"+(opaValue*100)+")";
			btn.style.opacity = opaValue;
			fadeIn_timer = setTimeout(function(){fadeInTimer(opaValue);}, options.fadeSpeed);
			// ↑opaValue が1になるまで透明度を 0.05 ずつ足して行くのを
			//  fadeSpeed に設定された時間毎に繰り返す
		} else {
			clearTimeout(fadeIn_timer);
			// ↑opaValue が1になったら繰り返し処理を止める
			btn.style.filter = "alpha(opacity:100)";
			btn.style.opacity = 1;
		}
	}

	// フェイドアウトアニメーション設定
	var fadeOut_timer;
	function fadeOutTimer(opaValue){
		if ( opaValue >= 0.05) {
			opaValue = opaValue - 0.05;
			btn.style.filter = "alpha(opacity:"+(opaValue*100)+")";
			btn.style.opacity = opaValue;
			fadeOut_timer = setTimeout(function(){ fadeOutTimer(opaValue); }, options.fadeSpeed);
			// opaValue が1になるまで透明度を 0.05 ずつ引いて行くのを
			//  fadeSpeed に設定された時間毎に繰り返す
		} else {
			clearTimeout(fadeIn_timer);
			// ↑ opaValue が0.05以下になったら繰り返し処理を止めて
			// 完全な0にしておく（↓）
			btn.style.filter = "alpha(opacity:0)";
			btn.style.opacity = 0;
		}
	}

	// スクロールイベント
	btn.style.opacity = 0;
	btn.style.filter = "alpha(opacity:0)";
	window.onscroll = function() {
		var winSc = document.body.scrollTop || document.documentElement.scrollTop;
		var opaValue;
		if(winSc >= options.showScroll){
			clearTimeout(fadeOut_timer);
			opaValue = parseFloat(btn.style.opacity);
			fadeInTimer(opaValue);
		} else {
			clearTimeout(fadeIn_timer);
			opaValue = parseFloat(btn.style.opacity);
			fadeOutTimer(opaValue);
		}
	};

	// クリックイベント
	btn.onclick = function() {
		// 現在のスクロール位置を取得する
		var x = document.body.scrollLeft || document.documentElement.scrollLeft;
		var y = document.body.scrollTop  || document.documentElement.scrollTop;
		// スクロール位置を pageTop() 関数へ渡して呼び出す
		pageTop(x, y);
		return false;
	};
};
