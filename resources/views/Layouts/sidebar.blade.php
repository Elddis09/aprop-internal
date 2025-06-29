<!-- Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="menu">
        <ul class="list">
            <li>
                @if(Auth::check())
                @php
                $user = Auth::user();
                @endphp
                <div class="user-info m-b-20">
                    <div class="image">
                        <a href="{{ url('/profile') }}">
                            <img src="{{ asset('assets/images/ava.jpg') }}" alt="User">
                        </a>
                    </div>
                    <div class="detail">
                        <h6>{{ $user->name }}</h6>
                        <span class="badge badge-warning">{{ ucfirst($user->role) }}</span>
                        <p class="m-b-0">{{ $user->email }}</p>
                        <a href="#"><i class="zmdi zmdi-facebook-box"></i></a>
                        <a href="#"><i class="zmdi zmdi-linkedin-box"></i></a>
                        <a href="#"><i class="zmdi zmdi-instagram"></i></a>
                        <a href="#"><i class="zmdi zmdi-twitter-box"></i></a>
                    </div>
                </div>
                @endif
            </li>
            <li class="header">MAIN</li>

            {{-- MENU UNTUK FRONT OFFICE --}}
            @if(Auth::check() && Auth::user()->role == 'frontoffice')
            <li class="{{ Request::is('dashboard-fo*') ? 'active' : '' }}">
                <a href="{{ route('fo.dashboard') }}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a>
            </li>
            <li class="{{ Request::is('bank-proposals*') ? 'active' : '' }}">
                <a href="{{ route('superadmin.proposal.bank-proposal') }}"><i class="zmdi zmdi-folder-star-alt"></i><span>Bank Proposal</span></a>
            </li>
            <li class="{{ Request::is('data-proposal*') ? 'active' : '' }}">
                <a href="{{ route('superadmin.proposal.data-proposal') }}"><i class="zmdi zmdi-folder-star-alt"></i><span>Data Proposal</span></a>
            </li>
            <li class="{{ Request::is('frontoffice/proposal/create*') ? 'active' : '' }}">
                <a href="{{ route('klien.proposal.create') }}"><i class="zmdi zmdi-file-plus"></i><span>Ajukan Proposal</span></a>
            </li>

            {{-- MENU UNTUK SUPERADMIN --}}
            @elseif(Auth::check() && Auth::user()->role == 'superadmin')
            <li class="{{ Request::is('dashboard-admin*') ? 'active' : '' }}">
                <a href="{{ route('superadmin.dashboard') }}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a>
            </li>
            <li class="{{ Request::is('bank-proposals*') ? 'active' : '' }}">
                <a href="{{ route('superadmin.proposal.bank-proposal') }}"><i class="zmdi zmdi-folder-star-alt"></i><span>Bank Proposal</span></a>
            </li>
            <!-- <li class="{{ Request::is('data-proposal*') ? 'active' : '' }}">
                <a href="{{ route('superadmin.proposal.data-proposal') }}"><i class="zmdi zmdi-folder-star-alt"></i><span>Data Proposal</span></a>
            </li>
            <li class="{{ Request::is('proposal-terbaru*') ? 'active' : '' }}">
                <a href="{{ route('superadmin.proposal-terbaru') }}"><i class="zmdi zmdi-time-restore"></i><span>Proposal Terbaru</span></a>
            </li>
            <li class="{{ Request::is('frontoffice/proposal/create*') ? 'active' : '' }}">
                <a href="{{ route('klien.proposal.create') }}"><i class="zmdi zmdi-file-plus"></i><span>Ajukan Proposal</span></a>
            </li> -->
            <li class="{{ Request::is('data-user*') || Request::is('user/create*') ? 'active' : '' }}">
                <a href="{{ route('superadmin.data-user') }}"><i class="zmdi zmdi-accounts"></i><span>Data User</span></a>
            </li>

            {{-- MENU UNTUK ROLE INTERNAL LAINNYA (non-FO, non-Superadmin) --}}
            @elseif(Auth::check())
            <li class="{{ Request::is('dashboard-admin*') ? 'active' : '' }}">
                <a href="{{ route('superadmin.dashboard') }}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a>
            </li>
            <li class="{{ Request::is('bank-proposals*') ? 'active' : '' }}">
                <a href="{{ route('superadmin.proposal.bank-proposal') }}"><i class="zmdi zmdi-collection-bookmark"></i><span>Bank Proposal</span></a>
            </li>
            <li class="{{ Request::is('data-proposal*') ? 'active' : '' }}">
                <a href="{{ route('superadmin.proposal.data-proposal') }}"><i class="zmdi zmdi-folder-star-alt"></i><span>Data Proposal</span></a>
            </li>
            <li class="{{ Request::is('proposal-terbaru*') ? 'active' : '' }}">
                <a href="{{ route('superadmin.proposal-terbaru') }}"><i class="zmdi zmdi-time-restore"></i><span>Proposal Terbaru</span></a>
            </li>
            @endif
        </ul>
    </div>
</aside>
