<div class="tab-pane fade show active" id="v-pills-General" role="tabpanel" aria-labelledby="v-pills-General-tab">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 text-white">
                <i class="fas fa-palette me-2 animate__animated animate__fadeIn"></i>@lang('l.Theme settings')
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('dashboard.admins.settings-update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="text-muted mb-4"><i class="fas fa-paint-brush me-2"></i>@lang('l.Select Theme')</h6>
                                <div class="row g-4">
                                    @foreach ($themes as $theme)
                                        <div class="col-md-4">
                                            <div class="theme-card">
                                                <input type="radio" name="theme" id="theme-{{ $theme->id }}"
                                                    value="{{ $theme->name }}"
                                                    {{ $settings['theme'] == $theme->name ? 'checked' : '' }}
                                                    class="theme-input">
                                                <label for="theme-{{ $theme->id }}"
                                                    class="theme-label {{ $settings['theme'] == $theme->name ? 'selected' : '' }}">
                                                    <div class="theme-preview">
                                                        <img src="{{ asset($theme->image) }}" alt="{{ $theme->name }}"
                                                            class="theme-image">
                                                        <div class="theme-overlay">
                                                            <span class="theme-check"><i class="fas fa-check-circle"></i></span>
                                                        </div>
                                                    </div>
                                                    <span class="theme-name mt-2">{{ ucfirst($theme->name) }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="text-muted mb-4"><i class="fas fa-fill-drip me-2"></i>@lang('l.Color Settings')</h6>
                                <div class="form-group">
                                    <label for="primary_color" class="form-label">@lang('l.Primary color')</label>
                                    <div class="color-picker-wrapper">
                                        <input type="color" name="primary_color" id="primary_color"
                                            class="form-control color-picker"
                                            value="{{ $settings['primary_color'] }}">
                                        <span class="color-preview">{{ $settings['primary_color'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="text-muted mb-4">
                                    <i class="fas fa-cloud-upload-alt me-2"></i>@lang('l.Upload New Theme')
                                </h6>
                                <div class="theme-upload-area" id="upload-area">
                                    <input type="file" name="new_theme" id="new_theme" class="theme-upload-input" accept=".zip">
                                    <label for="new_theme" class="theme-upload-label">
                                        <div class="upload-icon">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </div>
                                        <div class="upload-text">
                                            <h5>@lang('l.Drop theme file here or click to upload')</h5>
                                            <p class="text-muted">@lang('l.Supported format: ZIP file containing theme files')</p>
                                        </div>
                                    </label>
                                    <div class="upload-preview d-none">
                                        <div class="preview-content">
                                            <i class="fas fa-file-archive text-primary"></i>
                                            <span class="filename"></span>
                                        </div>
                                        <button type="button" class="btn-remove-file">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4 d-flex gap-3 justify-content-end">
                        <button type="submit" class="btn btn-primary px-4 py-2 d-flex align-items-center">
                            <i class="fas fa-save me-2"></i> @lang('l.Save Changes')
                        </button>
                        <a href="{{ route('dashboard.admins.settings') }}"
                            class="btn btn-outline-primary px-4 py-2 d-flex align-items-center">
                            <i class="fas fa-arrow-left me-2"></i> @lang('l.Back')
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .theme-label {
        display: block;
        cursor: pointer;
        border: 2px solid transparent;
        padding: 5px;
        border-radius: 5px;
        transition: border-color 0.3s;
    }

    .theme-image {
        width: 100%;
        height: auto;
        border-radius: 5px;
    }

    .theme-name {
        display: block;
        text-align: center;
        margin-top: 5px;
        font-weight: bold;
    }
</style>

<style>
.bg-gradient-primary {
    background: var(--bs-primary);
}

.theme-card {
    position: relative;
    transition: all 0.3s ease;
}

.theme-input {
    display: none;
}

.theme-label {
    display: block;
    cursor: pointer;
    text-align: center;
    padding: 10px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.theme-preview {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.theme-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.theme-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.theme-check {
    color: white;
    font-size: 2rem;
    transform: scale(0);
    transition: transform 0.3s ease;
}

.theme-name {
    display: block;
    margin-top: 10px;
    font-weight: 500;
}

.theme-label.selected {
    /* background: #f8f9fa; */
    transform: translateY(-5px);
}

.theme-label.selected .theme-overlay {
    opacity: 1;
}

.theme-label.selected .theme-check {
    transform: scale(1);
}

.theme-label:hover .theme-image {
    transform: scale(1.05);
}

.color-picker-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
}

.color-picker {
    width: 100px;
    height: 40px;
    padding: 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.color-preview {
    font-family: monospace;
    /* color: #666; */
}

.btn {
    transition: transform 0.2s ease;
}

.btn:hover {
    transform: translateY(-2px);
}

.theme-upload-area {
    border: 2px dashed var(--bs-primary);
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    position: relative;
    transition: all 0.3s ease;
}

.theme-upload-input {
    display: none;
}

.theme-upload-label {
    cursor: pointer;
    display: block;
    padding: 20px;
}

.upload-icon {
    font-size: 3rem;
    color: var(--bs-primary);
    margin-bottom: 15px;
}

.upload-text h5 {
    margin-bottom: 10px;
    color: var(--bs-primary);
}

.theme-upload-area:hover {
    background-color: rgba(var(--bs-primary-rgb), 0.05);
}

.upload-preview {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.preview-content {
    display: flex;
    align-items: center;
    gap: 10px;
}

.preview-content i {
    font-size: 1.5rem;
}

.btn-remove-file {
    border: none;
    background: none;
    color: #dc3545;
    cursor: pointer;
    padding: 5px;
    transition: transform 0.2s ease;
}

.btn-remove-file:hover {
    transform: scale(1.1);
}

.theme-upload-area.dragover {
    background-color: rgba(var(--bs-primary-rgb), 0.1);
    border-style: solid;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('new_theme');
    const uploadArea = document.getElementById('upload-area');
    const uploadPreview = document.querySelector('.upload-preview');
    const filename = document.querySelector('.filename');
    const uploadLabel = document.querySelector('.theme-upload-label');
    const removeButton = document.querySelector('.btn-remove-file');

    // وظائف السحب والإفلات
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('dragover');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            if (file.name.toLowerCase().endsWith('.zip')) {
                fileInput.files = files;
                showPreview(file);
            } else {
                alert('@lang("l.Please upload a ZIP file")');
            }
        }
    });

    function showPreview(file) {
        filename.textContent = file.name;
        uploadPreview.classList.remove('d-none');
        uploadLabel.classList.add('d-none');
    }

    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            showPreview(this.files[0]);
        }
    });

    removeButton.addEventListener('click', function() {
        fileInput.value = '';
        uploadPreview.classList.add('d-none');
        uploadLabel.classList.remove('d-none');
    });
});
</script>
