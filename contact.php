<?php


$mst = array(
	'comp'			=> '会社名',
	'comp_r'		=> '会社名（ふりがな）',
	'name'			=> 'お名前',
	'name_r'		=> 'お名前（ふりがな）',
	'email'			=> 'メールアドレス',
	'email_conf'	=> 'メールアドレス（確認）',
	'cont'			=> 'お問い合わせ内容',
	'tel'			=> '電話番号',
);

$form = $_POST;

$err		= array();
$must = array('email', 'name', 'cont');

foreach ($form as $pk => $pv) {
	if ($pk == 'mode' || $pk == 'urname') {
		continue;
	}
	#### 必須チェック


	if (!$form[$pk] && in_array($pk, $must)) {
		array_push($err, "<span class='red'>" . $mst[$pk] . "</span>の入力は必須です。");
	}
	if ($pk == 'email' || $pk == 'email_conf') {
		if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+\.([a-zA-Z0-9\._-]+)+$/", $form[$pk])) {
			array_push($err, "<span class='red'>メールアドレス</span>は、aa@bbbb.ccの形で入力してください。");
		}
	}
	if ($pk == 'email_conf' && ($form['email'] != $form['email_conf'])) {
		array_push($err, "<span class='red'>メールアドレス（確認）</span>が一致しません。");
	}
	if ($pk == 'tel' && $form['tel'] && (strlen($form['tel']) > 13 || !mb_ereg("[0-9-]+", $form['tel']))) {
		array_push($err, "<span class='red'>電話番号</span>は、13文字以内で数字とハイフンで入力してください。");
	}
	if ($pk == 'cont') {
		if (strlen($pv) > 9000) {
			array_push($err, "<span class='red'>お問い合わせ内容</span>は、3000文字以内で入力してください。");
		}
	}
	if ($pk == 'name_r') {
		if (!preg_match('/^[ぁ-ん ー　 ]+$/u', $form[$pk])) {
			array_push($err, "<span class='red'>お名前ふりがな</span>はひらがなで入力してください。");
		}
	}
	if ($pk == 'comp_r') {
		if (!preg_match('/^[ぁ-ん ー　 ]+$/u', $form[$pk])) {
			array_push($err, "<span class='red'>会社名ふりがな</span>はひらがなで入力してください。");
		}
	}
}


if (count($_POST) < 1 || count($err) > 0) {
	echo getHTML($form, $err);
} elseif ($_POST['mode'] ==  'sendmail') {
	sendEntryMail($mst);
	echo getHTML_Thx($form, $mst);
} else {
	echo getHTML_Confirm($form);
}




