<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="{{ route('index' )}}">Print Services</a>
      </div>
      <div class="navbar-nav mr-auto justify-content-start">
        <a class="nav-link" href="{{ route('model.manf-service', ['action' => 'list']) }}">@lang("navbar.services-list")</a>
      </div>
      <div class="navbar-nav ml-auto">
    @if (auth()->check())
        <li class="nav-item">
            <a class="nav-link" href="{{ route('model.print-model', ['action' => 'list', 'user' => auth()->user()->getCode()]) }}">
                <span>@lang("navbar.my-models") <span class="badge bg-primary">{{ auth()->user()->printModelsVisible->count() }}</span></span>
            </a>
        </li>
        <li class="nav-item">
            <span class="nav-link">{{ auth()->user()->id }}</span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('auth.logout') }}">@lang("navbar.logout")</a>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-link" href="{{ route('auth.login') }}">@lang("navbar.login")</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('auth.register') }}">@lang("navbar.register")</a>
        </li>
    @endif
      </div>
    </div>
  </nav>