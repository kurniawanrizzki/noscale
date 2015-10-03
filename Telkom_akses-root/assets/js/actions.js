var lastJQueryTS = 0 ;
$(document).ready(function(){        
    /* PROGGRESS START */
    $.mpb("show",{value: [0,50],speed: 5});        
    /* END PROGGRESS START */
    
    $('#row_alert_keluhan').show();
    $('#row_data_keluhan').hide();
    $('#row_alert_pegawai').show();
    $('#row_data_pegawai').hide();

    var html_click_avail = true;
    $('#id_pegawai_input').keyup(id_check);
    $('#email_pegawai_input').keyup(email_check);
    $('#id_pelanggan_input').keyup(pelanggan_check);


    if($('.form_title').html() == '<strong>FORM EDIT PEGAWAI</strong>'){
        $('input[type="submit"]').removeAttr('disabled');  
    }

    $("html").on("click", function(){
        if(html_click_avail)
            $(".x-navigation-horizontal li,.x-navigation-minimized li").removeClass('active');        
    });        
    
    $(".x-navigation-horizontal .panel").on("click",function(e){
        e.stopPropagation();
    });    
    
    /* WIDGETS (DEMO)*/
    $(".widget-remove").on("click",function(){
        $(this).parents(".widget").fadeOut(400,function(){
            $(this).remove();
            $("body > .tooltip").remove();
        });
        return false;
    });
    /* END WIDGETS */
    
    /* Gallery Items */
    $(".gallery-item .iCheck-helper").on("click",function(){
        var wr = $(this).parent("div");
        if(wr.hasClass("checked")){
            $(this).parents(".gallery-item").addClass("active");
        }else{            
            $(this).parents(".gallery-item").removeClass("active");
        }
    });
    $(".gallery-item-remove").on("click",function(){
        $(this).parents(".gallery-item").fadeOut(400,function(){
            $(this).remove();
        });
        return false;
    });
    $("#gallery-toggle-items").on("click",function(){
        
        $(".gallery-item").each(function(){
            
            var wr = $(this).find(".iCheck-helper").parent("div");
            
            if(wr.hasClass("checked")){
                $(this).removeClass("active");
                wr.removeClass("checked");
                wr.find("input").prop("checked",false);
            }else{            
                $(this).addClass("active");
                wr.addClass("checked");
                wr.find("input").prop("checked",true);
            }
            
        });
        
    });
    /* END Gallery Items */


    // XN PANEL DRAGGING
    $( ".xn-panel-dragging" ).draggable({
        containment: ".page-content", handle: ".panel-heading", scroll: false,
        start: function(event,ui){
            html_click_avail = false;
            $(this).addClass("dragged");
        },
        stop: function( event, ui ) {
            $(this).resizable({
                maxHeight: 400,
                maxWidth: 600,
                minHeight: 200,
                minWidth: 200,
                helper: "resizable-helper",
                start: function( event, ui ) {
                    html_click_avail = false;
                },
                stop: function( event, ui ) {
                    $(this).find(".panel-body").height(ui.size.height - 82);
                    $(this).find(".scroll").mCustomScrollbar("update");
                                            
                    setTimeout(function(){
                        html_click_avail = true; 
                    },1000);
                                            
                }
            })
            
            setTimeout(function(){
                html_click_avail = true; 
            },1000);            
        }
    });
    // END XN PANEL DRAGGING
    
    /* DROPDOWN TOGGLE */
    $(".dropdown-toggle").on("click",function(){
        onresize();
    });
    /* DROPDOWN TOGGLE */
    
    /* MESSAGE BOX */
    $(".mb-control").on("click",function(){
        var box = $($(this).data("box"));
        if(box.length > 0){
            box.toggleClass("open");
            
            var sound = box.data("sound");
            
            if(sound === 'alert')
                playAudio('alert');
            
            if(sound === 'fail')
                playAudio('fail');
            
        }        
        return false;
    });
    $(".mb-control-close").on("click",function(){
       $(this).parents(".message-box").removeClass("open");
       return false;
    });    
    /* END MESSAGE BOX */
    
    /* CONTENT FRAME */
    $(".content-frame-left-toggle").on("click",function(){
        $(".content-frame-left").is(":visible") 
        ? $(".content-frame-left").hide() 
        : $(".content-frame-left").show();
        page_content_onresize();
    });
    $(".content-frame-right-toggle").on("click",function(){
        $(".content-frame-right").is(":visible") 
        ? $(".content-frame-right").hide() 
        : $(".content-frame-right").show();
        page_content_onresize();
    });    
    /* END CONTENT FRAME */
    
    /* MAILBOX */
    $(".mail .mail-star").on("click",function(){
        $(this).toggleClass("starred");
    });
    
    $(".mail-checkall .iCheck-helper").on("click",function(){
        
        var prop = $(this).prev("input").prop("checked");
                    
        $(".mail .mail-item").each(function(){            
            var cl = $(this).find(".mail-checkbox > div");            
            cl.toggleClass("checked",prop).find("input").prop("checked",prop);                        
        }); 
        
    });
    /* END MAILBOX */
    
    /* PANELS */
    
    $(".panel-fullscreen").on("click",function(){
        panel_fullscreen($(this).parents(".panel"));
        return false;
    });
    
    $(".panel-collapse").on("click",function(){
        panel_collapse($(this).parents(".panel"));
        $(this).parents(".dropdown").removeClass("open");
        return false;
    });    
    $(".panel-remove").on("click",function(){
        panel_remove($(this).parents(".panel"));
        $(this).parents(".dropdown").removeClass("open");
        return false;
    });
    $(".panel-refresh").on("click",function(){
        var panel = $(this).parents(".panel");
        panel_refresh(panel);

        setTimeout(function(){
            panel_refresh(panel);
        },3000);
        
        $(this).parents(".dropdown").removeClass("open");
        return false;
    });
    /* EOF PANELS */
    
    /* ACCORDION */
    $(".accordion .panel-title a").on("click",function(){
        
        var blockOpen = $(this).attr("href");
        var accordion = $(this).parents(".accordion");        
        var noCollapse = accordion.hasClass("accordion-dc");
        
        
        if($(blockOpen).length > 0){            
            
            if($(blockOpen).hasClass("panel-body-open")){
                $(blockOpen).slideUp(200,function(){
                    $(this).removeClass("panel-body-open");
                });
            }else{
                $(blockOpen).slideDown(200,function(){
                    $(this).addClass("panel-body-open");
                });
            }
            
            if(!noCollapse){
                accordion.find(".panel-body-open").not(blockOpen).slideUp(200,function(){
                    $(this).removeClass("panel-body-open");
                });                                           
            }
            
            return false;
        }
        
    });
    /* EOF ACCORDION */
    
    /* DATATABLES/CONTENT HEIGHT FIX */
    $(".dataTables_length select").on("change",function(){
        onresize();
    });
    /* END DATATABLES/CONTENT HEIGHT FIX */
    
    /* TOGGLE FUNCTION */
    $(".toggle").on("click",function(){
        var elm = $("#"+$(this).data("toggle"));
        if(elm.is(":visible"))
            elm.addClass("hidden").removeClass("show");
        else
            elm.addClass("show").removeClass("hidden");
        
        return false;
    });
    /* END TOGGLE FUNCTION */
    
    /* MESSAGES LOADING */
    $(".messages .item").each(function(index){
        var elm = $(this);
        setInterval(function(){
            elm.addClass("item-visible");
        },index*300);              
    });
    /* END MESSAGES LOADING */
    
    x_navigation();
});



$(function(){            
    onload();

    /* PROGGRESS COMPLETE */
    $.mpb("update",{value: 100, speed: 5, complete: function(){            
        $(".mpb").fadeOut(200,function(){
            $(this).remove();
        });
    }});
    /* END PROGGRESS COMPLETE */
});

