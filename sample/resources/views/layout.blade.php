<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ToDo App</title>
  @yield('styles')
  <link rel="stylesheet" href="/css/styles.css">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
<header>
  <nav class="my-navbar">
    <a class="my-navbar-brand" href="/">ToDo App</a>
    <div class="my-navbar-control">
      @if(Auth::check())
        <a href="{{ route('calendars.index') }}" class="my-navbar-item calendar-text">カレンダー</a>
        <a href="{{ route('calendars.index') }}" class="my-navbar-brand calendar-icon"><i class="fas fa-calendar-alt"></i></a>
        |
        <span class="my-navbar-item">ようこそ、{{ Auth::user()->name }}さん</span>
        |
        <a href="#" id="logout" class="my-navbar-item">ログアウト</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
          @csrf
        </form>
      @else
        <a class="my-navbar-item" href="{{ route('login') }}">ログイン</a>
        |
        <a class="my-navbar-item" href="{{route('register')}}">会員登録</a>
      @endif  
    </div>
  </nav>
</header>
<main>
  @yield('content')
</main>
@if(Auth::check())
<script>
  document.getElementById('logout').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('logout-form').submit();
  });
</script>
@endif
@yield('scripts')
</body>
</html>