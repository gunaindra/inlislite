saveCollection = function () {
    $('#form-collection-modal').data('yiiActiveForm').submitting = true;
    $('#form-collection-modal').yiiActiveForm('validate');
    
}

formCollection = function (id,catalogid) {
     if($.ajax({
        type     :"POST",
        cache    : false,
        url  : $("#hdnAjaxUrlFormCollection").val()+'?id='+id+'&catalogid='+catalogid,
        success  : function(response) {
            $("#modalCollection").html(response);
        }
    }))
    {
      $("#collection-modal").modal("show");
    }
}

$("#btnAddCollection").click(function(e) {
    formCollection(0,$("#hdnCatalogId").val());
    $("#collections-jumlaheksemplar").val(1);
    $.ajax({
        type     :"POST",
        cache    : false,
        url  :  $("#hdnAjaxUrlNoInduk").val()+"?tglpengadaan=&eks=1",
        success  : function(response) {
            $("#listNoInduk").html(response);
        }
    });
  });

$(".editCollection").click(function() {
    var id = $(this).closest('tr').data('key');
    formCollection(id,$("#hdnCatalogId").val());
  });








    