$(window).resize(function(){
    x_navigation_onresize();
    page_content_onresize();
});

function onload(){
    x_navigation_onresize();    
    page_content_onresize();
}

function page_content_onresize(){
    $(".page-content,.content-frame-body,.content-frame-right,.content-frame-left").css("width","").css("height","");
    
    var content_minus = 0;
    content_minus = ($(".page-container-boxed").length > 0) ? 40 : content_minus;
    content_minus += ($(".page-navigation-top-fixed").length > 0) ? 50 : 0;
    
    var content = $(".page-content");
    var sidebar = $(".page-sidebar");
    
    if(content.height() < $(document).height() - content_minus){        
        content.height($(document).height() - content_minus);
    }        
    
    if(sidebar.height() > content.height()){        
        content.height(sidebar.height());
    }
    
    if($(window).width() > 1024){
        
        if($(".page-sidebar").hasClass("scroll")){
            if($("body").hasClass("page-container-boxed")){
                var doc_height = $(document).height() - 40;
            }else{
                var doc_height = $(window).height();
            }
           $(".page-sidebar").height(doc_height);
           
       }
       
        if($(".content-frame-body").height() < $(document).height()-162){
            $(".content-frame-body,.content-frame-right,.content-frame-left").height($(document).height()-162);            
        }else{
            $(".content-frame-right,.content-frame-left").height($(".content-frame-body").height());
        }
        
        $(".content-frame-left").show();
        $(".content-frame-right").show();
    }else{
        $(".content-frame-body").height($(".content-frame").height()-80);
        
        if($(".page-sidebar").hasClass("scroll"))
           $(".page-sidebar").css("height","");
    }
    
    if($(window).width() < 1200){
        if($("body").hasClass("page-container-boxed")){
            $("body").removeClass("page-container-boxed").data("boxed","1");
        }
    }else{
        if($("body").data("boxed") === "1"){
            $("body").addClass("page-container-boxed").data("boxed","");
        }
    }
}

/* PANEL FUNCTIONS */
function panel_fullscreen(panel){    
    
    if(panel.hasClass("panel-fullscreened")){
        panel.removeClass("panel-fullscreened").unwrap();
        panel.find(".panel-body,.chart-holder").css("height","");
        panel.find(".panel-fullscreen .fa").removeClass("fa-compress").addClass("fa-expand");        
        
        $(window).resize();
    }else{
        var head    = panel.find(".panel-heading");
        var body    = panel.find(".panel-body");
        var footer  = panel.find(".panel-footer");
        var hplus   = 30;
        
        if(body.hasClass("panel-body-table") || body.hasClass("padding-0")){
            hplus = 0;
        }
        if(head.length > 0){
            hplus += head.height()+21;
        } 
        if(footer.length > 0){
            hplus += footer.height()+21;
        } 

        panel.find(".panel-body,.chart-holder").height($(window).height() - hplus);
        
        
        panel.addClass("panel-fullscreened").wrap('<div class="panel-fullscreen-wrap"></div>');        
        panel.find(".panel-fullscreen .fa").removeClass("fa-expand").addClass("fa-compress");
        
        $(window).resize();
    }
}

function panel_collapse(panel,action,callback){

    if(panel.hasClass("panel-toggled")){        
        panel.removeClass("panel-toggled");
        
        panel.find(".panel-collapse .fa-angle-up").removeClass("fa-angle-up").addClass("fa-angle-down");

        if(action && action === "shown" && typeof callback === "function")
            callback();            

        onload();
                
    }else{
        panel.addClass("panel-toggled");
                
        panel.find(".panel-collapse .fa-angle-down").removeClass("fa-angle-down").addClass("fa-angle-up");

        if(action && action === "hidden" && typeof callback === "function")
            callback();

        onload();        
        
    }
}
function panel_refresh(panel,action,callback){        
    if(!panel.hasClass("panel-refreshing")){
        panel.append('<div class="panel-refresh-layer"><img src="http://students.ce.undip.ac.id/Telkom_akses/assets/img/loaders/default.gif"/></div>');
        panel.find(".panel-refresh-layer").width(panel.width()).height(panel.height());
        panel.addClass("panel-refreshing");
        
        if(action && action === "shown" && typeof callback === "function") 
            callback();
    }else{
        panel.find(".panel-refresh-layer").remove();
        panel.removeClass("panel-refreshing");
        
        if(action && action === "hidden" && typeof callback === "function") 
            callback();        
    }       
    onload();
}
function panel_remove(panel,action,callback){    
    if(action && action === "before" && typeof callback === "function") 
        callback();
    
    panel.animate({'opacity':0},200,function(){
        panel.parent(".panel-fullscreen-wrap").remove();
        $(this).remove();        
        if(action && action === "after" && typeof callback === "function") 
            callback();
        
        
        onload();
    });    
}
/* EOF PANEL FUNCTIONS */

/* X-NAVIGATION CONTROL FUNCTIONS */
function x_navigation_onresize(){    
    
    var inner_port = window.innerWidth || $(document).width();
    
    if(inner_port < 1025){               
        $(".page-sidebar .x-navigation").removeClass("x-navigation-minimized");
        $(".page-container").removeClass("page-container-wide");
        $(".page-sidebar .x-navigation li.active").removeClass("active");
        
                
        $(".x-navigation-horizontal").each(function(){            
            if(!$(this).hasClass("x-navigation-panel")){                
                $(".x-navigation-horizontal").addClass("x-navigation-h-holder").removeClass("x-navigation-horizontal");
            }
        });
        
        
    }else{        
        if($(".page-navigation-toggled").length > 0){
            x_navigation_minimize("close");
        }       
        
        $(".x-navigation-h-holder").addClass("x-navigation-horizontal").removeClass("x-navigation-h-holder");                
    }
    
}

function x_navigation_minimize(action){
    
    if(action == 'open'){
        $(".page-container").removeClass("page-container-wide");
        $(".page-sidebar .x-navigation").removeClass("x-navigation-minimized");
        $(".x-navigation-minimize").find(".fa").removeClass("fa-indent").addClass("fa-dedent");
        $(".page-sidebar.scroll").mCustomScrollbar("update");
    }
    
    if(action == 'close'){
        $(".page-container").addClass("page-container-wide");
        $(".page-sidebar .x-navigation").addClass("x-navigation-minimized");
        $(".x-navigation-minimize").find(".fa").removeClass("fa-dedent").addClass("fa-indent");
        $(".page-sidebar.scroll").mCustomScrollbar("disable",true);
    }
    
    $(".x-navigation li.active").removeClass("active");
    
}

function x_navigation(){
    
    $(".x-navigation-control").click(function(){
        $(this).parents(".x-navigation").toggleClass("x-navigation-open");
        
        onresize();
        
        return false;
    });

    if($(".page-navigation-toggled").length > 0){
        x_navigation_minimize("close");
    }    
    
    $(".x-navigation-minimize").click(function(){
                
        if($(".page-sidebar .x-navigation").hasClass("x-navigation-minimized")){
            $(".page-container").removeClass("page-navigation-toggled");
            x_navigation_minimize("open");
        }else{            
            $(".page-container").addClass("page-navigation-toggled");
            x_navigation_minimize("close");            
        }
        
        onresize();
        
        return false;        
    });
       
    $(".x-navigation  li > a").click(function(){
        
        var li = $(this).parent('li');        
        var ul = li.parent("ul");
        
        ul.find(" > li").not(li).removeClass("active");    
        
    });
    
    $(".x-navigation li").click(function(event){
        event.stopPropagation();
        
        var li = $(this);
                
            if(li.children("ul").length > 0 || li.children(".panel").length > 0 || $(this).hasClass("xn-profile") > 0){
                if(li.hasClass("active")){
                    li.removeClass("active");
                    li.find("li.active").removeClass("active");
                }else
                    li.addClass("active");
                    
                onresize();
                
                if($(this).hasClass("xn-profile") > 0)
                    return true;
                else
                    return false;
            }                                     
    });
    
    /* XN-SEARCH */
    $(".xn-search").on("click",function(){
        $(this).find("input").focus();
    })
    /* END XN-SEARCH */
    
}
/* EOF X-NAVIGATION CONTROL FUNCTIONS */

