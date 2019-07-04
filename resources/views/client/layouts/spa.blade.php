@php
	$isTamtem = (strpos($_SERVER['HTTP_HOST'], 'tamtem.ru') !== false);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	@if ($isTamtem)
	<!-- BING -->
	<meta name="msvalidate.01" content="098E721FA39EE921AB523C90E10C8C44" />
	<!-- END BING -->
	@endif

	<!-- Meta data -->
	<meta name="title" content="TamTem">
	<meta name="keywords" content="TamTem, купить, продать">
	<meta name="description" content="ТамТем - Сервис объявлений для Вашего бизнеса. Самый простой способ найти поставщика или продать товар">

	<link rel="image_src" href="{{ url('/') }}/images/image-site.jpg">
	<meta name="author" content="TamTem">
	<meta name="copyright" content="© ООО «Акстек», 2019 ОГРН 1187847338920">
	<meta name="application-name" content="TamTem">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="{{ url('/') }}">
	<meta property="og:title" content="TamTem">
	<meta property="og:image" content="{{ url('/') }}/images/image-site.jpg">
	<meta property="og:url" content="{{ url('/') }}">
	<meta property="og:description" content="ТамТем - Сервис объявлений для Вашего бизнеса. Самый простой способ найти поставщика или продать товар">
	<title>TamTem</title>

	<!-- Icon -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{ url('/') }}/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ url('/') }}/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ url('/') }}/favicon-16x16.png">
	<link rel="manifest" href="{{ url('/') }}/site.webmanifest">
	<link rel="mask-icon" href="{{ url('/') }}/safari-pinned-tab.svg" color="#0071bc">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="theme-color" content="#ffffff">

	<!-- Scripts -->
	<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript" defer></script>
	<script src="{{ mix('js/manifest.js') }}" defer></script>
	<script src="{{ mix('js/vendor.js') }}" defer></script>
	<script src="{{ mix('js/client.js') }}" defer></script>

	<!-- Styles -->
	<link href="{{ mix('css/client.css') }}" rel="stylesheet">
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>
<body>

	<noscript>
		<strong>We're sorry but vue-admin-lte-template doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
	</noscript>

	<div id="app"></div>
	
	<!-- Analytics and metrics -->
	@if ($isTamtem)
		<script>
			(function(w, d, s, h, id) {
				w.roistatProjectId = id; w.roistatHost = h;
				var p = d.location.protocol == "https:" ? "https://" : "http://";
				var u = /^.*roistat_visit=[^;]+(.*)?$/.test(d.cookie) ? "/dist/module.js" : "/api/site/1.0/"+id+"/init";
				var js = d.createElement(s); js.charset="UTF-8"; js.async = 1; js.src = p+h+u; var js2 = d.getElementsByTagName(s)[0]; js2.parentNode.insertBefore(js, js2);
			})(window, document, 'script', 'cloud.roistat.com', 'bf635993b8bf1ca6016f44b45de024cd');
		</script>

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-141180310-1"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-141180310-1');
		</script>
		<!-- END Global site tag (gtag.js) - Google Analytics -->
		
		<!-- Top100 (Kraken) Counter -->
		<script>
			(function (w, d, c) {
			(w[c] = w[c] || []).push(function() {
				var options = {
					project: 6658962,
				};
				try {
					w.top100Counter = new top100(options);
				} catch(e) { }
			});
			var n = d.getElementsByTagName("script")[0],
			s = d.createElement("script"),
			f = function () { n.parentNode.insertBefore(s, n); };
			s.type = "text/javascript";
			s.async = true;
			s.src =
			(d.location.protocol == "https:" ? "https:" : "http:") +
			"//st.top100.ru/top100/top100.js";
			if (w.opera == "[object Opera]") {
			d.addEventListener("DOMContentLoaded", f, false);
		} else { f(); }
		})(window, document, "_top100q");
		</script>
		<noscript>
		<img src="//counter.rambler.ru/top100.cnt?pid=6658962" alt="Топ-100" />
		</noscript>
		<!-- END Top100 (Kraken) Counter -->

		<!-- Yandex.Metrika counter -->
		<script type="text/javascript" >
		(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
		m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
		(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

		ym(53902132, "init", {
			clickmap:true,
			trackLinks:true,
			accurateTrackBounce:true
		});
		window.ym = ym
		window.ym(53902132, "reachGoal", "main_page");
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/53902132" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->

		<!-- Rating@Mail.ru counter -->
		<script type="text/javascript">
		var _tmr = window._tmr || (window._tmr = []);
		_tmr.push({id: "3125531", type: "pageView", start: (new Date()).getTime()});
		(function (d, w, id) {
		if (d.getElementById(id)) return;
		var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
		ts.src = "https://top-fwz1.mail.ru/js/code.js";
		var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
		if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
		})(document, window, "topmailru-code");
		</script><noscript><div>
		<img src="https://top-fwz1.mail.ru/counter?id=3125531;js=na" style="border:0;position:absolute;left:-9999px;" alt="Top.Mail.Ru" />
		</div></noscript>
		<!-- //Rating@Mail.ru counter -->
	@endif
	<!-- END Analytics and metrics -->
	
</body>
</html>
