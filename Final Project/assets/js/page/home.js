$(function () {
    var remote = $('#list_home').attr('data-remote');
    var target = $('#list_home').attr('data-target');
    var items = $('#items');
    var boxload = $('#box-load');

    function formatAngka(angka) {
        if (typeof (angka) != 'string') angka = angka.toString();
        var reg = new RegExp('([0-9]+)([0-9]{3})');
        while (reg.test(angka)) angka = angka.replace(reg, '$1.$2');
        return angka;
    }
    
    

    scrollingElement = (document.scrollingElement || document.body)

    function scrollSmoothToBottom(id) {
        $(scrollingElement).animate({
            scrollTop: document.body.scrollHeight
        }, 1000);
    }
    
    setInterval(loadData(), 1000);

    function loadData() {
        items.empty();
        $('#msg-empty').css('display','none');
        $.ajax({
            url: http + 'list?f=' + remote + '&d=' + target,
            async: true,
            dataType: 'json',
            type: 'POST',
            success: function (res) {
                hideLoading();
                let datanyo = "";
                if (res.home.code == 1) {
                    boxload.css('display','block');
                    let max = res.home.data.length;
                    datanyo += "<div class=\"row itemnyo\">";
                    for (let i = 0; i < res.home.data.length; i++) {
                        let code = res.home.data[i].code;
                        let nama = res.home.data[i].items;
                        let img = http + 'assets/img/buku/' + res.home.data[i].cover ;
                        let rmt = res.home.data[i].remote;
                        let tgt = res.home.data[i].target;
                        datanyo += "<div class=\"col-md-2 col-xs-6\">" +
                            "<a id=\"detail\" title=\"\" data-remote=\"" + rmt + "\" data-target=\"" + tgt + "\" data-content=\"" + code + "\">" +
                            "<div class=\"box box-solid\">" +
                            "<div class=\"box-header\">" +
                            "<h3 class=\"box-title text-ellipsis\">" + nama + "</h3>" +
                            "</div>" +
                            "<div class=\"box-body\">" +
                            "<img class=\"img-responsive\" src=\"" + img + "\" alt=\"" + nama + "\" width=\"100%\" height=\"140px\" style=\"max-height: 140px !important; height: 140px !important\">" +
                            "</div>" +
                            "</div>" +
                            "</a>" +
                            "</div>";
                    }
                    datanyo+="</div>";
                } else {
                    $('#cari').attr('disabled',true);
                    $('#msg-empty').css('display','block');
                }
                if (res.home.total <= 6) {
                    $('#box-load').css('display', 'none');
                }
                items.append(datanyo);
                scrollSmoothToBottom();
            }
        });
    }

    //jQuery.noConflict();

    $(document).on('click', '#detail', function (e) {
        e.preventDefault();
        $('#detail-table').empty();
        var target = $(this).attr('data-target');
        var remote = $(this).attr('data-remote');
        var id = $(this).attr('data-content');
        $.ajax({
            url: http + 'list?f=' + remote + '&d=' + target + '&id=' + id,
            async: true,
            dataType: 'json',
            type: 'POST',
            beforeSend: function () {
                showLoading();
            },
            success: function (res) {
                if (res.length == 0) {
                    hideLoading();
                    alertDanger('Invalid request');
                } else {
                    if (res.home.code == 1) {
                        hideLoading();
                        $('#detailModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        let code = res.home.data.code;
                        let judul_buku = res.home.data.items;
                        let nama_kategori = res.home.data.cat;
                        let nama_pengarang = res.home.data.np;
                        let nama_penerbit = res.home.data.nper;
                        let stok_buku = res.home.data.stok;
                        let nama_rak = res.home.data.rak;
                        let tahun_buku = res.home.data.th;
                        let img = http + 'assets/img/buku/' + res.home.data.cover;
                        let tr_str = '';
                        tr_str += "<tr><td colspan=\"2\"><img class=\"img-responsive\" style=\"max-height: 250px;\" width=\"100%\" src=\"" + img + "\"></td></tr>" +
                            "<tr><td style=\"width: 25% !important;\">Kode Buku</td><td>" + code + "</td></tr>" +
                            "<tr><td>Judul Buku</td><td>" + judul_buku + "</td></tr>" +
                            "<tr><td>Kategori Buku</td><td>" + nama_kategori + "</td></tr>" +
                            "<tr><td>Nama Pengarang</td><td>" + nama_pengarang + "</td></tr>" +
                            "<tr><td>Nama Penerbit</td><td>" + nama_penerbit + "</td></tr>" +
                            "<tr><td>Lokasi Rak Buku</td><td>" + nama_rak + "</td></tr>" +
                            "<tr><td>Stok</td><td>" + formatAngka(stok_buku) +"</td></tr>" +
                            "<tr><td>Tahun Buku</td><td>" + tahun_buku + "</td></tr>" +
                        $('input[name=id]').val(code);
                        $('#detail-table').append(tr_str);
                    } else {
                        hideLoading();
                        alertWarning(res.home.message);
                    }
                }
            }
        });
    });

   
  
});