/* PAGE ON RESIZE WITH TIMEOUT */
function onresize(timeout){    
    timeout = timeout ? timeout : 200;

    setTimeout(function(){
        page_content_onresize();
    },timeout);
}
/* EOF PAGE ON RESIZE WITH TIMEOUT */

/* PLAY SOUND FUNCTION */
function playAudio(file){
    if(file === 'alert')
        document.getElementById('audio-alert').play();

    if(file === 'fail')
        document.getElementById('audio-fail').play();    
}
/* END PLAY SOUND FUNCTION */

/*DELETE TABLE*/
function delete_row_on_tb_jadwal(row){
    var box = $("#mb-remove-row");
    box.addClass("open");
    
    box.find(".mb-control-yes").on("click",function(){
        var x = row.split(',');
        box.removeClass("open");
        $("#"+row).hide("slow",function(){
            $(this).remove();
            //window.location.href = 'http://students.ce.undip.ac.id/Telkom_akses/beranda/hapus_Jadwal/'+x[0]+'/'+x[1];
            window.location.href = 'http://localhost/Telkom_akses/index.php/beranda/hapus_Jadwal/'+x[0]+'/'+x[1];
        });
    });   
}
/*END DELETE TABLE*/

function delete_row_on_tb_pegawai(row){
    var box = $("#mb-remove-row");
    box.addClass("open");
    
    box.find(".mb-control-yes").on("click",function(){
        box.removeClass("open");
        $("#"+row).hide("slow",function(){
            $(this).remove();
            //window.location.href = 'http://students.ce.undip.ac.id/Telkom_akses/data/delete_pegawai/'+row;
            window.location.href = 'http://localhost/Telkom_akses/index.php/data/delete_pegawai/'+row;
        });
    });
}

function delete_row_on_tb_pelanggan(row){
    var box = $("#mb-remove-row");
    box.addClass('open');

    box.find(".mb-control-yes").on("click",function(){
        box.removeClass('open');
        $("#"+row).hide('slow',function(){
            $(this).remove();
            //window.location.href = 'http://students.ce.undip.ac.id/Telkom_akses/data/delete_pelanggan/'+row;
            window.location.href = 'http://localhost/Telkom_akses/index.php/data/delete_pelanggan/'+row;
        });
    });
}

function delete_row_on_tb_keluhan(row){
    var box = $("#mb-remove-row");
    box.addClass('open');

    box.find(".mb-control-yes").on("click",function(){
        box.removeClass('slow',function(){
            $(this).remove();
            //window.location.href = 'http://students.ce.undip.ac.id/Telkom_akses/alat/delete_keluhan/'+row;
            window.location.href = 'http://localhost/Telkom_akses/index.php/alat/delete_keluhan/'+row;
        });
    });
}
/* NEW OBJECT(GET SIZE OF ARRAY) */
Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};
/* EOF NEW OBJECT(GET SIZE OF ARRAY) */

//FUNGSI UNTUK LOAD DETAIL PEGAWAI
$(".open-detailModal").on("click", function () {
     var id_pegawai = $(this).data('id');
     $.post('Detail_Pegawai/'+id_pegawai,function(data){
        var obj =$.parseJSON(data);
        //console.log(obj[0].id_pegawai);
        $('.modal-title').html('Detail Pegawai <i>');
        $('#img_pegawai').attr('src','http://students.ce.undip.ac.id/Telkom_akses/assets/images/'+obj[0].img_pegawai);
        $('#id_pegawai_o').html(obj[0].id_pegawai);
        $('#nama_pegawai').html(obj[0].nama_pegawai);
        $('#jabatan_pegawai').html(obj[0].jabatan_pegawai);
        $('#alamat_pegawai').html(obj[0].alamat_pegawai);
        $('#email_pegawai').html(obj[0].email_pegawai);
        $('#telp_hp_pegawai').html(obj[0].telp_hp_pegawai);
     });    
});

$(".open-detailPModal").on("click",function(){
    var id_speedy = $(this).data('id');
    $.post('Detail_Pelanggan/'+id_speedy,function(data){
        var objP = $.parseJSON(data);
        $('.modal-title').html('Detail Pelanggan <i>');

        if($("#google_ptm_map").length > 0){
            console.log(objP[0].lat_pelanggan, objP[0].ltg_pelanggan)
            var gPTMCords = new google.maps.LatLng(objP[0].lat_pelanggan, objP[0].ltg_pelanggan);
            var gPTMOptions = {zoom: 15,center: gPTMCords, mapTypeId: google.maps.MapTypeId.ROADMAP}    
            var gPTM = new google.maps.Map(document.getElementById("google_ptm_map"), gPTMOptions);        
            
            var cords = new google.maps.LatLng(objP[0].lat_pelanggan, objP[0].ltg_pelanggan);
            var marker = new google.maps.Marker({position: cords, map: gPTM, title: "Lokasi Rumah Bpk/Ibu "+objP[0].nama_pelanggan});     
        }

        $('#id_speedy').html(objP[0].id_speedy);
        $('#nama_pelanggan').html(objP[0].nama_pelanggan);
        $('#id_dp').html('Jalur DP : '+objP[0].nama_dp);
        $('#id_msan').html('Jalur MSAN : '+objP[0].nama_msan);
        $('#alamat_pelanggan').html(objP[0].alamat_pelanggan);
        $('#telp_hp_pelanggan').html(objP[0].telp_hp_pelanggan);
        $('#telp_rumah_pelanggan').html(objP[0].telp_rumah_pelanggan);
        $('#status_pelanggan').html(objP[0].status_pelanggan);
    });
});

function openDetailKeluhan(id_keluhan){
    $.post('View_Detail_Keluhan/'+id_keluhan,function(data){
        var objK = $.parseJSON(data);
        //console.log(objK);
        var dateTime = objK[0].tgl_laporan.split(" ");
        var time = dateTime[1].split(":");
        var jam = time[0]+':'+time[1];

        var status = '';
        var pegawai = '';
        var tgl_pengerjaan = '';
        var ket = '';
        console.log(objK[0]);

        if(objK[0].status_kunjungan != null && objK[0].teknisi == null){
            status = "<span class='label label-default'>Belum Terjadwal</span>";
            pegawai = status;
            tgl_pengerjaan =  status;
            ket = '-';
        }else{
            if(objK[0].status_kunjungan == 'SELESAI'){
                status = "<span class='label label-success'>SELESAI</span>";
                pegawai = objK[0].teknisi;
                tgl_pengerjaan =  objK[0].tgl_kunjungan;
                if(objK[0].ket_kunjungan != ''){
                    ket = objK[0].ket_kunjungan;
                }else{
                    ket = '-';
                }
            }else if(objK[0].status_kunjungan == 'MENUNGGU'){
                status = "<span class='label label-warning'>MENUNGGU</span>";
                pegawai = objK[0].teknisi;
                tgl_pengerjaan =  objK[0].tgl_kunjungan;
                ket = '-';
                if(objK[0].ket_kunjungan != ''){
                    ket = objK[0].ket_kunjungan;
                }else{
                    ket = '-';
                }
            }else if(objK[0].status_kunjungan == 'TIDAK SELESAI'){
                status = "<span class='label label-danger'>TIDAK SELESAI</span>";
                pegawai = objK[0].teknisi;
                tgl_pengerjaan =  objK[0].tgl_kunjungan;
                if(objK[0].ket_kunjungan != ''){
                    ket = objK[0].ket_kunjungan;
                }else{
                    ket = '-';
                }
            }else{
                status = "<span class='label label-default'>Belum Terjadwal</span>";
                pegawai = status;
                tgl_pengerjaan =  status;
                ket = '-';
            }
        }


        $('.modal-title').html('Detail Keluhan Pelanggan <i>');
        $('#id_speedy_1').html(objK[0].id_speedy);
        $('#nama_pelanggan_1').html(objK[0].nama_pelanggan);
        $('#alamat_pelanggan_1').html(objK[0].alamat_pelanggan);
        $('#ket_keluhan_1').html(objK[0].ket_keluhan);
        $('#tgl_laporan_1').html(dateTime[0]);
        $('#jam_laporan_1').html(jam);
        $('#tgl_pengerjaan_1').html(tgl_pengerjaan);
        $('#ket_kunjungan_1').html(ket);
        $('#status_pengerjaan_1').html(status);
        $('#teknisi_1').html(pegawai);
    });
}

