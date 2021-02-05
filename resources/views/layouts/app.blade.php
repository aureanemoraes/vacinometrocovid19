<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css">
    <style>
    .c-header {
        padding-right: 50px;
        padding-left: 50px;
        padding-top: 10px;
        padding-bottom: 10px;

    }
    #brazao_prefeitura {
        width: 150px;
        length: 150px;
    }
    </style>
    @yield('css')
    <title>@yield('title')</title>
</head>
<body class="c-app">
  <div class="c-wrapper">
    <header class="c-header">
        <h3>(ExperTIse) Vacinômetro</h3>
        @yield('header')
    </header>
    <div class="c-body">
      <main class="c-main">
        @yield('main')
      </main>
    </div>
    <footer class="c-footer">
        @yield('footer')
    </footer>
  </div>
</body>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/@coreui/coreui/dist/js/coreui.min.js"></script>
@yield('js')
</html>



