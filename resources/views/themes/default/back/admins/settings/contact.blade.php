<div class="tab-pane fade show active" id="v-pills-General" role="tabpanel" aria-labelledby="v-pills-General-tab">
    <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">
                <i class="fas fa-phone me-2"></i>@lang('l.Contact settings')
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('dashboard.admins.settings-update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="form-group col-md-6">
                                        <label for="email1" class="form-label fw-medium">
                                            @lang('l.Email') 1
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="text" class="form-control" value="{{ $settings['email1'] }}"
                                                id="email1" name="email1" placeholder="@lang('l.Email 1')">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email2" class="form-label fw-medium">
                                            @lang('l.Email') 2
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="text" class="form-control" value="{{ $settings['email2'] }}"
                                                id="email2" name="email2" placeholder="@lang('l.Email 2')">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="phone1" class="form-label fw-medium">
                                            @lang('l.Phone') 1
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="text" class="form-control" value="{{ $settings['phone1'] }}"
                                                id="phone1" name="phone1" placeholder="@lang('l.Phone')">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="phone2" class="form-label fw-medium">
                                            @lang('l.Phone') 2
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="text" class="form-control" value="{{ $settings['phone2'] }}"
                                                id="phone2" name="phone2" placeholder="@lang('l.Phone')">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="siteWhatsapp" class="form-label fw-medium">
                                            @lang('l.Whatsapp')
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                            <input type="text" class="form-control" value="{{ $settings['whatsapp'] }}"
                                                id="siteWhatsapp" name="whatsapp" placeholder="@lang('l.Whatsapp')">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="facebook" class="form-label fw-medium">
                                            </i>@lang('l.Facebook')
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                            <input type="text" class="form-control" value="{{ $settings['facebook'] }}"
                                                id="facebook" name="facebook" placeholder="@lang('l.Facebook')">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="twitter" class="form-label fw-medium">
                                            @lang('l.Twitter')
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                            <input type="text" class="form-control" value="{{ $settings['twitter'] }}"
                                                id="twitter" name="twitter" placeholder="@lang('l.Twitter')">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="instagram" class="form-label fw-medium">
                                            @lang('l.Instagram')
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                            <input type="text" class="form-control" value="{{ $settings['instagram'] }}"
                                                id="instagram" name="instagram" placeholder="@lang('l.Instagram')">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="youtube" class="form-label fw-medium">
                                            @lang('l.Youtube')
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                            <input type="text" class="form-control" value="{{ $settings['youtube'] }}"
                                                id="youtube" name="youtube" placeholder="@lang('l.Youtube')">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="linkedin" class="form-label fw-medium">
                                            @lang('l.Linkedin')
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                            <input type="text" class="form-control" value="{{ $settings['linkedin'] }}"
                                                id="linkedin" name="linkedin" placeholder="@lang('l.Linkedin')">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="play_store_link" class="form-label fw-medium">
                                            @lang('l.Play Store Link')
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-google-play"></i></span>
                                            <input type="text" class="form-control" value="{{ $settings['play_store_link'] }}"
                                                id="play_store_link" name="play_store_link" placeholder="@lang('l.Play Store Link')">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="app_store_link" class="form-label fw-medium">
                                            @lang('l.App Store Link')
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-apple"></i></span>
                                            <input type="text" class="form-control" value="{{ $settings['app_store_link'] }}"
                                                id="app_store_link" name="app_store_link" placeholder="@lang('l.App Store Link')">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="address" class="form-label fw-medium">
                                            @lang('l.Address')
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            <textarea class="form-control" id="address" rows="4" name="address">{{ $settings['address'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Control Buttons -->
                    <div class="col-12 mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="fas fa-save me-1"></i> @lang('l.Save Changes')
                        </button>
                        <a href="{{ route('dashboard.admins.settings') }}" class="btn btn-outline-secondary px-4 py-2">
                            <i class="fas fa-arrow-left me-1"></i> @lang('l.Back')
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