function openDetailRiwayat(x,y,z){
    console.log(x,y,z);
    $.post('View_Riwayat_Evaluasi/'+x+'/'+y+'/'+z,function(data){
        var objRE = $.parseJSON(data);
        console.log(objRE);
        $('.modal-title').html('Riwayat Pekerjaan Bulan Lalu <i>');
        $('#id_pegawai_y').html(objRE[0].id_pegawai);
        $('#nama_pegawai_y').html(objRE[0].nama_pegawai);


        $("#table_RE tbody").remove();
        for(var i=0;i<objRE.length;i++){
            //console.log(objR['datPegawai'][i]);
            if(objRE[i].status_kunjungan == 'SELESAI'){
                status = "<span class='label label-success'>SELESAI</span>";
            }else if(objRE[i].status_kunjungan == 'MENUNGGU'){
                status = "<span class='label label-warning'>MENUNGGU</span>";
            }else{
                status = "<span class='label label-danger'>TIDAK SELESAI</span>";
            }

            if(objRE[i].ket_kunjungan.length==0){
                var x = '-';
            }else{
                var x = objRE[i].ket_kunjungan;
            }
            $('#table_RE').append(
                '<tr><td>'+objRE[i].id_speedy+'</td>'+
                '<td>'+objRE[i].nama_pelanggan+'</td>'+
                '<td>'+objRE[i].jenis_keluhan+'</td>'+
                '<td>'+objRE[i].tgl_laporan+'</td>'+
                '<td>'+objRE[i].tgl_pengerjaan+'</td>'+
                '<td>'+objRE[i].tgl_kunjungan+'</td>'+
                '<td>'+objRE[i].jam_kunjungan+'</td>'+
                '<td>'+status+'</td>'+
                '<td align=center>'+x+'</td></tr>'
                );

        }
    });
}

var bulans = ['1','2','3','4','5','6','7','8','9','10','11','12'];
var e = new Date();
var ey = bulans[e.getMonth()];
$('#selectRiwayat').val(bulans[e.getMonth()]);

$(".open-detailRModal").on('click',function(){
	var id_pegawai = $(this).data('id');

    $.post('Riwayat_Pegawai_By_Id/'+id_pegawai+'/'+ey,function(data){        
        var objR = $.parseJSON(data);

        $("#table_riwayat tbody").remove();
        if(objR['datPegawai'].length != 0){
            $('.modal-title').html('Riwayat Pekerjaan <i>');
            $('#id_pegawai_x').html(objR['datPegawai'][0].id_pegawai);
            $('#nama_pegawai_x').html(objR['datPegawai'][0].nama_pegawai);
            $('#jml_pekerjaan_x').html(objR['datTotUF']+' Pekerjaan');


            for(var i=0;i<objR['datPegawai'].length;i++){
                console.log(objR['datPegawai'][i]);
                var status = '';
                if(objR['datPegawai'][i].status_kunjungan == 'SELESAI'){
                    status = "<span class='label label-success'>SELESAI</span>";
                }else if(objR['datPegawai'][i].status_kunjungan == 'MENUNGGU'){
                    status = "<span class='label label-warning'>MENUNGGU</span>";
                }
                else{
                    status = "<span class='label label-danger'>TIDAK SELESAI</span>";
                }
                var dateTime = objR['datPegawai'][i].tgl_laporan.split(" ");
                var time = dateTime[1].split(":");
                var jam = time[0]+':'+time[1];

                $('#table_riwayat').append(
                    '<tr><td>'+objR['datPegawai'][i].id_speedy+'</td>'+
                    '<td>'+objR['datPegawai'][i].nama_pelanggan+'</td>'+
                    '<td>'+objR['datPegawai'][i].jenis_keluhan+'</td>'+
                    '<td>'+dateTime[0]+'</td>'+
                    '<td>'+objR['datPegawai'][i].tgl_pengerjaan+'</td>'+
                    '<td>'+objR['datPegawai'][i].tgl_kunjungan+'</td>'+
                    '<td>'+objR['datPegawai'][i].jam_kunjungan+'</td>'+
                    '<td>'+status+'</td></tr>'
                    );
            }
        }else{
            $('#table_riwayat').append("<tr><td colspan='8' align='center'><i><strong>Tidak Ada Pekerjaan</strong></i></td></tr>");
        }
    });
    
    $('#selectRiwayat').change(function(){
        var bulan_riwayat = $('#selectRiwayat').val();
        console.log(bulan_riwayat);
        
        $("#table_riwayat tbody").remove();
        if(bulan_riwayat == '0'){
            $.post('Riwayat_Pegawai_By_Id/'+id_pegawai,function(data){
                var objR = $.parseJSON(data);

                $("#table_riwayat tbody").remove();
                if(objR['datPegawai'].length != 0){
                    $('.modal-title').html('Riwayat Pekerjaan <i>');
                    $('#id_pegawai_x').html(objR['datPegawai'][0].id_pegawai);
                    $('#nama_pegawai_x').html(objR['datPegawai'][0].nama_pegawai);
                    $('#jml_pekerjaan_x').html(objR['datTotUF']+' Pekerjaan');


                    for(var i=0;i<objR['datPegawai'].length;i++){
                        console.log(objR['datPegawai'][i]);
                        var status = '';
                        if(objR['datPegawai'][i].status_kunjungan == 'SELESAI'){
                            status = "<span class='label label-success'>SELESAI</span>";
                        }else if(objR['datPegawai'][i].status_kunjungan == 'MENUNGGU'){
                            status = "<span class='label label-warning'>MENUNGGU</span>";
                        }
                        else{
                            status = "<span class='label label-danger'>TIDAK SELESAI</span>";
                        }
                        var dateTime = objR['datPegawai'][i].tgl_laporan.split(" ");
                        var time = dateTime[1].split(":");
                        var jam = time[0]+':'+time[1];

                        $('#table_riwayat').append(
                            '<tr><td>'+objR['datPegawai'][i].id_speedy+'</td>'+
                            '<td>'+objR['datPegawai'][i].nama_pelanggan+'</td>'+
                            '<td>'+objR['datPegawai'][i].jenis_keluhan+'</td>'+
                            '<td>'+dateTime[0]+'</td>'+
                            '<td>'+objR['datPegawai'][i].tgl_pengerjaan+'</td>'+
                            '<td>'+objR['datPegawai'][i].tgl_kunjungan+'</td>'+
                            '<td>'+objR['datPegawai'][i].jam_kunjungan+'</td>'+
                            '<td>'+status+'</td></tr>'
                            );
                    }
                }else{
                    $('#table_riwayat').append("<tr><td colspan='8' align='center'><i><strong>Tidak Ada Pekerjaan</strong></i></td></tr>");
                }
            });
        }else{
            $.post('Riwayat_Pegawai_By_Id/'+id_pegawai+'/'+bulan_riwayat,function(data){
                var objR = $.parseJSON(data);

                $("#table_riwayat tbody").remove();
                if(objR['datPegawai'].length != 0){
                    $('.modal-title').html('Riwayat Pekerjaan <i>');
                    $('#id_pegawai_x').html(objR['datPegawai'][0].id_pegawai);
                    $('#nama_pegawai_x').html(objR['datPegawai'][0].nama_pegawai);
                    $('#jml_pekerjaan_x').html(objR['datTotUF']+' Pekerjaan');


                    for(var i=0;i<objR['datPegawai'].length;i++){
                        console.log(objR['datPegawai'][i]);
                        var status = '';
                        if(objR['datPegawai'][i].status_kunjungan == 'SELESAI'){
                            status = "<span class='label label-success'>SELESAI</span>";
                        }else if(objR['datPegawai'][i].status_kunjungan == 'MENUNGGU'){
                            status = "<span class='label label-warning'>MENUNGGU</span>";
                        }
                        else{
                            status = "<span class='label label-danger'>TIDAK SELESAI</span>";
                        }
                        var dateTime = objR['datPegawai'][i].tgl_laporan.split(" ");
                        var time = dateTime[1].split(":");
                        var jam = time[0]+':'+time[1];

                        $('#table_riwayat').append(
                            '<tr><td>'+objR['datPegawai'][i].id_speedy+'</td>'+
                            '<td>'+objR['datPegawai'][i].nama_pelanggan+'</td>'+
                            '<td>'+objR['datPegawai'][i].jenis_keluhan+'</td>'+
                            '<td>'+dateTime[0]+'</td>'+
                            '<td>'+objR['datPegawai'][i].tgl_pengerjaan+'</td>'+
                            '<td>'+objR['datPegawai'][i].tgl_kunjungan+'</td>'+
                            '<td>'+objR['datPegawai'][i].jam_kunjungan+'</td>'+
                            '<td>'+status+'</td></tr>'
                            );
                    }
                }else{
                    $('#table_riwayat').append("<tr><td colspan='8' align='center'><i><strong>Tidak Ada Pekerjaan</strong></i></td></tr>");
                }
            });
        }
    });
});

