$(function() {

    moment.locale("id");
    var remote = $('#table_buku').attr('data-remote');
    var target = $('#table_buku').attr('data-target');
    var editbuku = $('#edit-buku').find('#nama_buku').attr('data-target'); //check nama_buku
    var addbuku = $('#add-buku').find('#nama_buku').attr('data-target'); 
  
    var start = moment().subtract(29, 'days');
    var end = moment();

    $('.modal-content').css('border-radius', '10px');
    $('.modal-content').css('border-radius', '10px');

    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000,
        animation: false,
        customClass: {
            popup: 'animated tada'
        },
    });

    function alertSuccess(msg) {
        Toast.fire({
            type: 'success',
            title: msg
        });
    }

    function alertWarning(msg) {
        Toast.fire({
            type: 'warning',
            title: msg
        });
    }

    function alertDanger(msg) {
        Toast.fire({
            type: 'error',
            title: msg
        });
    }

    function ajaxSuccess(id) {
        $(id)[0].reset();
        CloseModal().click();
        // problem nya ini. jadi harus di call
        a.resetForm();
    }
    $.validator.addMethod("angka_cek", function(value, element) {
        return this.optional(element) || /^[0-9.,]*$/.test(value);
    });
    const CloseModal = () => $('[data-dismiss=modal]').on('click', function (e) {
        e.preventDefault();

        const $t = $(this), target = $t[0].href || $t.data("target") || $t.parents('.modal') || [];
        
        $(target).find('.form-group').attr('class', 'form-group');
        $(target).find('span.form-control-feedback').remove();
        $(target).find('em.has-error').remove();
        $(target).find('div.has-feedback').removeClass('has-feedback');
        $(target).find('input').attr('class', 'form-control').removeAttr('aria-describedby').removeAttr('aria-invalid');
        $(target).find('select').attr('class', 'form-control custom-select custom-select-sm');
        $(target).find('.custom-file-label').empty();
        $(target)
            .find("input,textarea,select").val('').removeClass('is-valid').removeClass('is-invalid').end()
            .find("input[type=file]").val('').removeClass('is-valid').removeClass('is-invalid').end()
            .find("input[type=checkbox], input[type=radio]").prop("checked", "").removeClass('is-valid').removeClass('is-invalid').end();
        let timeoutHandler = null;
        if (document.getElementsByClassName('custom-file-label').length > 0) 
            $('.custom-file-label')[0].innerText = "File";

        $('.modal').on('hide.bs.modal', () => {
            $('.modal-dialog').removeClass('zoomIn').addClass('zoomOut');
            
            if (timeoutHandler) 
                clearTimeout(timeoutHandler);
            
            timeoutHandler = setTimeout(() => {
                $('.modal-dialog').removeClass('zoomOut').addClass('zoomIn');
            }, 1000);
        });
    });
    CloseModal();
    
     // Tambah Buku //
     const a = $('#add-buku').validate({
        errorClass: 'has-error animated tada',
        validClass: 'has-success',
        rules: {
            judul_buku: {
                required: true,
            },
            kategori: {
                required: true,
            },
            pengarang: {
                required: true,
            },
            penerbit: {
                required:true
            },
            rak:{
                required:true
            },
            img: {
                required: false,
            },
            tahun_buku:{
                required:true,
                angka_cek:true
            },
            stok_buku:{
                required:true,
                angka_cek:true
            }
            
        },
        messages: {
            judul_buku: {
                required: "Judul Buku harus diisi !",
                
            },
            kategori: {
                required: "Kategori Buku harus diisi !",
                
            },
            pengarang: {
                required: "Pengarang Buku harus diisi !",
                
            },
            penerbit: {
                required: "Penerbit Buku harus diisi !",
                
            },
            rak: {
                required: "Rak Buku harus diisi !",
                
            },
            tahun_buku: {
                required: "Tahun Buku harus diisi !",
                angka_cek:"Tidak boleh mengandung simbol lain selain angka !"
                
            },
            stok_buku: {
                required: "Stok Buku harus diisi !",
                angka_cek:"Tidak boleh mengandung simbol lain selain angka !"
            },
            
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
            error.addClass("help-block");
            element.parents(".col-xs-9").addClass("has-feedback");

            if (element.prop( "type" ) === "checkbox") {
                error.insertAfter( element.parent("label"));
            } else {
                error.insertAfter( element);
            }
            if (!element.next( "span" )[ 0 ] ) {
                $( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>").insertAfter(element);
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass(errorClass).removeClass(validClass);
            $(element).next("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass(validClass).removeClass(errorClass);
            $(element).next("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
        },
        submitHandler: function(form) {
            var route = $('#add-buku').attr('data-target'); //store_user
            var buku = new FormData($('#add-buku')[0]);
            $.ajax({
                url: http + 'fetch?f='+remote+'&d='+route,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                timeout: 3000,
                data: buku,
                beforeSend: function() {
                    showLoading();
                },
                success: function(res) {
                    hideLoading();
                    if (res.length == 0) {
                        dataTable.ajax.reload();
                        alertDanger('Invalid request');
                    } else {
                        if (res.buku.code == 1) {
                            ajaxSuccess('#add-buku');
                            dataTable.ajax.reload();
                            alertSuccess(res.buku.message);
                        } else {
                            dataTable.ajax.reload();
                            alertWarning(res.buku.message);
                        }
                    }
                },
                error: function(jqXHR, status, error) {
                    hideLoading();
                    alertDanger(status);
                   
                }
            });
            return false;
        }
    });
    //edit buku
    $('#edit-buku').validate({
        errorClass: 'has-error animated tada',
        validClass: 'has-success',
        rules: {
            judul_buku: {
                required: true,
            },
            kategori: {
                required: true,
            },
            pengarang: {
                required: true,
            },
            penerbit: {
                required:true
            },
            rak:{
                required:true
            },
            img: {
                required: false,
            },
            tahun_buku:{
                required:true,
                angka_cek:true
            },
            stok_buku:{
                required:true,
                angka_cek:true
            }
        },
        messages: {
            judul_buku: {
                required: "Judul Buku harus diisi !",
                
            },
            kategori: {
                required: "Kategori Buku harus diisi !",
                
            },
            pengarang: {
                required: "Pengarang Buku harus diisi !",
                
            },
            penerbit: {
                required: "Penerbit Buku harus diisi !",
                
            },
            rak: {
                required: "Rak Buku harus diisi !",
                
            },
            tahun_buku: {
                required: "Tahun Buku harus diisi !",
                angka_cek:"Tidak boleh mengandung simbol lain selain angka !"
                
            },
            stok_buku: {
                required: "Stok Buku harus diisi !",
                angka_cek:"Tidak boleh mengandung simbol lain selain angka !"
            },
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
            error.addClass("help-block");
            element.parents(".col-xs-9").addClass("has-feedback");

            if (element.prop( "type" ) === "checkbox") {
                error.insertAfter( element.parent("label"));
            } else {
                error.insertAfter( element);
            }
            if (!element.next( "span" )[ 0 ] ) {
                $( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>").insertAfter(element);
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass(errorClass).removeClass(validClass);
            $(element).next("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass(validClass).removeClass(errorClass);
            $(element).next("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
        },
        submitHandler: function(form) {
            var route = $('#edit-buku').attr('data-target');
            var buku = new FormData($('#edit-buku')[0]);
            var id = $('#edit-buku').find('input[type=hidden]').val();
            $.ajax({
                url: http + 'fetch?f='+remote+'&d='+route+'&id='+id,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                timeout: 3000,
                data: buku,
                beforeSend: function() {
                    showLoading();
                },
                success: function(res) {
                    if (res.length == 0) {
                        hideLoading();
                        alertDanger('Invalid request');
                    } else {
                        if (res.buku.code == 1) {
                            ajaxSuccess('#edit-buku');
                            dataTable.ajax.reload();
                            hideLoading();
                            alertSuccess(res.buku.message);
                        } else {
                            hideLoading();
                            alertWarning(res.buku.message);
                        }
                    }
                },
                error: function(jqXHR, status, error) {
                    hideLoading();
                    alertDanger(status);
                    // console.log(jqXHR);
                }
            });
            return false;
        }
    });
    $("#table_buku").on('click', '#edit', function (e) {
        e.preventDefault();
        var route = $(this).attr('data-target');
        var id = $(this).attr('data-content');
        $a = $('#edit-buku').find('input[type=hidden],input[type=text], select, textarea');
        $.ajax({
            url: http + 'fetch?f='+remote+'&d='+route+'&id='+id,
            type: 'GET',
            async: true,
            dataType: 'json',
            beforeSend: function () {
                showLoading();
            },
            success: function (res) {
                console.log(a);
                if (res.length == 0) {
                    hideLoading();
                    alertDanger('Invalid request');
                } else {
                    if (res.buku.code == 1) {
                        hideLoading();
                        $('#editModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        for (let i = 0; i < $a.length; i++) {
                            $a.eq(i).val(res.buku.data[i]);
                        }
                    } else {
                        hideLoading();
                        alertWarning(res.buku.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
                
            }
        });
    });
    //detail buku 
    $("#table_buku").on('click', '#detail', function (e) {
        e.preventDefault();
        var route = $(this).attr('data-target');
        var id = $(this).attr('data-content');
        var body = $('#detail-table').empty();
        $.ajax({
            url: http + 'fetch?f='+remote+'&d='+route+'&id='+id,
            type: 'GET',
            async: true,
            dataType: 'json',
            beforeSend: function () {
                showLoading();
            },
            success: function (res) {
                if (res.length == 0) {
                    hideLoading();
                    alertDanger('Invalid request');
                } else {
                    if (res.buku.code == 1) {
                        hideLoading();
                        $('#detailModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        let tr_str = '';
                        tr_str += "<tr><td colspan=\"2\"><img class=\"img-responsive\" style=\"max-height: 250px;\" width=\"100%\" src=\""+ http + 'assets/img/buku/' +res.buku.data[8] + "\"></td></tr>" +
                                "<tr><td style=\"width: 25% !important;\">Kode Buku</td><td>" + res.buku.data[0] + "</td></tr>" +
                                "<tr><td>Judul Buku</td><td>" + res.buku.data[1] + "</td></tr>" +
                                "<tr><td>Kategori Buku</td><td>" + res.buku.data[2] + "</td></tr>" +
                                "<tr><td>Pengarang Buku</td><td>" + res.buku.data[3] + "</td></tr>" +
                                "<tr><td>Penerbit Buku</td><td>" + res.buku.data[4] + "</td></tr>" +
                                "<tr><td>Rak Buku</td><td>" + res.buku.data[5] + "</td></tr>" +
                                "<tr><td>Tahun Buku</td><td>" + res.buku.data[6] + "</td></tr>" +
                                "<tr><td>Stok Buku</td><td>" + res.buku.data[7] + "</td></tr>" +
                                "<tr><td>Tanggal Buat Buku</td><td>" + moment(res.buku.data.created_at).format("dddd, DD-MMMM-YYYY HH:mm:ss") + "</td></tr>";
                        $('#detail-table').append(tr_str);
                    } else {
                        hideLoading();
                        alertWarning(res.buku.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
                console.log(jqXHR);
            }
        });
    });
    //delete buku
    $("#table_buku").on('click', '#hapus', function (e) {
        e.preventDefault();
        var nm = $(this).attr('title-content');
        var route = $(this).attr('data-target');
        var id = $(this).attr('data-content');
        Swal.fire({
            title: 'Apa Anda Yakin?',
            html: 'Menghapus data buku <b>' + nm + '</b> ?',
            type: 'warning',
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (isConfirm) {
            if (isConfirm.value) {
                $.ajax({
                    url: http + 'fetch?f='+remote+'&d='+route+'&id='+id,
                    type: 'POST',
                    dataType: 'json',
                    async: true,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        showLoading();
                    },
                    success: function (res) {
                        if (res.length == 0) {
                            hideLoading();
                            alertDanger('Invalid request');
                        } else {
                            if (res.buku.code == 1) {
                                hideLoading();
                                dataTable.ajax.reload();
                                alertSuccess(res.buku.message);
                            } else {
                                hideLoading();
                                alertWarning(res.buku.message);
                            }
                        }
                    },
                    error: function (jqXHR, status, error) {
                        hideLoading();
                        alertDanger(status);
                    }
                });
            }
        });
    });
     //show data
    var dataTable = $("#table_buku").DataTable({
        "language": {
            "sEmptyTable":   "Tidak ada data yang tersedia pada tabel ini",
            "sProcessing":   "Sedang memproses...",
            "sLengthMenu":   "Tampilkan _MENU_ entri",
            "sZeroRecords":  "Tidak ditemukan data yang sesuai",
            "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
            "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
            "sInfoPostFix":  "",
            "sSearch":       "Cari:",
            "sUrl":          "",
            "oPaginate": {
                "sFirst":    "Pertama",
                "sPrevious": "Sebelumnya",
                "sNext":     "Selanjutnya",
                "sLast":     "Terakhir"
            }
        },
        //"scrollY": true,
        "fixedHeader": true,
        "fixedColumns": true,
        //"autoWidth": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: http + 'fetch?f='+remote+'&d='+target,
            type: "POST",
            dataType: 'json',
            // data: 'dataTable',
            beforeSend: function () {
                $("#table_buku_processing").addClass("text-center").html('<i class="fa fa-spinner fa-pulse fa-fw text-blue"></i>&nbsp;<span>Memuat Data...</span>');
                // console.log(data);
            },
            error: function () {
                $(".table_buku-error").html("");
                $("#table_buku").append('<tbody class="table_buku-error"><tr><td colspan="7" class="text-center">Tidak ada data</td></tr></tbody>');
                $("#table_buku_processing").css('display', 'none');
            }
        },
        "pageLength": 10,
        "order": [
            [0,"desc"]
        ],
        columnDefs: [
            {
                orderable: true,
                targets: [0,1,2,3,4]
            },
            {
                orderable: false,
                targets: [5]
            },
            {
                searchable: true,
                targets: [2,3]
            },
            {
                searchable: false,
                targets: [0,5]
            }
        ],
        "lengthMenu": [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Semua"]
        ]
        
    });
    $(document).on('click change','#choose', function(e) {
        e.preventDefault();
        $('#gambar').trigger('click');
        $('#gambar').on('change', function() {
            var imgPath = $(this).val();
            var ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            if (ext == "gir" || ext == "png" || ext == "jpg" || ext == "jpeg") {
                if (typeof (FileReader) != "undefined") {
                    var reader = new FileReader();
                    reader.onload = function(r) {
                        $('#preview').attr({
                            src: r.target.result,
                            style: "display: block"
                        });
                    }
                    $('button[type=submit]').attr('readonly',false);
                    $('#img').val($(this)[0].files[0].name);
                    reader.readAsDataURL($(this)[0].files[0]);
                } else {
                    console.log('This is browser does not support file reader !');
                }
            } else {
                $('button[type=submit]').attr('readonly',true);
                console.log('please select only image *.gif, *.png, *.jpg, *.jpeg');
            }
        });
        $('#reset').on('click', function(e) {
            e.preventDefault();
            $('#preview').attr({
                src: '',
                style: "display: none"
            });
            $('#img').val('');
            $('#gambar').val('');
        });
        return false;
    });
    $(document).on('click change','#choose-edit', function(e) {
        e.preventDefault();
        $('#gambar-edit').trigger('click');
        $('#gambar-edit').on('change', function() {
            var imgPath = $(this).val();
            var ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            if (ext == "gir" || ext == "png" || ext == "jpg" || ext == "jpeg") {
                if (typeof (FileReader) != "undefined") {
                    var reader = new FileReader();
                    reader.onload = function(r) {
                        $('#preview-edit').attr({
                            src: r.target.result,
                            style: "display: block"
                        });
                    }
                    $('button[type=submit]').attr('readonly',false);
                    $('#img-edit').val($(this)[0].files[0].name);
                    reader.readAsDataURL($(this)[0].files[0]);
                } else {
                    console.log('This is browser does not support file reader !');
                }
            } else {
                $('button[type=submit]').attr('readonly',true);
                console.log('please select only image *.gif, *.png, *.jpg, *.jpeg');
            }
        });
        return false;
    });
    $("#table_buku_filter").addClass("pull-right");
    $("#table_buku_paginate").addClass("pull-right");
    
    dataTable.on("draw.dt", function () {
        var info = dataTable.page.info();
        dataTable.column(0, {
            search: "applied",
            order: "applied",
            page: "applied"
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + info.start + ".";
        });
    });
  
    jQuery.noConflict();

    $("#create_buku").on('click', function (e) {
        e.preventDefault();
        $('#addModal').modal({
            'show': true,
            'backdrop': 'static'
        });
    });   
    
    $('#filter').on('click change', function() {
        $a = $(this);
        if ($a.val() == 3) {
            $('#range').prop('disabled',false).focus();
        } else {
            $('#range').val('').attr('disabled',true).closest('.form-group').removeClass('has-success');
        }
    });
    
    $('#range').daterangepicker({
        locale: {
            format: "DD/MM/YYYY"
        },
        showDropdowns: true,
        autoApply: true,
        startDate: start,
        endDate: end,
        maxDate: end,
        opens: "center",
        drops: "down",
      }, function(start, end, label) {
        //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
});