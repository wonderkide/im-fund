/* 
    Created on : Jan 6, 2021, 12:52:40 PM
    Author     : wonderkide
*/

$('#sidebar-logout a').on('click',function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    confirmLogout(url);
});
$('#navbar-logout-detail').on('click',function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    confirmLogout(url);
});
$('#navbar-logout').on('click',function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    confirmLogout(url);
});

$(document).on('click', '.activity-create-link', function(e){ 
    var url = $(this).data("url");
    var title = $(this).data("title");
    $.get(
        'create',
        function (data)
        {
            $("#activity-modal").find(".modal-body").html(data);
            $("#activity-modal .modal-title").html(title);
            $("#activity-modal").modal("show");
        }
    );
});

$(document).on('click', '.activity-manage-link', function(e){ 
    var url = $(this).data("url");
    var id = $(this).data("id");
    var title = $(this).data("title");
    $.get(
        url,
        {
            id: id
        },
        function (data)
        {
            $("#activity-modal").find(".modal-body").html(data);
            $("#activity-modal .modal-title").html(title);
            $("#activity-modal").modal("show");
        }
    );
});

$(document).on('click', '.activity-delete-link', function(e){ 
    e.preventDefault();
    var url = $(this).attr('data-url');
    var id = $(this).attr('data-id');
    confirmDelete(id,url);
});

$(document).on('click', '.activity-confirm-link', function(e){ 
    e.preventDefault();
    var url = $(this).attr('data-url');
    var id = $(this).attr('data-id');
    var text = $(this).attr('data-title');
    confirmLink(id,url,text);
});

function confirmLink(id,url,text){
    Swal.fire({
        title: text,
        text: false,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก',
    }).then((result) => {
        if (result.value) {
            $('#loading-spinner').modal('show');
            $.get(
                url,
                {
                    id: id
                },
                function (data)
                {
                    
                }
            );
        }
    });
}

function confirmDelete(id,url){
    Swal.fire({
        title: 'ยืนยันการลบข้อมูล',
        text: false,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                method:'POST',
                url: url,
                success: function (data) {
                    console.log(data);
                }
            });
        }
    });
}

function confirmLogout(url){
    Swal.fire({
        title: 'ยืนยันการออกจากระบบ',
        text: false,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url,
                success: function (data) {
                    console.log(data);
                }
            });
        }
    });
}
