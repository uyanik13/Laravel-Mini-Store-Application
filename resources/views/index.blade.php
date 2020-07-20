<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <link rel="icon" href="<%= BASE_URL %>favicon.ico"> -->

    <title>Mini İşletmem | Türkiyenin İlk ve En Kolay Yönetilebilir İşletme Yazılımı</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset(mix('css/main.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/iconfont.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/material-icons/material-icons.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/vuesax.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/prism-tomorrow.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
    <meta name="geo.placename" content="İstanbul" /><meta name="geo.position" content="41.063246;28.997317" /><meta name="geo.region" content="TR" />
    <meta name="description" content="Mini İşletmelere Özel Yazılım. İşletmeler olarak müşterilerinizi kolayca takip edebileceğiniz, borçlarını görütüleyeblieceğiniz, borç girişi yapabileceğiniz bir yazılımdır. "/>
    <link rel="canonical" href="https://www.dromareter.com/" />
    <meta property="og:locale" content="tr_TR" />
    <meta property="og:type" content="website" />
    <meta property="place:location:latitude" content="41.063246"/>
    <meta property="place:location:longitude" content="28.997317"/>
    <meta property="business:contact_data:street_address" content="Fulya Mahallesi Ortaklar Caddesi"/>
    <meta property="business:contact_data:locality" content="İstanbul"/>
    <meta property="business:contact_data:country_name" content="Türkiye"/>
    <meta property="business:contact_data:postal_code" content="34394"/>
    <meta property="business:contact_data:website" content="https://www.dromareter.com/"/>
    <meta property="business:contact_data:region" content="-"/>
    <meta property="business:contact_data:email" content="bilgi@dijitalreklam.org"/>
    <meta property="business:contact_data:phone_number" content="05456134513"/>
    <meta property="og:title" content="Otomatik Bildirim Gönderen Yazılım" />
    <meta property="og:description" content="İşletmenizi en rahat yönetebileceğiniz yazılım" />
    <meta property="og:url" content="https://www.dromareter.com/" />
    <meta property="og:site_name" content="Türkiyenin En Kolay İşletme Yazılımı" />
    <meta property="og:image" content="https://dromarketer.com/images/logo.png?fit=1125%2C560&#038;ssl=1" />
    <meta property="og:image:secure_url" content="https://dromarketer.com/images/logo.png?fit=1125%2C560&#038;ssl=1" />
    <meta property="og:image:width" content="1125" />
    <meta property="og:image:height" content="560" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="Mini İşletmelere Özel Yazılım. İşletmeler olarak müşterilerinizi kolayca takip edebileceğiniz, borçlarını görütüleyeblieceğiniz, borç girişi yapabileceğiniz bir yazılımdır." />
    <meta name="twitter:title" content="Türkiyenin En Kolay İşletme Yazılımı | Mini İşletmem" />
    <meta name="twitter:site" content="@miniisletmem" />
    <meta name="twitter:image" content="https://dromarketer.com/images/logo.png" />
    <meta name="twitter:creator" content="@miniisletmem" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo/favicon.png') }}">
  </head>
  <body>
    <noscript>
      <strong>You cant see the content here :).</strong>
    </noscript>
    <div id="app">
    </div>

    <!-- <script src="js/app.js"></script> -->
    <script src="{{ asset(mix('js/app.js')) }}"></script>

  </body>
</html>
