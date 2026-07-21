@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%);
        color: white;
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }
    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .dashboard-header::after {
        content: '';
        position: absolute;
        bottom: -30px;
        left: -30px;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .dashboard-header h4 {
        font-weight: 700;
        margin-bottom: 3px;
        position: relative;
        z-index: 1;
    }
    .dashboard-header p {
        opacity: 0.9;
        margin-bottom: 0;
        font-size: 14px;
        position: relative;
        z-index: 1;
    }
    
    /* Widget Cards */
    .widget-card {
        border-radius: 12px;
        padding: 20px 25px;
        color: white;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
        height: 100%;
    }
    .widget-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .widget-card .widget-icon {
        position: absolute;
        right: 15px;
        top: 15px;
        font-size: 35px;
        opacity: 0.15;
    }
    .widget-card h6 {
        font-weight: 500;
        opacity: 0.9;
        margin-bottom: 5px;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .widget-card h2 {
        font-weight: 700;
        margin-bottom: 0;
        font-size: 32px;
    }
    .widget-total {
        background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
    }
    .widget-admin {
        background: linear-gradient(135deg, #8e44ad 0%, #9b59b6 100%);
    }
    .widget-pemohon {
        background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%);
    }
    
    /* Card Table */
    .card-table {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 25px;
    }
    .card-table .card-body {
        padding: 0;
        overflow-x: auto;
    }
    .card-table .card-header {
        background: white;
        border-bottom: 1px solid #f0f2f5;
        padding: 12px 20px;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-table .card-header .badge-count {
        background: #1a6e4a;
        color: white;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 12px;
    }
    
    /* Table Styling */
    .table-user {
        font-size: 13px;
    }
    .table-user thead th {
        background: #f8f9fa;
        color: #2c3e50;
        font-weight: 600;
        border-bottom: 2px solid #e0e5ec;
        padding: 10px 12px;
        font-size: 12px;
        white-space: nowrap;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .table-user tbody td {
        padding: 10px 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f2f5;
    }
    .table-user tbody tr {
        transition: background 0.2s;
    }
    .table-user tbody tr:hover {
        background: #f8f9fa;
    }
    
    /* Badge Role */
    .badge-role {
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .badge-role.badge-admin {
        background: #e8d5f5;
        color: #6c3483;
    }
    .badge-role.badge-pemohon {
        background: #d4edda;
        color: #155724;
    }
    
    /* Avatar kecil di tabel */
    .avatar-sm {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 30px 20px;
        color: #95a5a6;
    }
    .empty-state i {
        font-size: 36px;
        margin-bottom: 10px;
        opacity: 0.3;
    }
    .empty-state p {
        margin-bottom: 0;
        font-size: 14px;
    }
    
    /* Search Box */
    .search-box {
        position: relative;
    }
    .search-box .form-control {
        padding-left: 35px;
        border-radius: 8px;
        border: 1px solid #e0e5ec;
        padding: 8px 14px 8px 35px;
        font-size: 13px;
        width: 250px;
    }
    .search-box .form-control:focus {
        border-color: #1a6e4a;
        box-shadow: 0 0 0 3px rgba(26, 110, 74, 0.1);
    }
    .search-box .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #95a5a6;
    }
    
    /* ============================================
       BUTTON DETAIL - MODERN
       ============================================ */
    .btn-detail {
        background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%);
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        cursor: pointer;
    }
    
    .btn-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(26, 110, 74, 0.4);
        color: white;
    }
    
    .btn-detail i {
        font-size: 14px;
    }
    
    .btn-detail:active {
        transform: translateY(0px);
    }
    
    /* Status Online/Offline */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 500;
    }
    .status-badge .status-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        animation: pulse-dot 2s infinite;
    }
    .status-badge .status-dot.online {
        background: #27ae60;
    }
    .status-badge .status-dot.offline {
        background: #95a5a6;
        animation: none;
    }
    
    @keyframes pulse-dot {
        0% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(0.8); }
        100% { opacity: 1; transform: scale(1); }
    }
    
    .last-active-text {
        font-size: 12px;
        color: #7f8c8d;
    }
    
    /* Modal Detail */
    .modal-header-custom {
        background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 20px 25px;
    }
    .modal-header-custom .btn-close-white {
        filter: brightness(0) invert(1);
    }
    
    .detail-avatar-lg {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 700;
        color: #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }
    
    .detail-item {
        display: flex;
        padding: 10px 0;
        border-bottom: 1px solid #f0f2f5;
    }
    .detail-item:last-child {
        border-bottom: none;
    }
    .detail-item .detail-label {
        font-weight: 600;
        color: #7f8c8d;
        width: 140px;
        flex-shrink: 0;
        font-size: 13px;
    }
    .detail-item .detail-value {
        color: #2c3e50;
        font-size: 14px;
        font-weight: 500;
    }
    
    .info-banner {
        background: #f0f9f4;
        border-left: 4px solid #1a6e4a;
        padding: 12px 16px;
        border-radius: 6px;
        font-size: 13px;
        color: #2c3e50;
        margin-top: 15px;
    }
    .info-banner i {
        color: #1a6e4a;
        margin-right: 8px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 20px;
        }
        .dashboard-header h4 {
            font-size: 18px;
        }
        
        .widget-card {
            padding: 15px 20px;
        }
        .widget-card h2 {
            font-size: 24px;
        }
        .widget-card .widget-icon {
            font-size: 28px;
        }
        .table-user {
            font-size: 12px;
        }
        .table-user thead th,
        .table-user tbody td {
            padding: 8px 10px;
        }
        .search-box .form-control {
            width: 100%;
        }
        .detail-item {
            flex-direction: column;
            gap: 2px;
        }
        .detail-item .detail-label {
            width: 100%;
        }
        .btn-detail {
            padding: 4px 12px;
            font-size: 11px;
        }
    }
