$(document).ready(function () {
  AuthorityLoaded();
});

  $("#btnAddTag").click(function(e) {
    if( $('#tag-body').is(':empty') ) {
      $.ajax({
          type     :"POST",
          cache    : false,
          url  : $("#hdnAjaxUrlAddTag").val(),
          success  : function(response) {
              $("#tag-body").html(response);
          },
          async: true
      });
    }
    $("#tag-modal").modal("show");
      
  });

$("#btnAddTag2").click(function(e) {
   if( $('#tag-body').is(':empty') ) {
      $.ajax({
          type     :"POST",
          cache    : false,
          url  : $("#hdnAjaxUrlAddTag").val(),
          success  : function(response) {
              $("#tag-body").html(response);
          },
          async: true
      });
    }
    $("#tag-modal").modal("show");
      
});


sendTag = function(id,code,desc,fixed,enabled,panjang,mandatory,iscustomable,repeatable) {
        var newRow = "";
        var classGroup = "";
        var buttonOnclick = "";
        var buttonInd1Onclick = "";
        var buttonInd2Onclick = "";
        var txtLenght = "";
        var txtDisabled = "";
        var txtValue = "$a ";
        var sort="";

        var tags = [];
        var sameTags = [];
        $("#tblAdv").find("input.item").each(function(index){
           var myData = $(this).val();
           tags.push(myData);
          });
    
        var search_term = code; // search term
        var search = new RegExp(search_term , "i");
        var sameTags = $.grep(tags, function (value) {
                              return search.test(value);
                            }
                         );
        if(sameTags.length > 0)
        {
          sort = String(parseInt(sameTags[sameTags.length -1].substr(4,1)) + 1);
        }else{
          if(repeatable==1)
          {
            sort="0";
          }
        }

        if(fixed == 1)
        {
          if(panjang != -1)
          {
            txtLenght = " maxlength=\""+panjang+"\"";
          }
        }

        if(enabled != 1)
        {
          txtDisabled= " readonly";
          txtValue="";
        }else{
          classGroup="class=\"input-group\"";
        }

        if(iscustomable == 1)
        {
          buttonOnclick = "js:pickRuasFixed(\'"+id+"\',\'"+code.trim()+"\',\'"+sort+"\')";
        }else{
          buttonOnclick = "js:pickRuas(\'"+id+"\',\'"+code.trim()+"\',\'"+sort+"\')";
        }

        buttonInd1Onclick = "js:pickIndicator1(\'"+id+"\',\'"+code.trim()+"\',\'"+sort+"\')";
        buttonInd2Onclick = "js:pickIndicator2(\'"+id+"\',\'"+code.trim()+"\',\'"+sort+"\')";

        if(sort != "")
        {
          sort = "["+sort+"]";
        }
        var tagcode="";
        var sortJs="";
        var tagcodeJs="";
        var classtajuk="";

        //console.log(code+sort);
        if ($.inArray(code, tags) > -1 && repeatable==0){ 
          alert("Data tag "+code+" sudah ada");
        }else{
          tagcode = "["+code+"]";
          sortJs =  sort.replace("[","_").replace("]","");
          tagcodeJs =  tagcode.replace("[","_").replace("]","");
          if(code=='100' || code=='110' || code=='700' || code=='710' || code=='600')
          {
            classtajuk=" tajukpengarang";
          }else if(code=='600' || code=='650' || code=='651')
          {
            classtajuk=" tajuksubyek";
          }
          newRow += "<tr id=\""+code+sortJs+"\">";
            newRow += "<td>";
            if(mandatory != 1)
            {
              newRow += "<button class=\"btn btn-danger\" type=\"button\" onclick=\"$(\'table#tblAdv tr#"+code+sortJs+"\').remove();\"><i class=\"glyphicon glyphicon-trash\"></i></button>";
            }
            newRow += "</td>";
            newRow += "<td>"+code+"</td>";
            newRow += "<td>"+desc+"</td>";
            newRow += "<td>";
            if(fixed != 1)
            {
              newRow += "<div class=\"input-group\">";
                newRow += "<input type=\"text\" class=\"form-control\" id=\"Indicator1"+tagcodeJs+sortJs+"\" name=\"Indicator1"+tagcode+sort+"\" value=\"#\" maxlength=\"1\">";
                newRow += "<span class=\"input-group-btn\">";
                  newRow += "<a class=\"btn bg-purple\" href=\"javascript:void(0)\" title=\"Pick\" data-toggle=\"modal\" data-target=\"#helper-modal\" onclick=\""+buttonInd1Onclick+"\">...</a>";
                newRow += "</span>";
              newRow += "</div>";
            }
            newRow += "</td>";
            newRow += "<td>";
            if(fixed != 1)
            {
              newRow += "<div class=\"input-group\">";
                newRow += "<input type=\"text\" class=\"form-control\" id=\"Indicator2"+tagcodeJs+sortJs+"\" name=\"Indicator2"+tagcode+sort+"\" value=\"#\" maxlength=\"1\">";
                newRow += "<span class=\"input-group-btn\">";
                  newRow += "<a class=\"btn bg-purple\" href=\"javascript:void(0)\" title=\"Pick\" data-toggle=\"modal\" data-target=\"#helper-modal\" onclick=\""+buttonInd2Onclick+"\">...</a>";
                newRow += "</span>";
              newRow += "</div>";
            }
            newRow += "</td>";
            newRow += "<td>";
              newRow += "<input type=\"hidden\" id=\"Tags"+tagcodeJs+sortJs+"\" name=\"Tags"+tagcode+sort+"\" value=\""+code+sort+"\" class=\"item\">";
              newRow += "<div "+classGroup+">";
                newRow += "<input type=\"text\" class=\"form-control"+classtajuk+"\" id=\"TagsValue"+tagcodeJs+sortJs+"\" name=\"TagsValue"+tagcode+sort+"\"  "+txtLenght+" value=\""+txtValue+"\" "+txtDisabled+">";
                if(enabled == 1)
                {
                newRow += "<span class=\"input-group-btn\">";
                  newRow += "<a class=\"btn bg-purple\" href=\"javascript:void(0)\" title=\"Pick\" data-toggle=\"modal\" data-target=\"#helper-modal\" onclick=\""+buttonOnclick+"\">...</a>";
                newRow += "</span>";
                }
              newRow += "</div>";
            newRow += "</td>";
          newRow += "</tr>";
          $("#tblAdv tr:last").after(newRow);
          $("#tag-modal").hide();
          $(".modal-backdrop").hide();
          $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
          $("body").css("overflow","auto");
          loadFirst();
          
      }
    },

    

    //buat load grid sub ruas dalam modal (INDICATOR1)
    pickIndicator1 = function(id,tag,sort) {
        sort = sort.replace("_", "");
        $.ajax({
            type     :"POST",
            cache    : false,
            url  :  $("#hdnAjaxUrlIndicator1").val(),
            data: {
              id: id,
              tag: tag,
              sort: sort
            },
            success  : function(response) {
                $("#helper-body").html(response);
                
            }
        });
    },

    //buat load grid sub ruas dalam modal (INDICATOR2)
    pickIndicator2 = function(id,tag,sort) {
        sort = sort.replace("_", "");
        $.ajax({
            type     :"POST",
            cache    : false,
            url  :  $("#hdnAjaxUrlIndicator2").val(),
            data: {
              id: id,
              tag: tag,
              sort: sort
            },
            success  : function(response) {
                $("#helper-body").html(response);
                
            }
        });
    },

    //kirim value dari grid sub ruas ke text input ruas(INDICATOR 1 & 2)
    sendIndicator = function(tag,code) {
      $("#"+tag).val(code);
      $("#helper-modal").modal("hide");
    }
    
    //buat load grid sub ruas dalam modal(RUAS)
    pickRuas = function(id,tag,sort) {
        var v = "";
        if(sort !=  "")
        {
            v = $("#TagsValue_"+tag+"_"+sort).val();
        }else{
            v = $("#TagsValue_"+tag).val();
        }
        $.ajax({
            type     :"POST",
            cache    : false,
            url  :  $("#hdnAjaxUrlRuas").val(),
            data: {
              id: id,
              tag: tag,
              v: v,
              sort: sort
            },
            success  : function(response) {
                $("#helper-body").html(response);
                setValueRuas(tag,v);
                
            }
        });

        
    },

    //buat load grid sub ruas dalam modal(RUAS FIXED)
    pickRuasFixed = function(id,tag,sort) {
        var v = "";
        if(sort !=  "")
        {
            v = $("#TagsValue_"+tag+"_"+sort).val();
        }else{
            v = $("#TagsValue_"+tag).val();
        }
        var worksheetid = $("#catalogs-worksheet_id").val();
        var catalogid = $("#catalogid").val();
        $.ajax({
            type     :"POST",
            cache    : false,
            url  :  $("#hdnAjaxUrlRuasFixed").val(),
            data: {
              id: id,
              tag: tag,
              v: v,
              sort: sort,
              worksheetid: worksheetid,
              catalogid: catalogid
            },
            success  : function(response) {
                $("#tagfixed-body").html(response);
            }
        });

        
    },

    //buat load isi data sub ruas grid modal dari text input ruas(RUAS)
    setValueRuas = function(tag,v)
    {
        var key,item;
        var ruas = v.split("$");
        for(var i = 0; i < ruas.length; i++)
        {
            if(ruas[i])
            {
               key=  ruas[i].substring(0,1);          
               item = ruas[i].substring(1,ruas[i].length);
               $("#FieldDatas_"+key).val(item);
            }

        }
    },

    //kirim value dari grid sub ruas ke text input ruas(RUAS)
    sendRuas = function(tag) {
        var item;
        var result = "";
        var elementsInput = document.getElementById("fielddatas-grid").getElementsByTagName("input");
        for(var i = 0; i < elementsInput.length; i++)
        {
            key=  elementsInput[i].name.replace("FieldDatas_","");          
            item = elementsInput[i].value;
            if(item)
            {
                 result +="$"+ key + " " +item + " ";
            }

        }
        $("#"+tag.id).val(result);
        $("#helper-modal").modal("hide");
    },

    //kirim value dari grid sub ruas ke text input ruas(RUAS)
    sendRuasFixed = function(tag) {
        var item;
        var result = "";
        var elementsInput = document.getElementById("ruasfixed-grid").getElementsByTagName("input");
        for(var i = 0; i < elementsInput.length; i++)
        {      
            item = elementsInput[i].value;
            if(item)
            {
                 result +=item;
            }

        }
      $("#"+tag.id).val(result);
      $("#tagfixed-modal").modal("hide");
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