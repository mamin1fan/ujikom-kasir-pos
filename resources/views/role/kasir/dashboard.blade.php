<x-app-layout>
    <div class="flex h-screen bg-gray-950 text-white overflow-hidden font-sans">

        {{-- ===== KIRI: Daftar Produk ===== --}}
        <div class="flex flex-col flex-1 overflow-hidden">

            {{-- Header Kasir --}}
            <div class="flex items-center justify-between px-6 py-4 bg-gray-900 border-b border-gray-800 shadow-md">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18M9 3v18M3 9h6M3 15h6"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-sm font-bold tracking-wide text-white leading-none">KASIR</h1>
                        <p class="text-xs text-gray-500 leading-none mt-0.5">{{ now()->format('d M Y · H:i') }}</p>
                    </div>
                </div>

                {{-- Search + Kategori --}}
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                        </svg>
                        <input
                            type="text"
                            placeholder="Cari produk..."
                            class="pl-9 pr-4 py-2 text-sm bg-gray-800 border border-gray-700 rounded-xl text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-56 transition"
                        />
                    </div>
                    <div class="flex items-center gap-1.5 bg-gray-800 border border-gray-700 rounded-xl px-1 py-1">
                        @foreach(['Semua','Makanan','Minuman','Snack'] as $i => $kat)
                            <button
                                class="{{ $i === 0 ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:text-white' }} text-xs font-medium px-3 py-1.5 rounded-lg transition-all duration-150"
                            >{{ $kat }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-500">{{ auth()->user()->name }}</span>
                    <div class="w-8 h-8 rounded-full bg-indigo-700 flex items-center justify-center text-xs font-bold uppercase">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </div>

            {{-- Grid Produk --}}
            <div class="flex-1 overflow-y-auto p-5">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">

                    @php
                    $produk = [
                        ['nama'=>'Nasi Goreng Spesial','harga'=>25000,'stok'=>12,'kat'=>'Makanan','emoji'=>'🍳','warna'=>'from-orange-500/20 to-orange-600/5'],
                        ['nama'=>'Es Teh Manis','harga'=>5000,'stok'=>30,'kat'=>'Minuman','emoji'=>'🧊','warna'=>'from-cyan-500/20 to-cyan-600/5'],
                        ['nama'=>'Ayam Bakar','harga'=>30000,'stok'=>8,'kat'=>'Makanan','emoji'=>'🍗','warna'=>'from-amber-500/20 to-amber-600/5'],
                        ['nama'=>'Jus Alpukat','harga'=>15000,'stok'=>15,'kat'=>'Minuman','emoji'=>'🥑','warna'=>'from-green-500/20 to-green-600/5'],
                        ['nama'=>'Keripik Singkong','harga'=>8000,'stok'=>40,'kat'=>'Snack','emoji'=>'🥔','warna'=>'from-yellow-500/20 to-yellow-600/5'],
                        ['nama'=>'Bakso Kuah','harga'=>18000,'stok'=>20,'kat'=>'Makanan','emoji'=>'🍲','warna'=>'from-red-500/20 to-red-600/5'],
                        ['nama'=>'Kopi Hitam','harga'=>7000,'stok'=>50,'kat'=>'Minuman','emoji'=>'☕','warna'=>'from-stone-500/20 to-stone-600/5'],
                        ['nama'=>'Mie Ayam','harga'=>20000,'stok'=>10,'kat'=>'Makanan','emoji'=>'🍜','warna'=>'from-rose-500/20 to-rose-600/5'],
                        ['nama'=>'Pisang Goreng','harga'=>12000,'stok'=>25,'kat'=>'Snack','emoji'=>'🍌','warna'=>'from-yellow-400/20 to-yellow-500/5'],
                        ['nama'=>'Air Mineral','harga'=>3000,'stok'=>100,'kat'=>'Minuman','emoji'=>'💧','warna'=>'from-blue-500/20 to-blue-600/5'],
                    ];
                    @endphp

                    @foreach($produk as $p)
                    <button
                        onclick="tambahKeranjang('{{ $p['nama'] }}', {{ $p['harga'] }})"
                        class="group relative flex flex-col items-center justify-between p-4 rounded-2xl bg-gradient-to-b {{ $p['warna'] }} bg-gray-900 border border-gray-800 hover:border-indigo-500/60 hover:shadow-lg hover:shadow-indigo-500/10 hover:-translate-y-0.5 transition-all duration-200 text-left cursor-pointer"
                    >
                        {{-- Badge stok --}}
                        <span class="absolute top-2.5 right-2.5 text-[10px] bg-gray-800 text-gray-400 px-1.5 py-0.5 rounded-full font-mono border border-gray-700">
                            {{ $p['stok'] }}
                        </span>

                        <div class="text-4xl mb-2 mt-1 group-hover:scale-110 transition-transform duration-200">{{ $p['emoji'] }}</div>

                        <div class="w-full">
                            <p class="text-xs font-semibold text-gray-200 leading-tight line-clamp-2">{{ $p['nama'] }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $p['kat'] }}</p>
                        </div>

                        <div class="w-full mt-2 flex items-center justify-between">
                            <span class="text-sm font-bold text-indigo-400">Rp {{ number_format($p['harga'],0,',','.') }}</span>
                            <div class="w-6 h-6 rounded-lg bg-indigo-600/0 group-hover:bg-indigo-600 flex items-center justify-center transition-all duration-150">
                                <svg class="w-3.5 h-3.5 text-indigo-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                                </svg>
                            </div>
                        </div>
                    </button>
                    @endforeach

                </div>
            </div>
        </div>

        {{-- ===== KANAN: Keranjang / Input Transaksi ===== --}}
        <div class="w-[360px] flex flex-col bg-gray-900 border-l border-gray-800 shadow-2xl">

            {{-- Header Keranjang --}}
            <div class="px-5 py-4 border-b border-gray-800 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.962-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                    </svg>
                    <h2 class="text-sm font-bold text-white tracking-wide">KERANJANG</h2>
                    <span id="badge-count" class="text-[10px] bg-indigo-600 text-white px-1.5 py-0.5 rounded-full font-bold min-w-[18px] text-center">0</span>
                </div>
                <button onclick="kosongkanKeranjang()" class="text-xs text-gray-500 hover:text-red-400 transition-colors flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                    </svg>
                    Kosongkan
                </button>
            </div>

            {{-- Info Pelanggan --}}
            <div class="px-5 py-3 border-b border-gray-800">
                <label class="text-[10px] font-semibold uppercase tracking-widest text-gray-500 mb-1.5 block">Nama Pelanggan (opsional)</label>
                <input type="text" placeholder="Walk-in Customer" class="w-full bg-gray-800 border border-gray-700 text-sm text-gray-200 placeholder-gray-600 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"/>
            </div>

            {{-- List Item Keranjang --}}
            <div id="keranjang-list" class="flex-1 overflow-y-auto px-5 py-4 space-y-3">
                {{-- State Kosong --}}
                <div id="empty-state" class="flex flex-col items-center justify-center h-full text-center py-16 text-gray-600">
                    <div class="text-5xl mb-3">🛒</div>
                    <p class="text-sm font-medium text-gray-600">Belum ada produk</p>
                    <p class="text-xs text-gray-700 mt-1">Klik produk di kiri untuk menambahkan</p>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-800 mx-5"></div>

            {{-- Ringkasan & Metode Bayar --}}
            <div class="px-5 py-4 space-y-3">

                {{-- Subtotal --}}
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Subtotal</span>
                    <span id="subtotal" class="font-semibold text-gray-200">Rp 0</span>
                </div>

                {{-- Diskon --}}
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-400">Diskon</span>
                    <div class="flex items-center gap-2">
                        <input id="diskon-input" type="number" min="0" placeholder="0" oninput="hitungTotal()"
                            class="w-20 text-right bg-gray-800 border border-gray-700 text-gray-200 text-xs rounded-lg px-2 py-1 focus:outline-none focus:ring-1 focus:ring-indigo-500"/>
                        <span class="text-gray-600 text-xs">%</span>
                    </div>
                </div>

                {{-- Total --}}
                <div class="flex justify-between items-center pt-2 border-t border-gray-800">
                    <span class="text-sm font-bold text-white">TOTAL</span>
                    <span id="total" class="text-lg font-black text-indigo-400">Rp 0</span>
                </div>

                {{-- Metode Bayar --}}
                <div>
                    <label class="text-[10px] font-semibold uppercase tracking-widest text-gray-500 mb-2 block">Metode Pembayaran</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach([['Tunai','💵'],['QRIS','📱'],['Kartu','💳']] as $i => [$m,$icon])
                        <button
                            onclick="pilihMetode(this)"
                            class="metode-btn {{ $i === 0 ? 'border-indigo-500 bg-indigo-600/10 text-white' : 'border-gray-700 text-gray-400' }} flex flex-col items-center justify-center py-2.5 rounded-xl border text-xs font-medium gap-1 hover:border-indigo-500 hover:text-white transition-all duration-150"
                        >
                            <span class="text-base">{{ $icon }}</span>
                            {{ $m }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Input Uang Tunai --}}
                <div id="cash-section">
                    <label class="text-[10px] font-semibold uppercase tracking-widest text-gray-500 mb-1.5 block">Uang Diterima</label>
                    <input id="bayar-input" type="number" placeholder="0" oninput="hitungKembalian()"
                        class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"/>
                    <div class="flex justify-between mt-2 text-sm">
                        <span class="text-gray-400">Kembalian</span>
                        <span id="kembalian" class="font-bold text-green-400">Rp 0</span>
                    </div>
                    {{-- Quick Cash --}}
                    <div class="flex gap-1.5 mt-2 flex-wrap">
                        @foreach([5000,10000,20000,50000,100000] as $nominal)
                        <button onclick="setQuickCash({{ $nominal }})"
                            class="text-[10px] bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-300 px-2 py-1 rounded-lg transition font-mono">
                            {{ number_format($nominal,0,',','.') }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Tombol Bayar --}}
                <button
                    onclick="prosesTransaksi()"
                    class="w-full bg-indigo-600 hover:bg-indigo-500 active:scale-95 text-white font-bold py-3.5 rounded-2xl text-sm tracking-wide transition-all duration-150 shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    Proses Pembayaran
                </button>
            </div>
        </div>
    </div>

    {{-- ===== JAVASCRIPT ===== --}}
    <script>
        let keranjang = {};
        let subtotalValue = 0;
        let totalValue = 0;

        function tambahKeranjang(nama, harga) {
            if (keranjang[nama]) {
                keranjang[nama].qty++;
            } else {
                keranjang[nama] = { harga, qty: 1 };
            }
            renderKeranjang();
        }

        function renderKeranjang() {
            const list = document.getElementById('keranjang-list');
            const empty = document.getElementById('empty-state');
            const keys = Object.keys(keranjang);

            if (keys.length === 0) {
                list.innerHTML = `
                    <div id="empty-state" class="flex flex-col items-center justify-center h-full text-center py-16">
                        <div class="text-5xl mb-3">🛒</div>
                        <p class="text-sm font-medium text-gray-600">Belum ada produk</p>
                        <p class="text-xs text-gray-700 mt-1">Klik produk di kiri untuk menambahkan</p>
                    </div>`;
                document.getElementById('badge-count').textContent = '0';
                hitungTotal();
                return;
            }

            let html = '';
            let totalQty = 0;
            keys.forEach(nama => {
                const item = keranjang[nama];
                totalQty += item.qty;
                const sub = item.harga * item.qty;
                html += `
                <div class="flex items-center gap-3 bg-gray-800/60 rounded-xl p-3 border border-gray-700/50">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-200 truncate">${nama}</p>
                        <p class="text-[11px] text-gray-500 mt-0.5">Rp ${fmt(item.harga)} × ${item.qty}</p>
                    </div>
                    <div class="flex items-center gap-1.5 shrink-0">
                        <button onclick="ubahQty('${nama}',-1)" class="w-6 h-6 rounded-lg bg-gray-700 hover:bg-gray-600 flex items-center justify-center text-gray-300 transition text-sm font-bold">−</button>
                        <span class="text-sm font-bold text-white w-5 text-center">${item.qty}</span>
                        <button onclick="ubahQty('${nama}',1)" class="w-6 h-6 rounded-lg bg-gray-700 hover:bg-gray-600 flex items-center justify-center text-gray-300 transition text-sm font-bold">+</button>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-xs font-bold text-indigo-400">Rp ${fmt(sub)}</p>
                        <button onclick="hapusItem('${nama}')" class="text-[10px] text-red-500 hover:text-red-400 mt-0.5 transition">hapus</button>
                    </div>
                </div>`;
            });

            list.innerHTML = html;
            document.getElementById('badge-count').textContent = totalQty;
            hitungTotal();
        }

        function ubahQty(nama, delta) {
            keranjang[nama].qty += delta;
            if (keranjang[nama].qty <= 0) delete keranjang[nama];
            renderKeranjang();
        }

        function hapusItem(nama) {
            delete keranjang[nama];
            renderKeranjang();
        }

        function kosongkanKeranjang() {
            keranjang = {};
            renderKeranjang();
        }

        function hitungTotal() {
            subtotalValue = Object.values(keranjang).reduce((s, i) => s + i.harga * i.qty, 0);
            const diskon = parseFloat(document.getElementById('diskon-input').value) || 0;
            totalValue = subtotalValue - (subtotalValue * diskon / 100);
            document.getElementById('subtotal').textContent = 'Rp ' + fmt(subtotalValue);
            document.getElementById('total').textContent = 'Rp ' + fmt(Math.round(totalValue));
            hitungKembalian();
        }

        function hitungKembalian() {
            const bayar = parseFloat(document.getElementById('bayar-input').value) || 0;
            const kembalian = bayar - totalValue;
            const el = document.getElementById('kembalian');
            if (kembalian < 0) {
                el.textContent = '− Rp ' + fmt(Math.abs(Math.round(kembalian)));
                el.className = 'font-bold text-red-400';
            } else {
                el.textContent = 'Rp ' + fmt(Math.round(kembalian));
                el.className = 'font-bold text-green-400';
            }
        }

        function setQuickCash(nominal) {
            const current = parseFloat(document.getElementById('bayar-input').value) || 0;
            document.getElementById('bayar-input').value = current + nominal;
            hitungKembalian();
        }

        function pilihMetode(btn) {
            document.querySelectorAll('.metode-btn').forEach(b => {
                b.classList.remove('border-indigo-500', 'bg-indigo-600/10', 'text-white');
                b.classList.add('border-gray-700', 'text-gray-400');
            });
            btn.classList.add('border-indigo-500', 'bg-indigo-600/10', 'text-white');
            btn.classList.remove('border-gray-700', 'text-gray-400');

            const isCash = btn.textContent.trim().startsWith('Tunai');
            document.getElementById('cash-section').style.display = isCash ? 'block' : 'none';
        }

        function prosesTransaksi() {
            if (Object.keys(keranjang).length === 0) {
                alert('Keranjang masih kosong!');
                return;
            }
            alert('✅ Transaksi berhasil!\nTotal: Rp ' + fmt(Math.round(totalValue)));
            kosongkanKeranjang();
            document.getElementById('bayar-input').value = '';
            document.getElementById('diskon-input').value = '';
        }

        function fmt(n) {
            return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    </script>
</x-app-layout>