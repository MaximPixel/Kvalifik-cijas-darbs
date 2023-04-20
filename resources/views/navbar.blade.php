<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="{{ route('index' )}}">Print Services</a>
      </div>
      <div class="navbar-nav mr-auto justify-content-start">
        <a class="nav-link" href="{{ route('model.manf-service', ['action' => 'list']) }}">@lang("navbar.services-list")</a>
      </div>
      <div class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="#">{{ request()->get("redirect") }}</a>
        </li>
      @if (auth()->check())
      @if (auth()->user()->isAdmin())
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin') }}">
                <span>@lang("admin")</span>
            </a>
        </li>
      @endif
      @if (auth()->user()->ordersVisible->isNotEmpty())
        <li class="nav-item">
            <a class="nav-link" href="{{ route('model.order', ['action' => 'list', 'user' => auth()->user()->getCode()]) }}">
                <span>@lang("navbar.my-orders") <span class="badge bg-primary">{{ auth()->user()->ordersVisible->count() }}</span></span>
            </a>
        </li>
      @endif
        <li class="nav-item">
            <a class="nav-link" href="{{ route('model.print-model', ['action' => 'list', 'user' => auth()->user()->getCode()]) }}">
                <span>@lang("navbar.my-models") <span class="badge bg-primary">{{ auth()->user()->printModelsVisible->count() }}</span></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ auth()->user()->getRoute() }}">@lang("navbar.user")</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('auth.logout', ['redirect' => url()->full() ]) }}">@lang("navbar.logout")</a>
        </li>
      @else
        <li class="nav-item">
            <a class="nav-link" href="{{ route('auth.login', ['redirect' => url()->full() ]) }}">@lang("navbar.login")</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('auth.register', ['redirect' => url()->full() ]) }}">@lang("navbar.register")</a>
        </li>
      @endif
      </div>
    </div>
  </nav>