var d = new Date();
var ex = bulans[d.getMonth()];
$('#selectLogin').val(bulans[d.getMonth()]);

$(".open-detailLModal").on('click',function(){
	var id_user = $(this).data('id');

    $.post('Monitoring/'+id_user+'/'+ex,function(data){
        var dataLogin = $.parseJSON(data);
        
        console.log(dataLogin.length);
        $("#table_L tbody").remove();
        if(dataLogin.length != 0){
            $('.modal-title').html('Riwayat Login Pegawai');
            $('#id_pegawai_s').html(dataLogin[0].id_pegawai);
            $('#nama_pegawai_s').html(dataLogin[0].nama_pegawai);
            $('#jabatan_pegawai_s').html(dataLogin[0].jabatan_pegawai);
            $('#email_pegawai_s').html(dataLogin[0].email_pegawai);


            for (var i = 0; i < dataLogin.length; i++) 
            {
                var xlogin = dataLogin[i].login.split(" ");
                var xlogout = dataLogin[i].logout.split(" ");

                var xjam = xlogin[1].split(':');
                var xjamx = xjam[0]+':'+xjam[1];

                var yjam = xlogout[1].split(':');
                var yjamy = yjam[0]+':'+yjam[1];
                $('#table_L').append(
                    '<tr><td>'+(i+1)+'</td>'+
                    '<td>'+xlogin[0]+'</td>'+
                    '<td>'+xjamx+'</td>'+
                    '<td>'+xlogout[0]+'</td>'+
                    '<td>'+yjamy+'</td></tr>'
                );
            }
        }else{
            $('#table_L').append("<tr><td colspan='5' align='center'><i><strong>Pengguna Belum Pernah Login</strong></i></td></tr>");
        }
    });
    
    $('#selectLogin').change(function(){
        var bulan_login = $('#selectLogin').val();
        console.log(bulan_login);
        
        $("#table_L tbody").remove();
        if(bulan_login == '0'){
            $.post('Monitoring/'+id_user,function(data){
                var dataLogin = $.parseJSON(data);

                console.log(dataLogin.length);

                if(dataLogin.length != 0){
                    $('.modal-title').html('Riwayat Login Pegawai');
                    $('#id_pegawai_s').html(dataLogin[0].id_pegawai);
                    $('#nama_pegawai_s').html(dataLogin[0].nama_pegawai);
                    $('#jabatan_pegawai_s').html(dataLogin[0].jabatan_pegawai);
                    $('#email_pegawai_s').html(dataLogin[0].email_pegawai);


                    for (var i = 0; i < dataLogin.length; i++) 
                    {
                        var xlogin = dataLogin[i].login.split(" ");
                        var xlogout = dataLogin[i].logout.split(" ");

                        var xjam = xlogin[1].split(':');
                        var xjamx = xjam[0]+':'+xjam[1];

                        var yjam = xlogout[1].split(':');
                        var yjamy = yjam[0]+':'+yjam[1];
                        $('#table_L').append(
                            '<tr><td>'+(i+1)+'</td>'+
                            '<td>'+xlogin[0]+'</td>'+
                            '<td>'+xjamx+'</td>'+
                            '<td>'+xlogout[0]+'</td>'+
                            '<td>'+yjamy+'</td></tr>'
                        );
                    }
                }else{
                    $('#table_L').append("<tr><td colspan='5' align='center'><i><strong>Pengguna Belum Pernah Login</strong></i></td></tr>");
                }
            });
        }else{
            $.post('Monitoring/'+id_user+'/'+bulan_login,function(data){
                var dataLogin = $.parseJSON(data);
                
                console.log(dataLogin.length);

                if(dataLogin.length != 0){
                    $('.modal-title').html('Riwayat Login Pegawai');
                    $('#id_pegawai_s').html(dataLogin[0].id_pegawai);
                    $('#nama_pegawai_s').html(dataLogin[0].nama_pegawai);
                    $('#jabatan_pegawai_s').html(dataLogin[0].jabatan_pegawai);
                    $('#email_pegawai_s').html(dataLogin[0].email_pegawai);

                    for (var i = 0; i < dataLogin.length; i++) 
                    {
                        var xlogin = dataLogin[i].login.split(" ");
                        var xlogout = dataLogin[i].logout.split(" ");

                        var xjam = xlogin[1].split(':');
                        var xjamx = xjam[0]+':'+xjam[1];

                        var yjam = xlogout[1].split(':');
                        var yjamy = yjam[0]+':'+yjam[1];
                        $('#table_L').append(
                            '<tr><td>'+(i+1)+'</td>'+
                            '<td>'+xlogin[0]+'</td>'+
                            '<td>'+xjamx+'</td>'+
                            '<td>'+xlogout[0]+'</td>'+
                            '<td>'+yjamy+'</td></tr>'
                        );
                    }
                }else{
                    $('#table_L').append("<tr><td colspan='5' align='center'><i><strong>Pengguna Belum Pernah Login</strong></i></td></tr>");
                }
            });
        }
    });
});



