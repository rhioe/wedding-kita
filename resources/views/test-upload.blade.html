<!DOCTYPE html>
<html>
<head>
    <title>Test Upload Auto Parallel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* === BASE STYLES === */
        .preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
            margin-top: 20px;
        }
        .preview-item {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            transition: all 0.3s;
        }
        .preview-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .preview-img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            transition: filter 0.5s;
        }
        .file-info {
            padding: 8px;
            background: rgba(0,0,0,0.7);
            color: white;
            font-size: 12px;
        }
        
        /* === REMOVE BUTTON === */
.remove-btn {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(239, 68, 68, 0.9);
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 20;
    opacity: 0;
    transition: all 0.3s;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    border: 2px solid white;
}
.preview-item:hover .remove-btn {
    opacity: 1;
}

/* === MOBILE: X ALWAYS VISIBLE & BETTER TAP AREA === */
@media (max-width: 767px) {
    .remove-btn {
        opacity: 1 !important;
        width: 32px !important;
        height: 32px !important;
        background: #ef4444 !important; /* Solid red */
        box-shadow: 0 3px 8px rgba(0,0,0,0.4) !important;
        top: 6px !important;
        right: 6px !important;
        border: 2px solid white !important;
        transform: scale(1);
        transition: transform 0.2s;
    }
    .remove-btn i {
        font-size: 16px !important;
    }
    
    /* Tap feedback */
    .remove-btn:active {
        transform: scale(0.9);
        background: #dc2626 !important;
    }
    
    /* Preview item mobile adjustments */
    .preview-item {
        border-width: 1px;
    }
    
    /* Progress ring smaller on mobile */
    .progress-ring {
        width: 40px;
        height: 40px;
    }
    
    /* Better grid for mobile */
    .preview-container {
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 8px;
    }
}

/* === MOBILE HEADER ADJUSTMENTS === */
@media (max-width: 767px) {
    .counter-badge {
        font-size: 12px;
        padding: 1px 6px;
        margin-left: 4px;
    }
    
    .error-message {
        font-size: 12px;
        padding: 4px 8px;
        margin-left: 8px;
        margin-top: 4px;
    }
    
    /* Stack header on mobile */
    .flex-col.sm\\:flex-row {
        flex-direction: column;
        align-items: flex-start;
    }
}

/* === BETTER TOUCH TARGETS FOR MOBILE === */
@media (max-width: 767px) {
    /* Larger clickable areas */
    #dropZone {
        padding: 24px 16px;
    }
    
    /* Thumbnail badge more visible */
    .preview-item .absolute.top-2.left-2 {
        top: 4px !important;
        left: 4px !important;
        padding: 2px 6px !important;
        font-size: 10px !important;
    }
    
    /* File info more compact */
    .file-info {
        padding: 6px;
        font-size: 11px;
    }
}

