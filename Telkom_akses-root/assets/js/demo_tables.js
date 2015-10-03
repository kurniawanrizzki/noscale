
    function delete_row(row){
        
        var box = $("#mb-remove-row");
        box.addClass("open");
        
        box.find(".mb-control-yes").on("click",function(){
            box.removeClass("open");
            $("#"+row).hide("slow",function(){
                $(this).remove();
                window.location.href = 'http://localhost/Telkom_akses/Beranda/Hapus_Jadwal'+row;
            });
        });
        
    }