$.post(window.location.origin+'/Telkom_akses/index.php/alat/view_keluhan/',function(d){
    var data = $.parseJSON(d);
    $("#table_search tbody").remove();
    for(var i=0;i<data['k'].length;i++){

        if(data['k'][i].teknisi == null){
            var teknisi = "<span class='label label-default'>Belum Terjadwal</span>";
        }else{
            var teknisi = data['k'][i].teknisi;
        }

        if(data['k'][i].teknisi == null && data['k'][i].status_kunjungan != null){
            var status = "<span class='label label-default'>Belum Terjadwal</span>";
        }else{
            if(data['k'][i].status_kunjungan == null){
                var status = "<span class='label label-default'>Belum Terjadwal</span>";
            }
            else if(data['k'][i].status_kunjungan == 'SELESAI'){
                var status = "<span class='label label-success'>SELESAI</span>";
            }else if(data['k'][i].status_kunjungan == 'TIDAK SELESAI'){
                var status = "<span class='label label-danger'>TIDAK SELESAI</span>";
            }else{
                var status = "<span class='label label-warning'>MENUNGGU</span>";
            }
        }

        var update = "<a href='"+window.location.origin+"/Telkom_akses/index.php/alat/update_Keluhan/"+data['k'][i].id_keluhan+"' class='btn btn btn-warning'><i class='glyphicon glyphicon-pencil'></i></a>";
        var modal = "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal2' onClick='openDetailKeluhan("+data['k'][i].id_keluhan+");' data-backdrop=''><i class='glyphicon glyphicon-info-sign'></i></button>";     
        var hapus ="<button class='btn btn-danger' onClick='delete_row_on_tb_keluhan("+data['k'][i].id_keluhan+");'><i class='glyphicon glyphicon-trash'></i></button>";
        
        if(data['k'][i].status_kunjungan != 'TIDAK SELESAI'){
            if(data['jabatan'].jabatan_pegawai == 'KARYAWAN' || data['jabatan'].jabatan_pegawai == 'KEPALA TEKNISI'){
                $('#table_search').append(
                '<tr id='+data['k'][i].id_keluhan+'><td>'+data['k'][i].id_speedy+'</td>'+
                '<td>'+data['k'][i].nama_pelanggan+'</td>'+
                '<td>'+data['k'][i].jenis_keluhan+'</td>'+
                '<td>'+teknisi+'</td>'+
                '<td>'+status+'</td>'+
                '<td>'+modal+' '+update+' '+hapus+'</td></tr>'
                );
            }else if(data['jabatan'].jabatan_pegawai == 'MANAGER'){
                $('#table_search').append(
                '<tr id='+data['k'][i].id_keluhan+'><td>'+data['k'][i].id_speedy+'</td>'+
                '<td>'+data['k'][i].nama_pelanggan+'</td>'+
                '<td>'+data['k'][i].jenis_keluhan+'</td>'+
                '<td>'+teknisi+'</td>'+
                '<td>'+status+'</td>'+
                '<td>'+modal+'</td></tr>'
                );
            }else{
                // window.location.href = 'http://students.ce.undip.ac.id/Telkom_akses/errors/page_missing';
                console.log('error');
            }
        }
    }
});

$('#SelectBulanKeluhan').change(function(){
    var selectBulan = $('#SelectBulanKeluhan').val();
    
    if(selectBulan != '0'){
        $.post(window.location.origin+'/Telkom_akses/index.php/alat/view_keluhan/'+selectBulan,function(d){
            var data = $.parseJSON(d);
            $("#table_search tbody").remove();
            for(var i=0;i<data['k'].length;i++){

                if(data['k'][i].teknisi == null){
                    var teknisi = "<span class='label label-default'>Belum Terjadwal</span>";
                }else{
                    var teknisi = data['k'][i].teknisi;
                }

                if(data['k'][i].teknisi == null && data['k'][i].status_kunjungan != null){
                    var status = "<span class='label label-default'>Belum Terjadwal</span>";
                }else{
                    if(data['k'][i].status_kunjungan == null){
                        var status = "<span class='label label-default'>Belum Terjadwal</span>";
                    }
                    else if(data['k'][i].status_kunjungan == 'SELESAI'){
                        var status = "<span class='label label-success'>SELESAI</span>";
                    }else if(data['k'][i].status_kunjungan == 'TIDAK SELESAI'){
                        var status = "<span class='label label-danger'>TIDAK SELESAI</span>";
                    }else{
                        var status = "<span class='label label-warning'>MENUNGGU</span>";
                    }
                }
                var update = "<a href='"+window.location.origin+"/Telkom_akses/index.php/alat/update_Keluhan/"+data['k'][i].id_keluhan+"' class='btn btn btn-warning'><i class='glyphicon glyphicon-pencil'></i></a>";
                var modal = "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal2' onClick='openDetailKeluhan("+data['k'][i].id_keluhan+");' data-backdrop=''><i class='glyphicon glyphicon-info-sign'></i></button>";     
                var hapus ="<button class='btn btn-danger' onClick='delete_row_on_tb_keluhan("+data['k'][i].id_keluhan+");'><i class='glyphicon glyphicon-trash'></i></button>";
                
                if(data['k'][i].status_kunjungan != 'TIDAK SELESAI'){
                    if(data['jabatan'].jabatan_pegawai == 'KARYAWAN' || data['jabatan'].jabatan_pegawai == 'KEPALA TEKNISI'){
                        $('#table_search').append(
                        '<tr id='+data['k'][i].id_keluhan+'><td>'+data['k'][i].id_speedy+'</td>'+
                        '<td>'+data['k'][i].nama_pelanggan+'</td>'+
                        '<td>'+data['k'][i].jenis_keluhan+'</td>'+
                        '<td>'+teknisi+'</td>'+
                        '<td>'+status+'</td>'+
                        '<td>'+modal+' '+update+' '+hapus+'</td></tr>'
                        );
                    }else if(data['jabatan'].jabatan_pegawai == 'MANAGER'){
                        $('#table_search').append(
                        '<tr id='+data['k'][i].id_keluhan+'><td>'+data['k'][i].id_speedy+'</td>'+
                        '<td>'+data['k'][i].nama_pelanggan+'</td>'+
                        '<td>'+data['k'][i].jenis_keluhan+'</td>'+
                        '<td>'+teknisi+'</td>'+
                        '<td>'+status+'</td>'+
                        '<td>'+modal+'</td></tr>'
                        );
                    }else{
                        //window.location.href = 'http://students.ce.undip.ac.id/Telkom_akses/errors/page_missing';
                        console.log(error);
                    }
                }
            }
        });
    }else{
        $.post(window.location.origin+'/Telkom_akses/index.php/alat/view_keluhan/',function(d){
            var data = $.parseJSON(d);
            $("#table_search tbody").remove();
            for(var i=0;i<data['k'].length;i++){

                if(data['k'][i].teknisi == null){
                    var teknisi = "<span class='label label-default'>Belum Terjadwal</span>";
                }else{
                    var teknisi = data['k'][i].teknisi;
                }

                if(data['k'][i].teknisi == null && data['k'][i].status_kunjungan != null){
                    var status = "<span class='label label-default'>Belum Terjadwal</span>";
                }else{
                    if(data['k'][i].status_kunjungan == null){
                        var status = "<span class='label label-default'>Belum Terjadwal</span>";
                    }
                    else if(data['k'][i].status_kunjungan == 'SELESAI'){
                        var status = "<span class='label label-success'>SELESAI</span>";
                    }else if(data['k'][i].status_kunjungan == 'TIDAK SELESAI'){
                        var status = "<span class='label label-danger'>TIDAK SELESAI</span>";
                    }else{
                        var status = "<span class='label label-warning'>MENUNGGU</span>";
                    }
                }
                var update = "<a href='"+window.location.origin+"/Telkom_akses/index.php/alat/update_Keluhan/"+data['k'][i].id_keluhan+"' class='btn btn btn-warning'><i class='glyphicon glyphicon-pencil'></i></a>";
                var modal = "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal2' onClick='openDetailKeluhan("+data['k'][i].id_keluhan+");' data-backdrop=''><i class='glyphicon glyphicon-info-sign'></i></button>";     
                var hapus ="<button class='btn btn-danger' onClick='delete_row_on_tb_keluhan("+data['k'][i].id_keluhan+");'><i class='glyphicon glyphicon-trash'></i></button>";
                
                if(data['k'][i].status_kunjungan != 'TIDAK SELESAI'){
                    if(data['jabatan'].jabatan_pegawai == 'KARYAWAN' || data['jabatan'].jabatan_pegawai == 'KEPALA TEKNISI'){
                        $('#table_search').append(
                        '<tr id='+data['k'][i].id_keluhan+'><td>'+data['k'][i].id_speedy+'</td>'+
                        '<td>'+data['k'][i].nama_pelanggan+'</td>'+
                        '<td>'+data['k'][i].jenis_keluhan+'</td>'+
                        '<td>'+teknisi+'</td>'+
                        '<td>'+status+'</td>'+
                        '<td>'+modal+' '+update+' '+hapus+'</td></tr>'
                        );
                    }else if(data['jabatan'].jabatan_pegawai == 'MANAGER'){
                        $('#table_search').append(
                        '<tr id='+data['k'][i].id_keluhan+'><td>'+data['k'][i].id_speedy+'</td>'+
                        '<td>'+data['k'][i].nama_pelanggan+'</td>'+
                        '<td>'+data['k'][i].jenis_keluhan+'</td>'+
                        '<td>'+teknisi+'</td>'+
                        '<td>'+status+'</td>'+
                        '<td>'+modal+'</td></tr>'
                        );
                    }else{
                        console.log(error);
                    }
                }
            }
        });
    }
});