</style>

<div>
    <!-- Header -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4><i class="bi bi-people me-2"></i>Kelola User</h4>
                <p>Manajemen akun pengguna sistem Permohonan Laboratorium</p>
            </div>
            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <span class="badge bg-light text-dark px-3 py-2">
                    <i class="bi bi-person-circle me-1"></i> 
                    {{ Auth::user()->name ?? 'Admin' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Widget Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="widget-card widget-total">
                <div class="widget-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h6>Total User</h6>
                <h2>{{ $totalUsers ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="widget-card widget-admin">
                <div class="widget-icon">
                    <i class="bi bi-person-badge"></i>
                </div>
                <h6>Admin</h6>
                <h2>{{ $totalAdmin ?? 1 }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="widget-card widget-pemohon">
                <div class="widget-icon">
                    <i class="bi bi-person"></i>
                </div>
                <h6>Pemohon</h6>
                <h2>{{ $totalPemohon ?? 0 }}</h2>
            </div>
        </div>
    </div>

    <!-- Tabel User -->
    <div class="row">
        <div class="col-12">
            <div class="card card-table">
                <div class="card-header">
                    <span><i class="bi bi-list-ul me-2"></i>Daftar Akun Pemohon</span>
                    <span class="badge-count">{{ $users->count() ?? 0 }} pemohon</span>
                </div>
                <div class="card-body">
                    <!-- Search Box -->
                    <div class="px-3 pt-3 pb-2">
                        <div class="search-box">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" class="form-control" id="searchUser" placeholder="Cari user...">
                        </div>
                    </div>
                    
                    <table class="table table-user table-hover mb-0" id="userTable">
                        <thead>
                            <tr>
                                <th style="width: 50px; text-align: center;">No</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>No. HP</th>
                                <th style="width: 120px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-sm" style="background: {{ $user->avatar_color ?? '#1a6e4a' }}">
                                            {{ $user->initials ?? strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <span class="fw-semibold">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <a href="mailto:{{ $user->email }}" class="text-decoration-none" style="color: #2c3e50;">
                                        {{ $user->email }}
                                    </a>
                                </td>
                                <td>{{ $user->no_hp ?? '-' }}</td>
                                <td class="text-center">
                                    <button class="btn-detail" 
                                            onclick="viewUser('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->no_hp }}', '{{ $user->role }}', '{{ $user->created_at }}', '{{ $user->updated_at }}')">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="bi bi-people"></i>
                                        <p>Belum ada pemohon yang terdaftar.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail User -->
<div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
            <div class="modal-header-custom" style="display: flex; justify-content: space-between; align-items: center; padding: 20px 25px;">
                <h5 class="modal-title" id="userDetailModalLabel" style="margin: 0;">
                    <i class="bi bi-person-circle me-2"></i> Detail User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="margin: 0;"></button>
            </div>
            <div class="modal-body" style="padding: 25px;">
                <!-- Avatar -->
                <div class="text-center mb-4">
                    <div class="detail-avatar-lg" id="modalAvatar">
                        U
                    </div>
                </div>
                
                <!-- Detail -->
                <div class="detail-item">
                    <span class="detail-label"><i class="bi bi-person me-2"></i>Username</span>
                    <span class="detail-value" id="modalName">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="bi bi-envelope me-2"></i>Email</span>
                    <span class="detail-value" id="modalEmail">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="bi bi-phone me-2"></i>No. HP</span>
                    <span class="detail-value" id="modalPhone">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="bi bi-calendar-plus me-2"></i>Dibuat Pada</span>
                    <span class="detail-value" id="modalCreated">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="bi bi-person-badge me-2"></i>Role</span>
                    <span class="detail-value" id="modalRole">-</span>
                </div>
                
                <!-- Info Banner -->
                <div class="info-banner">
                    <i class="bi bi-info-circle"></i>
                    Jika user lupa password, gunakan fitur <strong>"Lupa Password"</strong> di halaman login dengan memasukkan email di atas.
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #f0f2f5; padding: 15px 25px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 6px; padding: 8px 20px;">
                    <i class="bi bi-x-circle me-1"></i> Tutup
                </button>
                <button type="button" class="btn btn-primary" onclick="copyEmail()" style="border-radius: 6px; padding: 8px 20px; background: linear-gradient(135deg, #1a6e4a 0%, #27ae60 100%); border: none;">
                    <i class="bi bi-clipboard me-1"></i> Salin Email
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ============================================
        // SEARCH USER
        // ============================================
        const searchInput = document.getElementById('searchUser');
        const table = document.getElementById('userTable');
        const rows = table.querySelectorAll('tbody tr');

        searchInput.addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            let visibleCount = 0;
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchText)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Update active users count
            document.getElementById('activeUsersCount').textContent = visibleCount;
        });
    });

    // ============================================
    // VIEW USER DETAIL
    // ============================================
    function viewUser(id, name, email, phone, role, created, updated) {
        const modal = new bootstrap.Modal(document.getElementById('userDetailModal'));
        
        // Set data ke modal
        document.getElementById('modalName').textContent = name;
        document.getElementById('modalEmail').textContent = email;
        document.getElementById('modalPhone').textContent = phone || '-';
        document.getElementById('modalRole').textContent = role.charAt(0).toUpperCase() + role.slice(1);
        document.getElementById('modalCreated').textContent = created ? new Date(created).toLocaleString('id-ID', { 
            day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' 
        }) : '-';
        
        // Set avatar
        const avatar = document.getElementById('modalAvatar');
        const initials = name.split(' ').map(word => word[0]).join('').substring(0, 2).toUpperCase();
        const colors = ['#1a6e4a', '#27ae60', '#2ecc71', '#3498db', '#9b59b6', '#e67e22', '#e74c3c'];
        const index = Math.abs(name.split('').reduce((acc, char) => acc + char.charCodeAt(0), 0)) % colors.length;
        avatar.style.background = colors[index];
        avatar.textContent = initials;
        
        modal.show();
    }

    // ============================================
    // COPY EMAIL
    // ============================================
    function copyEmail() {
        const email = document.getElementById('modalEmail').textContent;
        if (navigator.clipboard) {
            navigator.clipboard.writeText(email).then(() => {
                showToast('Email berhasil disalin: ' + email);
            }).catch(() => {
                fallbackCopy(email);
            });
        } else {
            fallbackCopy(email);
        }
    }
    
    function fallbackCopy(text) {
        const input = document.createElement('input');
        input.value = text;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        showToast('Email berhasil disalin: ' + text);
    }
    
    function showToast(message) {
        // Buat toast sederhana
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed; bottom: 20px; right: 20px; 
            background: #1a6e4a; color: white; 
            padding: 12px 24px; border-radius: 8px; 
            font-size: 14px; font-weight: 500;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            z-index: 9999;
            animation: slideUp 0.3s ease;
        `;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s ease';
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
</script>

<!-- Tambahkan style untuk animasi toast -->
<style>
    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>
@endsection