$(function() {

    moment.locale("id");
    var remote = $('#table_peminjaman').attr('data-remote');
    var target = $('#table_peminjaman').attr('data-target');

    var start = moment().subtract(29, 'days');
    var end = moment();

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
        $(id).find('.form-group').removeClass('has-success');
        $('[data-dismiss=modal]').click();
        $('#reset').click();
    }

    

    $('.auto').autoNumeric('init',{
        aSep: '.',
        aDec: ',',
        vMin: '0',
        vMax: '9999999999'
    });

    $.validator.addMethod("timenya", function (value, element) {
        var stamp = value.split(" ");
        var validDate = !/Invalid|NaN/.test(new Date(stamp[0]).toString());
        var validTime = /^(([0-1]?[0-9])|([2][0-3])).([0-5]?[0-9])(:([0-5]?[0-9]))?$/i.test(stamp[1]);
        return this.optional(element) || (validDate && validTime);
    }, "Please enter a valid date and time.");

    // Hide modal & reset form
    $('[data-dismiss=modal]').on('click', function (e) {
        var $t = $(this), target = $t[0].href || $t.data("target") || $t.parents('.modal') || [];
        $(target).find('.form-group').attr('class','form-group');
        $(target).find('label.has-error').remove();
        $(target)
            .find("input,textarea,select").val('').end()
            .find("input[type=checkbox], input[type=radio]").prop("checked", "").end();
        $(target).find('#preview').attr({src: '', style: 'display: none'});
        closeModal();
    });

    // Animation modal bootstrap + library Animate.css
    function closeModal() {
        var timeoutHandler = null;
        $('#addModal,#editModal,#detailModal,#downloadModal').on('hide.bs.modal', function () {
            var anim = $('.modal-dialog').removeClass('zoomIn').addClass('zoomOut');
            if (timeoutHandler) clearTimeout(timeoutHandler);
            timeoutHandler = setTimeout(function() {
                $('.modal-dialog').removeClass('zoomOut').addClass('zoomIn');
            }, 750); // some delay for complete Animation
        });
        $('#detail-table').empty();
    }

    // Validation Alat Start // 
    $('#add-peminjaman').validate({
        errorClass: 'has-error animated tada',
        validClass: 'has-success',
        rules: {
           
            durasi: {
                required: true,
                timenya: true,
            }
        },
        messages: {
           
            durasi: {
                required: "Pilih lama peminjaman !",
                timenya: "Tanggal tidak benar !"
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
            var uuid = $('#add-peminjaman').attr('data-target');
            var peminjaman = new FormData($('#add-peminjaman')[0]);
            $.ajax({
                url: http + 'fetch?f='+remote+'&d='+uuid,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                timeout: 3000,
                data: peminjaman,
                beforeSend: function() {
                    showLoading();
                },
                success: function(res) {
                    if (res.length == 0) {
                        hideLoading();
                        alertDanger('Invalid request');
                    } else {
                        if (res.peminjaman.code == 1) {
                            ajaxSuccess('#add-peminjaman');
                            dataTable.ajax.reload();
                            hideLoading();
                            alertSuccess(res.peminjaman.message);
                        } else {
                            hideLoading();
                            console.log(peminjaman);
                            alertWarning(res.peminjaman.message);
                        }
                    }
                },
                error: function(jqXHR, status, error) {
                    hideLoading();
                    
                    alertDanger(jqXHR);
                    
                }
            });
            return false;
        }
    });

    $('#durasi').datetimepicker({
        format: 'MM/DD/YYYY HH:mm',
        daysOfWeekDisabled: [0],
        minDate: new Date(),
        sideBySide: true,
    });

    $('#durasi_edit').datetimepicker({
        format: 'MM/DD/YYYY HH:mm',
        daysOfWeekDisabled: [0],
        sideBySide: true,
    });

    $('#edit-peminjaman').validate({
        errorClass: 'has-error animated tada',
        validClass: 'has-success',
        rules: {
            durasi_edit: {
                required: false,

            }
        },
        messages: {
            durasi_edit: {
                required: "Nama peminjaman harus diisi !"
            },
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.addClass("help-block");
            element.parents(".col-xs-9").addClass("has-feedback");

            if (element.prop( "type" ) === "checkbox") {
                error.insertAfter( element.parent("label"));
            } else {
                error.insertAfter( element);
            }
            if (!element.next( "span" )[ 0 ]) {
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
            var route = $('#edit-peminjaman').attr('data-target');
            var peminjaman = new FormData($('#edit-peminjaman')[0]);
            var id = $('#edit-peminjaman').find('input[type=hidden]').val();
            $.ajax({
                url: http + 'fetch?f='+remote+'&d='+route+'&id='+id,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                timeout: 3000,
                data: peminjaman,
                beforeSend: function() {
                    showLoading();
                },
                success: function(res) {
                    hideLoading();
                    if (res.length == 0) {
                        alertDanger('Invalid request');
                    } else {
                        if (res.peminjaman.code == 1) {
                            dataTable.ajax.reload();
                            ajaxSuccess('#edit-peminjaman');
                            alertSuccess(res.peminjaman.message);
                        } else if (res.peminjaman.code == 2) {
                            dataTable.ajax.reload();
                            $('[data-dismiss=modal]').click();
                            alertWarning(res.peminjaman.message);
                        } else {
                            alertWarning(res.peminjaman.message);
                        }
                    }
                },
                error: function(jqXHR, status, error) {
                    hideLoading();
                    alertDanger(error);
                }
            });
            return false;
        }
    });
    $("#table_peminjaman").on('click', '#edit', function (e) {
        e.preventDefault();
        var route = $(this).attr('data-target');
        var id = $(this).attr('data-content');
        $a = $('#edit-peminjaman').find('input[type=hidden],input[type=text], select, textarea');
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
                    if (res.peminjaman.code == 1) {
                        hideLoading();
                        $('#editModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        for (let i = 0; i < $a.length; i++) {
                            $a.eq(i).val(res.peminjaman.data[i]);
                        }
                    } else {
                        hideLoading();
                        alertWarning(res.peminjaman.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
                
            }
        });
    });
    // Validation Alat End //

    var dataTable = $("#table_peminjaman").DataTable({
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
            beforeSend: function () {
                $("#table_peminjaman_processing").addClass("text-center").html('<i class="fa fa-spinner fa-pulse fa-fw text-blue"></i>&nbsp;<span>Memuat Data...</span>');
            },
            error: function (data) {
                console.log(data);
                $(".table_peminjaman-error").html("");
                $("#table_peminjaman").append('<tbody class="table_peminjaman-error"><tr><td colspan="7" class="text-center">Tidak ada data</td></tr></tbody>');
                $("#table_peminjaman_processing").css('display', 'none');
            }
        },
        "pageLength": 10,
        "order": [
            [0,"desc"]
        ],
        columnDefs: [
            {
                orderable: true,
                targets: [0,1,2,3,4,5]
            },
            {
                orderable: false,
                targets: [6]
            },
            {
                searchable: true,
                targets: [1,2]
            },
            {
                searchable: false,
                targets: [0,3,4,5,6]
            }
        ],
        "lengthMenu": [ 
            [5, 10, 25, 50, 100, -1], 
            [5, 10, 25, 50, 100, "Semua"]
        ]
    });

    $("#table_peminjaman_filter").addClass("pull-right");
    $("#table_peminjaman_paginate").addClass("pull-right");
    
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
    
    const convertMinute = (minute = 1) => typeof minute === 'number' ? (minute * 60) * 1000 : (1 * 60) * 1000;

    const autoRefreshDatatable = (callback) => {
        setTimeout(() => {
            callback.ajax.reload();
            autoRefreshDatatable(callback);
        }, convertMinute(1));
    }

    // setiap 1 menit refresh data
    autoRefreshDatatable(dataTable);

    $("#create_peminjaman").on('click', function (e) {
        e.preventDefault();
        var target = $(this).attr('data-target');
        $('#list_peminjaman').empty();
        $('#box-load').css('display', 'block');
        $.ajax({
            url: http + 'fetch?f='+remote+'&d='+target,
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
                    if (res.peminjaman.code == 1) {
                        hideLoading();
                        $('#addModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        let tr_str = '';
                        for (let i = 0; i < res.peminjaman.data.length; i++) {
                            tr_str += "<tr>" +
                                        "<td>"+res.peminjaman.data[i].no+"</td>" +
                                        "<td>"+res.peminjaman.data[i].items+"</td>" +
                                        "<td>"+res.peminjaman.data[i].category+"</td>" +
                                        "<td>"+res.peminjaman.data[i].stock+"</td>" +
                                        "<td>"+res.peminjaman.data[i].checkbox+"</td>" +
                                        "<td>"+res.peminjaman.data[i].amount+"</td>" +
                                      "</tr>";
                        }
                        $('#list_peminjaman').append(tr_str);
                        if (res.peminjaman.total <= 3) {
                            $('#box-load').css('display', 'none');
                        }
                    } else {
                        hideLoading();
                        alertWarning(res.peminjaman.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });

    $(document).on('change','#list_peminjaman tr td input#pinjam', function(e) {
        e.preventDefault();
        var pjmn = $('#list_peminjaman tr td input#pinjam');
        var jmlh = $('#list_peminjaman tr td input#jumlah');
        for (let i = 0; i < jmlh.length; i++) {
            jmlh[i].disabled = !pjmn[i].checked;
            if (!pjmn[i].checked) jmlh[i].min;
        }
    });

    $(document).on('change','#list_peralatan_edit tr td input#tambah', function(e) {
        e.preventDefault();
        var pjmn = $('#list_peralatan_edit tr td input#tambah');
        var jmlh = $('#list_peralatan_edit tr td input#jumlah_edit');
        for (let i = 0; i < jmlh.length; i++) {
            jmlh[i].disabled = !pjmn[i].checked;
            if (!pjmn[i].checked) jmlh[i].min;
        }
    }); 

    // $(document).on('click','#add-peminjaman #box-load #loadmore', function(e) {
    //     e.preventDefault();
    //     var count = 0;
    //     var item = $('#list_peminjaman').children().length;
    //     var target = $('#add-peminjaman #box-load').attr('data-target');
    //     for (let i = 0; i < item; i++) {
    //         count++
    //     }
    //     $.ajax({
    //         url: http + 'fetch?f='+remote+'&d='+target+'&q=loadmore',
    //         async: true,
    //         dataType: 'json',
    //         data: {"awal": count},
    //         type: 'GET',
    //         success: function(res) {
    //             if (res.peminjaman.code == 1) {
    //                 let tr_str = '';
    //                 for (let i = 0; i < res.peminjaman.data.length; i++) {
    //                     tr_str += "<tr>" +
    //                                 "<td>"+res.peminjaman.data[i].no+"</td>" +
    //                                 "<td>"+res.peminjaman.data[i].items+"</td>" +
    //                                 "<td>"+res.peminjaman.data[i].category+"</td>" +
    //                                 "<td>"+res.peminjaman.data[i].stock+"</td>" +
    //                                 "<td>"+res.peminjaman.data[i].checkbox+"</td>" +
    //                                 "<td>"+res.peminjaman.data[i].amount+"</td>" +
    //                               "</tr>";
    //                 }
    //                 $('#list_peminjaman').append(tr_str);
    //                 count = 0;
    //             }
    //             if (res.peminjaman.total <= res.peminjaman.filter) {
    //                 $('#box-load').css('display', 'none');
    //             }
    //         }
    //     });
    // });

    $("#table_peminjaman").on('click', '#edit', function (e) {
        e.preventDefault();
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        $('#list_peralatan_edit').empty();
        $a = $('#edit-peminjaman').find('input[type=hidden],input[type=text], select, textarea');

        $.ajax({
            url: http + 'fetch?f='+remote+'&d='+uuid+'&id='+uid,
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
                    if (res.peminjaman.code == 1) {
                        hideLoading();
                        $('#editModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        $a.eq(0).val(res.peminjaman.data.peminjam.code);
                        $a.eq(1).val(res.peminjaman.data.peminjam.status);
                        $a.eq(2).val(moment(res.peminjaman.data.peminjam.exp).format("MM/DD/YYYY HH:mm"));
                        $a.eq(3).val(res.peminjaman.data.peminjam.name);
                        let tr_peralatan = '';
                        let jmlh = res.peminjaman.data.peralatan;
                        let no = 1;
                        for (let i = 0; i < jmlh.length; i++) {
                            tr_peralatan += "<tr>" +
                                                "<td>" + no + ".</td>" +
                                                "<td>" + res.peminjaman.data.peralatan[i].name + "</td>" +
                                                "<td>" + res.peminjaman.data.peralatan[i].category + "</td>" +
                                                "<td>" + res.peminjaman.data.peralatan[i].stock + "</td>" +
                                                "<td>" + res.peminjaman.data.peralatan[i].amount + "</td>" +
                                                "<td>" + res.peminjaman.data.peralatan[i].checkbox + "</td>" +
                                                "<td>" + res.peminjaman.data.peralatan[i].jumlah + "</td>" +
                                            "</tr>";
                            no++;
                        }
                        $('#list_peralatan_edit').append(tr_peralatan);
                    } else {
                        hideLoading();
                        alertWarning(res.peminjaman.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });
    $("#table_peminjaman").on('click', '#detail', function (e) {
        e.preventDefault();
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        var peminjam = $('#detail-peminjam').empty();
        var peminjaman = $('#detail-peminjaman').empty();

        $.ajax({
            url: http + 'fetch?f='+remote+'&d='+uuid+'&id='+uid,
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
                    if (res.peminjaman.code == 1) {
                        hideLoading();
                        $('#detailModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        let tr_peminjam = '';
                        tr_peminjam +=  "<tr><td style=\"width: 25% !important;\">Kode Peminjaman</td><td>" + res.peminjaman.data.peminjam.code + "</td></tr>" + 
                                        "<tr><td>Nama Peminjam</td><td>" + res.peminjaman.data.peminjam.name + "</td></tr>" +
                                        "<tr><td>Status</td><td>" + res.peminjaman.data.peminjam.status + "</td></tr>" +
                                        "<tr><td>Tanggal Peminjaman</td><td>" + moment(res.peminjaman.data.peminjam.create).format("dddd, DD-MMMM-YYYY HH:mm") + "</td></tr>" +
                                        "<tr><td>Tanggal Tempo</td><td>" + moment(res.peminjaman.data.peminjam.exp).format("dddd, DD-MMMM-YYYY HH:mm") + "</td></tr>";
                        peminjam.append(tr_peminjam);
                        
                        let tr_peminjaman = '';
                        let jmlh = res.peminjaman.data.peminjaman;
                        let no = 1;
                        let total = 0;
                        for (let i = 0; i < jmlh.length; i++) {
                            let unit = res.peminjaman.data.peminjaman[i].unit;
                            tr_peminjaman += "<tr>" +
                                                "<td>" + no + ".</td>" +
                                                "<td>" + res.peminjaman.data.peminjaman[i].code + "</td>" +
                                                "<td>" + res.peminjaman.data.peminjaman[i].name + "</td>" +
                                                "<td>" + res.peminjaman.data.peminjaman[i].category + "</td>" +
                                                "<td>" + res.peminjaman.data.peminjaman[i].amount + " " + unit + "</td>" +
                                            "</tr>";
                            no++;
                            total += parseInt(res.peminjaman.data.peminjaman[i].amount);
                        }
                        tr_peminjaman += "<tr><td colspan=\"4\" style=\"text-align: right !important;\">Jumlah</td><td>" + total + " item</td></tr>";
                        peminjaman.append(tr_peminjaman);
                    } else {
                        hideLoading();
                        alertWarning(res.peminjaman.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });

    $("#table_peminjaman").on('click', '#hapus', function (e) {
        e.preventDefault();
        var nm = $(this).attr('title-content');
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        Swal.fire({
            title: 'Apa Anda Yakin?',
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
                    url: http + 'fetch?f='+remote+'&d='+uuid+'&id='+uid,
                    type: 'POST',
                    dataType: 'json',
                    async: true,
                    processData: false,
                    contentType: false,
                    timeout: 3000,
                    beforeSend: function () {
                        showLoading();
                    },
                    success: function (res) {
                        if (res.length == 0) {
                            hideLoading();
                            alertDanger('Invalid request');
                        } else {
                            if (res.peminjaman.code == 1) {
                                hideLoading();
                                dataTable.ajax.reload();
                                alertSuccess(res.peminjaman.message);
                            } else {
                                hideLoading();
                                alertWarning(res.peminjaman.message);
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

    $("#download_peminjaman").on('click', function (e) {
        e.preventDefault();
        var rule = $(this).attr('data-remote');
        var uuid = $(this).attr('data-target');
        $.ajax({
            url: http + 'fetch?f='+rule+'&d='+uuid+'&tipe=peminjaman',
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
                    if (res.download.code == 1) {
                        hideLoading();
                        $('#downloadModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        $('#download-peminjaman h4.pull-right').html('Jumlah data sebanyak : ' + res.download.count + ' peminjaman.');
                    } else {
                        hideLoading();
                        alertWarning(res.download.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
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