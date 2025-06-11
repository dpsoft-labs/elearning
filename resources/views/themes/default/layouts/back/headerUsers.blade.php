<li class="menu-header small text-uppercase">
    <span class="menu-header-text" data-i18n="@lang('l.Content & Quizzes')">@lang('l.Lectures & Lives & Quizzes')</span>
</li>
<li class="menu-item {{ request()->is('*/lectures*') ? 'active' : '' }}">
    <a href="{{ route('dashboard.users.lectures') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-play-circle"></i>
        <div class="text-truncate" data-i18n="@lang('l.Lectures')">@lang('l.Lectures')</div>
    </a>
</li>
<li class="menu-item {{ request()->is('*/lives*') ? 'active' : '' }}">
    <a href="{{ route('dashboard.users.lives') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-video"></i>
        <div class="text-truncate" data-i18n="@lang('l.Lives')">@lang('l.Lives')</div>
    </a>
</li>
<li class="menu-item {{ request()->is('*/quizzes*') ? 'active' : '' }}">
    <a href="{{ route('dashboard.users.quizzes') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-list-check"></i>
        <div class="text-truncate" data-i18n="@lang('l.Quizzes')">@lang('l.Quizzes')</div>
    </a>
</li>
<li class="menu-header small text-uppercase">
    <span class="menu-header-text" data-i18n="@lang('l.Registration & Invoices')">@lang('l.Registration & Invoices')</span>
</li>
<li class="menu-item {{ request()->is('*/registrations*') ? 'active' : '' }}">
    <a href="{{ route('dashboard.users.registrations') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-book"></i>
        <div class="text-truncate" data-i18n="@lang('l.Registrations')">@lang('l.Registrations')</div>
    </a>
</li>
<li class="menu-item {{ request()->is('*/invoices*') ? 'active' : '' }}">
    <a href="{{ route('dashboard.users.invoices') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-file"></i>
        <div class="text-truncate" data-i18n="@lang('l.Invoices')">@lang('l.Invoices')</div>
    </a>
</li>

<li class="menu-header small text-uppercase">
    <span class="menu-header-text" data-i18n="@lang('l.Notes & Support')">@lang('l.Notes & Support')</span>
</li>
<li class="menu-item {{ request()->is('*/ai*') ? 'active' : '' }}">
    <a href="{{ route('dashboard.users.ai') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-bot"></i>
        <div class="text-truncate" data-i18n="@lang('l.AI Assistant')">@lang('l.AI Assistant')</div>
    </a>
</li>
<li class="menu-item {{ request()->is('*/tickets*') ? 'active' : '' }}">
    <a href="{{ route('dashboard.users.tickets') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-message-square-dots"></i>
        <div class="text-truncate" data-i18n="@lang('l.Support Tickets')">@lang('l.Support Tickets')</div>
    </a>
</li>
<li class="menu-item {{ request()->is('*/notes*') ? 'active' : '' }}">
    <a href="{{ route('dashboard.users.notes') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-note"></i>
        <div class="text-truncate" data-i18n="@lang('l.Notes')">@lang('l.Notes')</div>
    </a>
</li>