/* === VERY SMALL MOBILE (iPhone SE, etc) === */
@media (max-width: 400px) {
    .remove-btn {
        width: 28px !important;
        height: 28px !important;
        top: 4px !important;
        right: 4px !important;
    }
    .remove-btn i {
        font-size: 14px !important;
    }
    
    .preview-container {
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
    }
}
        
        /* === MOBILE: X ALWAYS VISIBLE === */
        @media (max-width: 767px) {
            .remove-btn {
                opacity: 1 !important;
                width: 28px !important;
                height: 28px !important;
                background: rgba(239, 68, 68, 0.95) !important;
                box-shadow: 0 3px 8px rgba(0,0,0,0.3) !important;
            }
            .remove-btn i {
                font-size: 14px !important;
            }
        }
        
        /* === PROGRESS RING === */
        .progress-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            transition: opacity 0.5s ease-out;
        }
        .progress-ring.hidden {
            opacity: 0;
            pointer-events: none;
        }
        
        /* === STATUS BADGE === */
        .status-badge {
            position: absolute;
            bottom: 40px;
            left: 0;
            right: 0;
            text-align: center;
            padding: 3px;
            font-size: 11px;
            font-weight: bold;
            transition: opacity 0.5s;
        }
        
        /* === CUSTOM MODAL === */
        .custom-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }
        .custom-modal.active {
            opacity: 1;
            pointer-events: all;
        }
        .modal-content {
            background: white;
            padding: 24px;
            border-radius: 12px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transform: translateY(20px);
            transition: transform 0.3s;
        }
        .custom-modal.active .modal-content {
            transform: translateY(0);
        }
        
        /* === ANIMATIONS === */
        @keyframes slideInUp {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slideInUp {
            animation: slideInUp 0.3s ease-out;
        }
        .animate-slideInRight {
            animation: slideInRight 0.3s ease-out;
        }
        
        /* === COUNTER BADGE === */
        .counter-badge {
            background: #3b82f6;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
            margin-left: 8px;
        }
        
        /* === ERROR MESSAGE === */
        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 6px 12px;
            border-radius: 6px;
            border-left: 4px solid #dc2626;
            font-size: 14px;
            margin-left: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
    </style>
</head>
<body class="p-4 sm:p-8 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <h1 class="text-2xl font-bold mb-2">🚀 Test Upload AUTO PARALLEL</h1>
        <p class="text-gray-600 mb-6">WhatsApp-style upload dengan instant preview</p>
        
        <!-- Stats Bar -->
        <div class="bg-white p-4 rounded-lg shadow border mb-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="font-bold text-gray-700">📊 Upload Stats</h2>
                    <div class="flex gap-4 mt-2">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600" id="uploadedCount">0</div>
                            <div class="text-xs text-gray-500">Uploaded</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600" id="pendingCount">0</div>
                            <div class="text-xs text-gray-500">Pending</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600" id="failedCount">0</div>
                            <div class="text-xs text-gray-500">Failed</div>
                        </div>
                    </div>
                </div>
                <div class="text-sm text-gray-500 bg-gray-100 px-3 py-2 rounded">
                    <i class="fas fa-info-circle mr-2"></i>
                    Max: <?php echo ini_get('upload_max_filesize'); ?> per file • 10 foto maksimal
                </div>
            </div>
        </div>
        
        <!-- Upload Zone -->
        <div class="bg-white p-6 rounded-lg shadow border mb-6">
            <div class="text-center py-12 border-3 border-dashed border-gray-300 rounded-xl hover:border-green-400 hover:bg-green-50 transition-all duration-300 cursor-pointer"
                 onclick="document.getElementById('photoInput').click()"
                 id="dropZone">
                <div class="text-6xl text-gray-300 mb-4">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Klik atau Drop Foto</h3>
                <p class="text-gray-500 mb-4">Auto upload langsung (WhatsApp style)</p>
                <div class="text-sm text-gray-400">
                    <i class="fas fa-info-circle mr-1"></i>
                    Drag & drop atau klik untuk memilih
                </div>
            </div>
            
            <!-- Hidden File Input -->
            <input type="file" 
                   id="photoInput" 
                   name="photos[]" 
                   multiple 
                   accept="image/*"
                   class="hidden">
        </div>
        
        <!-- Preview Section -->
        <div class="bg-white p-6 rounded-lg shadow border">
            <!-- Header with Counter -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-2">
                <div class="flex items-center">
                    <i class="fas fa-images text-blue-500 mr-2 text-lg"></i>
                    <h2 class="text-lg font-bold text-gray-800">Preview & Status</h2>
                    <div id="counterHeader" class="counter-badge">(0/10)</div>
                </div>
                
                <!-- Error Message Area -->
                <div id="errorMessage" class="error-message hidden">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span id="errorText"></span>
                </div>
            </div>
            
            <!-- Preview Container -->
            <div class="preview-container" id="previewContainer">
                <!-- Photos will appear here automatically -->
            </div>
            
            <!-- Empty State -->
            <div id="emptyState" class="text-center py-12 text-gray-400">
                <i class="fas fa-images text-4xl mb-3"></i>
                <p>Belum ada foto</p>
                <p class="text-sm mt-1">Upload foto untuk melihat preview</p>
            </div>
        </div>
        
        <!-- Log Panel -->
        <div id="resultsLog" class="mt-6 p-4 bg-gray-900 text-gray-100 rounded-lg">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-bold flex items-center">
                    <i class="fas fa-terminal mr-2"></i>
                    System Log
                </h3>
                <button onclick="clearLog()" class="text-xs text-gray-400 hover:text-white">
                    <i class="fas fa-trash-alt mr-1"></i>Clear
                </button>
            </div>
            <div id="logContent" class="text-xs font-mono max-h-40 overflow-y-auto">
                <div class="text-green-400">✅ System ready for auto upload...</div>
            </div>
        </div>
    </div>

    <script>
    // ========== GLOBAL STATE ==========
    let uploadedFiles = new Map(); // filename -> {data, status, elementId}
    let uploadQueue = [];
    let isUploading = false;
    let concurrentUploads = 3;
    let currentThumbnail = null;
    const MAX_PHOTOS = 10;
    
    // ========== 1. CUSTOM CONFIRM MODAL ==========
    function showConfirmModal(filename, previewId) {
        // Remove existing modal
        const existingModal = document.getElementById('customConfirmModal');
        if (existingModal) existingModal.remove();
        
        // Create new modal
        const modal = document.createElement('div');
        modal.id = 'customConfirmModal';
        modal.className = 'custom-modal';
        modal.innerHTML = `
            <div class="modal-content">
                <div class="mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-center mb-2">Hapus Foto?</h3>
                    <p class="text-gray-600 text-center" id="modalMessage">Hapus foto "${filename}"?</p>
                </div>
                <div class="flex gap-3">
                    <button id="modalCancel" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button id="modalConfirm" class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        
        // Show modal with animation
        setTimeout(() => modal.classList.add('active'), 10);
        
        // Event listeners
        document.getElementById('modalCancel').addEventListener('click', () => {
            modal.classList.remove('active');
            setTimeout(() => modal.remove(), 300);
        });
        
        document.getElementById('modalConfirm').addEventListener('click', () => {
            removeFile(filename, previewId);
            modal.classList.remove('active');
            setTimeout(() => modal.remove(), 300);
        });
        
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
                setTimeout(() => modal.remove(), 300);
            }
        });
    }
    
    // ========== 2. AUTO UPLOAD TRIGGER ==========
    document.getElementById('photoInput').addEventListener('change', function(e) {
        handleFiles(Array.from(e.target.files));
        this.value = ''; // Reset input
    });
    
    // ========== 3. HANDLE FILES (with limit check) ==========
    function handleFiles(files) {
        if (files.length === 0) return;
        
        logMessage(`📁 Selected ${files.length} file(s)`, 'info');
        
        // Check max limit
        const availableSlots = MAX_PHOTOS - uploadedFiles.size;
        if (availableSlots <= 0) {
            showError(`Maksimal ${MAX_PHOTOS} foto sudah tercapai`);
            return;
        }
        
        if (files.length > availableSlots) {
            const excess = files.length - availableSlots;
            showError(`Maksimal ${MAX_PHOTOS} foto. ${excess} foto akan diabaikan.`);
            files = files.slice(0, availableSlots);
        }
        
        // Process each file
        files.forEach(file => {
            if (uploadedFiles.size < MAX_PHOTOS) {
                processFile(file);
            }
        });
    }
    
    // ========== 4. PROCESS FILE ==========
    function processFile(file) {
        const fileId = generateFileId(file);
        
        // Check duplicate
        if (uploadedFiles.has(file.name)) {
            logMessage(`❌ "${file.name}" sudah ada`, 'error');
            showToast('error', `Foto "${file.name}" sudah ada`);
            return;
        }
        
        // Create preview
        const previewId = `preview-${fileId}`;
        createPreview(file, previewId);
        
        // Add to state
        const fileData = {
            id: fileId,
            file: file,
            name: file.name,
            size: file.size,
            previewId: previewId,
            status: 'pending',
            progress: 0
        };
        
        uploadedFiles.set(file.name, fileData);
        uploadQueue.push(fileData);
        
        updateCounters();
        
        // Auto start upload
        if (!isUploading && uploadQueue.length > 0) {
            startUploadProcess();
        }
    }
    
    // ========== 5. PARALLEL UPLOAD PROCESS ==========
    async function startUploadProcess() {
        if (isUploading || uploadQueue.length === 0) return;
        
        isUploading = true;
        logMessage(`🚀 Starting parallel upload (${uploadQueue.length} files)...`, 'info');
        
        // Process in batches
        while (uploadQueue.length > 0) {
            const batch = uploadQueue.splice(0, Math.min(concurrentUploads, uploadQueue.length));
            
            try {
                await Promise.all(batch.map(fileData => uploadFile(fileData)));
                logMessage(`✅ Batch completed, ${uploadQueue.length} remaining`, 'success');
            } catch (error) {
                logMessage(`❌ Batch error: ${error.message}`, 'error');
            }
            
            // Small delay between batches
            if (uploadQueue.length > 0) {
                await new Promise(resolve => setTimeout(resolve, 300));
            }
        }
        
        isUploading = false;
        logMessage('🎉 All uploads completed!', 'success');
    }
    
    // ========== 6. UPLOAD SINGLE FILE ==========
    async function uploadFile(fileData) {
        return new Promise((resolve, reject) => {
            updateFileStatus(fileData.name, 'uploading', 10);
            
            const formData = new FormData();
            formData.append('photos[]', fileData.file);
            formData.append('_token', '<?php echo csrf_token(); ?>');
            
            const xhr = new XMLHttpRequest();
            
            // Progress tracking
            xhr.upload.addEventListener('progress', (e) => {
                if (e.lengthComputable) {
                    const percent = 10 + Math.round((e.loaded / e.total) * 50); // 10-60%
                    updateFileStatus(fileData.name, 'uploading', percent);
                }
            });
            
            // On load
            xhr.addEventListener('load', () => {
                if (xhr.status === 200) {
                    // Simulate compression
                    simulateCompression(fileData.name)
                        .then(() => {
                            updateFileStatus(fileData.name, 'completed', 100);
                            resolve();
                        })
                        .catch(reject);
                } else {
                    updateFileStatus(fileData.name, 'error', 0);
                    reject(new Error(`HTTP ${xhr.status}`));
                }
            });
            
            // Error handling
            xhr.addEventListener('error', () => {
                updateFileStatus(fileData.name, 'error', 0);
                reject(new Error('Network error'));
            });
            
            xhr.open('POST', '<?php echo route("test.upload.handle"); ?>', true);
            xhr.timeout = 30000;
            xhr.send(formData);
        });
    }
    
    // ========== 7. COMPRESSION SIMULATION ==========
    function simulateCompression(filename) {
        return new Promise(resolve => {
            updateFileStatus(filename, 'compressing', 60);
            
            // Simulate compression time
            setTimeout(() => {
                updateFileStatus(filename, 'compressing', 80);
                setTimeout(() => {
                    updateFileStatus(filename, 'compressing', 95);
                    setTimeout(() => resolve(), 200);
                }, 300);
            }, 300);
        });
    }
    
    // ========== 8. CREATE PREVIEW ==========
    function createPreview(file, previewId) {
        const container = document.getElementById('previewContainer');
        const emptyState = document.getElementById('emptyState');
        
        // Hide empty state
        if (emptyState) emptyState.style.display = 'none';
        
        const previewItem = document.createElement('div');
        previewItem.className = 'preview-item cursor-pointer';
        previewItem.id = previewId;
        
        const isFirstPhoto = uploadedFiles.size === 1; // Karena belum ditambahkan ke map
        
        previewItem.innerHTML = `
            <!-- Remove Button -->
            <div class="remove-btn" onclick="event.stopPropagation(); showConfirmModal('${file.name}', '${previewId}')">
                <i class="fas fa-times"></i>
            </div>
            
            <!-- Thumbnail Badge -->
            ${isFirstPhoto ? `
            <div class="absolute top-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded-full flex items-center z-10 shadow-md">
                <i class="fas fa-star text-xs mr-1"></i>
                <span class="hidden sm:inline">Thumbnail</span>
            </div>
            ` : ''}
            
            <!-- Image -->
            <img src="" class="preview-img" style="filter: blur(5px);">
            
            <!-- Progress Ring -->
            <div id="ring-container-${previewId}" class="progress-ring">
                <svg width="50" height="50" viewBox="0 0 50 50">
                    <circle cx="25" cy="25" r="20" fill="none" stroke="#e5e7eb" stroke-width="4"/>
                    <circle id="ring-${previewId}" cx="25" cy="25" r="20" fill="none" 
                            stroke="#3b82f6" stroke-width="4" stroke-linecap="round"
                            stroke-dasharray="126" stroke-dashoffset="126"/>
                </svg>
                <div id="percent-${previewId}" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xs font-bold">
                    0%
                </div>
            </div>
            
            <!-- Status Badge -->
            <div id="status-${previewId}" class="status-badge bg-blue-500 text-white">
                Pending
            </div>
            
            <!-- File Info -->
            <div class="file-info">
                <div class="truncate" title="${file.name}">${file.name}</div>
                <div class="text-xs mt-1">${formatBytes(file.size)}</div>
            </div>
        `;
        
        // Load preview image
        const reader = new FileReader();
        reader.onload = function(e) {
            previewItem.querySelector('img').src = e.target.result;
        };
        reader.readAsDataURL(file);
        
        // Click to select as thumbnail
        previewItem.addEventListener('click', function(e) {
            if (!e.target.closest('.remove-btn')) {
                selectAsThumbnail(previewId, file.name);
            }
        });
        
        container.appendChild(previewItem);
        
        // Set as thumbnail if first photo
        if (isFirstPhoto) {
            currentThumbnail = previewId;
        }
        
        updateCounterDisplay();
    }
    
    // ========== 9. UPDATE FILE STATUS ==========
    function updateFileStatus(filename, status, progress) {
        const fileData = uploadedFiles.get(filename);
        if (!fileData) return;
        
        fileData.status = status;
        fileData.progress = progress;
        
        const previewId = fileData.previewId;
        const ringContainer = document.getElementById(`ring-container-${previewId}`);
        const ring = document.getElementById(`ring-${previewId}`);
        const percentText = document.getElementById(`percent-${previewId}`);
        const statusBadge = document.getElementById(`status-${previewId}`);
        const img = document.querySelector(`#${previewId} img`);
        
        if (ring && percentText) {
            const dashoffset = 126 - (126 * progress / 100);
            ring.style.strokeDashoffset = dashoffset;
            percentText.textContent = `${progress}%`;
            
            // Update colors
            if (status === 'completed') {
                ring.style.stroke = '#10b981';
                percentText.className = 'absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xs font-bold text-green-600';
                if (img) img.style.filter = 'none';
                
                // Hide progress ring
                setTimeout(() => {
                    if (ringContainer) ringContainer.classList.add('hidden');
                }, 500);
                
            } else if (status === 'error') {
                ring.style.stroke = '#ef4444';
                percentText.className = 'absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xs font-bold text-red-600';
                
            } else if (status === 'compressing') {
                ring.style.stroke = '#f59e0b';
                percentText.className = 'absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xs font-bold text-yellow-600';
                
            } else {
                ring.style.stroke = '#3b82f6';
                percentText.className = 'absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xs font-bold text-blue-600';
            }
        }
        
        if (statusBadge) {
            statusBadge.textContent = getStatusText(status);
            statusBadge.className = `status-badge ${getStatusColor(status)}`;
            
            if (status === 'completed') {
                setTimeout(() => {
                    statusBadge.style.opacity = '0';
                }, 1000);
            }
        }
        
        updateCounters();
    }
    
    // ========== 10. SELECT AS THUMBNAIL ==========
    function selectAsThumbnail(previewId, filename) {
        if (currentThumbnail === previewId) return;
        
        // Remove previous thumbnail badge
        if (currentThumbnail) {
            const prevItem = document.getElementById(currentThumbnail);
            if (prevItem) {
                const prevBadge = prevItem.querySelector('.absolute.top-2.left-2');
                if (prevBadge) prevBadge.remove();
            }
        }
        
        // Add badge to new thumbnail
        const previewItem = document.getElementById(previewId);
        if (previewItem) {
            let badge = previewItem.querySelector('.absolute.top-2.left-2');
            if (!badge) {
                badge = document.createElement('div');
                badge.className = 'absolute top-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded-full flex items-center z-10 shadow-md';
                badge.innerHTML = '<i class="fas fa-star text-xs mr-1"></i><span class="hidden sm:inline">Thumbnail</span>';
                previewItem.insertBefore(badge, previewItem.firstChild);
            }
            
            currentThumbnail = previewId;
            logMessage(`📌 Selected "${filename}" as thumbnail`, 'info');
        }
    }
    
    // ========== 11. REMOVE FILE ==========
    function removeFile(filename, previewId) {
        // Remove from state
        uploadedFiles.delete(filename);
        uploadQueue = uploadQueue.filter(f => f.name !== filename);
        
        // Remove from DOM
        const previewItem = document.getElementById(previewId);
        if (previewItem) previewItem.remove();
        
        // Handle thumbnail reassignment
        if (currentThumbnail === previewId) {
            const firstItem = document.querySelector('.preview-item');
            if (firstItem) {
                const firstFilename = firstItem.querySelector('.file-info div').textContent;
                selectAsThumbnail(firstItem.id, firstFilename);
            } else {
                currentThumbnail = null;
            }
        }
        
        // Show empty state if no photos
        if (uploadedFiles.size === 0) {
            document.getElementById('emptyState').style.display = 'block';
        }
        
        updateCounters();
        updateCounterDisplay();
        hideError(); // Clear any error message
        
        logMessage(`🗑️ Removed "${filename}"`, 'info');
        showToast('success', `Foto "${filename}" dihapus`);
    }
    
    // ========== 12. HELPER FUNCTIONS ==========
    function updateCounters() {
        const files = Array.from(uploadedFiles.values());
        const completed = files.filter(f => f.status === 'completed').length;
        const pending = files.filter(f => f.status === 'pending' || f.status === 'uploading' || f.status === 'compressing').length;
        const failed = files.filter(f => f.status === 'error').length;
        
        document.getElementById('uploadedCount').textContent = completed;
        document.getElementById('pendingCount').textContent = pending;
        document.getElementById('failedCount').textContent = failed;
    }
    
    function updateCounterDisplay() {
        const total = uploadedFiles.size;
        document.getElementById('counterHeader').textContent = `(${total}/${MAX_PHOTOS})`;
        
        // Show error if max reached
        if (total >= MAX_PHOTOS) {
            showError(`Maksimal ${MAX_PHOTOS} foto`);
        }
    }
    
    function showError(message) {
        const errorDiv = document.getElementById('errorMessage');
        const errorText = document.getElementById('errorText');
        
        errorText.textContent = message;
        errorDiv.classList.remove('hidden');
    }
    
    function hideError() {
        document.getElementById('errorMessage').classList.add('hidden');
    }
    
    function getStatusText(status) {
        const texts = {
            'pending': 'Waiting',
            'uploading': 'Uploading',
            'compressing': 'Compressing',
            'completed': '✓ Done',
            'error': '✗ Error'
        };
        return texts[status] || status;
    }
    
    function getStatusColor(status) {
        const colors = {
            'pending': 'bg-gray-500',
            'uploading': 'bg-blue-500',
            'compressing': 'bg-yellow-500',
            'completed': 'bg-green-500',
            'error': 'bg-red-500'
        };
        return colors[status] || 'bg-gray-500';
    }
    
    function generateFileId(file) {
        return Date.now() + '-' + Math.random().toString(36).substr(2, 9);
    }
    
    function formatBytes(bytes, decimals = 1) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }
    
    function logMessage(message, type = 'info') {
        const logContent = document.getElementById('logContent');
        const timestamp = new Date().toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit',
            second: '2-digit'
        });
        
        const color = {
            'info': 'text-blue-400',
            'success': 'text-green-400',
            'error': 'text-red-400',
            'upload': 'text-yellow-400',
            'compress': 'text-purple-400'
        }[type] || 'text-gray-400';
        
        const logEntry = document.createElement('div');
        logEntry.className = `${color} mb-1`;
        logEntry.innerHTML = `[${timestamp}] ${message}`;
        
        logContent.appendChild(logEntry);
        logContent.scrollTop = logContent.scrollHeight;
    }
    
    function clearLog() {
        document.getElementById('logContent').innerHTML = 
            '<div class="text-green-400">✅ Log cleared</div>';
    }
    
    function showToast(type, message) {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 left-4 px-4 py-3 rounded-lg shadow-lg text-white font-medium ${
            type === 'error' ? 'bg-red-500' : 'bg-green-500'
        } animate-slideInUp z-50 max-w-sm`;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.5s';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }
    
    // ========== 13. DRAG & DROP ==========
    const dropZone = document.getElementById('dropZone');
    
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-green-500', 'bg-green-50');
    });
    
    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-green-500', 'bg-green-50');
    });
    
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-green-500', 'bg-green-50');
        
        const files = Array.from(e.dataTransfer.files)
            .filter(file => file.type.startsWith('image/'));
            
        if (files.length > 0) {
            handleFiles(files);
        }
    });
    
    // ========== 14. INITIALIZATION ==========
    document.addEventListener('DOMContentLoaded', function() {
        logMessage('🟢 System ready. Pilih foto untuk auto upload...', 'success');
        updateCounterDisplay();
    });
    </script>
</body>
</html>