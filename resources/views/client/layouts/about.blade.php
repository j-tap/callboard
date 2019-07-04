<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title>Добро пожаловать</title>
	<!-- <base href=""> -->
    <link rel="stylesheet" href="{{asset('css/main.css')}}" />
	    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    <header class="header">
      <div class="container container-header">
		  <a href="/" class="logo">
			<img src="/img/logo.svg" alt="" class="logo" />
		  </a>

        <ul class="nav desktop-nav">
          <li class="nav-elem">
            <a href="/" class="nav-elem-link">Главная</a>
          </li>
		  <li class="nav-elem">
            <a href="#second" class="nav-elem-link">Преимущества</a>
          </li>
          <li class="nav-elem">
            <a href="#third" class="nav-elem-link">Как это работает</a>
          </li>
          <li class="nav-elem">
            <a href="#four" class="nav-elem-link">Тарифы</a>
          </li>
          <li class="nav-elem">
            <a class="nav-elem-link" href="#five">Попробовать</a>
          </li>
        </ul>
        <div class="mobile-nav">
          <button class="toggle-nav" onclick="navtoggle()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
			stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #0071bc;">
			<line x1="8" y1="6" x2="21" y2="6"></line>
			<line x1="8" y1="12" x2="21" y2="12"></line>
			<line x1="8" y1="18" x2="21" y2="18"></line>
			<line x1="3" y1="6" x2="3" y2="6"></line>
			<line x1="3" y1="12" x2="3" y2="12"></line>
			<line x1="3" y1="18" x2="3" y2="18"></line>
		</svg></button>
          <ul id="mobnav" class="nav">
		  <li class="nav-elem">
            <a href="/" class="nav-elem-link">Главная</a>
          </li>		
		  <li class="nav-elem">
              <a onclick="navtoggle()" href="#second" class="nav-elem-link">Преимущества</a>
            </li>
            <li class="nav-elem">
              <a onclick="navtoggle()" href="#third" class="nav-elem-link">Как это работает</a>
            </li>
            <li class="nav-elem">
              <a onclick="navtoggle()" href="#four" class="nav-elem-link">Тарифы</a>
            </li>
            <li class="nav-elem">
              <a onclick="navtoggle()" class="nav-elem-link" href="#five">Попробовать</a>
            </li>
          </ul>
        </div>
      </div>
    </header>
    <section class="section section-first">
	<img class="desk" src="/img/fc.png" alt="">	
	<img class="tabl" src="/img/fc768.png" alt="">	
		<div class="container">
			<div class="row">
				<div class="first-section-items">
					<h1 class="section-title">
						ТамТем - Сервис объявлений <br />
						для Вашего <br> бизнеса
					</h1>
					<p class="subtitle">
						Самый простой способ <br>найти поставщика <br>или продать товар
					</p>
					<div class="search-form-wrapper">
						<img class="mob" src="/img/fc320.png" alt="">	
						<form action="javascript:void(0);" onsubmit="submitSearchForm(event)">
							<div class="wrapper-search">
								<input required type="text" name="searchString" tabindex="1" />
								<button type="submit" tabindex="3"></button>
							</div>
							<div class="checkbox">
								<label class="checkbox-label" tabindex="2" for="isbuying">
									<input type="checkbox" class="checkbox-input" name="isbuying" id="isbuying" />
									<span class="checkbox-text">Объявления о закупке</span>
								</label>
							</div>
						</form>
						<img class="mob last" src="/img/sc320.png" alt="">
					</div>
				</div>
			</div>
		</div>
	<img class="desk" src="/img/sc.png" alt="">	
	<img class="tabl" src="/img/sc768.png" alt="">	
	</section>
    <section id="second" class="section section-second">
		<div class="container">
			<div class="row">
				<div class="section-content">
					<h1 class="section-title">С ТамТем Вы можете</h1>
					<div class="section-content-items">
						<div class="item">
							<div class="image-wrapper">
								<svg xmlns="http://www.w3.org/2000/svg" width="97.786" height="97.786"
									viewBox="0 0 97.786 97.786">
									<defs>
										<style>
											.cls-1 {
												fill: none;
												stroke: #0071bc;
												stroke-linecap: round;
												stroke-linejoin: round;
												stroke-miterlimit: 10;
												stroke-width: 4px;
											}
										</style>
									</defs>
									<g id="edit" transform="translate(2 2)">
										<path id="Shape"
											d="M84.408 49.988v25.041a9.379 9.379 0 0 1-9.379 9.379H9.379A9.379 9.379 0 0 1 0 75.029V9.379A9.379 9.379 0 0 1 9.379 0H34.42"
											class="cls-1" transform="translate(0 9.379)" />
										<path id="Shape-2" d="M46.893 0L65.65 18.757 18.757 65.65H0V46.893L46.893 0z"
											class="cls-1" data-name="Shape" transform="translate(28.136)" />
									</g>
								</svg>
							</div>
							<div class="text-wrapper">
								<p class="text">
									Найти поставщика, <br />подходящего именно<br />Вашей
									компании<br />в кратчайшие сроки
								</p>
							</div>
						</div>
						<div class="item">
							<div class="image-wrapper"><svg xmlns="http://www.w3.org/2000/svg" width="97.787"
									height="105.103" viewBox="0 0 97.787 105.103">
									<defs>
										<style>
											.cls-1 {
												fill: none;
												stroke: #0071bc;
												stroke-linecap: round;
												stroke-linejoin: round;
												stroke-miterlimit: 10;
												stroke-width: 4px
											}
										</style>
									</defs>
									<g id="package" transform="translate(2 2.069)">
										<path id="Shape"
											d="M51.067.98l37.514 18.757a9.379 9.379 0 0 1 5.205 8.394V72.82a9.379 9.379 0 0 1-5.205 8.394L51.067 99.971a9.379 9.379 0 0 1-8.394 0L5.158 81.214A9.379 9.379 0 0 1 0 72.773V28.131a9.379 9.379 0 0 1 5.205-8.394L42.72.98a9.379 9.379 0 0 1 8.347 0z"
											class="cls-1" />
										<path id="Shape-2" d="M0 0l45.393 22.7L90.785 0" class="cls-1" data-name="Shape"
											transform="translate(1.501 23.066)" />
										<path id="Shape-3" d="M0 55.146V0" class="cls-1" data-name="Shape"
											transform="translate(46.893 45.763)" />
										<path id="Shape-4" d="M0 0l46.893 23.447" class="cls-1" data-name="Shape"
											transform="translate(23.447 10.593)" />
									</g>
								</svg>
							</div>
							<div class="text-wrapper">
								<p class="text">Эффективно реализовать<br>складские остатки<br>или показать<br>новый
									товар</p>
							</div>
						</div>
						<div class="item">
							<div class="image-wrapper"><svg xmlns="http://www.w3.org/2000/svg" width="104.651"
									height="94.586" viewBox="0 0 104.651 94.586">
									<defs>
										<style>
											.cls-1 {
												fill: none;
												stroke: #0071bc;
												stroke-linecap: round;
												stroke-linejoin: round;
												stroke-miterlimit: 10;
												stroke-width: 4px
											}
										</style>
									</defs>
									<g id="Group_1153" data-name="Group 1153" transform="translate(2 2)">
										<g id="briefcase">
											<rect id="Rectangle-path" width="100.652" height="70.456" class="cls-1"
												rx="2" transform="translate(0 20.13)" />
											<path id="Shape"
												d="M40.261 90.586V10.065A10.065 10.065 0 0 0 30.2 0H10.065A10.065 10.065 0 0 0 0 10.065v80.521"
												class="cls-1" transform="translate(30.195)" />
										</g>
									</g>
								</svg>
							</div>
							<div class="text-wrapper">
								<p class="text">Создать компанию<br>и использовать<br>все возможности<br>для
									продвижения<br> Вашего
									бизнеса</p>
							</div>
						</div>
						<div class="item">
							<div class="image-wrapper">
								<svg xmlns="http://www.w3.org/2000/svg" width="107.165" height="97.786"
									viewBox="0 0 107.165 97.786">
									<defs>
										<style>
											.cls-1 {
												fill: none;
												stroke: #0071bc;
												stroke-linecap: round;
												stroke-linejoin: round;
												stroke-miterlimit: 10;
												stroke-width: 4px
											}
										</style>
									</defs>
									<g id="sunrise" transform="translate(2 2)">
										<path id="Shape" d="M46.893 23.447a23.447 23.447 0 1 0-46.893 0" class="cls-1"
											transform="translate(28.136 51.583)" />
										<path id="Shape-2" d="M0 0v32.825" class="cls-1" data-name="Shape"
											transform="translate(51.582)" />
										<path id="Shape-3" d="M0 0l6.659 6.659" class="cls-1" data-name="Shape"
											transform="translate(15.1 38.546)" />
										<path id="Shape-4" d="M0 0h9.379" class="cls-1" data-name="Shape"
											transform="translate(0 75.029)" />
										<path id="Shape-5" d="M0 0h9.379" class="cls-1" data-name="Shape"
											transform="translate(93.786 75.029)" />
										<path id="Shape-6" d="M0 6.659L6.659 0" class="cls-1" data-name="Shape"
											transform="translate(81.407 38.546)" />
										<path id="Shape-7" d="M103.165 0H0" class="cls-1" data-name="Shape"
											transform="translate(0 93.786)" />
										<path id="Shape-8" d="M0 18.757L18.757 0l18.758 18.757" class="cls-1"
											data-name="Shape" transform="translate(32.825)" />
									</g>
								</svg>
							</div>
							<div class="text-wrapper">
								<p class="text">Настроить профиль<br>и получать уведомления<br>об интересующих<br>Вас
									заказах или
									товарах</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
    <section id="third" class="section section-third lefted">
		<div class="container">
			<div class="side left-side">
				<div class="arrow-right-wrapper md">
					<button onclick="changeside()">
						<img src="/img/how-work1.svg">
					</button>
				</div>
				<h3 class="left-side-title">Как это работает</h3>
				<div class="left-side-items">
					<ul class="items-list">
						<li class="left-item">
							<p><span>Создайте</span> объявление на закупку</p>
							<img src="/img/how-work1.svg">

						</li>
						<li class="left-item">
							<p> <span>Ваш заказ увидят все поставщики,</span> которые работают с данным видом товаров
								или услуг</p>
							<img src="/img/how-work2.svg" alt="">

						</li>
						<li class="left-item">
							<p>Принимайте предложения <span>удобным</span> Вам способом</p>
							<img src="/img/how-work3.svg" alt="">
						</li>
						<li class="left-item">
							<p>Выбирайте <span>подходящего</span> Вам поставщика</p>
							<img src="/img/how-work-4.png" alt="">
						</li>
					</ul>
				</div>
			</div>
			<div class="side right-side">
								<div class="arrow-right-wrapper md">
									<button onclick="changeside()">
										<img src="/img/how-work1.svg">
									</button>
								</div>
				<div class="right-side-form">
					<h3>Разместите объявление<br>о закупке на любой вид товара</h3>
					<h4>Бесплатно</h4>
					<form action="javascript:void(0);" onsubmit="additem(event)">
						<textarea required name="description" id="" cols="30" rows="10"
							placeholder="Что вы хотите купить?"></textarea>
						<div class="inputs-wrapper">
							<input onchange="emailMasking(this)" required placeholder="Email" name="email" type="text">
							<input onchange="phoneMasking(this)"  required placeholder="Телефон" name="phone" type="text">
							<input type="text" name="name" tabindex="-1" class="honey">
						</div>
						<div class="checkbox">
							<label class="checkbox-label" tabindex="2" for="agreement">
								<input checked="checked" onchange="agreementTest(this)" required type="checkbox" class="checkbox-input" name="agreement" id="agreement" />
								<span class="checkbox-text"><p>Я принимаю условия <a href="/files/agreement.doc">лицензионного соглашения</a> 
								и даю свое согласие на обработку персональных
								данных на условиях и целях, определенных <a href="/files/politic.doc">политикой конфиденциальности</a></p></span>
							</label>
						</div>
						<button type="submit">Попробовать</button>
					</form>
				</div>
			</div>
		</div>
	</section>
    <section id="four" class="section section-four">
		<div class="container">
			<div class="row">
				<h1 class="section-title">Тарифы</h1>
				<div class="section-items">
					<div class="tarif-item first">
						<div class="peoples">
							<img src="/img/file-text.svg" alt="">
							<p>Закупщикам</p>
						</div>
						<a href="#third" class="find-link">Найти поставщиков</a>
					</div>
					<div class="tarif-item second">
						<div class="peoples">
							<img src="/img/box.svg" alt="">
							<p>Продавцам</p>
						</div>
						<a href="/?city&type_deal=buy" class="find-link">Найти клиентов</a>
					</div>
				</div>
			</div>
		</div>
	</section>
    <section id="five" class="section section-five">
		<div class="container">
			<div class="row">
				<div class="section-items">
					<div class="side try-now">
						<div class="gift-info-wrapper">
							<h3>Попробуйте сейчас!</h3>
							<p>Успейте зарегистрироваться <br>и Вы получите тариф стартовый <br>в <span>подарок!</span></p>
						</div>
					</div>
					<div class="side gift-form-wrapper">
						<div class="gift-form">
							<div class="peoples">
								<img alt="" src="/img/award.svg">
								<p>Тариф стартовый</p>
							</div>
							<div class="gift-text">3 дня тарифа в подарок, активируйте, когда потребуется</div>
							<a class="gift-link" href="/signup">Зарегистрироваться</a>
						</div>
					</div>
				</div>
			</div>
			</div>
	</section>
    <section class="section section-six">
		<div class="container">
			<div class="row">
				<h1 class="section-title">Остались вопросы?</h1>
				<p class="section-title section-subtitle"></p>
				<p class="section-title section-subtitle">Оставьте номер телефона и мы Вам перезвоним</p>
				<form class="callback-form" action="javascript:void(0);" onsubmit="callback(event)">
					<input onchange="phoneMasking(this)"  required placeholder="+7 (XXX) XXX-XX-XX" class="callback-form-input" type="text" name="phone">
					<input class="honey" name="name" tabindex="-1" type="text">
					<button class="callback-form-button" type="submit">Заказать звонок</button>
				</form>
			</div>
		</div>
	</section>
    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="footer-content">
            <div class="footer-content-logo">
              <img src="/img/footer-logo.svg" alt="" />

              <p>© ООО "Акстек", 2019 ОГРН 1187847338920</p>
            </div>
            <ul class="footer-content-nav">
              <li class="footer-content-nav-item">
                <a href="/files/agreement.doc" class="footer-content-nav-item-link"
                  >Условия использования</a
                >
              </li>
              <li class="footer-content-nav-item">
                <a href="javascript:void(0);" class="footer-content-nav-item-link bordered"
                  >Контакты</a
                >
              </li>
              <li class="footer-content-nav-item">
                <a href="/files/politic.doc" class="footer-content-nav-item-link"
                  >Политика конфиденциальности</a
                >
              </li>
            </ul>
          </div>
        </div>
      </div>
	</footer>
	<div id="notification" class="notification">
		<div class="notification-body">
			<p id="notification-text" class="notification-text"></p>	
		</div>
	</div>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/axios@0.18.0/dist/axios.min.js"></script>											
  <script src="{{ asset('js/main.js') }}"></script>
</html>