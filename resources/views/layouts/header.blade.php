
<header class="topbar">
    <!-- ============================================================== -->
    <!-- Navbar scss in header.scss -->
    <!-- ============================================================== -->
    <nav>
        <div class="nav-wrapper">
            <!-- ============================================================== -->
            <!-- Logo you can find that scss in header.scss -->
            <!-- ============================================================== -->
            <a href="javascript:void(0)" class="brand-logo">
                <span class="icon">
                    <img class="light-logo" src="{{ asset('/images/logo-smp-nobg.png') }}" width="50px">
                    <img class="dark-logo" src="{{ asset('/images/logo-smp-nobg.png') }}" width="50px">
                </span>
                <span class="text">
                    <img class="light-logo" src="{{ asset('/images/logo-smp-text-nobg.png') }}" width="160px">
                    <img class="dark-logo" src="{{ asset('/images/logo-smp-text-nobg.png') }}">
                </span>
            </a>
            <!-- ============================================================== -->
            <!-- Logo you can find that scss in header.scss -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Left topbar icon scss in header.scss -->
            <!-- ============================================================== -->
            <ul class="left">
                <li class="hide-on-med-and-down">
                    <a href="javascript: void(0);" class="nav-toggle">
                        <span class="bars bar1"></span>
                        <span class="bars bar2"></span>
                        <span class="bars bar3"></span>
                    </a>
                </li>
                <li class="hide-on-large-only">
                    <a href="javascript: void(0);" class="sidebar-toggle">
                        <span class="bars bar1"></span>
                        <span class="bars bar2"></span>
                        <span class="bars bar3"></span>
                    </a>
                </li>
                <!-- ============================================================== -->
                <!-- Notification icon scss in header.scss -->
                <!-- ============================================================== -->
                <li><a class="dropdown-trigger" href="javascript: void(0);" data-target="noti_dropdown">
                    @if ($harticles->count() != null) <i class="material-icons materialize-red-text">notifications_active</i>
                    @else <i class="material-icons">notifications</i>
                    @endif
                    </a>
                    <ul id="noti_dropdown" class="mailbox dropdown-content">
                        <li>
                            <div class="drop-title">Notifikasi @if ($harticles->count() != null) <span class="new badge red">{{ $harticles->count() }}</span> @endif</div>
                        </li>
                        <li>
                            <div class="message-center">
                                <!-- Message -->
                                @if ($harticles)
                                    @foreach ($harticles as $article)
                                        <a href="/studi/pengumuman/{{ $article->id }}">
                                            <span class="btn-floating btn-large red"><i class="material-icons">date_range</i></span>
                                            <span class="mail-contnet">
                                                <h5>{{ $article->title }}</h5>
                                                <span class="mail-desc">{{ $article->author }}</span> <span class="time">
                                                    @if (date('d/m/Y', strtotime($article->created_at)) == date('d/m/Y', strtotime(now()))) Hari Ini, {{ date('H:i', strtotime($article->created_at)) }} WIB
                                                    @else {{ date('d/m/Y, H:i', strtotime($article->created_at)) }} WIB
                                                    @endif
                                                </span>
                                            </span>
                                        </a>
                                        
                                    @endforeach
                                @endif
                            </div>
                        </li>
                        <li>
                            <a class="center-align" href="/studi/pengumuman"> <strong>Semua Notifikasi</strong> </a>
                        </li>
                    </ul>
                </li>
                {{-- <li class="search-box">
                    <a href="javascript: void(0);"><i class="material-icons">search</i></a>
                    <form class="app-search">
                        <input type="text" class="form-control" placeholder="Search &amp; enter"> <a class="srh-btn"><i class="ti-close"></i></a>
                    </form>
                </li> --}}
            </ul>
            <!-- ============================================================== -->
            <!-- Left topbar icon scss in header.scss -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right topbar icon scss in header.scss -->
            <!-- ============================================================== -->
            <ul class="right">
                <!-- ============================================================== -->
                <!-- Profile icon scss in header.scss -->
                <!-- ============================================================== -->
                <li><a class="dropdown-trigger" href="javascript: void(0);" data-target="user_dropdown"><img src="{{ asset('/images/users/2.jpg') }}" alt="user" class="circle profile-pic"></a>
                    <ul id="user_dropdown" class="mailbox dropdown-content dropdown-user">
                        <li>
                            <div class="dw-user-box">
                                <div class="u-img"><img src="{{ asset('/images/users/2.jpg') }}" alt="user"></div>
                                <div class="u-text">
                                    <h4>{{ session()->get('sname') }}</h4>
                                    <p>
                                        @if (session()->get('srole') == 'admin')
                                            Admin
                                        @elseif (session()->get('srole') == 'student')
                                            Siswa
                                        @elseif (session()->get('srole') == 'teacher')
                                            Guru
                                        @else
                                            Orang Tua
                                        @endif
                                    </p>
                                    <a href="/studi/profil" class="waves-effect waves-light btn-small red white-text">Lihat Profil</a>
                                </div>
                            </div>
                        </li>
                        {{-- <li role="separator" class="divider"></li>
                        <li><a href="/studi/notifikasi"><i class="material-icons">inbox</i> Kotak Masuk</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#"><i class="material-icons">settings</i> Pengaturan</a></li> --}}
                        <li role="separator" class="divider"></li>
                        <li><a href="/logout"><i class="material-icons">power_settings_new</i> Keluar</a></li>
                    </ul>
                </li>
            </ul>
            <!-- ============================================================== -->
            <!-- Right topbar icon scss in header.scss -->
            <!-- ============================================================== -->
        </div>
    </nav>
    <!-- ============================================================== -->
    <!-- Navbar scss in header.scss -->
    <!-- ============================================================== -->
</header>

@section('sidebar')
    <!-- ============================================================== -->
    <!-- Page wrapper scss in scafholding.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right Sidebar -->
    <!-- ============================================================== -->
    <a href="#" data-target="right-slide-out" class="sidenav-trigger right-side-toggle btn-floating btn-large waves-effect waves-light red"><i class="material-icons">settings</i></a>
    <aside class="right-sidebar">
        <!-- Right Sidebar -->
        <ul id="right-slide-out" class="sidenav right-sidenav p-t-10">
            <li>
                <div class="row">
                    <div class="col s12">
                        <!-- Tabs -->
                        <ul class="tabs">
                            <li class="tab col s4"><a href="#settings" class="active"><span class="material-icons">build</span></a></li>
                            <li class="tab col s4"><a href="#chat"><span class="material-icons">chat_bubble</span></a></li>
                            <li class="tab col s4"><a href="#activity"><span class="material-icons">local_activity</span></a></li>
                        </ul>
                        <!-- Tabs -->
                    </div>
                    <!-- Setting -->
                    <div id="settings" class="col s12">
                        <div class="m-t-10 p-10 b-b">
                            <h6 class="font-medium">Layout Settings</h6>
                            <ul class="m-t-15">
                                <li class="m-b-10">
                                    <label>
                                        <input type="checkbox" name="theme-view" id="theme-view" />
                                        <span>Dark Theme</span>
                                    </label>
                                </li>
                                <li class="m-b-10">
                                    <label>
                                        <input type="checkbox" class="nav-toggle" name="collapssidebar" id="collapssidebar" />
                                        <span>Collapse Sidebar</span>
                                    </label>
                                </li>
                                <li class="m-b-10">
                                    <label>
                                        <input type="checkbox" name="sidebar-position" id="sidebar-position" />
                                        <span>Fixed Sidebar</span>
                                    </label>
                                </li>
                                <li class="m-b-10">
                                    <label>
                                        <input type="checkbox" name="header-position" id="header-position" />
                                        <span>Fixed Header</span>
                                    </label>
                                </li>
                                <li class="m-b-10">
                                    <label>
                                        <input type="checkbox" name="boxed-layout" id="boxed-layout" />
                                        <span>Boxed Layout</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="p-10 b-b">
                            <!-- Logo BG -->
                            <h6 class="font-medium">Logo Backgrounds</h6>
                            <ul class="m-t-15 theme-color">
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-logobg="skin1"></a></li>
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-logobg="skin2"></a></li>
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-logobg="skin3"></a></li>
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-logobg="skin4"></a></li>
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-logobg="skin5"></a></li>
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-logobg="skin6"></a></li>
                            </ul>
                            <!-- Logo BG -->
                        </div>
                        <div class="p-10 b-b">
                            <!-- Navbar BG -->
                            <h6 class="font-medium">Navbar Backgrounds</h6>
                            <ul class="m-t-15 theme-color">
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-navbarbg="skin1"></a></li>
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-navbarbg="skin2"></a></li>
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-navbarbg="skin3"></a></li>
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-navbarbg="skin4"></a></li>
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-navbarbg="skin5"></a></li>
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-navbarbg="skin6"></a></li>
                            </ul>
                            <!-- Navbar BG -->
                        </div>
                        <div class="p-10 b-b">
                            <!-- Logo BG -->
                            <h6 class="font-medium">Sidebar Backgrounds</h6>
                            <ul class="m-t-15 theme-color">
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-sidebarbg="skin1"></a></li>
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-sidebarbg="skin2"></a></li>
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-sidebarbg="skin3"></a></li>
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-sidebarbg="skin4"></a></li>
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-sidebarbg="skin5"></a></li>
                                <li class="theme-item"><a href="javascript:void(0)" class="theme-link" data-sidebarbg="skin6"></a></li>
                            </ul>
                            <!-- Logo BG -->
                        </div>
                    </div>
                    <!-- chat -->
                    <div id="chat" class="col s12">
                        <ul class="mailbox m-t-20">
                            <li>
                                <div class="message-center">
                                    <!-- Message -->
                                    <a href="#" class="user-info" id='chat_user_1' data-user-id='1'>
                                        <span class="user-img">
                                            <img src="{{ asset('/images/users/1.jpg') }}" alt="user" class="circle">
                                            <span class="profile-status online pull-right" data-status="online"></span>
                                        </span>
                                        <span class="mail-contnet">
                                            <h5>Chris Evans</h5>
                                            <span class="mail-desc">Just see the my admin!</span>
                                            <span class="time">9:30 AM</span>
                                        </span>
                                    </a>
                                    <!-- Message -->
                                    <a href="#" class="user-info" id='chat_user_2' data-user-id='2'>
                                        <span class="user-img">
                                            <img src="{{ asset('/images/users/2.jpg') }}" alt="user" class="circle">
                                            <span class="profile-status busy pull-right" data-status="busy"></span>
                                        </span>
                                        <span class="mail-contnet">
                                            <h5>Ray Hudson</h5>
                                            <span class="mail-desc">I've sung a song! See you at</span>
                                            <span class="time">9:10 AM</span>
                                        </span>
                                    </a>
                                    <!-- Message -->
                                    <a href="#" class="user-info" id='chat_user_3' data-user-id='3'>
                                        <span class="user-img">
                                            <img src="{{ asset('/images/users/3.jpg') }}" alt="user" class="circle">
                                            <span class="profile-status away pull-right" data-status="away"></span>
                                        </span>
                                        <span class="mail-contnet">
                                            <h5>Lb James</h5>
                                            <span class="mail-desc">I am a singer!</span>
                                            <span class="time">9:08 AM</span>
                                        </span>
                                    </a>
                                    <!-- Message -->
                                    <a href="#" class="user-info" id='chat_user_4' data-user-id='4'>
                                        <span class="user-img">
                                            <img src="{{ asset('/images/users/4.jpg') }}" alt="user" class="circle">
                                            <span class="profile-status offline pull-right" data-status="offline"></span>
                                        </span>
                                        <span class="mail-contnet">
                                            <h5>Don Andres</h5>
                                            <span class="mail-desc">Just see the my admin!</span>
                                            <span class="time">9:02 AM</span>
                                        </span>
                                    </a>
                                    <!-- Message -->
                                    <a href="#" class="user-info" id='chat_user_5' data-user-id='5'>
                                        <span class="user-img">
                                            <img src="{{ asset('/images/users/1.jpg') }}" alt="user" class="circle">
                                            <span class="profile-status online pull-right" data-status="online"></span>
                                        </span>
                                        <span class="mail-contnet">
                                            <h5>Chris Evans</h5>
                                            <span class="mail-desc">Just see the my admin!</span>
                                            <span class="time">9:30 AM</span>
                                        </span>
                                    </a>
                                    <!-- Message -->
                                    <a href="#" class="user-info" id='chat_user_6' data-user-id='6'>
                                        <span class="user-img">
                                            <img src="{{ asset('/images/users/2.jpg') }}" alt="user" class="circle">
                                            <span class="profile-status busy pull-right" data-status="busy"></span>
                                        </span>
                                        <span class="mail-contnet">
                                            <h5>Ray Hudson</h5>
                                            <span class="mail-desc">I've sung a song! See you at</span>
                                            <span class="time">9:10 AM</span>
                                        </span>
                                    </a>
                                    <!-- Message -->
                                    <a href="#" class="user-info" id='chat_user_7' data-user-id='7'>
                                        <span class="user-img">
                                            <img src="{{ asset('/images/users/3.jpg') }}" alt="user" class="circle">
                                            <span class="profile-status away pull-right" data-status="away"></span>
                                        </span>
                                        <span class="mail-contnet">
                                            <h5>Lb James</h5>
                                            <span class="mail-desc">I am a singer!</span>
                                            <span class="time">9:08 AM</span>
                                        </span>
                                    </a>
                                    <!-- Message -->
                                    <a href="#" class="user-info" id='chat_user_8' data-user-id='8'>
                                        <span class="user-img">
                                            <img src="{{ asset('/images/users/4.jpg') }}" alt="user" class="circle">
                                            <span class="profile-status offline pull-right" data-status="offline"></span>
                                        </span>
                                        <span class="mail-contnet">
                                            <h5>Don Andres</h5>
                                            <span class="mail-desc">Just see the my admin!</span>
                                            <span class="time">9:02 AM</span>
                                        </span>
                                    </a>
                                    <!-- Message -->
                                    <a href="#" class="user-info" id='chat_user_9' data-user-id='9'>
                                        <span class="user-img">
                                            <img src="{{ asset('/images/users/1.jpg') }}" alt="user" class="circle">
                                            <span class="profile-status online pull-right" data-status="online"></span>
                                        </span>
                                        <span class="mail-contnet">
                                            <h5>Chris Evans</h5>
                                            <span class="mail-desc">Just see the my admin!</span>
                                            <span class="time">9:30 AM</span>
                                        </span>
                                    </a>
                                    <!-- Message -->
                                    <a href="#" class="user-info" id='chat_user_10' data-user-id='10'>
                                        <span class="user-img">
                                            <img src="{{ asset('/images/users/2.jpg') }}" alt="user" class="circle">
                                            <span class="profile-status busy pull-right" data-status="busy"></span>
                                        </span>
                                        <span class="mail-contnet">
                                            <h5>Ray Hudson</h5>
                                            <span class="mail-desc">I've sung a song! See you at</span>
                                            <span class="time">9:10 AM</span>
                                        </span>
                                    </a>
                                    <!-- Message -->
                                    <a href="#" class="user-info" id='chat_user_11' data-user-id='11'>
                                        <span class="user-img">
                                            <img src="{{ asset('/images/users/3.jpg') }}" alt="user" class="circle">
                                            <span class="profile-status away pull-right" data-status="away"></span>
                                        </span>
                                        <span class="mail-contnet">
                                            <h5>Lb James</h5>
                                            <span class="mail-desc">I am a singer!</span>
                                            <span class="time">9:08 AM</span>
                                        </span>
                                    </a>
                                    <!-- Message -->
                                    <a href="#" class="user-info" id='chat_user_12' data-user-id='12'>
                                        <span class="user-img">
                                            <img src="{{ asset('/images/users/4.jpg') }}" alt="user" class="circle">
                                            <span class="profile-status offline pull-right" data-status="offline"></span>
                                        </span>
                                        <span class="mail-contnet">
                                            <h5>Don Andres</h5>
                                            <span class="mail-desc">Just see the my admin!</span>
                                            <span class="time">9:02 AM</span>
                                        </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- Activity -->
                    <div id="activity" class="col s12">
                        <div class="m-t-10 p-10">
                            <h6 class="font-medium">Activity Timeline</h6>
                            <div class="steamline">
                                <div class="sl-item">
                                    <div class="sl-left green"> <i class="ti-user"></i></div>
                                    <div class="sl-right">
                                        <div class="font-medium">Meeting today <span class="sl-date"> 5pm</span></div>
                                        <div class="desc">you can write anything </div>
                                    </div>
                                </div>
                                <div class="sl-item">
                                    <div class="sl-left blue"><i class="fa fa-image"></i></div>
                                    <div class="sl-right">
                                        <div class="font-medium">Send documents to Clark</div>
                                        <div class="desc">Lorem Ipsum is simply </div>
                                    </div>
                                </div>
                                <div class="sl-item">
                                    <div class="sl-left"> <img class="circle" alt="user" src="{{ asset('/images/users/2.jpg') }}"> </div>
                                    <div class="sl-right">
                                        <div class="font-medium">Go to the Doctor <span class="sl-date">5 minutes ago</span></div>
                                        <div class="desc">Contrary to popular belief</div>
                                    </div>
                                </div>
                                <div class="sl-item">
                                    <div class="sl-left"> <img class="circle" alt="user" src="{{ asset('/images/users/1.jpg') }}"> </div>
                                    <div class="sl-right">
                                        <div><a href="javascript:void(0)">Stephen</a> <span class="sl-date">5 minutes ago</span></div>
                                        <div class="desc">Approve meeting with tiger</div>
                                    </div>
                                </div>
                                <div class="sl-item">
                                    <div class="sl-left teal"> <i class="ti-user"></i></div>
                                    <div class="sl-right">
                                        <div class="font-medium">Meeting today <span class="sl-date"> 5pm</span></div>
                                        <div class="desc">you can write anything </div>
                                    </div>
                                </div>
                                <div class="sl-item">
                                    <div class="sl-left purple"><i class="fa fa-image"></i></div>
                                    <div class="sl-right">
                                        <div class="font-medium">Send documents to Clark</div>
                                        <div class="desc">Lorem Ipsum is simply </div>
                                    </div>
                                </div>
                                <div class="sl-item">
                                    <div class="sl-left"> <img class="circle" alt="user" src="{{ asset('/images/users/4.jpg') }}"> </div>
                                    <div class="sl-right">
                                        <div class="font-medium">Go to the Doctor <span class="sl-date">5 minutes ago</span></div>
                                        <div class="desc">Contrary to popular belief</div>
                                    </div>
                                </div>
                                <div class="sl-item">
                                    <div class="sl-left"> <img class="circle" alt="user" src="{{ asset('/images/users/6.jpg') }}"> </div>
                                    <div class="sl-right">
                                        <div><a href="javascript:void(0)">Stephen</a> <span class="sl-date">5 minutes ago</span></div>
                                        <div class="desc">Approve meeting with tiger</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </aside>
    <div class="chat-windows"></div>
    <!-- ============================================================== -->
    <!-- Right Sidebar -->
    <!-- ============================================================== -->
@endsection