<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('index') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                @if ($settings['logo'] && file_exists(public_path($settings['logo'])))
                    <img id="logo-image" src="{{ asset($settings['logo']) }}" alt="{{ $settings['name'] }}" width="180">
                    <img id="logo-dark-image" src="{{ asset($settings['logo_black']) }}" alt="{{ $settings['name'] }}"
                        width="180">
                    <img id="favicon-image" src="{{ asset($settings['favicon']) }}" alt="{{ $settings['name'] }}"
                        width="25">
                @else
                    <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <defs>
                            <path
                                d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                                id="path-1"></path>
                            <path
                                d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                                id="path-3"></path>
                            <path
                                d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                                id="path-4"></path>
                            <path
                                d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                                id="path-5"></path>
                        </defs>
                        <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                                <g id="Icon" transform="translate(27.000000, 15.000000)">
                                    <g id="Mask" transform="translate(0.000000, 8.000000)">
                                        <mask id="mask-2" fill="white">
                                            <use xlink:href="#path-1"></use>
                                        </mask>
                                        <use fill="{{ $settings['primary_color'] }}" xlink:href="#path-1"></use>
                                        <g id="Path-3" mask="url(#mask-2)">
                                            <use fill="{{ $settings['primary_color'] }}" xlink:href="#path-3"></use>
                                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                                        </g>
                                        <g id="Path-4" mask="url(#mask-2)">
                                            <use fill="{{ $settings['primary_color'] }}" xlink:href="#path-4"></use>
                                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                                        </g>
                                    </g>
                                    <g id="Triangle"
                                        transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                                        <use fill="{{ $settings['primary_color'] }}" xlink:href="#path-5"></use>
                                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                @endif
            </span>
            {{-- <span class="app-brand-text demo menu-text fw-bold ms-2">{{ $settings['name'] }}</span> --}}
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item {{ Route::is('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="@lang('l.Dashboard')">@lang('l.Dashboard')</div>
            </a>
        </li>

        @if (count(auth()->user()->getRoleNames()) == 0) <!-- users links -->
            @include('themes.default.layouts.back.headerUsers')
            <!-- Account & Settings -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text" data-i18n="@lang('l.Account &amp; Settings')">@lang('l.Account &amp; Settings')</span>
            </li>
        @else
            <!-- admins links -->
            @canany(['show lectures', 'show lives', 'show quizzes'])
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text" data-i18n="@lang('l.Content & Quizzes')">@lang('l.Lectures & Lives & Quizzes')</span>
                </li>
                @can('show lectures')
                    <li class="menu-item {{ request()->is('*/lectures*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.admins.lectures') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-play-circle"></i>
                            <div class="text-truncate" data-i18n="@lang('l.Lectures')">@lang('l.Lectures')</div>
                        </a>
                    </li>
                @endcan
                @can('show lives')
                    <li class="menu-item {{ request()->is('*/lives*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.admins.lives') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-video"></i>
                            <div class="text-truncate" data-i18n="@lang('l.Lives')">@lang('l.Lives')</div>
                        </a>
                    </li>
                @endcan
                @can('show quizzes')
                    <li class="menu-item {{ request()->is('*/quizzes*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.admins.quizzes') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-list-check"></i>
                            <div class="text-truncate" data-i18n="@lang('l.Quizzes')">@lang('l.Quizzes')</div>
                        </a>
                    </li>
                @endcan
            @endcanany

            <!-- courses -->
            @canany(['show courses', 'upload grades'])
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text" data-i18n="@lang('l.Courses & Grades')">@lang('l.Courses & Grades')</span>
                </li>
                @can('show courses')
                    <li class="menu-item {{ request()->is('*/courses*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.admins.courses') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-book"></i>
                            <div class="text-truncate" data-i18n="@lang('l.Courses')">@lang('l.Courses')</div>
                        </a>
                    </li>
                @endcan
                @can('upload grades')
                    <li class="menu-item {{ request()->is('*/grades*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.admins.grades') }}" class="menu-link">
                            <i class='menu-icon bx bx-food-menu'></i>
                            <div class="text-truncate" data-i18n="@lang('l.Grades')">@lang('l.Grades')</div>
                        </a>
                    </li>
                @endcan
            @endcanany

            <!-- students & support -->
            @canany(['show students', 'show invoices', 'show tickets', 'show newsletters_subscribers', 'show admissions'])
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text" data-i18n="@lang('l.Students & Support')">@lang('l.Students & Support')</span>
                </li>
                @can('show students')
                    <li class="menu-item {{ request()->is('*/students*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.admins.students') }}" class="menu-link">
                            <i class="menu-icon fas fa-user-group" style="font-size: 1.0rem !important;"></i>
                            <div class="text-truncate" data-i18n="@lang('l.Students')">@lang('l.Students')</div>
                        </a>
                    </li>
                @endcan
                @can('show invoices')
                    <li class="menu-item {{ request()->is('*/invoices*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.admins.invoices') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-file"></i>
                            <div class="text-truncate" data-i18n="@lang('l.Invoices')">@lang('l.Invoices')</div>
                        </a>
                    </li>
                @endcan

                @can('show tickets')
                    @php
                        $newTickets = \App\Models\Ticket::where('status', 'in_progress')->count();
                    @endphp
                    <li class="menu-item {{ request()->is('*/tickets*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.admins.tickets') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-message-square-dots"></i>
                            <div class="text-truncate" data-i18n="@lang('l.Support Tickets')">@lang('l.Support Tickets')</div>
                            @if ($newTickets > 0)
                                <span class="badge rounded-pill bg-danger ms-auto">{{ $newTickets }}</span>
                            @endif
                        </a>
                    </li>
                @endcan
                @can('show admissions')
                    <li class="menu-item {{ request()->is('*/admissions*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.admins.admissions') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-file"></i>
                            <div class="text-truncate" data-i18n="@lang('l.Admissions')">@lang('l.Admissions')</div>
                        </a>
                    </li>
                @endcan
                @can('show newsletters_subscribers')
                    <li class="menu-item {{ request()->is('*/subscribers*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.admins.subscribers') }}" class="menu-link">
                            <i class="menu-icon fa fa-paper-plane" style="font-size: 1.0rem !important;"></i>
                            <div class="text-truncate" data-i18n="@lang('l.Newsletters Subscribers')">
                                @lang('l.Newsletters Subscribers')
                            </div>
                        </a>
                    </li>
                @endcan
                <li class="menu-item {{ request()->is('*/notes*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.admins.notes') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-note"></i>
                        <div class="text-truncate" data-i18n="@lang('l.Notes')">@lang('l.Notes')</div>
                    </a>
                </li>
            @endcanany
            @canany(['show branches', 'show colleges'])
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text" data-i18n="@lang('l.Branches & Colleges')">@lang('l.Branches & Colleges')</span>
                </li>
                @can('show branches')
                    <li class="menu-item {{ request()->is('*/branches*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.admins.branches') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-building"></i>
                            <div class="text-truncate" data-i18n="@lang('l.Branches')">@lang('l.Branches')</div>
                        </a>
                    </li>
                @endcan
                @can('show colleges')
                    <li class="menu-item {{ request()->is('*/colleges*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.admins.colleges') }}" class="menu-link">
                            <i class='menu-icon bx bxs-objects-horizontal-center'></i>
                            <div class="text-truncate" data-i18n="@lang('l.Colleges')">@lang('l.Colleges')</div>
                        </a>
                    </li>
                @endcan
            @endcanany
            <!-- pages & blog -->
            @canany(['show blog', 'show pages', 'show team_members', 'show questions', 'show contact_us'])
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text" data-i18n="@lang('l.Pages & Blog')">@lang('l.Pages & Blog')</span>
                </li>
                @canany(['show blog', 'show blog_category'])
                    <li class="menu-item {{ request()->is('*/blog*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-edit-alt"></i>
                            <div class="text-truncate" data-i18n="@lang('l.Blog')">@lang('l.Blog')</div>
                        </a>
                        <ul class="menu-sub">
                            @can('show blog')
                                <li class="menu-item {{ request()->is('*/blog/articles*') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard.admins.blogs.articles') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="@lang('l.Articles')">@lang('l.Articles')</div>
                                    </a>
                                </li>
                            @endcan
                            @can('show blog_category')
                                <li class="menu-item {{ request()->is('*/blog/categories*') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard.admins.blogs.categories') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="@lang('l.Blog Categories')">@lang('l.Blog Categories')</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['show pages', 'show team_members', 'show questions', 'show contact_us'])
                    <li
                        class="menu-item {{ request()->is('*/pages*') || request()->is('*/teams*') || request()->is('*/questions*') || request()->is('*/contact-us*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div class="text-truncate" data-i18n="@lang('l.Pages')">@lang('l.Pages')</div>
                            @php $newRequests = \App\Models\Contact::where('status', 0)->count(); @endphp
                            @if ($newRequests > 0)
                                <span class="badge rounded-pill bg-danger ms-auto">{{ $newRequests }}</span>
                            @endif
                        </a>
                        <ul class="menu-sub">
                            @can('show pages')
                                <li class="menu-item {{ request()->is('*/pages/home') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard.admins.pages', ['page' => 'home']) }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="@lang('l.Home Page')">@lang('l.Home Page')</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('*/pages/about') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard.admins.pages', ['page' => 'about']) }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="@lang('l.About Page')">@lang('l.About Page')</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('*/pages/privacy') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard.admins.pages', ['page' => 'privacy']) }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="@lang('l.Privacy Policy')">@lang('l.Privacy Policy')</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('*/pages/terms') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard.admins.pages', ['page' => 'terms']) }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="@lang('l.Terms & Conditions')">@lang('l.Terms & Conditions')</div>
                                    </a>
                                </li>
                            @endcan
                            @can('show team_members')
                                <li class="menu-item {{ request()->is('*/teams*') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard.admins.teams') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="@lang('l.Team Members')">@lang('l.Team Members')</div>
                                    </a>
                                </li>
                            @endcan
                            @can('show questions')
                                <li class="menu-item {{ request()->is('*/questions*') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard.admins.questions') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="@lang('l.Questions')">@lang('l.Questions')</div>
                                    </a>
                                </li>
                            @endcan
                            @can('show contact_us')
                                <li class="menu-item {{ request()->is('*/contact-us*') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard.admins.contacts') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="@lang('l.Contact Us')">@lang('l.Contact Us')</div>
                                        @if ($newRequests > 0)
                                            <span class="badge rounded-pill bg-danger ms-auto">{{ $newRequests }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
            @endcanany

            <!-- Users & Roles -->
            @canany(['show users', 'show roles'])
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text" data-i18n="@lang('l.Users & Roles')">@lang('l.Users & Roles')</span>
                </li>
                @can('show users')
                    <li class="menu-item {{ request()->is('*/users*') ? 'active open' : '' }}">
                        <a href="{{ route('dashboard.admins.users') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-user"></i>
                            <div class="text-truncate" data-i18n="@lang('l.Users')">@lang('l.Users')</div>
                        </a>
                    </li>
                @endcan
                @canany(['show tasks', 'show chats'])
                    @php
                        $newTasks = \App\Models\Task::where('status', 'new')
                            ->where('assigned_to', auth()->user()->id)
                            ->count();

                        // حساب عدد الرسائل غير المقروءة بالطريقة الجديدة
                        $totalChatMessages = 0;
                        if (auth()->check() && auth()->user()->can('show chats')) {
                            $user = auth()->user();
                            $chats = \App\Models\Chat::whereHas('participants', function ($query) use ($user) {
                                $query->where('user_id', $user->id);
                            })->with('participants.user')->get();

                            foreach ($chats as $chat) {
                                // الحصول على مشاركة المستخدم الحالي
                                $participant = $chat->participants->where('user_id', $user->id)->first();

                                if ($participant) {
                                    // استخدام الوظيفة الجديدة لحساب عدد الرسائل غير المقروءة
                                    $totalChatMessages += $participant->unreadMessagesCount();
                                }
                            }
                        }

                        $totalAlerts = $newTasks + $totalChatMessages;
                    @endphp
                    <li class="menu-item {{ request()->is('*/tasks*') || request()->is('*/chats*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-task"></i>
                            <div class="text-truncate" data-i18n="@lang('l.Tasks & Chats')">
                                @lang('l.Tasks & Chats')
                            </div>
                            @if ($totalAlerts > 0)
                                <span class="badge rounded-pill bg-danger ms-auto">{{ $totalAlerts }}</span>
                            @endif
                        </a>
                        <ul class="menu-sub">
                            @can('show tasks')
                                <li class="menu-item {{ request()->is('*/tasks*') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard.admins.tasks') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="@lang('l.Tasks')">@lang('l.Tasks')</div>
                                        @if ($newTasks > 0)
                                            <span class="badge rounded-pill bg-danger ms-auto">{{ $newTasks }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="menu-item {{ request()->is('*/calendar*') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard.admins.tasks-calendar') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="@lang('l.Calendar')">@lang('l.Calendar')</div>
                                    </a>
                                </li>
                            @endcan
                            @can('show chats')
                                <li class="menu-item {{ request()->is('*/chats*') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard.admins.chats') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="@lang('l.Chats')">@lang('l.Chats')</div>
                                        @if ($totalChatMessages > 0)
                                            <span class="badge rounded-pill bg-danger ms-auto">{{ $totalChatMessages }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                @can('show roles')
                    <li class="menu-item {{ request()->is('*/roles*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.admins.roles') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-check-shield"></i>
                            <div class="text-truncate" data-i18n="@lang('l.Roles')">@lang('l.Roles')</div>
                        </a>
                    </li>
                @endcan
            @endcanany

            <!-- Statistics -->
            @canany(['show statistics', 'show visitors_statistics'])
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text" data-i18n="@lang('l.Statistics')">@lang('l.Statistics')</span>
            </li>
            <li class="menu-item {{ request()->is('*/statistics*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
                    <div class="text-truncate" data-i18n="@lang('l.Statistics')">@lang('l.Statistics')</div>
                </a>
                <ul class="menu-sub">
                    @can('show visitors_statistics')
                        <li class="menu-item {{ Route::is('dashboard.admins.statistics-visitors') ? 'active' : '' }}">
                            <a href="{{ route('dashboard.admins.statistics-visitors') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="@lang('l.Visitors Statistics')">@lang('l.Visitors Statistics')</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Route::is('dashboard.admins.statistics-google') ? 'active' : '' }}">
                            <a href="{{ route('dashboard.admins.statistics-google') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="@lang('l.Google Analytics')">@lang('l.Google Analytics')</div>
                            </a>
                        </li>
                    @endcan
                    @can('show money_statistics')
                        <li class="menu-item {{ Route::is('dashboard.admins.statistics-money') ? 'active' : '' }}">
                            <a href="{{ route('dashboard.admins.statistics-money') }}" class="menu-link">
                                <div class="text-truncate" data-i18n="@lang('l.Money Statistics')">@lang('l.Money Statistics')</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany

            <!-- Settings -->
            @can('show settings')
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text" data-i18n="@lang('l.Account &amp; Settings')">@lang('l.Account &amp; Settings')</span>
                </li>
                <li class="menu-item {{ request()->is('*/settings*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.admins.settings') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-cog"></i>
                        <div class="text-truncate" data-i18n="@lang('l.Settings')">@lang('l.Settings')</div>
                    </a>
                </li>
            @endcan
        @endif

        <!-- Account -->
        <li class="menu-item {{ Route::is('dashboard.profile') ? 'active' : '' }}">
            <a href="{{ route('dashboard.profile') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div class="text-truncate" data-i18n="@lang('l.My Account')">@lang('l.My Account')</div>
            </a>
        </li>

        @can('access maintenance')
            <!-- Misc -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text" data-i18n="@lang('l.Misc')">@lang('l.Misc')</span>
            </li>
            <li class="menu-item">
                <a href="{{ env('support_url') }}" target="_blank" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-support"></i>
                    <div class="text-truncate" data-i18n="@lang('l.Support')">@lang('l.Support')</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ env('docs_url') }}" target="_blank" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-file"></i>
                    <div class="text-truncate" data-i18n="@lang('l.Documentation')">@lang('l.Documentation')</div>
                </a>
            </li>
        @endcan
    </ul>
</aside>
<!-- / Menu -->
