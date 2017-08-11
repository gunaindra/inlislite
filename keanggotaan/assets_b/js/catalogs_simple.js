$(document).ready(function () {
  AuthorityLoaded();

  $("#btnAuthorAdded").on("click", function() {
      var html = [];
      var sort = $("#AuthorAddCount").val();
      if(sort != '')
      {
        sort = parseInt(sort)+1;
      }
      $("#AuthorAddCount").val(sort);
      html.push("<div id='DivAuthorAdded"+sort+"'>");
        html.push("<div style='margin-top:5px' class='input-group'>");
          html.push("<input type='text' id='collectionbiblio-authoradded-"+sort+"' class='form-control' name='CollectionBiblio[AuthorAdded]["+sort+"]' style='width:100%' placeholder='Masukan Pengarang Tambahan...'>");
          html.push("<span class='input-group-btn'>");
          html.push("<button class='btn btn-danger' type='button' onclick='RemoveAuthorAdded("+sort+")'><i class='glyphicon glyphicon-trash'></i></button>");
          html.push("</span>");
        html.push("</div>");
        html.push("<div class='btm-add-on' style='text-align:left'>");
          html.push("<input type='hidden' name='CollectionBiblio[AuthorAddedType]["+sort+"]' value=''>");
            html.push("<div id='collectionbiblio-authoraddedtype-"+sort+"'>");
            html.push("<label><input  checked type='radio' name='CollectionBiblio[AuthorAddedType]["+sort+"]' value='0'> Nama Depan</label>");
            html.push("&nbsp;<label><input type='radio' name='CollectionBiblio[AuthorAddedType]["+sort+"]' value='1'> Nama Belakang</label>");
            html.push("&nbsp;<label><input type='radio' name='CollectionBiblio[AuthorAddedType]["+sort+"]' value='3'> Nama Keluarga</label>");
            html.push("&nbsp;<label><input type='radio' name='CollectionBiblio[AuthorAddedType]["+sort+"]' value='#'> Badan Korporasi</label>");
            html.push("&nbsp;<label><input type='radio' name='CollectionBiblio[AuthorAddedType]["+sort+"]' value='##'> Nama Pertemuan</label>");
            html.push("</div>");
        html.push("</div>");
      html.push("</div>");
      $("#AuthorAddList").append(html.join(''));
      $("#collectionbiblio-authoradded-"+sort).focus();
      AutoCompleteOn("#collectionbiblio-authoradded-"+sort,'pengarang');
    });

    $("#btnISBN").on("click", function() {
      var html = [];
      var sort = $("#ISBNCount").val();
      if(sort != '')
      {
        sort = parseInt(sort)+1;
      }
      $("#ISBNCount").val(sort);
      html.push("<div id='DivISBN"+sort+"'>")
        html.push("<div style='margin-top:5px' class='input-group'>");
          html.push("<input type='text' id='collectionbiblio-isbn-"+sort+"' class='form-control' name='CollectionBiblio[ISBN]["+sort+"]' style='width:100%' placeholder='Masukan ISBN...'>");
          html.push("<span class='input-group-btn'>");
          html.push("<button class='btn btn-danger' type='button' onclick='RemoveISBN("+sort+")'><i class='glyphicon glyphicon-trash'></i></button>");
          html.push("</span>");
        html.push("</div>");
      html.push("</div>");
      $("#ISBNList").append(html.join(''));
      $("#collectionbiblio-isbn-"+sort).focus();
    });

    $("#btnISSN").on("click", function() {
      var html = [];
      var sort = $("#ISSNCount").val();
      if(sort != '')
      {
        sort = parseInt(sort)+1;
      }
      $("#ISSNCount").val(sort);
      html.push("<div id='DivISSN"+sort+"'>")
        html.push("<div style='margin-top:5px' class='input-group'>");
          html.push("<input type='text' id='collectionbiblio-issn-"+sort+"' class='form-control' name='CollectionBiblio[ISSN]["+sort+"]' style='width:100%' placeholder='Masukan ISSN...'>");
          html.push("<span class='input-group-btn'>");
          html.push("<button class='btn btn-danger' type='button' onclick='RemoveISSN("+sort+")'><i class='glyphicon glyphicon-trash'></i></button>");
          html.push("</span>");
        html.push("</div>");
      html.push("</div>");
      $("#ISSNList").append(html.join(''));
      $("#collectionbiblio-issn-"+sort).focus();
    });

    $("#btnNote").on("click", function() {
      var html = [];
      var sort = $("#NoteCount").val();
      if(sort != '')
      {
        sort = parseInt(sort)+1;
      }
      $("#NoteCount").val(sort);
      html.push("<div id='DivNote"+sort+"'>")
        html.push("<div style='margin-top:5px' class='input-group'>");
          html.push("<input type='text' id='collectionbiblio-note-"+sort+"' class='form-control' name='CollectionBiblio[Note]["+sort+"]' style='width:100%' placeholder='Masukan Catatan...'>");
          html.push("<span class='input-group-btn'>");
          html.push("<button class='btn btn-danger' type='button' onclick='RemoveNote("+sort+")'><i class='glyphicon glyphicon-trash'></i></button>");
          html.push("</span>");
        html.push("</div>");
        html.push("<div class='btm-add-on' style='text-align:left'>");
          html.push("<input type='hidden' name='CollectionBiblio[NoteTag]["+sort+"]' value=''>");
            html.push("<div id='collectionbiblio-notetag-"+sort+"'>");
            html.push("<label><input  checked type='radio' name='CollectionBiblio[NoteTag]["+sort+"]' value='520'> Abstrak / Anotasi</label>");
            html.push("&nbsp;<label><input type='radio' name='CollectionBiblio[NoteTag]["+sort+"]' value='502'> Catatan Disertasi</label>");
            html.push("&nbsp;<label><input type='radio' name='CollectionBiblio[NoteTag]["+sort+"]' value='504'> Catatan Bibliografi</label>");
            html.push("&nbsp;<label><input type='radio' name='CollectionBiblio[NoteTag]["+sort+"]' value='505'> Rincian Isi</label>");
            html.push("&nbsp;<label><input type='radio' name='CollectionBiblio[NoteTag]["+sort+"]' value='500'> Catatan Umum</label>");
            html.push("</div>");
        html.push("</div>");
      html.push("</div>");
      $("#NoteList").append(html.join(''));
      $("#collectionbiblio-note-"+sort).focus();
    });

    $("#btnSubject").on("click", function() {
      var html = [];
      var sort = $("#SubjectCount").val();
      if(sort != '')
      {
        sort = parseInt(sort)+1;
      }

      $("#SubjectCount").val(sort);
      html.push("<div id='DivSubject"+sort+"'>")
        html.push("<div class='row' style='margin-top:5px' >");
          html.push("<div class='col-sm-3' style='padding-right: 0px'>");
            html.push("<select id='collectionbiblio-subjecttag-"+sort+"' class='form-control' name='CollectionBiblio[SubjectTag]["+sort+"]' onchange='ShowOptionSubject("+sort+");'>");
              html.push("<option value='650'>Topikal</option>");
              html.push("<option value='600'>Nama Orang</option>");
              html.push("<option value='651'>Nama Geografis</option>");
            html.push("</select>");
          html.push("</div>");
          html.push("<div class='col-sm-9' style='padding-left: 0px'>");
            html.push("<div class='input-group'>");
              html.push("<input type='text' id='collectionbiblio-subject-"+sort+"' class='form-control' name='CollectionBiblio[Subject]["+sort+"]' style='width:100%' placeholder='Masukan Subject...'>");
              html.push("<span class='input-group-btn'>");
              html.push("<button class='btn btn-danger' type='button' onclick='RemoveSubject("+sort+")'><i class='glyphicon glyphicon-trash'></i></button>");
              html.push("</span>");
            html.push("</div>");
          html.push("</div>");
        html.push("</div>");
        html.push("<div class='btm-add-on' style='text-align:left'>");
          html.push("<input type='hidden' name='CollectionBiblio[SubjectInd]["+sort+"]' value=''>");
          html.push("<div id='collectionbiblio-subjectind-"+sort+"'>");
          html.push("<label id='opt#_"+sort+"'><input checked type='radio' id='subjectind_X_"+sort+"' name='CollectionBiblio[SubjectInd]["+sort+"]' value='#'> Tdk Ada Info Tambahan</label>");
          html.push("&nbsp;<label id='opt0_"+sort+"' style='display: none'><input type='radio' id='subjectind_0_"+sort+"' name='CollectionBiblio[SubjectInd]["+sort+"]' value='0'> Nama Depan</label>");
          html.push("&nbsp;<label id='opt1_"+sort+"' style='display: none'><input type='radio' id='subjectind_1_"+sort+"' name='CollectionBiblio[SubjectInd]["+sort+"]' value='1'> Nama Belakang</label>");
          html.push("&nbsp;<label id='opt3_"+sort+"' style='display: none'><input type='radio' id='subjectind_3_"+sort+"' name='CollectionBiblio[SubjectInd]["+sort+"]' value='3'> Nama Keluarga</label>");
          html.push("</div>");
        html.push("</div>");
      html.push("</div>");
      $("#SubjectList").append(html.join(''));
      $("#collectionbiblio-subject-"+sort).focus();
      AutoCompleteOn("#collectionbiblio-subject-"+sort,'subyek');
    });

    $("#btnCallNumber").on("click", function() {
      var html = [];
      var sort = $("#CallNumberCount").val();
      if(sort != '')
      {
        sort = parseInt(sort)+1;
      }
      $("#CallNumberCount").val(sort);
      html.push("<div id='DivCallNumber"+sort+"'>")
        html.push("<div style='margin-top:5px' class='input-group'>");
          html.push("<input type='text' id='collectionbiblio-callnumber-"+sort+"' class='form-control' name='CollectionBiblio[CallNumber]["+sort+"]' style='width:100%' placeholder='Masukan No. Panggil...'>");
          html.push("<span class='input-group-btn'>");
          html.push("<button class='btn btn-danger' type='button' onclick='RemoveCallNumber("+sort+")'><i class='glyphicon glyphicon-trash'></i></button>");
          html.push("</span>");
        html.push("</div>");
      html.push("</div>");
      $("#CallNumberList").append(html.join(''));
      $("#collectionbiblio-callnumber-"+sort).focus();
    });
});


  function RemoveAuthorAdded(id) {
     $("#DivAuthorAdded"+id).remove();
     var sort = $("#AuthorAddCount").val();
     if(sort != '')
     {
       sort = parseInt(sort)-1;
     }
     $("#AuthorAddCount").val(sort);
  }

  function RemoveISBN(id) {
     $("#DivISBN"+id).remove();
     var sort = $("#ISBNCount").val();
     if(sort != '')
     {
       sort = parseInt(sort)-1;
     }
     $("#ISBNCount").val(sort);
  }

  function RemoveISSN(id) {
     $("#DivISSN"+id).remove();
     var sort = $("#ISSNCount").val();
     if(sort != '')
     {
       sort = parseInt(sort)-1;
     }
     $("#ISSNCount").val(sort);
  }

  function RemoveNote(id) {
     $("#DivNote"+id).remove();
     var sort = $("#NoteCount").val();
     if(sort != '')
     {
       sort = parseInt(sort)-1;
     }
     $("#NoteCount").val(sort);
  }

  function RemoveSubject(id) {
     $("#DivSubject"+id).remove();
     var sort = $("#SubjectCount").val();
     if(sort != '')
     {
       sort = parseInt(sort)-1;
     }
     $("#SubjectCount").val(sort);
  }

  function RemoveCallNumber(id) {
     $("#DivCallNumber"+id).remove();
     var sort = $("#CallNumberCount").val();
     if(sort != '')
     {
       sort = parseInt(sort)-1;
     }
     $("#CallNumberCount").val(sort);
  }

  function ShowOptionSubject(id){
     if($("#collectionbiblio-subjecttag-"+id).val()=="600")
     {
        $("#opt0_"+id).show();
        $("#opt1_"+id).show();
        $("#opt3_"+id).show();
     }else{
        $("#opt0_"+id).hide();
        $("#opt1_"+id).hide();
        $("#opt3_"+id).hide();
        $("#subjectind_X_"+id).prop("checked",true);
     }
                                                                            
  }

  function MonkeyPatchAutocomplete() {
          var oldFn = $.ui.autocomplete.prototype._renderItem;
          $.ui.autocomplete.prototype._renderItem = function( ul, item) {
              var t = String(item.value).replace(
                new RegExp(this.term, "gi"),
                "<span class='ui-state-highlight'>$&</span>");
              return $( "<li></li>" )
                  .data( "item.autocomplete", item )
                  .append( "<a>" + t + "</a>" )
                  .appendTo( ul );
          };
  }

  function AutoCompleteOn(id,type)
  {
    var url;
    if(type=='pengarang')
    {
      url=$("#hdnAjaxUrlTajukPengarang").val();
    }else{
      url=$("#hdnAjaxUrlTajukSubyek").val();
    }
    $(id).autocomplete({
          source: function (request, response) {
                $.ajax({
                    dataType: "json",
                    data: {
                        term: request.term,
                    },
                    type: 'GET',
                    contentType: 'application/json; charset=utf-8',
                    xhrFields: {
                        withCredentials: true
                    },
                    crossDomain: true,
                    cache: true,
                    url: url,
                    success: function (data) {
                        var array = data;

                        //call the filter here
                        var results = $.ui.autocomplete.filter(array, request.term);

                        //limit 10
                        //response(results.slice(0, 10));

                        response(results);
                    },
                    error: function (data) {

                    }
                });
            }
      });
  }

  function AuthorityLoaded() {
    MonkeyPatchAutocomplete(); 
    $(".tajukpengarang").each(function(){
      AutoCompleteOn(this,'pengarang');
    });

    $(".tajuksubyek").each(function(){
      AutoCompleteOn(this,'subyek');
    });

  }