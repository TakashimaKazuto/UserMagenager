<nav class="navbar navbar-expand-md bg-green-200">
    <div class="container">
        <div class="navbar-brand">
            <a class="header-title" href="{{ route('admin.home') }}">人材管理システム（管理者）</a>
        </div>

        <button type="button" class="navbar-toggler" data-toggle="collaspe" data-target="#navbarDropdown">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ ($page === 'member') ? 'active' : '' }}" href="{{ route('admin.member') }}">メンバー管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ ($page === 'item') ? 'active' : '' }}" href="{{ route('admin.item') }}">項目管理</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('password.edit') }}">パスワード変更</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" name="logout">
                        @csrf
                        <a class="nav-link" href="javascript:logout.submit()">ログアウト</a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>