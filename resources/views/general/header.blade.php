<nav class="navbar navbar-expand-md bg-blue-200">
    <div class="container">
        <div class="navbar-brand">
            <a class="header-title" href="{{ route('general.home') }}">人材管理システム（一般）</a>
        </div>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link {{ ($page === 'profile') ? 'active' : '' }}" href="{{ route('general.profile') }}">プロフィール</a>
                </li>
            </ul>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('LOG OUT') }}
                </x-dropdown-link>
            </form>
        </div>
    </div>
</nav>