$(".open-settingModal").on('click',function(){
    $('.modal-title').html('Foto Profil Pegawai');
});

//aktivasi pelanggan
if($('#aktif_pelanggan').val() == 'ON'){
    console.log('ON');    
    $('#aktif_pelanggan').attr('checked','checked');
    $('#ON').show();
    $('#OFF').css('display','none');
}else{
     $('#ON').css('display','none');
    $('#OFF').show();
}

$('#aktif_pelanggan').change(function(){
    if(this.checked){
        console.log('wkwkak');
        $('#ON').show();
        $('#OFF').css('display','none');
    }else{
        $('#ON').css('display','none');
        $('#OFF').show();
    }
});
//end aktivasi pelanggan

//FUNGSI UNTUK MENGAKTIFKAN DATEPICKER
$('.item').change(function() {
/* Act on the event */
var isChecked = this.checked;

if(isChecked) {
    $(this).parent().parent().find('input[type=text]').removeAttr('disabled');
    $('.datepicker').change(function(){
        if($('.datepicker').val().length != 0){
            $('input[type="submit"]').removeAttr('disabled');
        }else{
            $('input[type="submit"]').attr('disabled','disabled');       
        }
    });  
}else{
    $(this).parent().parent().find('input[type=text]').attr('disabled','disabled');
    $('input[type="submit"]').attr('disabled','disabled');
}
});

$("#preview-uf").click(function(event) {
 $('#data1').show("slow");
 return false;
});

$("#remove-uf").click(function(event) {
 $('#data1').hide("slow");
 return false;
});
$("#preview-hi").click(function(event) {
 $('#data2').show("slow");
 return false;
});

$("#remove-hi").click(function(event) {
 $('#data2').hide("slow");
 return false;
});

$(function(){
    $("#img_pegawai_o").fileinput({
            showUpload: false,
            showCaption: false,
            browseClass: "btn btn-danger",
            fileType: "any"
    });                           
});

function pelanggan_check(){  
    var id = $('#id_pelanggan_input').val();
    $.post(window.location.origin+'/Telkom_akses/index.php/data/checkIdPeL/'+id,function(d){
        var data = $.parseJSON(d);
        if(/^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test( id ) == true){
            if(data.length == 1){
                $('#id_pelanggan_input').css('border', '1px #C33 solid'); 
                $('#cross2').css('color', '#C33');
                $('#cross2').fadeIn();
                $('input[type="submit"]').attr('disabled','disabled');
            }else{
                if(id.length == 11 || id.length == 12){
                    $('#id_pelanggan_input').css('border', '1px #95B75D solid');
                    $('#cross2').hide();
                    $('input[type="submit"]').removeAttr('disabled'); 
                }
            }
        }else{
            $('#id_pelanggan_input').css('border', '1px #C33 solid');
            $('input[type="submit"]').attr('disabled','disabled'); 
        }
    });
}
    
function id_check(){  
    var id = $('#id_pegawai_input').val();
    $.post(window.location.origin+'/Telkom_akses/index.php/data/checkIdPE/'+id,function(d){
        var data = $.parseJSON(d);
        if(/^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test( id ) == true){
            if(data.length == 1){
                $('#id_pegawai_input').css('border', '1px #C33 solid'); 
                $('#cross').css('color', '#C33');
                // $('#tick').hide();
                $('#cross').fadeIn();
                $('input[type="submit"]').attr('disabled','disabled');
            }else{
                if(id.length == 11 && $('#email_pegawai_input').val().length != 0 && (/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test( $('#email_pegawai_input').val()))){
                    $('#id_pegawai_input').css('border', '1px #95B75D solid');
                    // $('#tick').css('color', '#090')
                    $('#cross').hide();
                    // $('#tick').fadeIn();
                    $('input[type="submit"]').removeAttr('disabled');
                }
            }
        }else{
            $('#id_pegawai_input').css('border', '1px #C33 solid');
            $('input[type="submit"]').attr('disabled','disabled'); 
        }
    });
}


function email_check(){
    var email = $('#email_pegawai_input').val();
    var email_s = email.split('@');
    var email_f = email_s[0];
    $.post(window.location.origin+'/Telkom_akses/index.php/data/checkEmPe/'+email_f ,function(d){
        if(/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test( email ) == true){
            var data = $.parseJSON(d);
            if(data.length == 1){
                $('#email_pegawai_input').css('border', '1px #C33 solid'); 
                $('#cross1').css('color', '#C33')
                $('#cross1').fadeIn();
                $('input[type="submit"]').attr('disabled','disabled');
            }else{
                if(email_f.length != 0){
                    $('input[type="submit"]').removeAttr('disabled'); 
                    $('#email_pegawai_input').css('border', '1px #95B75D solid');
                    $('#cross1').hide();
                }else{
                    $('#email_pegawai_input').css('border', '1px #C33 solid');
                    $('input[type="submit"]').attr('disabled','disabled'); 
                }
            }
        }else{
            $('#email_pegawai_input').css('border', '1px #C33 solid'); 
            $('input[type="submit"]').attr('disabled','disabled'); 
        }
    });
}




$("#SelectDatePicker").datepicker({format:'yyyy-mm',viewMode:"months",minViewMode:"months"}).on('changeDate',function(ev){
    // console.log(ev);
    $("#SelectDatePicker").change();
});

$('#SelectDatePicker').val('0000-00');

