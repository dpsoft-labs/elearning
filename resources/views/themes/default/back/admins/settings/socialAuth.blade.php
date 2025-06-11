<div class="container-fluid py-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white">
            <h4 class="mb-0 text-white">
                <i class="fas fa-share-alt me-2"></i>@lang('l.Social Authentication Settings')
            </h4>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('dashboard.admins.settings-update') }}" method="POST">
                @csrf

                <!-- Nav tabs -->
                <ul class="nav nav-tabs mb-4" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#google" type="button">
                            <i class="fab fa-google me-2 text-danger"></i>@lang('l.Google')
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#facebook" type="button">
                            <i class="fab fa-facebook me-2 text-dark"></i>@lang('l.Facebook')
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#twitter" type="button">
                            <i class="fab fa-twitter me-2 text-info"></i>@lang('l.Twitter')
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    <div class="alert alert-dark alert-dismissible fade show" role="alert">
                        @lang('l.If you need help getting these credentials, please read our detailed guide at') <a href="{{env('social_auth_guide_url')}}" target="_blank">@lang('l.Here')</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <!-- Google Tab -->
                    <div class="tab-pane fade show active" id="google">
                        <div class="card border">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fab fa-google me-2 text-danger"></i>@lang('l.Google Authentication')
                                </h5>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="status-indicator">
                                        <span class="badge rounded-circle p-2 {{ $settings['googleLogin'] == 1 ? 'bg-success' : 'bg-danger' }}">
                                            <i class="fas fa-circle"></i>
                                        </span>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="googleLogin" value="0">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                               onchange="this.value = this.checked ? '1' : '0'"
                                               name="googleLogin"
                                               value="{{ $settings['googleLogin'] }}"
                                               {{ $settings['googleLogin'] == 1 ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body mt-3">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="GOOGLE_CLIENT_ID"
                                                   value="{{ $settings['GOOGLE_CLIENT_ID'] }}">
                                            <label>@lang('l.Google ID')</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="GOOGLE_CLIENT_SECRET"
                                                   value="{{ $settings['GOOGLE_CLIENT_SECRET'] }}">
                                            <label>@lang('l.Google Secret')</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="alert alert-info d-flex align-items-center">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <div>
                                                <strong>@lang('l.Redirect URL')</strong>
                                                <code>{{ url('auth/google/callback') }}</code>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Facebook Tab -->
                    <div class="tab-pane fade" id="facebook">
                        <div class="card border">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fab fa-facebook me-2 text-dark"></i>@lang('l.Facebook Authentication')
                                </h5>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="status-indicator">
                                        <span class="badge rounded-circle p-2 {{ $settings['facebookLogin'] == 1 ? 'bg-success' : 'bg-danger' }}">
                                            <i class="fas fa-circle"></i>
                                        </span>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="facebookLogin" value="0">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                               onchange="this.value = this.checked ? '1' : '0'"
                                               name="facebookLogin"
                                               value="{{ $settings['facebookLogin'] }}"
                                               {{ $settings['facebookLogin'] == 1 ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body mt-3">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="FACEBOOK_CLIENT_ID"
                                                   value="{{ $settings['FACEBOOK_CLIENT_ID'] }}">
                                            <label>@lang('l.Facebook ID')</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="FACEBOOK_CLIENT_SECRET"
                                                   value="{{ $settings['FACEBOOK_CLIENT_SECRET'] }}">
                                            <label>@lang('l.Facebook Secret')</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="alert alert-info d-flex align-items-center">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <div>
                                                <strong>@lang('l.Redirect URL')</strong>
                                                <code>{{ url('auth/facebook/callback') }}</code>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Twitter Tab -->
                    <div class="tab-pane fade" id="twitter">
                        <div class="card border">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fab fa-twitter me-2 text-info"></i>@lang('l.Twitter Authentication')
                                </h5>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="status-indicator">
                                        <span class="badge rounded-circle p-2 {{ $settings['twitterLogin'] == 1 ? 'bg-success' : 'bg-danger' }}">
                                            <i class="fas fa-circle"></i>
                                        </span>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="twitterLogin" value="0">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                               onchange="this.value = this.checked ? '1' : '0'"
                                               name="twitterLogin"
                                               value="{{ $settings['twitterLogin'] }}"
                                               {{ $settings['twitterLogin'] == 1 ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body mt-3">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="TWITTER_CLIENT_API_KEY"
                                                   value="{{ $settings['TWITTER_CLIENT_API_KEY'] }}">
                                            <label>@lang('l.Twitter ID')</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="TWITTER_CLIENT_API_SECRET_KEY"
                                                   value="{{ $settings['TWITTER_CLIENT_API_SECRET_KEY'] }}">
                                            <label>@lang('l.Twitter Secret')</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="alert alert-info d-flex align-items-center">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <div>
                                                <strong>@lang('l.Redirect URL')</strong>
                                                <code>{{ url('auth/twitter/callback') }}</code>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- أزرار التحكم -->
                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>@lang('l.Save Changes')
                    </button>
                    <a href="{{ route('dashboard.admins.settings') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-arrow-left me-2"></i>@lang('l.Back')
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.nav-tabs .nav-link {
    color: #6c757d;
    border: none;
    padding: 10px 20px;
    border-bottom: 2px solid transparent;
}

.form-switch .form-check-input {
    width: 3em;
    height: 1.5em;
    cursor: pointer;
}

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

.status-indicator .badge {
    width: 15px;
    height: 15px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.status-indicator .badge i {
    font-size: 8px;
}

.alert code {
    background: rgba(255,255,255,0.7);
    padding: 2px 6px;
    border-radius: 4px;
    margin-left: 4px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const switches = document.querySelectorAll('.form-check-input');
    switches.forEach(switchEl => {
        switchEl.addEventListener('change', function() {
            const card = this.closest('.card');
            const indicator = card.querySelector('.status-indicator .badge');
            if (this.checked) {
                indicator.classList.remove('bg-danger');
                indicator.classList.add('bg-success');
            } else {
                indicator.classList.remove('bg-success');
                indicator.classList.add('bg-danger');
            }
        });
    });
});
</script>
