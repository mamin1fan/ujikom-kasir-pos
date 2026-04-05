<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Management User
        </h2>
    </x-slot>

    {{-- Custom Styles --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        .mu-wrap * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Stat Cards */
        .stat-card {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            padding: 20px 24px;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(0,0,0,.1); }
        .stat-card::before {
            content: '';
            position: absolute;
            top: -30px; right: -30px;
            width: 100px; height: 100px;
            border-radius: 50%;
            opacity: .15;
            background: currentColor;
        }
        .stat-total   { background: linear-gradient(135deg,#6366f1,#818cf8); color:#fff; }
        .stat-active  { background: linear-gradient(135deg,#10b981,#34d399); color:#fff; }
        .stat-nonactive { background: linear-gradient(135deg,#f43f5e,#fb7185); color:#fff; }

        /* Search & Filter bar */
        .mu-search-input, .mu-filter-select {
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 9px 14px;
            font-size: .875rem;
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .mu-search-input:focus, .mu-filter-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        }
        .dark .mu-search-input, .dark .mu-filter-select {
            background: #1f2937; border-color: #374151; color:#e5e7eb;
        }

        /* Table */
        .mu-table thead th {
            background: #f8fafc;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #64748b;
            padding: 12px 16px;
            border-bottom: 2px solid #e2e8f0;
        }
        .dark .mu-table thead th { background:#111827; color:#94a3b8; border-color:#1f2937; }
        .mu-table tbody tr {
            transition: background .15s;
            border-bottom: 1px solid #f1f5f9;
        }
        .mu-table tbody tr:hover { background: #f8fafc; }
        .dark .mu-table tbody tr:hover { background: #1e293b; }
        .mu-table td { padding: 13px 16px; font-size: .875rem; }

        /* Badges */
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 999px; font-size: .72rem; font-weight: 600;
        }
        .badge-active   { background:#d1fae5; color:#065f46; }
        .badge-inactive { background:#fee2e2; color:#991b1b; }
        .badge::before { content:''; display:inline-block; width:6px; height:6px; border-radius:50%; background:currentColor; }

        /* Role pill */
        .role-pill {
            display: inline-block;
            padding: 2px 10px; border-radius: 6px;
            font-size: .72rem; font-weight: 600;
            background: #ede9fe; color: #5b21b6;
        }

        /* Action buttons */
        .btn-edit {
            padding: 5px 14px; border-radius: 8px; font-size: .8rem; font-weight: 600;
            background: #fef3c7; color: #92400e; border: 1px solid #fde68a;
            cursor: pointer; transition: background .15s;
        }
        .btn-edit:hover { background: #fde68a; }
        .btn-activate {
            padding: 5px 14px; border-radius: 8px; font-size: .8rem; font-weight: 600;
            background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7;
            cursor: pointer; transition: background .15s;
        }
        .btn-activate:hover { background: #a7f3d0; }
        .btn-deactivate {
            padding: 5px 14px; border-radius: 8px; font-size: .8rem; font-weight: 600;
            background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;
            cursor: pointer; transition: background .15s;
        }
        .btn-deactivate:hover { background: #fecaca; }
        .btn-primary {
            padding: 9px 20px; border-radius: 10px; font-size: .875rem; font-weight: 600;
            background: linear-gradient(135deg,#6366f1,#818cf8); color:#fff;
            border:none; cursor:pointer; transition: opacity .2s, transform .15s;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-primary:hover { opacity: .9; transform: translateY(-1px); }

        /* Empty state */
        .empty-row td { padding: 48px 16px; text-align:center; color:#94a3b8; }

        /* Fade-in animation */
        @keyframes fadeSlideIn {
            from { opacity:0; transform:translateY(12px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .mu-wrap { animation: fadeSlideIn .35s ease both; }

        /* Avatar */
        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg,#6366f1,#a5b4fc);
            color: #fff; font-weight: 700; font-size: .8rem;
            display: inline-flex; align-items:center; justify-content:center;
            flex-shrink: 0;
        }
    </style>

    <div class="py-10 mu-wrap">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ═══════════════════════════════════════════
                 STAT CARDS
            ═══════════════════════════════════════════ --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                <div class="stat-card stat-total">
                    <p class="text-sm font-medium opacity-80 mb-1">Total User</p>
                    <h3 class="text-3xl font-bold">{{ $users->count() }}</h3>
                    <p class="text-xs opacity-70 mt-1">Semua pengguna terdaftar</p>
                </div>

                <div class="stat-card stat-active">
                    <p class="text-sm font-medium opacity-80 mb-1">User Aktif</p>
                    <h3 class="text-3xl font-bold">{{ $users->where('is_active', 1)->count() }}</h3>
                    <p class="text-xs opacity-70 mt-1">Dapat login ke sistem</p>
                </div>

                <div class="stat-card stat-nonactive">
                    <p class="text-sm font-medium opacity-80 mb-1">Non Aktif</p>
                    <h3 class="text-3xl font-bold">{{ $users->where('is_active', 0)->count() }}</h3>
                    <p class="text-xs opacity-70 mt-1">Akses dinonaktifkan</p>
                </div>

            </div>

            {{-- ═══════════════════════════════════════════
                 MAIN CARD
            ═══════════════════════════════════════════ --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

                {{-- Toolbar --}}
                <div class="p-5 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row md:items-center gap-3">

                    {{-- Search --}}
                    <div class="relative flex-1">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                        <input
                            type="text"
                            id="searchInput"
                            placeholder="Cari nama atau username..."
                            class="mu-search-input w-full pl-9"
                            oninput="filterTable()"
                        >
                    </div>

                    {{-- Filter: Sekolah --}}
                    <select id="filterSekolah" class="mu-filter-select w-full md:w-48" onchange="filterTable()">
                        <option value="">Semua Sekolah</option>
                        @foreach($users->pluck('sekolah.nama_sekolah')->filter()->unique()->sort() as $sekolah)
                            <option value="{{ $sekolah }}">{{ $sekolah }}</option>
                        @endforeach
                    </select>

                    {{-- Filter: Role --}}
                    <select id="filterRole" class="mu-filter-select w-full md:w-36" onchange="filterTable()">
                        <option value="">Semua Role</option>
                        @foreach($users->pluck('role.nama_role')->filter()->unique()->sort() as $role)
                            <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>

                    {{-- Filter: Status --}}
                    <select id="filterStatus" class="mu-filter-select w-full md:w-36" onchange="filterTable()">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="nonactive">Non Aktif</option>
                    </select>

                    {{-- Tambah Button --}}
                    <button onclick="openTambahUser()" class="btn-primary whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah User
                    </button>

                </div>

                {{-- Result count --}}
                <div class="px-5 py-2 text-xs text-gray-400 bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-700" id="resultCount">
                    Menampilkan {{ $users->count() }} user
                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">
                    <table class="w-full mu-table" id="userTable">
                        <thead>
                            <tr>
                                <th class="text-left">No</th>
                                <th class="text-left">User</th>
                                <th class="text-left">Username</th>
                                <th class="text-left">Role</th>
                                <th class="text-left">Sekolah</th>
                                <th class="text-left">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="userTableBody">
                            @forelse ($users as $item)
                                <tr class="user-row"
                                    data-nama="{{ strtolower($item->nama_lengkap) }}"
                                    data-username="{{ strtolower($item->username) }}"
                                    data-sekolah="{{ $item->sekolah->nama_sekolah ?? '' }}"
                                    data-role="{{ $item->role->nama_role ?? '' }}"
                                    data-status="{{ $item->is_active ? 'active' : 'nonactive' }}"
                                >
                                    <td class="text-gray-400 font-mono text-xs">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>

                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="user-avatar">
                                                {{ strtoupper(substr($item->nama_lengkap, 0, 2)) }}
                                            </div>
                                            <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $item->nama_lengkap }}</span>
                                        </div>
                                    </td>

                                    <td class="text-gray-500 dark:text-gray-400 font-mono text-xs">{{ $item->username }}</td>

                                    <td>
                                        @if($item->role)
                                            <span class="role-pill">{{ $item->role->nama_role }}</span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>

                                    <td class="text-gray-600 dark:text-gray-300 text-sm">
                                        {{ $item->sekolah->nama_sekolah ?? '—' }}
                                    </td>

                                    <td>
                                        @if ($item->is_active)
                                            <span class="badge badge-active">Aktif</span>
                                        @else
                                            <span class="badge badge-inactive">Non Aktif</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="flex items-center justify-center gap-2">

                                            {{-- EDIT --}}
                                            <button onclick="editUser(this)"
                                                data-user='@json($item)'
                                                class="btn-edit">
                                                ✏️ Edit
                                            </button>

                                            {{-- TOGGLE STATUS --}}
                                            <form action="{{ route('super-admin.user.activate', $item->id_user) }}"
                                                method="POST" class="inline form-toggle">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="is_active" value="{{ $item->is_active ? 0 : 1 }}">
                                                <button type="submit"
                                                    class="{{ $item->is_active ? 'btn-deactivate' : 'btn-activate' }}">
                                                    {{ $item->is_active ? '🔴 Nonaktifkan' : '🟢 Aktifkan' }}
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="empty-row">
                                    <td colspan="7">
                                        <div class="flex flex-col items-center gap-2 text-gray-400">
                                            <svg class="w-10 h-10 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                                            </svg>
                                            <p>Belum ada user terdaftar</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- No results row (hidden by default) --}}
                    <div id="noResults" class="hidden py-12 text-center text-gray-400 text-sm">
                        <p>😕 Tidak ada user yang cocok dengan filter.</p>
                        <button onclick="resetFilter()" class="mt-2 text-indigo-500 hover:underline text-xs">Reset filter</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         MODAL TAMBAH
    ═══════════════════════════════════════════ --}}
    <flux:modal name="tambah-user">
        <form method="POST" action="{{ route('super-admin.user.index') }}">
            @csrf
            <flux:input name="nama_user" label="Nama Lengkap" required />
            <flux:input name="username" label="Username" required />
            <flux:input name="password" type="password" label="Password" required />
            <flux:button type="submit">Simpan User</flux:button>
        </form>
    </flux:modal>

    {{-- ═══════════════════════════════════════════
         MODAL EDIT
    ═══════════════════════════════════════════ --}}
    <flux:modal name="edit-user">
        <form method="POST" id="editUserForm">
            @csrf
            @method('PUT')
            <flux:input name="nama_user" id="edit_nama" label="Nama Lengkap" />
            <flux:input name="username" id="edit_username" label="Username" />
            <flux:button type="submit">Update User</flux:button>
        </form>
    </flux:modal>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // ── Open tambah modal ──────────────────────────────
            function openTambahUser() {
                Flux.showModal('tambah-user');
            }

            // ── Open edit modal ────────────────────────────────
            function editUser(btn) {
                const data = JSON.parse(btn.dataset.user);
                document.getElementById('edit_nama').value     = data.nama_lengkap ?? data.nama_user;
                document.getElementById('edit_username').value = data.username;
                document.getElementById('editUserForm').action =
                    "{{ route('super-admin.user.update', ':id') }}".replace(':id', data.id_user);
                Flux.showModal('edit-user');
            }

            // ── Filter table ───────────────────────────────────
            function filterTable() {
                const search   = document.getElementById('searchInput').value.toLowerCase();
                const sekolah  = document.getElementById('filterSekolah').value;
                const role     = document.getElementById('filterRole').value;
                const status   = document.getElementById('filterStatus').value;

                const rows = document.querySelectorAll('.user-row');
                let visible = 0;

                rows.forEach(row => {
                    const matchSearch  = !search  || row.dataset.nama.includes(search) || row.dataset.username.includes(search);
                    const matchSekolah = !sekolah || row.dataset.sekolah === sekolah;
                    const matchRole    = !role    || row.dataset.role    === role;
                    const matchStatus  = !status  || row.dataset.status  === status;

                    const show = matchSearch && matchSekolah && matchRole && matchStatus;
                    row.style.display = show ? '' : 'none';
                    if (show) visible++;
                });

                document.getElementById('resultCount').textContent =
                    `Menampilkan ${visible} user`;

                document.getElementById('noResults').classList.toggle('hidden', visible > 0);
            }

            function resetFilter() {
                document.getElementById('searchInput').value     = '';
                document.getElementById('filterSekolah').value   = '';
                document.getElementById('filterRole').value      = '';
                document.getElementById('filterStatus').value    = '';
                filterTable();
            }

            // ── SweetAlert toggle ──────────────────────────────
            document.querySelectorAll('.form-toggle').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const isActive = form.querySelector('input[name=is_active]').value == '0';
                    Swal.fire({
                        title: isActive ? 'Nonaktifkan user?' : 'Aktifkan user?',
                        text: 'Status user akan diubah.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: isActive ? '#f43f5e' : '#10b981',
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Ya, ubah!',
                    }).then(result => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });
        </script>
    @endpush

</x-app-layout>