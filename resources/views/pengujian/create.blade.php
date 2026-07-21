@extends('layouts.app')

@section('title', 'Form Pengujian')

@section('content')
<style>
    /* Form Styling */
    .form-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        padding: 25px 30px;
        margin-bottom: 25px;
    }
    
    .form-section .section-title {
        font-weight: 700;
        color: #2c3e50;
        font-size: 18px;
        margin-bottom: 5px;
    }
    
    .form-section .section-subtitle {
        color: #7f8c8d;
        font-size: 13px;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f2f5;
    }
    
    .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #2c3e50;
        margin-bottom: 4px;
    }
    
    .form-label .required {
        color: #e74c3c;
        margin-left: 3px;
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #dce1e8;
        padding: 10px 14px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #1a6e4a;
        box-shadow: 0 0 0 3px rgba(26, 110, 74, 0.1);
    }
    
    .form-control[readonly] {
        background: #f8f9fa;
        cursor: not-allowed;
    }
    
    .form-control::placeholder {
        color: #b0b8c4;
        font-size: 13px;
    }
    
    /* Info Cards */
    .info-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    
    .info-card .info-icon {
        font-size: 20px;
        color: #1a6e4a;
    }
    
    .info-card .info-label {
        font-size: 12px;
        color: #7f8c8d;
        font-weight: 500;
    }
    
    .info-card .info-value {
        font-size: 14px;
        color: #2c3e50;
        font-weight: 600;
    }
    
    /* Alert Info */
    .alert-info-custom {
        background: #e8f5e9;
        border: 1px solid #27ae60;
        color: #1a6e4a;
        border-radius: 8px;
        padding: 15px 20px;
        margin-top: 20px;
    }
    
    .alert-info-custom i {
        font-size: 18px;
        margin-right: 10px;
    }
    
    /* Upload Area */
    .upload-area {
        border: 2px dashed #dce1e8;
        border-radius: 8px;
        padding: 30px 20px;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
        background: #fafbfc;
        position: relative;
    }
    
    .upload-area:hover {
        border-color: #1a6e4a;
        background: #f0f9f4;
    }
    
    .upload-area.dragover {
        border-color: #1a6e4a;
        background: #e8f5e9;
    }
    
    .upload-area .upload-icon {
        font-size: 40px;
        color: #b0b8c4;
        margin-bottom: 10px;
    }
    
    .upload-area .upload-text {
        color: #7f8c8d;
        font-size: 14px;
    }
    
    .upload-area .upload-text strong {
        color: #1a6e4a;
    }
    
    .upload-area .upload-formats {
        font-size: 12px;
        color: #b0b8c4;
        margin-top: 6px;
    }
    
    /* File List */
    .file-list-container {
        margin-top: 15px;
        max-height: 300px;
        overflow-y: auto;
    }
    
    .file-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 8px;
        border-left: 3px solid #1a6e4a;
        transition: all 0.3s;
    }
    
    .file-item:hover {
        background: #f0f2f5;
    }
    
    .file-item .file-info {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        min-width: 0;
    }
    
    .file-item .file-icon {
        font-size: 24px;
        color: #1a6e4a;
        flex-shrink: 0;
    }
    
    .file-item .file-name {
        font-size: 14px;
        color: #2c3e50;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .file-item .file-size {
        font-size: 12px;
        color: #95a5a6;
        flex-shrink: 0;
        margin: 0 10px;
    }
    
    .file-item .file-actions {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }
    
    .file-item .btn-file-action {
        padding: 4px 10px;
        font-size: 12px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
    }
    
    .file-item .btn-file-action.btn-view {
        background: #e8f5e9;
        color: #1a6e4a;
    }
    
    .file-item .btn-file-action.btn-view:hover {
        background: #1a6e4a;
        color: white;
    }
    
    .file-item .btn-file-action.btn-remove {
        background: #fce4ec;
        color: #c62828;
    }
    
    .file-item .btn-file-action.btn-remove:hover {
        background: #c62828;
        color: white;
    }
    
    /* File Preview */
    .file-preview-container {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #f0f2f5;
    }
    
    .file-preview-container .preview-title {
        font-weight: 600;
        color: #2c3e50;
        font-size: 14px;
        margin-bottom: 10px;
    }
    
    .file-preview {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        max-height: 400px;
        overflow: auto;
    }
    
    .file-preview iframe {
        width: 100%;
        height: 350px;
        border: none;
        border-radius: 6px;
    }
    
    .file-preview .preview-placeholder {
        text-align: center;
        padding: 40px 20px;
        color: #95a5a6;
    }
    
    .file-preview .preview-placeholder i {
        font-size: 48px;
        opacity: 0.3;
        display: block;
        margin-bottom: 10px;
    }
    
    /* Action Buttons */
    .form-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        padding-top: 20px;
        border-top: 2px solid #f0f2f5;
        margin-top: 10px;
    }
    
    .btn-submit-pengujian {
        background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%);
        color: white;
        border: none;
        padding: 10px 35px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }
    
    .btn-submit-pengujian:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(26, 110, 74, 0.4);
        color: white;
    }
    
    .btn-submit-pengujian:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    
    .btn-cancel {
        background: #f0f2f5;
        color: #7f8c8d;
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .btn-cancel:hover {
        background: #e0e5ec;
        color: #2c3e50;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .form-section {
            padding: 15px 18px;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .form-actions .btn {
            width: 100%;
            justify-content: center;
        }
        
        .info-card {
            flex-wrap: wrap;
        }
        
        .file-item {
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .file-item .file-info {
            width: 100%;
        }
        
        .file-item .file-actions {
            width: 100%;
            justify-content: flex-end;
        }
    }
</style>

<div class="row">
    <div class="col-12">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">
                    <i class="bi bi-clipboard2-check me-2" style="color: #1a6e4a;"></i>
                    Form Pengujian
                </h4>
                <p class="text-muted mb-0" style="font-size: 14px;">
                    <strong>Nomor Permohonan:</strong> {{ $permohonan->nomor_surat_permohonan ?? 'PMH-'.str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}
                </p>
            </div>
            <a href="{{ route('dashboard.admin') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <!-- Info Permohonan -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-file-earmark-text me-2" style="color: #1a6e4a;"></i>
                Detail Permohonan
            </div>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="bi bi-file-earmark"></i>
                        </div>
                        <div>
                            <div class="info-label">Nomor Permohonan</div>
                            <div class="info-value">
                                {{ $permohonan->nomor_surat_permohonan ?? 'PMH-'.str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        <div>
                            <div class="info-label">Pemohon</div>
                            <div class="info-value">{{ $permohonan->nama_pemohon }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="bi bi-tools"></i>
                        </div>
                        <div>
                            <div class="info-label">Alsintan</div>
                            <div class="info-value">{{ $permohonan->jenis_alsintan }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="bi bi-tag"></i>
                        </div>
                        <div>
                            <div class="info-label">Merek/Tipe</div>
                            <div class="info-value">{{ $permohonan->merek_model_tipe }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <span class="badge bg-success">
                    <i class="bi bi-check-circle me-1"></i> Validasi Selesai
                </span>
                <span class="text-muted ms-2" style="font-size: 13px;">
                    {{ $permohonan->tanggal_surat_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_surat_permohonan)->format('d M Y') : '-' }}
                </span>
            </div>
        </div>

        <!-- Form Pengujian -->
        <form method="POST" action="{{ route('pengujian.store', $permohonan->id) }}" enctype="multipart/form-data" id="formPengujian">
            @csrf
            <div class="form-section">
                <div class="section-title">
                    <i class="bi bi-clipboard-data me-2" style="color: #1a6e4a;"></i>
                    Form Pengujian
                </div>
                <div class="section-subtitle">
                    Berdasarkan Permohonan Uji No. <strong>{{ $permohonan->nomor_surat_permohonan ?? 'PMH-'.str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}</strong>
                </div>

                <!-- Berdasarkan Permohonan Uji No. -->
                <div class="mb-3">
                    <label for="nomor_permohonan_uji" class="form-label">
                        Berdasarkan Permohonan Uji No.
                    </label>
                    <input type="text" class="form-control" id="nomor_permohonan_uji" 
                           name="nomor_permohonan_uji" 
                           value="{{ $permohonan->nomor_surat_permohonan ?? 'PMH-'.str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) }}" 
                           readonly>
                </div>

                <!-- Tanggal Pengujian -->
                <div class="mb-3">
                    <label for="tanggal_pengujian" class="form-label">
                        Tanggal Pengujian <span class="required">*</span>
                    </label>
                    <input type="date" class="form-control @error('tanggal_pengujian') is-invalid @enderror" 
                           id="tanggal_pengujian" name="tanggal_pengujian" 
                           value="{{ old('tanggal_pengujian', date('Y-m-d')) }}" required>
                    @error('tanggal_pengujian')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Lokasi Pengujian -->
                <div class="mb-3">
                    <label for="lokasi" class="form-label">
                        Lokasi Pengujian <span class="required">*</span>
                    </label>
                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                           id="lokasi" name="lokasi" 
                           placeholder="Contoh: Laboratorium LPMA UPTD BMSPP, Bogor"
                           value="{{ old('lokasi') }}" required>
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Deskripsi Pengujian -->
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">
                        Deskripsi Pengujian
                    </label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" name="deskripsi" rows="4"
                              placeholder="Deskripsi proses dan lingkup pengujian yang dilakukan...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ============================================ -->
                <!-- UPLOAD FILE - TAMBAHKAN DI SINI              -->
                <!-- ============================================ -->
                <div class="mt-4">
                    <div class="section-title" style="font-size: 16px; margin-bottom: 15px;">
                        <i class="bi bi-upload me-2" style="color: #1a6e4a;"></i>
                        Upload Dokumen Pendukung
                    </div>
                    <div class="section-subtitle" style="font-size: 13px;">
                        Upload file dokumentasi atau bukti pendukung pengujian (Opsional)
                    </div>

                    <!-- Upload Area -->
                    <div class="mb-3">
                        <label for="file_pengujian" class="form-label">
                            File Dokumentasi Pengujian
                        </label>
                        
                        <div class="upload-area" id="uploadArea">
                            <div class="upload-icon">
                                <i class="bi bi-cloud-arrow-up"></i>
                            </div>
                            <div class="upload-text">
                                <strong>Klik untuk upload</strong> atau drag and drop
                            </div>
                            <div class="upload-formats">
                                Format: PDF / JPG / PNG (Maks. 5MB per file)
                                <br>
                                <small class="text-muted">Anda dapat memilih beberapa file sekaligus (Ctrl+klik atau drag multiple)</small>
                            </div>
                        </div>
                        
                        <input type="file" class="d-none" id="file_pengujian" 
                               name="file_pengujian[]" 
                               accept=".pdf,.jpg,.jpeg,.png"
                               multiple>
                        
                        @error('file_pengujian')
                            <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                        @enderror
                        @error('file_pengujian.*')
                            <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- File List -->
                    <div id="fileListContainer" class="file-list-container" style="display: none;">
                        <h6 class="fw-semibold text-dark mb-2">
                            <i class="bi bi-files me-1"></i>
                            File yang akan diupload (<span id="fileCount">0</span>)
                        </h6>
                        <div id="fileList"></div>
                    </div>

                    <!-- File Preview -->
                    <div id="filePreviewContainer" class="file-preview-container" style="display: none;">
                        <div class="preview-title">
                            <i class="bi bi-eye me-1"></i>
                            Preview File
                        </div>
                        <div class="file-preview" id="filePreview">
                            <div class="preview-placeholder">
                                <i class="bi bi-file-earmark"></i>
                                <p>Klik tombol <strong>Lihat</strong> pada file untuk melihat preview</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Alert -->
                <div class="alert-info-custom">
                    <i class="bi bi-info-circle"></i>
                    <strong>Informasi:</strong>
                    Data pengujian tidak dapat diedit setelah disimpan.
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="form-section">
                <div class="form-actions">
                    <button type="submit" class="btn-submit-pengujian" id="btnSubmit">
                        <i class="bi bi-save"></i> Simpan Data Pengujian
                    </button>
                    <a href="{{ route('dashboard.admin') }}" class="btn-cancel">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============================================
    // VARIABLES
    // ============================================
    const fileInput = document.getElementById('file_pengujian');
    const uploadArea = document.getElementById('uploadArea');
    const fileListContainer = document.getElementById('fileListContainer');
    const fileList = document.getElementById('fileList');
    const fileCount = document.getElementById('fileCount');
    const filePreviewContainer = document.getElementById('filePreviewContainer');
    const filePreview = document.getElementById('filePreview');
    const form = document.getElementById('formPengujian');
    
    let selectedFiles = [];
    let previewFileIndex = null;

    // ============================================
    // FILE HANDLING
    // ============================================
    function updateFileList() {
        fileList.innerHTML = '';
        
        if (selectedFiles.length === 0) {
            fileListContainer.style.display = 'none';
            filePreviewContainer.style.display = 'none';
            return;
        }
        
        fileListContainer.style.display = 'block';
        fileCount.textContent = selectedFiles.length;
        
        selectedFiles.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item';
            
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            const fileExtension = file.name.split('.').pop().toLowerCase();
            const iconMap = {
                'pdf': 'bi-file-earmark-pdf',
                'jpg': 'bi-file-earmark-image',
                'jpeg': 'bi-file-earmark-image',
                'png': 'bi-file-earmark-image',
                'doc': 'bi-file-earmark-word',
                'docx': 'bi-file-earmark-word'
            };
            const iconClass = iconMap[fileExtension] || 'bi-file-earmark';
            
            fileItem.innerHTML = `
                <div class="file-info">
                    <span class="file-icon"><i class="bi ${iconClass}"></i></span>
                    <span class="file-name" title="${file.name}">${file.name}</span>
                    <span class="file-size">${fileSize} MB</span>
                </div>
                <div class="file-actions">
                    <button type="button" class="btn-file-action btn-view" onclick="previewFile(${index})">
                        <i class="bi bi-eye"></i> Lihat
                    </button>
                    <button type="button" class="btn-file-action btn-remove" onclick="removeFile(${index})">
                        <i class="bi bi-x"></i> Hapus
                    </button>
                </div>
            `;
            
            fileList.appendChild(fileItem);
        });
        
        if (previewFileIndex !== null && previewFileIndex < selectedFiles.length) {
            previewFile(previewFileIndex);
        } else if (selectedFiles.length > 0) {
            previewFile(0);
        }
    }

    function addFiles(files) {
        const maxSize = 5 * 1024 * 1024;
        
        for (let file of files) {
            const exists = selectedFiles.some(f => 
                f.name === file.name && f.size === file.size
            );
            if (exists) continue;
            
            if (file.size > maxSize) {
                alert(`File "${file.name}" melebihi batas 5MB.`);
                continue;
            }
            
            const validExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
            const ext = file.name.split('.').pop().toLowerCase();
            if (!validExtensions.includes(ext)) {
                alert(`File "${file.name}" format tidak didukung. Gunakan PDF, JPG, atau PNG.`);
                continue;
            }
            
            selectedFiles.push(file);
        }
        
        updateFileList();
        
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    window.removeFile = function(index) {
        selectedFiles.splice(index, 1);
        
        if (previewFileIndex === index) {
            previewFileIndex = null;
            filePreviewContainer.style.display = 'none';
        } else if (previewFileIndex > index) {
            previewFileIndex--;
        }
        
        updateFileList();
        
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    };

    // ============================================
    // PREVIEW FUNCTION
    // ============================================
    window.previewFile = function(index) {
        previewFileIndex = index;
        const file = selectedFiles[index];
        if (!file) return;
        
        filePreviewContainer.style.display = 'block';
        
        const fileExtension = file.name.split('.').pop().toLowerCase();
        const isImage = ['jpg', 'jpeg', 'png'].includes(fileExtension);
        const isPDF = fileExtension === 'pdf';
        
        if (isImage) {
            const reader = new FileReader();
            reader.onload = function(e) {
                filePreview.innerHTML = `
                    <div style="text-align: center;">
                        <img src="${e.target.result}" alt="${file.name}" style="max-width: 100%; max-height: 350px; border-radius: 4px;">
                        <p class="text-muted mt-2" style="font-size: 12px;">${file.name}</p>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        } else if (isPDF) {
            const url = URL.createObjectURL(file);
            filePreview.innerHTML = `
                <iframe src="${url}" style="width: 100%; height: 350px; border: none; border-radius: 6px;"></iframe>
                <p class="text-muted mt-2" style="font-size: 12px; text-align: center;">${file.name}</p>
            `;
            setTimeout(() => URL.revokeObjectURL(url), 10000);
        } else {
            filePreview.innerHTML = `
                <div class="preview-placeholder">
                    <i class="bi bi-file-earmark"></i>
                    <p>Preview tidak tersedia untuk file ini</p>
                    <p class="text-muted" style="font-size: 12px;">${file.name}</p>
                </div>
            `;
        }
        
        filePreviewContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    // ============================================
    // EVENT LISTENERS
    // ============================================
    
    uploadArea.addEventListener('click', function() {
        fileInput.click();
    });

    fileInput.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            addFiles(this.files);
        }
        this.value = '';
    });

    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
            addFiles(e.dataTransfer.files);
        }
    });

    // ============================================
    // SET DEFAULT DATE
    // ============================================
    const tanggalInput = document.getElementById('tanggal_pengujian');
    if (tanggalInput && !tanggalInput.value) {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        tanggalInput.value = `${year}-${month}-${day}`;
    }

    // ============================================
    // FORM SUBMIT
    // ============================================
    form.addEventListener('submit', function(e) {
        // Konfirmasi submit
        if (!confirm('Apakah Anda yakin ingin menyimpan data pengujian ini? Data tidak dapat diedit kembali.')) {
            e.preventDefault();
            return false;
        }
        
        // Pastikan file input terisi jika ada file yang dipilih
        if (selectedFiles.length > 0 && fileInput.files.length === 0) {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files;
        }
        
        return true;
    });

    // Prevent default drag behavior on page
    document.addEventListener('dragover', function(e) {
        e.preventDefault();
    });

    document.addEventListener('drop', function(e) {
        e.preventDefault();
    });
});
</script>
@endsection