function getHTML($form, $err)
{


	$html .= <<<HTML
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="email=no,telephone=no,address=no">
  <title>お問い合わせ | 株式会社スリーアップバランス</title>
  <meta name="description" content="株式会社スリーアップバランスのお問い合わせフォームです。スリーアップバランスは関東エリア全域に対応した荷揚げ屋です。様々な建設現場の資材搬入出・荷揚げ・手元作業などを請け負います。" />
  <!-- ogp start -->
  <meta property="og:url" content="https://www.3upbalance.jp/contact.php" />
  <meta property="og:type" content="article" />
  <meta property="og:title" content="お問い合わせ | 株式会社スリーアップバランス" />
  <meta property="og:description" content="株式会社スリーアップバランスのお問い合わせフォームです。スリーアップバランスは関東エリア全域に対応した荷揚げ屋です。様々な建設現場の資材搬入出・荷揚げ・手元作業などを請け負います。" />
  <meta property="og:site_name" content="株式会社スリーアップバランス" />
  <meta property="og:image" content="https://www.3upbalance.jp/assets/img/ogp.jpg" />
  <!-- //ogp end -->
  <meta name="twitter:card" content="summary_large_image">
  <link rel="shortcut icon" href="./assets/img/favicon.ico">
  <link rel="apple-touch-icon-precomposed" href="./assets/img/apple-touch-icon.png" />
  <link rel="stylesheet" href="./assets/css/style.css" />
</head>
<body>
	<!-- header start -->
  <header class="l-Header">
    <div class="l-Header__container">
      <h1 class="l-Header__logo">
        <a href="./index.html" class="l-Header__logoLink">
          <img src="./assets/img/logo_3up.png" alt="株式会社スリーアップバランス" width="800" height="120">
        </a>
      </h1>
      <nav class="l-HeaderNav">
        <ul class="l-HeaderNav__list">
          <li class="l-HeaderNav__item"><a href="./index.html">TOP</a></li>
          <li class="l-HeaderNav__item"><a href="./company.html">会社概要</a></li>
          <li class="l-HeaderNav__item"><a href="./recruit.html">採用情報</a></li>
          <li class="l-HeaderNav__contact"><a href="./contact.php">お問い合わせ</a></li>
        </ul>
      </nav>
      <!-- ハンバーガーメニュー -->
      <div class="l-BurgerButton">
        <div class="l-BurgerButton__lineGroup">
          <span class="l-BurgerButton__line"></span>
        </div>
      </div>
    </div>
    <div class="l-NavOverlay"></div>
  </header>
  <!-- //header end -->

	<!-- main start -->
	<main>
		<div class="c-PageTitle">
      <div class="c-PageTitle__container">
        <h1 class="c-PageTitle__txt">お問い合わせ</h1>
      </div>
    </div>
		<div class="l-PageContent">
			<div class="l-Container">
				<section class="TelSection">
					<h2 class="TelSection__title">お電話でのお問い合わせ</h2>
					<a href="tel:03-6277-6014" class="TelSection__numberLink">
						<span class="TelSection__number">03-6277-6014</span>
					</a>
				</section>
				<section class="MailSection">
					<div class="c-SectionTitle">
						<div class="c-SectionTitle__en">Contact</div>
						<h2 class="c-SectionTitle__ja">メールでのお問い合わせ</h2>
					</div>
					<div class="MailSection__body">
						<div class="ErrorTextWrap">
HTML;
	if (count($err) > 0) {
		$html .= <<<HTML
				<span class="red">■■　入力のエラーがございました。■■</span><br />
HTML;
		foreach ($err as $ek => $ev) {
			$html .= <<<HTML
						{$ev}<br />
HTML;
		}
	}
	$html .= <<<HTML
						</div>

						<form method="POST" action="./contact.php">
							<table class="FormTable">
								<tr>
									<th class="required">メールアドレス</th>
									<td><input type="text" name="email" value="{$form['email']}" maxlength="200"></td>
								</tr>
								<tr>
									<th>会社名</th>
									<td><input type="text" name="comp" value="{$form['comp']}"　maxlength="200"></td>
								</tr>
								<tr>
									<th class="required">お名前</th>
									<td><input type="text" name="name" value="{$form['name']}" maxlength="200"></td>
								</tr>
								<tr>
									<th>電話番号</th>
									<td><input type="text" name="tel" value="{$form['tel']}" maxlength="200"></td>
								</tr>
								<tr>
									<th class="required">お問い合わせ内容</th>
									<td><textarea name="cont" id="cont" maxlength="3000">{$form['cont']}</textarea><p>※3,000文字以内</p></td>
								</tr>
							</table>
							<ul class="FormButtonList">
								<li class="FormButtonList__item">
									<button class="c-Button FormButtonList__button" type="submit">
										入力内容を確認する
										<svg class="c-Button__arrow">
                			<use xlink:href="./assets/img/shapes.svg#icon-arrow" />
              			</svg>
									</button>
								</li>
							</ul>
						</form>
					</div>
				</section>
			</div> <!-- //l-Container -->
		</div> <!-- //l-PageContent -->
	</main>
	<!-- //main end -->

	<!-- footer start -->
	<footer class="l-Footer">
    <div class="l-Footer__navArea">
      <div class="l-Container">
        <ul class="l-Footer__nav">
          <li><a href="./" class="l-Footer__navLink">TOP</a></li>
          <li><a href="./company.html" class="l-Footer__navLink">会社概要</a></li>
          <li><a href="./recruit.html" class="l-Footer__navLink">採用情報</a></li>
          <li><a href="./contact.php" class="l-Footer__navLink">お問い合わせ</a></li>
        </ul>
      </div>
    </div>
    <div class="l-Footer__copyrightArea">
      <p class="l-Footer__copyright">Copyright &copy; Three Up Balance All Rights Reserved.</p>
    </div>
  </footer>
  <!-- //footer end -->

	<!-- JavaScript -->
	<script type="text/javascript" src="./assets/js/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="./assets/js/common.js"></script>

</body>
</html>
HTML;


	return $html;
}
function getHTML_Confirm($form)
{


	$cont = mb_ereg_replace("\n", "<br />", $form['cont']);

	$html .= <<<HTML
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="email=no,telephone=no,address=no">
  <title>お問い合わせ | 株式会社スリーアップバランス</title>
  <meta name="description" content="株式会社スリーアップバランスのお問い合わせフォームです。スリーアップバランスは関東エリア全域に対応した荷揚げ屋です。様々な建設現場の資材搬入出・荷揚げ・手元作業などを請け負います。" />
  <!-- ogp start -->
  <meta property="og:url" content="https://www.3upbalance.jp/contact.php" />
  <meta property="og:type" content="article" />
  <meta property="og:title" content="お問い合わせ | 株式会社スリーアップバランス" />
  <meta property="og:description" content="株式会社スリーアップバランスのお問い合わせフォームです。スリーアップバランスは関東エリア全域に対応した荷揚げ屋です。様々な建設現場の資材搬入出・荷揚げ・手元作業などを請け負います。" />
  <meta property="og:site_name" content="株式会社スリーアップバランス" />
  <meta property="og:image" content="https://www.3upbalance.jp/assets/img/ogp.jpg" />
  <!-- //ogp end -->
  <meta name="twitter:card" content="summary_large_image">
  <link rel="shortcut icon" href="./assets/img/favicon.ico">
  <link rel="apple-touch-icon-precomposed" href="./assets/img/apple-touch-icon.png" />
  <link rel="stylesheet" href="./assets/css/style.css" />
</head>
<body>
		<!-- header start -->
		<header class="l-Header">
    <div class="l-Header__container">
      <h1 class="l-Header__logo">
        <a href="./index.html" class="l-Header__logoLink">
          <img src="./assets/img/logo_3up.png" alt="株式会社スリーアップバランス" width="800" height="120">
        </a>
      </h1>
      <nav class="l-HeaderNav">
        <ul class="l-HeaderNav__list">
          <li class="l-HeaderNav__item"><a href="./index.html">TOP</a></li>
          <li class="l-HeaderNav__item"><a href="./company.html">会社概要</a></li>
          <li class="l-HeaderNav__item"><a href="./recruit.html">採用情報</a></li>
          <li class="l-HeaderNav__contact"><a href="./contact.php">お問い合わせ</a></li>
        </ul>
      </nav>
      <!-- ハンバーガーメニュー -->
      <div class="l-BurgerButton">
        <div class="l-BurgerButton__lineGroup">
          <span class="l-BurgerButton__line"></span>
        </div>
      </div>
    </div>
    <div class="l-NavOverlay"></div>
  </header>
  <!-- //header end -->

	<main class="">
		<div class="c-PageTitle">
      <div class="c-PageTitle__container">
        <h1 class="c-PageTitle__txt">お問い合わせ</h1>
      </div>
    </div>
		<div class="l-PageContent">
			<div class="l-Container">
				<section class="MailSection">
					<div class="c-SectionTitle">
						<div class="c-SectionTitle__en">Contact</div>
						<h2 class="c-SectionTitle__ja">メールでのお問い合わせ</h2>
					</div>
					<div class="MailSection__body">
						<form method="POST" action="./contact.php" class="">
									<table class="FormTable -confirm">
										<tr>
											<th class="required">メールアドレス</th>
											<td>{$form['email']}</td>
										</tr>
										<tr>
											<th>会社名</th>
											<td>{$form['comp']}</td>
										</tr>
										<tr>
											<th class="required">お名前</th>
											<td>{$form['name']}</td>
										</tr>
										<tr>
											<th>電話番号</th>
											<td>{$form['tel']}</td>
										</tr>
										<tr>
											<th class="required">お問い合わせ内容</th>
											<td>{$cont}</td>
										</tr>
									</table>
							<ul class="FormButtonList -confirm">
								<li class="FormButtonList__item">
									<button class="c-Button FormButtonList__button -revise" type="submit" onClick="history.back(); return false;" >
									内容を修正する
										<svg class="c-Button__arrow">
                			<use xlink:href="./assets/img/shapes.svg#icon-arrow" />
              			</svg>
									</button>
								</li>
								<li class="FormButtonList__item -send">
									<button class="c-Button FormButtonList__button" type="submit">
									送信する
										<svg class="c-Button__arrow">
                			<use xlink:href="./assets/img/shapes.svg#icon-arrow" />
              			</svg>
									</button>
								</li>
							</ul>

HTML;
	foreach ($form as $k => $v) {
		$html .= <<<HTML
							<input type="hidden" name="{$k}" value="{$v}">
HTML;
	}
	$html .= <<<HTML
							<input type="hidden" name="mode" value="sendmail">

						</form>
			</section>
			</div>
			</div>
		</main>

		<!-- footer start -->
	<footer class="l-Footer">
    <div class="l-Footer__navArea">
      <div class="l-Container">
        <ul class="l-Footer__nav">
          <li><a href="./" class="l-Footer__navLink">TOP</a></li>
          <li><a href="./company.html" class="l-Footer__navLink">会社概要</a></li>
          <li><a href="./recruit.html" class="l-Footer__navLink">採用情報</a></li>
          <li><a href="./contact.php" class="l-Footer__navLink">お問い合わせ</a></li>
        </ul>
      </div>
    </div>
    <div class="l-Footer__copyrightArea">
      <p class="l-Footer__copyright">Copyright &copy; Three Up Balance All Rights Reserved.</p>
    </div>
  </footer>
  <!-- //footer end -->

	<!-- JavaScript -->
	<script type="text/javascript" src="./assets/js/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="./assets/js/common.js"></script>

</body>
</html>
HTML;


	return $html;
}

