<ul class="nav navbar-nav navbar-right">

    @auth

        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Menu
            </a>
            <ul class="dropdown-menu">

                @foreach($nav['auth']->getItems() as $nav)

                    @if($nav->getName() == 'logout')

                        <li>
                            <a href="{{ $nav->getUrl() }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ $nav->getTitle() }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>

                    @else

                        <li>
                            <a href="{{ $nav->getUrl() }}">
                                {{ $nav->getTitle() }}
                            </a>
                        </li>

                    @endif

                @endforeach

            </ul>
        </li>

    @else

        @foreach($nav['guest']->getItems() as $item)

            <li@if($item->isMatch()){{ 'class="active"' }}@endif>

                <a href="{{ $item->getUrl() }}">
                    {{ $item->getTitle() }}
                </a>
            </li>

        @endforeach

    @endauth

</ul>