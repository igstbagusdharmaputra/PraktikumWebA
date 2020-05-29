<?php

return $static = array(
    'data-user' => array(
        'permissions' => array(
            'create_user',
            'search_user'
        ),
        'box-create' => array(
            'box-add' => array(
                'id' => 'create_user',
                'name' => 'create_user',
                'class' => 'btn btn-primary btn-sm',
                'title' => 'Tambah Data User',
                'data-target' => $route['data-user']['crud'][1]
            ),
            
        ),
        'table' => array(
            'id' => 'table_user',
            'name' => 'table_user',
            'class' => 'table table-bordered table-striped table-hover table_user',
            'data-remote' =>$route['data-user']['remote'],
            'data-target' =>$route['data-user']['crud'][0],
            'field' => array('No.','Nama','Nama Pengguna','Level','Status','Aksi')
        ),
    ),
    'data-kategori' => array(
        'permissions' => array(
            'create_kategori',
            'search_kategori'
        ),
        'box-create' => array(
            'box-add' => array(
                'id' => 'create_kategori',
                'name' => 'create_kategori',
                'class' => 'btn btn-primary btn-sm',
                'title' => 'Tambah Data Kategori',
                'data-target' => $route['data-kategori']['crud'][1]
            ),
            
        ),
        'table' => array(
            'id' => 'table_kategori',
            'name' => 'table_kategori',
            'class' => 'table table-bordered table-striped table-hover table_kategori',
            'data-remote' =>$route['data-kategori']['remote'],
            'data-target' =>$route['data-kategori']['crud'][0],
            'field' => array('No.','Nama Kategori','Aksi')
        ),
    ),
    'data-penerbit' => array(
        'permissions' => array(
            'create_penerbit',
            'search_penerbit'
        ),
        'box-create' => array(
            'box-add' => array(
                'id' => 'create_penerbit',
                'name' => 'create_penerbit',
                'class' => 'btn btn-primary btn-sm',
                'title' => 'Tambah Data Penerbit',
                'data-target' => $route['data-penerbit']['crud'][1]
            ),
            
        ),
        'table' => array(
            'id' => 'table_penerbit',
            'name' => 'table_penerbit',
            'class' => 'table table-bordered table-striped table-hover table_penerbit',
            'data-remote' =>$route['data-penerbit']['remote'],
            'data-target' =>$route['data-penerbit']['crud'][0],
            'field' => array('No.','Nama Penerbit','Aksi')
        ),
    ),
    'data-pengarang' => array(
        'permissions' => array(
            'create_pengarang',
            'search_pengarang'
        ),
        'box-create' => array(
            'box-add' => array(
                'id' => 'create_pengarang',
                'name' => 'create_pengarang',
                'class' => 'btn btn-primary btn-sm',
                'title' => 'Tambah Data Pengarang',
                'data-target' => $route['data-pengarang']['crud'][1]
            ),
            
        ),
        'table' => array(
            'id' => 'table_pengarang',
            'name' => 'table_pengarang',
            'class' => 'table table-bordered table-striped table-hover table_pengarang',
            'data-remote' =>$route['data-pengarang']['remote'],
            'data-target' =>$route['data-pengarang']['crud'][0],
            'field' => array('No.','Nama Pengarang','Aksi')
        ),
    ),
    'data-buku' => array(
        'permissions' => array(
            'create_buku',
            'search_buku'
        ),
        'box-create' => array(
            'box-add' => array(
                'id' => 'create_buku',
                'name' => 'create_buku',
                'class' => 'btn btn-primary btn-sm',
                'title' => 'Tambah Data Buku',
                'data-target' => $route['data-buku']['crud'][1]
            ),
            
        ),
        'table' => array(
            'id' => 'table_buku',
            'name' => 'table_buku',
            'class' => 'table table-bordered table-striped table-hover table_buku',
            'data-remote' =>$route['data-buku']['remote'],
            'data-target' =>$route['data-buku']['crud'][0],
            'field' => array('No.','ID Buku','Judul Buku','Kategori Buku','Stok Buku','Aksi')
        )
    ),
    'data-rak' => array(
        'permissions' => array(
            'create_rak',
            'search_rak'
        ),
        'box-create' => array(
            'box-add' => array(
                'id' => 'create_rak',
                'name' => 'create_rak',
                'class' => 'btn btn-primary btn-sm',
                'title' => 'Tambah Data Rak',
                'data-target' => $route['data-rak']['crud'][1]
            ),
            
        ),
        'table' => array(
            'id' => 'table_rak',
            'name' => 'table_rak',
            'class' => 'table table-bordered table-striped table-hover table_rak',
            'data-remote' =>$route['data-rak']['remote'],
            'data-target' =>$route['data-rak']['crud'][0],
            'field' => array('No.','Nama Rak','Aksi')
        )
    ),
    'data-peminjaman' => array(
        'permissions' => array(
            'create_peminjaman',
            'search_buku'
        ),
        'box-create' => array(
            'box-add' => array(
                'id' => 'create_peminjaman',
                'name' => 'create_peminjaman',
                'class' => 'btn btn-primary btn-sm',
                'title' => 'Tambah Data Peminjaman',
                'data-target' => $route['data-peminjaman']['crud'][1]
            ),
            
        ),
        'table' => array(
            'id' => 'table_peminjaman',
            'name' => 'table_peminjaman',
            'class' => 'table table-bordered table-striped table-hover table_peminjaman',
            'data-remote' => $route['data-peminjaman']['remote'],
            'data-target' => $route['data-peminjaman']['crud'][0],
            'field' => array('No.','Kode Peminjaman','Nama Peminjam','Tanggal Pinjam','Jatuh Tempo','Status','Aksi')
        )
    ),
    'data-pengembalian' => array(
        'permissions' => array(
            'create_pengembalian',
            'search_alat'
        ),
        'box-create' => array(
            'box-add' => array(
                'id' => 'create_pengembalian',
                'name' => 'create_pengembalian',
                'class' => 'btn btn-primary btn-sm',
                'title' => 'Tambah Data Pengembalian',
                'data-target' => ($route['data-pengembalian']['crud'][1])
            ),
        ),
        'table' => array(
            'id' => 'table_pengembalian',
            'name' => 'table_pengembalian',
            'class' => 'table table-bordered table-striped table-hover table_pengembalian',
            'data-remote' => ($route['data-pengembalian']['remote']),
            'data-target' => ($route['data-pengembalian']['crud'][0]),
            'field' => array('No.','Kode Peminjaman','Tanggal Kembali','Ketepatan','Aksi')
        )
    ),
);