function getHTML_Thx($form, $mst)
{


	$form = $_POST;
	$html .= <<<HTML
	<!DOCTYPE html>
	<html lang="ja">
	<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="email=no,telephone=no,address=no">
  <title>お問い合わせ | 株式会社スリーアップバランス</title>
  <meta name="description" content="株式会社スリーアップバランスのお問い合わせフォームです。スリーアップバランスは関東エリア全域に対応した荷揚げ屋です。様々な建設現場の資材搬入出・荷揚げ・手元作業などを請け負います。" />
  <!-- ogp start -->
  <meta property="og:url" content="https://www.3upbalance.jp/contact.php" />
  <meta property="og:type" content="article" />
  <meta property="og:title" content="お問い合わせ | 株式会社スリーアップバランス" />
  <meta property="og:description" content="株式会社スリーアップバランスのお問い合わせフォームです。スリーアップバランスは関東エリア全域に対応した荷揚げ屋です。様々な建設現場の資材搬入出・荷揚げ・手元作業などを請け負います。" />
  <meta property="og:site_name" content="株式会社スリーアップバランス" />
  <meta property="og:image" content="https://www.3upbalance.jp/assets/img/ogp.jpg" />
  <!-- //ogp end -->
  <meta name="twitter:card" content="summary_large_image">
  <link rel="shortcut icon" href="./assets/img/favicon.ico">
  <link rel="apple-touch-icon-precomposed" href="./assets/img/apple-touch-icon.png" />
  <link rel="stylesheet" href="./assets/css/style.css" />
</head>
	<body>
				<!-- header start -->
				<header class="l-Header">
    <div class="l-Header__container">
      <h1 class="l-Header__logo">
        <a href="./index.html" class="l-Header__logoLink">
          <img src="./assets/img/logo_3up.png" alt="株式会社スリーアップバランス" width="800" height="120">
        </a>
      </h1>
      <nav class="l-HeaderNav">
        <ul class="l-HeaderNav__list">
          <li class="l-HeaderNav__item"><a href="./index.html">TOP</a></li>
          <li class="l-HeaderNav__item"><a href="./company.html">会社概要</a></li>
          <li class="l-HeaderNav__item"><a href="./recruit.html">採用情報</a></li>
          <li class="l-HeaderNav__contact"><a href="./contact.php">お問い合わせ</a></li>
        </ul>
      </nav>
      <!-- ハンバーガーメニュー -->
      <div class="l-BurgerButton">
        <div class="l-BurgerButton__lineGroup">
          <span class="l-BurgerButton__line"></span>
        </div>
      </div>
    </div>
    <div class="l-NavOverlay"></div>
  </header>
  <!-- //header end -->
			<main>
			<div class="c-PageTitle">
      <div class="c-PageTitle__container">
        <h1 class="c-PageTitle__txt">お問い合わせ</h1>
      </div>
    </div>
		<div class="l-PageContent">
			<div class="l-Container">
				<section class="ThanksSection">
				<div class="c-SectionTitle">
						<h2 class="c-SectionTitle__ja">お問い合わせ完了</h2>
					</div>
					<div class="ThanksSection__textWrap">
						<p>
						お問い合わせ、誠にありがとうございます。<br>
						<br>
							担当者より随時返信いたします。<br>
							お問い合わせの内容により回答に時間がかかる場合がございますので、ご了承ください。
						</p>
					</div>
				</section>
			</div>
			</div>
			</main>

			<!-- footer start -->
	<footer class="l-Footer">
    <div class="l-Footer__navArea">
      <div class="l-Container">
        <ul class="l-Footer__nav">
          <li><a href="./" class="l-Footer__navLink">TOP</a></li>
          <li><a href="./company.html" class="l-Footer__navLink">会社概要</a></li>
          <li><a href="./recruit.html" class="l-Footer__navLink">採用情報</a></li>
          <li><a href="./contact.php" class="l-Footer__navLink">お問い合わせ</a></li>
        </ul>
      </div>
    </div>
    <div class="l-Footer__copyrightArea">
      <p class="l-Footer__copyright">Copyright &copy; Three Up Balance All Rights Reserved.</p>
    </div>
  </footer>
  <!-- //footer end -->

	<!-- JavaScript -->
	<script type="text/javascript" src="./assets/js/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="./assets/js/common.js"></script>

	</body>
	</html>
HTML;

	return $html;
}
function sendEntryMail($mst)
{

	$mail .= <<<HTML
{$_POST['comp']}
{$_POST['name']}様


この度は、株式会社スリーアップバランスへのお問い合わせありがとうございました。

下記の通り承りました。
---------

HTML;
	foreach ($_POST as $pk => $pv) {

		if ($pk == 'mode' || $pk == 'email_conf') {
			continue;
		}
		$mail .= <<<HTML
{$mst[$pk]}: 	{$pv}

HTML;
	}
	$mail .= <<<HTML
---------


ご返信を差し上げます。いましばらくお待ちいただければと存じます。

===============================
株式会社スリーアップバランス
y.mikami@three-up-balance.com

〒1070052
東京都港区赤坂4丁目5番21
===============================

HTML;

	mb_language("Japanese");
	mb_internal_encoding("UTF-8");


	$mailto = $_POST['email'];  //宛先メールアドレス
	$subject = "【株式会社スリーアップバランス】お問い合わせありがとうございます。";
	$headers = "From: y.mikami@three-up-balance.com";
	$headers .= "\r\n";
	$headers .= "Bcc: y.mikami@three-up-balance.com";


	if (mb_send_mail($mailto, $subject, $mail, $headers)) {
		//	echo "送信成功";
	} else {
		//	echo "送信失敗";
	}
}
