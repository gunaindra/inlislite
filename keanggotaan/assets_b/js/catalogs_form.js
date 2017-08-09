$('#pilihsalin-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        var forform = $('#hdnFor').val();
        var params = {};
        params['for'] = forform;
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        $.get(href,params)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        });
savePartner = function (edit) {
      var ID= $("#partners-id").val();
      var Name= $("#partners-name").val();
      var Address= $("#partners-address").val();
      var Phone= $("#partners-phone").val();
      var Fax= $("#partners-fax").val();
      $.ajax({
            type     :"POST",
            cache    : false,
            url  : "save-partners",
            data : {"edit":edit, "ID":ID, "Name":Name, "Address":Address, "Phone":Phone,"Fax":Fax },
            success  : function(response) {
                $.pjax.reload({container:"#pajax-collection-partners"});
            }
        });
      $("#rekanan-modal").modal("hide");
  }
changeDivBiblio = function (mode) {
      var wksid= $("#catalogs-worksheet_id").val();
      if(mode == "simple")
      {
        $("#modeform").val("0");
        $("#btn-change-simple").hide();
        $("#btn-change-advance").show();
        $("#simple").show();
        $("#advance").hide();
        $.ajax({
              type     :"POST",
              cache    : false,
              url  : $("#hdnAjaxUrlFormSimple").val()+"?worksheetid="+wksid+"&for="+$("#hdnFor").val(),
              data: $("#entryBibliografi :input").serialize(),
              success  : function(response) {
                  $("#entryBibliografi").html(response);
              }
          });
      }
      else
      {
        $("#modeform").val("1");
        $("#btn-change-simple").show();
        $("#btn-change-advance").hide();
        $("#simple").hide();
        $("#advance").show();
        $.ajax({
              type     :"POST",
              cache    : false,
              url  : $("#hdnAjaxUrlFormAdvance").val()+"?worksheetid="+wksid+"&for="+$("#hdnFor").val(),
              data: $("#entryBibliografi :input").serialize(),
              success  : function(response) {
                  $("#entryBibliografi").html(response);
              }
          });
      } 
    }

  validationBibliografis = function()
  {
      if($("#hdnPilihJudul").val() !== "")
      {
        $("#w0").submit(); 
      }else{
        var no=0;
        var tags = ["245","100","700",["260a","260b","260c"],["300a","300b","300c"],"250","082","084","020","022","650","520"];
        var textids = ["title","author","authoradded-0",["publishlocation","publisher","publishyear"],["jumlahhalaman","keteranganillustrasi","dimensi"],"edition","class","callnumber","isbn","issn","subject","note"];
        var textfocus = "";
        var arrayLength = tags.length;
        for (var i = 0; i < arrayLength; i++) {

          if($.isArray(tags[i]))
          {
            var arrayLength2 = tags[i].length;
            for (var k = 0; k < arrayLength2; k++) {
              if($("#status-"+tags[i][k]).hasClass("required") && $("#collectionbiblio-"+textids[i][k]).val() === "")
              {
                 $("#status-"+tags[i][k]).removeClass().addClass("required has-error");
                 $("#error-"+tags[i][k]).html($("#message-"+tags[i][k]).val());
                 no++;
                 if(textfocus=="")
                 {
                    textfocus="#collectionbiblio-"+textids[i][k];
                 }
              }else{
                $("#status-"+tags[i][k]).removeClass().addClass("required has-success");
                $("#error-"+tags[i][k]).html("");
              }
            }
          }else{
            if($("#status-"+tags[i]).hasClass("required") && $("#collectionbiblio-"+textids[i]).val() === "")
            {
               $("#status-"+tags[i]).removeClass().addClass("required has-error");
               $("#error-"+tags[i]).html($("#message-"+tags[i]).val());
               no++;
               if(textfocus=="")
               {
                  textfocus="#collectionbiblio-"+textids[i];
               }
            }else{
              $("#status-"+tags[i]).removeClass().addClass("required has-success");
              $("#error-"+tags[i]).html("");
            }
          }

          
        }

        
        if(no==0)
        {
          $("#w0").submit(); 
        }else{
          $(textfocus).focus();
        }
      }
        
  }

    $("#listNoInduk").ready(function(){
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

    $("#collections-jumlaheksemplar").on("blur", function(){
         var jumlahEks = $("#collections-jumlaheksemplar").val();
         var tglPengadaan = $("#collections-tanggalpengadaan").val();
         $.ajax({
            type     :"POST",
            cache    : false,
            url  : $("#hdnAjaxUrlNoInduk").val()+"?tglpengadaan="+tglPengadaan+"&eks="+jumlahEks,
            success  : function(response) {
                $("#listNoInduk").html(response);
            }
        });
    });

    $("#btnAddPartners").click(function(e) {
        if($.ajax({
            type     :"POST",
            cache    : false,
            url  : $("#hdnAjaxUrlPartner").val()+"?id=&edit=0",
            success  : function(response) {
                $("#modalPartners").html(response);
            }
        }))
        {
          $("#rekanan-modal").modal("show");
        }
    });

    $("#btnEditPartners").click(function(e) {
        var pId = $("#collections-partner_id").val();
        if(pId != "")
        {
          $.ajax({
              type     :"POST",
              cache    : false,
              url  : $("#hdnAjaxUrlPartner").val()+"?id="+pId+"&edit=1",
              success  : function(response) {
                  $("#modalPartners").html(response);
              }
          });
          $("#rekanan-modal").modal("show");
        }
    });
  
    $("#btnSave").click(function(e) {
        validationBibliografis();
    });

     $("#btnSave2").click(function(e) {
        validationBibliografis();
    });
    
    window.onload = function() {
      var position = $(window).scrollTop(); // should start at 0
      if(!$("#entryBibliografi").hasClass("disabled"))
      {
        $(window).scroll(function () {
            var scroll = $(window).scrollTop();
            if (scroll == 0) {
                $("#btn-change-advance").css({ top: "295px" });
                 $("#btn-change-simple").css({ top: "295px" });
            } else{
                if (scroll > 10) {
                    $("#btn-change-advance").css({ top: "0px" });
                    $("#btn-change-simple").css({ top: "0px" });
                }
            }
        });
      }else{
        $("#btn-change-simple").removeClass().addClass("btn bg-navy pull-right  btn-sm");
        $("#btn-change-advance").removeClass().addClass("btn bg-navy pull-right  btn-sm");
      }

    }