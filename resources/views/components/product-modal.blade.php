<div>
    @props([
        'name' => 'product-modal',
        'mode' => 'create', // create | edit
        'action' => '',
        'method' => 'POST',
        'product' => null,
        'kategori' => [],
        'suppliers' => [],
        'kelompokKategori' => [],
    ])

    <flux:modal :name="$name" class="md:w-96">
        @include('role.super-admin.partials.product-form', [
            'title' => $mode === 'edit' ? 'Edit Product' : 'Add Product',
            'route' => $action,
            'method' => $method,
            'product' => $product,
            'isEdit' => $mode === 'edit',
            'kategori' => $kategori,
            'suppliers' => $suppliers,
            'kelompok_kategori' => $kelompokKategori,
        ])
    </flux:modal>
</div>
