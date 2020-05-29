<?php
return $route = array(
    'data-user' => array(
        'remote' => ('table-user'),
        'check' => array(
            'check_user',
            'check_user_edit',
            
        ),
        'crud' => array(
            'read_user',
            'create_user',
            'store_user',
            'edit_user',
            'update_user',
            'show_user',
            'destroy_user'
        )
    ),
    'data-password' => array(
        'remote' => ('form_password'),
        'crud' => array(
            ('ubah_password'),
            ('check_password')
        )
    ),
    'register' => array(
        'remote' => ('register'),
        'check' => array(
            'username'
        )
        
    ),
    'data-kategori' => array(
        'remote' => ('table-kategori'),
        'check' => array(
            'check_kategori',
            'check_kategori_edit',
        ),
        'crud' => array(
            'read_kategori',
            'create_kategori',
            'store_kategori',
            'edit_kategori',
            'update_kategori',
            'show_kategori',
            'destroy_kategori'
        )
    ),
    'data-penerbit' => array(
        'remote' => ('table-penerbit'),
        'check' => array(
            'check_penerbit',
            'check_penerbit_edit',
        ),
        'crud'  => array(
            'read_penerbit',
            'create_penerbit',
            'store_penerbit',
            'edit_penerbit',
            'update_penerbit',
            'show_penerbit',
            'destroy_penerbit'
        )
    ),
    'data-pengarang' => array(
        'remote' => ('table-pengarang'),
        'check' => array(
            'check_pengarang',
            'check_pengarang_edit',
        ),
        'crud'  => array(
            'read_pengarang',
            'create_pengarang',
            'store_pengarang',
            'edit_pengarang',
            'update_pengarang',
            'show_pengarang',
            'destroy_pengarang'
        )
    ),
    'data-buku' => array(
        'remote' => ('table-buku'),
        'check' => array(
            'check_buku',
            'check_buku_edit',
        ),
        'crud'  => array(
            'read_buku',
            'create_buku',
            'store_buku',
            'edit_buku',
            'update_buku',
            'show_buku',
            'destroy_buku'
        )
    ),
    'data-rak' => array(
        'remote' => ('table-rak'),
        'check' => array(
            'check_rak',
            'check_rak_edit',
        ),
        'crud'  => array(
            'read_rak',
            'create_rak',
            'store_rak',
            'edit_rak',
            'update_rak',
            'show_rak',
            'destroy_rak'
        )
    ),
    'data-peminjaman' => array(
        'remote' => ('table-peminjaman'),
        'crud' => array(
            'read_peminjaman',
            'create_peminjaman',
            'store_peminjaman',
            'edit_peminjaman',
            'update_peminjaman',
            'show_peminjaman',
            'destroy_peminjaman',
            'load_peminjaman',
        )
    ),
    'data-pengembalian' => array(
        'remote' => ('table-pengembalian'),
        'check' => array(
            'check_pengembalian',
        ),
        'crud' => array(
            ('read_pengembalian'),
            ('create_pengembalian'),
            ('store_pengembalian'),
            ('edit_pengembalian'),
            ('update_pengembalian'),
            ('show_pengembalian'),
            ('destroy_pengembalian'),
            
        )
    ),
    'data-home' => array(
        'remote' => ('table-home'),
        'crud' => array(
            ('read_home'),
            ('detail_home'),
            ('add_cart'),
            ('search_home'),
            ('more_home'),
        )
    ),
);