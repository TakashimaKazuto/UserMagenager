<nav class="navbar navbar-expand-md bg-green-200">
    <div class="container">
        <div class="navbar-brand">
            <a class="header-title" href="{{ route('admin.home') }}">人材管理システム（管理者）</a>
        </div>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link {{ ($page === 'member') ? 'active' : '' }}" href="{{ route('admin.member') }}">メンバー管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ ($page === 'item') ? 'active' : '' }}" href="{{ route('admin.item') }}">項目管理</a>
                </li>
            </ul>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('LOG OUT') }}
                </x-dropdown-link>
            </form>
        </div>
    </div>
</nav>