$('#SelectDatePicker').change(function () {
    var send = true;
    var aksi;
    var bln;
    $('#chart-keluhan').html('');
    $('#chart-pegawai').html('');

    if (typeof(event) == 'object'){
        if (event.timeStamp - lastJQueryTS < 300){
            send = false;
        }
        lastJQueryTS = event.timeStamp;
    }
    if (send){
        $(this).datepicker('hide');

        var select = $('#SelectDatePicker').val();
        var x = select.split('-');
        var x1 = x[0];
        var x2 = x[1];
        //console.log(x);

        var kalender = [{bulan:'Januari',indeks:'01'},
                        {bulan:'Februari',indeks:'02'},
                        {bulan:'Maret',indeks:'03'},
                        {bulan:'April',indeks:'04'},
                        {bulan:'Mei',indeks:'05'},
                        {bulan:'Juni',indeks:'06'},
                        {bulan:'Juli',indeks:'07'},
                        {bulan:'Agustus',indeks:'08'},
                        {bulan:'September',indeks:'09'},
                        {bulan:'Oktober',indeks:'10'},
                        {bulan:'November',indeks:'11'},
                        {bulan:'Desember',indeks:'12'}];

        //Grafik Keluhan
        $.post('getDataEvaluasi/'+x2+'/'+x1,function(data){
            var obj = $.parseJSON(data);
            var x2split = x2.split('0');
            //console.log(obj);
            $("#tb_ek tbody").remove();

            if(x2 < 10){
                bln = kalender[x2split[1]-1].bulan
            }else{
                bln = kalender[x2-1].bulan
            }

            if(obj['ek'].length > 0){
                $('#row_alert_keluhan').hide();
                $('#row_data_keluhan').show();
                for(var i=0;i<obj['ek'].length;i++){
                    $('#tb_ek').append('<tr><td>'+bln+'</td>'+
                        '<td>'+obj['ek'][i].jenis_keluhan+'</td>'+
                        '<td>'+obj['ek'][i].jml_keluhan+' Pekerjaan'+'</td></tr>');
                }
            }else{
                $('#row_alert_keluhan').show();
                $('#row_data_keluhan').hide();
            }



            $("#tb_ep tbody").remove();
            if(obj['ep'].length > 0){
                $('#row_alert_pegawai').hide();
                $('#row_data_pegawai').show();

                for(var i=0;i<obj['ep'].length;i++){
                    if(obj['ep'].jml_uf == 0){
                        aksi = '-';
                    }else{
                        //console.log("<button type='button' class='open-detailREModal btn btn-primary' data-toggle='modal' data-target='#myModal4' data-id='"+target+"' data-backdrop=''><i class='glyphicon glyphicon-info-sign'></i></button>");
                        aksi = "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal4' onClick='openDetailRiwayat("+obj['ep'][i].id_pegawai+','+x2+','+x1+")' data-backdrop=''><i class='glyphicon glyphicon-info-sign'></i></button>";
                    }
                    $('#tb_ep').append('<tr><td>'+bln+'</td>'+
                        '<td>'+obj['ep'][i].nama_pegawai+'</td>'+
                        '<td>'+obj['ep'][i].jml_uf+' Pekerjaan'+'</td>'+
                        '<td>'+aksi+'</td>'+
                        '</tr>');
                        //'<td>'+aksi+'</td>
                }
            }else{
                $('#row_alert_pegawai').show();
                $('#row_data_pegawai').hide();
            }
        });

        $.post('getChartKeluhan/'+x2+'/'+x1,function(data){
            var chartData = $.parseJSON(data);

            if(chartData.length > 0){
                Morris.Donut({
                    element: 'chart-keluhan',
                    data: chartData,
                    resize:true
                });
            }

        });

        //Grafik Pegawai
        $.post('getChartPegawai/'+x2+'/'+x1,function(data){
            var chartData = $.parseJSON(data);
            //console.log(chartData);
            
            Morris.Bar({
                element: 'chart-pegawai',
                data: chartData,
                xkey: 'y',
                ykeys: ['a', 'b','c'],
                labels: ['SELESAI', 'MENUNGGU','TIDAK SELESAI'],
                resize:true,
                barColors: ['#95B75D', '#FEA223','#B64645']
            });
        });
    }
});



$('#edit_nama_pegawai').click(function() {
    /* Act on the event */
    $('#sunting-1').css('display','none');
    $('.loading_spinner1').show();
    setTimeout(function(){    
        $('.loading_spinner1').css('display','none');
        $('.edit_default_nama_pegawai').css('display','none');
        $('.edit_form_nama_pegawai').fadeIn('slow');
        $('.edit_submit_nama_pegawai').fadeIn('slow');
    },3000)
});                         

$('#close_nama_pegawai').click(function() {
    /* Act on the event */
    $('#sunting-1').fadeIn('slow');
    $('.edit_default_nama_pegawai').fadeIn('slow');
    $('.edit_form_nama_pegawai').css('display','none');
    $('.edit_submit_nama_pegawai').css('display','none')
});

$('#edit_alamat_pegawai').click(function() {
    /* Act on the event */
        $('#sunting-2').css('display','none');
    $('.loading_spinner2').show();
    setTimeout(function(){    
        $('.loading_spinner2').css('display','none');
        $('.edit_default_alamat_pegawai').css('display','none');
        $('.edit_form_alamat_pegawai').fadeIn('slow');
        $('.edit_submit_alamat_pegawai').fadeIn('slow');
    },3000)
});                         

$('#close_alamat_pegawai').click(function() {
    /* Act on the event */
    $('#sunting-2').fadeIn('slow');
    $('.edit_default_alamat_pegawai').fadeIn('slow');
    $('.edit_form_alamat_pegawai').css('display','none');
    $('.edit_submit_alamat_pegawai').css('display','none')
});

$('#edit_telepon_pegawai').click(function() {
    /* Act on the event */
    $('#sunting-3').css('display','none');
    $('.loading_spinner3').show();
    setTimeout(function(){    
        $('.loading_spinner3').css('display','none');
        $('.edit_default_telepon_pegawai').css('display','none');
        $('.edit_form_telepon_pegawai').fadeIn('slow');
        $('.edit_submit_telepon_pegawai').fadeIn('slow');
    },3000)
});                         

$('#close_telepon_pegawai').click(function() {
    /* Act on the event */
    $('#sunting-3').fadeIn('slow');
    $('.edit_default_telepon_pegawai').fadeIn('slow');
    $('.edit_form_telepon_pegawai').css('display','none');
    $('.edit_submit_telepon_pegawai').css('display','none')
});

$('#edit_email_pegawai').click(function() {
    /* Act on the event */
    $('#sunting-4').css('display','none');
    $('.loading_spinner4').show();
    setTimeout(function(){    
        $('.loading_spinner4').css('display','none');
        $('.edit_default_email_pegawai').css('display','none');
        $('.edit_form_email_pegawai').fadeIn('slow');
        $('.edit_submit_email_pegawai').fadeIn('slow');
    },3000)
});                         

$('#close_email_pegawai').click(function() {
    /* Act on the event */
    $('#sunting-4').fadeIn('slow');
    $('.edit_default_email_pegawai').fadeIn('slow');
    $('.edit_form_email_pegawai').css('display','none');
    $('.edit_submit_email_pegawai').css('display','none')
});

$('#edit_pass_pegawai').click(function() {
    /* Act on the event */
    $('#sunting-5').css('display','none');
    $('.loading_spinner5').show();
    setTimeout(function(){    
        $('.loading_spinner5').css('display','none');
        $('.edit_default_pass_pegawai').css('display','none');
        $('.edit_form_pass_pegawai').fadeIn('slow');
        $('.edit_submit_pass_pegawai').fadeIn('slow');
    },3000)
});                         

$('#close_pass_pegawai').click(function() {
    /* Act on the event */
    $('#sunting-5').fadeIn('slow');
    $('.edit_default_pass_pegawai').fadeIn('slow');
    $('.edit_form_pass_pegawai').css('display','none');
    $('.edit_submit_pass_pegawai').css('display','none')
});

$('#close-setting-img').click(function() {
    /* Act on the event */
    location.reload();
});

$('#alamat_pegawai_setting').on('change',function(){
    if($('#alamat_pegawai_setting').val() == ''){
         $('input[type="submit"]').attr({disabled: ''});
    }else{
        $('input[type="submit"]').removeAttr('disabled');
    }
});

$('#telepon_pegawai_setting').on('change',function(){
    if($('#telepon_pegawai_setting').val() == ''){
         $('input[type="submit"]').attr({disabled: ''});
    }else{
        $('input[type="submit"]').removeAttr('disabled');
    }
});

$('#email_pegawai_setting').on('change',function(){
    if($('#email_pegawai_setting').val() == ''){
         $('input[type="submit"]').attr({disabled: ''});
    }else{
        $('input[type="submit"]').removeAttr('disabled');
    }
});


