<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>EverestBill</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
    <!-- Get all custom CSS -->    
    @yield('custom-css')
  </head>

  <body>
    <!-- Static navbar -->
    <nav class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{ route('frontend.index') }}">EverestBill</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            {!! $navBar !!}
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                {{ $welcomeMessage }}
               <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                {!! $dropdownMenu !!}
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
      <div class="row">
        <div class="col-md-12">
          @include('frontend.partials.notifications')
        </div>
      </div>
    </div>

    <div id="main-container" class="container">
      @yield('content')
    </div> <!-- /container -->

    <footer class="footer">
      <div class="container">
        <p>Copyright &copy 2016</p>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('frontend/js/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
  </body>
</html>
