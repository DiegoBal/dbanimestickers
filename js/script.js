//category Add Edit //
$('.add').on('click', function() {
  var $this = $(this);
  $this.button('loading');
  setTimeout(function() {
   $this.button('reset');
 }, 2000);
});

$(document).ready(function () {



  $('#categorietbl').DataTable();
  
  $('#add_categories').on('submit', function (e) {
    var srno=$('.srno').val();
    var categories_name = $('#categoriesname').val();
    e.preventDefault();
    $.ajax({
      type: 'post',
      dataType :'json',
      url: 'controller/categories_data.php',
      data: {categoriesname:categories_name,flag:"add_categories"},
      success: function (data) {
       console.log(data);
       if(data.success==0){
        $('.error').text(data.message);
      }else{   
       var datacount = parseInt(srno) +1;            
       $('#addmodel').modal('hide');
      //  if(data.category!=""){
         newRow = $('#categorietbl').dataTable().fnAddData([
           (parseInt(srno)+1),
           data.category.categories_name,
           '<button class="btn btn-warning btn-circle waves-effect waves-light edit_cat" data-toggle="modal" data-target="#editmodel" data-id="'+data.category.id+'" data-name="'+data.category.categories_name+'" data-count="'+datacount+'"><i class="fa fa-pencil-square-o" style="font-size:19px;"></i></button><a class="btn btn-danger btn-circle waves-effect waves-light" href="controller/categories_data.php?id='+data.category.id+'&flag=remove_categories" onclick="return checkDelete()"  style="margin-left: 15px;"><i class="fa fa-remove" style="font-size:19px;color:white;"></i></a>'
           ]);
         var row = $('#categorietbl').dataTable().fnGetNodes(newRow);
         $(row).attr('id', data.category.id);
         var oSettings = $('#categorietbl').dataTable().fnSettings();
         var nTr = oSettings.aoData[ newRow[0] ].nTr;
         $('.srno').val((parseInt(srno)+1));
         $("#add_categories")[0].reset();
         document.getElementById("add_categories").reset();
      //  }
     }
   }
 });
  });

  $('#edit_categorie').on('submit', function (e) {
    var categories_name = $('#ecategoriesname').val();
    var trsrno = $('.trsrno1').val();
    var id = $('.hiddenid').val();
    var table = $('#categorietbl').DataTable();
    var info = table.page.info();
    var currentpage = info.start;
    e.preventDefault();
    $.ajax({
      type: 'post',
      dataType :'json',
      url: 'controller/categories_data.php',
      data: {id:id,categoriesname:categories_name,flag:"edit_categories"} ,
      success: function (data) {
        if(data.success==0){
          $('.error1').text(data.message);
        }
        else
        {     
         $('#editmodel').modal('hide');
         $('#categorietbl').dataTable().fnDeleteRow($('#'+id));
         newRow = $('#categorietbl').dataTable().fnAddData([
           (parseInt(trsrno)),
           data.catname,
           '<button class="btn btn-warning btn-circle waves-effect waves-light edit_cat" data-toggle="modal" data-target="#editmodel" data-id="'+data.id+'" data-name="'+ data.catname+'" data-count="'+trsrno+'"><i class="fa fa-pencil-square-o" style="font-size:19px;"></i></button><a class="btn btn-danger btn-circle waves-effect waves-light" href="controller/categories_data.php?id='+data.id+'&flag=remove_categories" onclick="return checkDelete()" style="margin-left: 15px;"><i class="fa fa-remove" style="font-size:19px;color:white;"></i></a>'
           ]);
         var row = $('#categorietbl').dataTable().fnGetNodes(newRow);
         $(row).attr('id', data.id);
         var oSettings = $('#categorietbl').dataTable().fnSettings();
         var nTr = oSettings.aoData[ newRow[0] ].nTr;
         $('.trsrno1').val((parseInt(trsrno)+1));
         $("#edit_categorie")[0].reset();
         document.getElementById("edit_categorie").reset();
       }
     }
   });
  });

$('#addmodel').on('hidden.bs.modal', function () 
{ 
  $(this).find('form')[0].reset();
  $('.error').text('');
});


  $('#editmodel').on('hidden.bs.modal', function () 
  { 
    $("#edit_categorie")[0].reset();
    $(this).find('form')[0].reset();
    $('.error1').text('');

  });

  $(document).on('click','.edit_cat', function (e) {
    var categories_name = $(this).attr('data-name');
    console.log(categories_name);
    $('.hiddenid').val($(this).attr('data-id'));
    $('.trsrno1').val($(this).attr('data-count'));
    $('.ecat').attr('value',categories_name);
  });   
});

$('.update').on('click', function() {
  var $this = $(this);
  $this.button('loading');
  setTimeout(function() {
   $this.button('reset');
 }, 2000);
});

function checkDelete(){
  return confirm('Are you sure remove it..?');
}

//Pack Add Edit //
//onclick loader //
$('.add').on('click', function() {
  var $this = $(this);
  $this.button('loading');
  setTimeout(function() {
   $this.button('reset');
 }, 2000);
});

//add pack//
$(document).ready(function () {
 $('#packtbl').DataTable();

 $(document).on('submit','#add_pack', function (e) {
  e.preventDefault();
  var formData;
  formData = new FormData($('#add_pack')[0]);
  formData.append( 'flag', 'add_pack_data');
  var  srno= $('.srno').val();
  $.ajax({
    type: 'post',            
    url: 'controller/pack_data.php',
    data: formData,
    dataType :'json',
    processData: false,
    contentType: false,
    success: function (data) {
      if(data.success==0){
        $('.error').text(data.message);
      }else{   
       var datacount = parseInt(srno) +1;     
       $('#addmodel').modal('hide');  
      //  if(data.packs!=""){ 
         newRow = $('#packtbl').dataTable().fnAddData([
           (parseInt(srno)+1),
           data.packs.categories_name,
           '<img src="../uploadpack/'+data.packs.try_icone+'" alt=" " height="75" width="75">',
           data.packs.title,
           data.packs.identifier,
           data.packs.publisher,
           data.packs.publisher_website,
           data.packs.pp_website,
           data.packs.la_website,
           '<div style="width: 200px; margin-top: 10px"><a href="controller/pack_data.php?id='+data.packs.id+'&action=download" class="btn btn-circle waves-effect waves-light" title="download json file" style="margin-top:10px; margin-left: 5px; background-color: #81C9E8;"><i class="fa fa-download" style="font-size:15px; color:white;"></i></a><button class="btn btn-warning btn-circle waves-effect waves-light edit_cat" data-toggle="modal" data-target="#editmodel" data-id="'+data.packs.id+'"  data-name="'+data.packs.cat_name_id+'" data-count="'+datacount+'" data-image="'+data.packs.try_icone+'" data-title="'+ data.packs.title+'" data-identifier="'+data.packs.identifier+'"data-publisher="'+ data.packs.publisher+'" data-publisher_website="'+data.packs.publisher_website+'" data-pp_website="'+ data.packs.pp_website+'"data-la_website="'+  data.packs.la_website+'" title="edit pack detail" style="margin-top: 10px; margin-left: 5px;"><i class="fa fa-pencil-square-o" style="font-size:15px;color:white;"></i></button><a class="btn btn-danger btn-circle waves-effect waves-light" href="controller/pack_data.php?id='+data.packs.id+'&flag=remove_pack" onclick="return checkDelete()" title="remove pack" style="margin-top: 10px; margin-left: 5px;"><i class="fa fa-remove" style="font-size:15px; color:white;"></i></a></div>'
           ]);
         var row = $('#packtbl').dataTable().fnGetNodes(newRow);
         $(row).attr('id', data.packs.id);
         var oSettings = $('#packtbl').dataTable().fnSettings();
         var nTr = oSettings.aoData[ newRow[0] ].nTr;
         $('.srno').val((parseInt(srno)+1));
         $("#add_pack")[0].reset();
         document.getElementById("add_pack").reset();
      //  }
     }
   }
 });
}); 

 $('#addmodel').on('hidden.bs.modal', function () { 
  $(this).find('form')[0].reset();
  $(this).find('form')[0].reset(); 
  // document.getElementById("add_pack").reset();
  $('#image_upload_preview').attr('src','http://placehold.it/96x96');

});

 function addURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('#image_upload_preview').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}

$("#fileToUpload").change(function () {
  addURL(this); 
});  

  //edit pack//
  $(document).on('submit','#edit_pack', function (e) {
    var formData;
    formData = new FormData($('#edit_pack')[0]);
    formData.append( 'flag', 'edit_pack_data');
    var  trsrno= $('.trsrno1').val();
    var id = $('.hiddenid').val();
    e.preventDefault();

    $.ajax({
      type: 'post',            
      url: 'controller/pack_data.php',
      data: formData,
      dataType :'json',
      processData: false,
      contentType: false,
      success: function (data) 
      {
       if(data.success==0){
        $('.error1').text(data.message);
      }
      else
      {      
       $('#editmodel').modal('hide');
       $('#packtbl').dataTable().fnDeleteRow($('#'+id));
       newRow = $('#packtbl').dataTable().fnAddData([
         (parseInt(trsrno)),
         data.packs.categories_name,
         '<img src="../uploadpack/'+data.packs.try_icone+'" alt=" " height="75" width="75">',
         data.packs.title,
         data.packs.identifier,
         data.packs.publisher,
         data.packs.publisher_website,
         data.packs.pp_website,
         data.packs.la_website,

         '<div style="width: 200px; margin-top: 10px"><a href="controller/pack_data.php?id='+data.packs.id+'&action=download" class="btn btn-circle waves-effect waves-light" title="download json file" style="margin-top:10px; margin-left: 5px; background-color: #81C9E8;"><i class="fa fa-download" style="font-size:15px; color:white;"></i></a><button class="btn btn-warning btn-circle waves-effect waves-light edit_cat" data-toggle="modal" data-target="#editmodel" data-id="'+data.packs.id+'" data-name="'+data.packs.cat_name_id+'" data-count="'+trsrno+'" data-image="'+data.packs.try_icone+'" data-title="'+data.packs.title+'" data-identifier="'+data.packs.identifier+'"data-publisher="'+data.packs.publisher+'" data-publisher_website="'+data.packs.publisher_website+'" data-pp_website="'+data.packs.pp_website+'"data-la_website="'+data.packs.la_website+'" title="edit pack detail" style="margin-top: 10px; margin-left: 5px;"><i class="fa fa-pencil-square-o" style="font-size:15px; color:white;"></i></button><a class="btn btn-danger btn-circle waves-effect waves-light" href="controller/pack_data.php?id='+data.packs.id+'&flag=remove_pack" onclick="return checkDelete()" title="remove pack" style="margin-top: 10px; margin-left: 5px;"><i class="fa fa-remove" style="font-size:15px; color:white;"></i></a></div>'
         ]);
       var row = $('#packtbl').dataTable().fnGetNodes(newRow);
       $(row).attr('id', data.packs.id);
       var oSettings = $('#packtbl').dataTable().fnSettings();
       var nTr = oSettings.aoData[ newRow[0] ].nTr;
       $('.trsrno1').val((parseInt(trsrno)));
       $("#edit_pack")[0].reset();
       document.getElementById("edit_pack").reset();
     }
   }
 });
  }); 

  $('#editmodel').on('hidden.bs.modal', function () { 
   $(this).find('form')[0].reset(); 
 }); 

  $(document).on('click','.edit_cat', function (e) {
    var cat_name_id = $(this).attr('data-name');
    var title = $(this).attr('data-title');
    var identifier = $(this).attr('data-identifier');
    var publisher = $(this).attr('data-publisher');
    var publisher_website = $(this).attr('data-publisher_website');
    var pp_website = $(this).attr('data-pp_website');
    var la_website = $(this).attr('data-la_website');
    var try_icone = $(this).attr('data-image');

    $('.hiddenid').val($(this).attr('data-id'));
    $('.trsrno1').val($(this).attr('data-count'));
    $('.ecat').find('option:selected').attr("selected",false);
    $('select[name^="ecategorieid"] option[value="'+cat_name_id+'"]').attr("selected",true);
    $('.etitle').attr('value',title);
    $('.eidentifier').attr('value',identifier);
    $('.epublisher').attr('value',publisher);
    $('.epublisherwebsite').attr('value',publisher_website);
    $('.eppwebsite').attr('value',pp_website);
    $('.elawebsite').attr('value',la_website);
    $('.previewimg').attr('src','../uploadpack/'+$(this).attr('data-image'));
    $('.hiddenimg').attr('value',$(this).attr('data-image'));
    $('#efileToUpload').attr('value',try_icone);
  }); 

  $('.update').on('click', function() {
    var $this = $(this);
    $this.button('loading');
    setTimeout(function() {
     $this.button('reset');
   }, 2000);
  });

  function editURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#eimage_upload_preview').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#efileToUpload").change(function () {
    editURL(this); 
  });  
});

//loader on click //
$('.update').on('click', function() {
  var $this = $(this);
  $this.button('loading');
  setTimeout(function() {
   $this.button('reset');
 }, 2000);
});

$(document).ready(function(){

  $('#efiles').on('change', function(e) {
    e.preventDefault();

    
    var c_image=document.getElementById("efiles").files;
    for (var i = 0; i < c_image.length; i++)
    {
      var file_name=c_image[i].name;
      var ex=file_name.split('.').pop();
      if(ex!="png")
      {
        $('#sticker_image_err').html("Upload png Image Only...!");
        // $('#efiles').val('');
        return false;
      }
      else
      {
        $('#sticker_image_err').html("");
      }
    }
    
    var formdata = new FormData($('#edit_sticker')[0]); 
    formdata.append("flag","multi_image");
    var count1=$('#countmulti_img').val();
    // alert(count);
    if(count1=="")
    {
      $('#countmulti_img').val('0');
    }
    var count=$('#countmulti_img').val();
    var filelength= $("#efiles")[0].files.length; 
    var stickercount=parseInt(filelength)+parseInt(count);
    var pack_id=$('.esticker1').val();
    formdata.append("pack_id",pack_id);
    $('#countmulti_img').val(stickercount);

    if(stickercount > 30) 
    {
      alert("You can't upload more then 30 images!");
      $('#countmulti_img').val(count);
      $('#efiles').val('');
    } 
    else {
      $.ajax({
        type: 'POST',
        url: "controller/sticker_data.php", 
        data: formdata,
        contentType: false,
        cache: false,
        processData:false,
        dataType: "json",
        success: function(data)
        { 
          // alert(data);
          $('#efiles').val('');
          if(data.success==1)
          {

            var images=$('#multi_img').val();
            var upload_image=data.data.toString();
            var final_images=images+','+upload_image;
            var rec=final_images.replace(/^,|,$/g, '');
            $('#multi_img').val(rec);
            var images=$('#multi_img').val();
            
            var arr=images.split(',');
            $(".image_gallery").html('');
            var html="";
            $.each(arr,function(index,val)
            {            
                 html +='<div class="col-md-4"><span"><img width="105px" height="105px" class="multiple_image_select" name="multipleselectimg[]" id="mulimg" style="margin-top: 15px; border: 2px solid; " src="../uploadpack/'+val+'"><span class="remove_img_preview" data-name="'+val+'"></span></span></div>';
  
            });

            $(".image_gallery").html(html);

         }

        }
      });
    }
  });
// 
  //delete images from edit part//
  $('.image_gallery').on('click', '.remove_img_preview',function () {
    var image=$(this).attr("data-name");
    var data=$("#multi_img").val();
    var result_img=data.replace(image,"");

    var result_img = result_img.replace(',,', ',');

    if(confirm("Are you sure Delete Sticker..!"))
    {
      var count=$('#countmulti_img').val();
      if(count==0)
      {
        $('#countmulti_img').val('');
      }
      else
      {
        var remove_count=count-1;
        $('#countmulti_img').val(remove_count);
      }
      $(this).parent('span').remove();
      if(data==result_img)
      {
        result_img=data.replace(image,"");
      }
      $(".image_gallery").html('');
      var temp=result_img.replace(/^,|,$/g, '');
      
      if(temp=="")
      {
        $("#multi_img").val('');
      }
      if(temp!="")
      {
        var img_arr=temp.split(',');

        var html="";
        $.each(img_arr , function(index,val) 
        {
             html +='<div class="col-md-4"><span><img width="105px" height="105px" class="multiple_image_select" name="multipleselectimg[]" id="mulimg" style="margin-top: 15px; border: 2px solid; " src="../uploadpack/'+val+'"><span class="remove_img_preview" data-name="'+val+'"></span></span></div>';
        });

        $(".image_gallery").html(html);
        var rcomma = result_img.replace(/^,|,$/g, '');
        $("#multi_img").val(rcomma); 
        var test=$('#multi_image').val();
      }

    }
  });




  //update edited data and redirect to stickerlist//
  $(document).on('submit','#edit_sticker', function (e) {
    e.preventDefault();
    var formData;
    formData = new FormData($('#edit_sticker')[0]);
    formData.append( 'flag', "edit_sticker");
    var id = $('.hiddenid').val();
    $.ajax({
      type: 'post',            
      url: 'controller/sticker_data.php',
      data: formData,
      dataType :'json',
      processData: false,
      contentType: false,
      success: function (data) {                
        if (data.success==1) {
          $("#edit_sticker")[0].reset();
          document.getElementById("edit_sticker").reset();
          window.location = "stickers.php";
        }
        else{
        }
      }
    });
  });
});
//filter packs data//
$(document).ready(function(){
  $(document).on('click', '.apply_filter_onpack', function() {
    var filter_category=$('#filtercategoriesname option:selected').val();
    var table = $("#packtbl").DataTable();
    var num=1;
    $.ajax({
      url: "controller/pack_data.php",
      type: "POST", 
      data:{id:filter_category,data:"filter_category"},
      dataType: "json",
      cache: false,
      success: function(data){
        if(data.success==1){
          table.clear().draw();
          $.each(data.data , function(index, val) {
            newRow = $('#packtbl').dataTable().fnAddData([
              num,
              val.categories_name,
              '<img src="../uploadpack/'+val.try_icone+'" alt=" " height="75" width="75">',
              val.title,
              val.identifier,
              val.publisher,
              val.publisher_website,
              val.pp_website,
              val.la_website,
              '<div style="width: 200px; margin-top: 10px"><a href="pack_data.php?id='+val.id+'&action=download" class="btn btn-circle waves-effect waves-light" style="margin-top:10px; margin-left: 5px; background-color: #81C9E8;""><i class="fa fa-download" style="font-size:15px; color:white;"></i></a><button class="btn btn-warning btn-circle waves-effect waves-light edit_cat" data-toggle="modal" data-target="#editmodel" data-id="'+val.id+'"  data-name="'+val.cat_name_id+'" data-count="'+num+'" data-image="'+val.try_icone+'" data-title="'+ val.title+'" data-identifier="'+val.identifier+'"data-publisher="'+val.publisher+'" data-publisher_website="'+val.publisher_website+'" data-pp_website="'+ val.pp_website+'"data-la_website="'+val.la_website+'"  style="margin-top: 10px;margin-left: 5px;"><i class="fa fa-pencil-square-o" style="font-size:15px; color:white;"></i></button><a class="btn btn-danger btn-circle waves-effect waves-light" href="pack_data.php?id='+val.id+'&flag=remove_pack" onclick="return checkDelete()" style="margin-top: 10px;margin-left: 5px;"><i class="fa fa-remove" style="font-size:15px; color:white;"></i></a></div>'
              ]);
            var row = $('#packtbl').dataTable().fnGetNodes(newRow);
            $(row).attr('id', val.id);
            var oSettings = $('#packtbl').dataTable().fnSettings();
            var nTr = oSettings.aoData[ newRow[0] ].nTr;
            num++;
          });
        }
      }
    })             
  });
  
  // Clear filter
  $(document).on('click', '.clear_filter_onpack', function() {
    var filter_category="";
    var table = $("#packtbl").DataTable();
    var num=1;
    $.ajax({
      url: "controller/pack_data.php",
      type: "POST", 
      data:{id:filter_category,data:"filter_category"},
      dataType: "json",
      cache: false,
      success: function(data){
       if(data.success==1){
        table.clear().draw();
        $.each(data.data , function(index, val) {
          newRow = $('#packtbl').dataTable().fnAddData([
            num,
            val.categories_name,
            '<img src="../uploadpack/'+val.try_icone+'" alt=" " height="75" width="75">',
            val.title,
            val.identifier,
            val.publisher,
            val.publisher_website,
            val.pp_website,
            val.la_website,
            '<div style="width: 200px; margin-top: 10px"><a href="pack_data.php?id='+val.id+'&action=download" class="btn btn-circle waves-effect waves-light" style="margin-top:10px; margin-left: 5px; background-color: #81C9E8;""><i class="fa fa-download" style="font-size:15px; color:white;"></i></a><button class="btn btn-warning btn-circle waves-effect waves-light edit_cat" data-toggle="modal" data-target="#editmodel" data-id="'+val.id+'"  data-name="'+val.cat_name_id+'" data-count="'+num+'" data-image="'+val.try_icone+'" data-title="'+ val.title+'" data-identifier="'+val.identifier+'"data-publisher="'+val.publisher+'" data-publisher_website="'+val.publisher_website+'" data-pp_website="'+ val.pp_website+'"data-la_website="'+val.la_website+'"  style="margin-top: 10px; margin-left: 5px;"><i class="fa fa-pencil-square-o" style="font-size:15px; color:white;"></i></button><a class="btn btn-danger btn-circle waves-effect waves-light" href="pack_data.php?id='+val.id+'&flag=remove_pack" onclick="return checkDelete()" style="margin-top: 10px; margin-left: 5px;"><i class="fa fa-remove" style="font-size:15px; color:white;"></i></a></div>'
            ]);
          var row = $('#packtbl').dataTable().fnGetNodes(newRow);
          $(row).attr('id', val.id);
          var oSettings = $('#packtbl').dataTable().fnSettings();
          var nTr = oSettings.aoData[ newRow[0] ].nTr;
          num++;
        });
        $('#filtercategoriesname option:selected').prop('selected', false);
      }
    }
  });           
  });

  $(document).on('submit', '#edit_token_pass_check', function(e) {
   e.preventDefault();
   var formData = new FormData($('#edit_token_pass_check')[0]);
   formData.append( 'flag', "edit_token_pass_check");

   $.ajax({
    type: 'post',            
    url: 'controller/token_change.php',
    data: formData,
    dataType :'json',
    processData: false,
    contentType: false,
    success: function (data) {               
      if(data.success==1){
        $('#id_pass_checkmodel').modal('hide');
        $('#edittoken').attr('style','display:none;');
        $('#updatetoken').attr('style','display:block;');
        $('#secret-token').removeAttr( "readonly" );
      }else{
       $.notify({
        wrapper: 'body',
        message: data.message,
        type: 'error',
        position: 3,
        dir: 'rtl',
        duration: 4000
      });
       return false;
     }
   }
 });
 });

  $('#id_pass_checkmodel').on('hidden.bs.modal', function () { 
   $(this).find('form')[0].reset(); 
 }); 

  $(document).on('click', '.update-token', function(e) {
    e.preventDefault();
    var token=$('#secret-token').val();
    var tokenid=$('#tokenid').val();
    if(token!=""){
      if (confirm("Are you sure Update Token ?? ")) {
        $.ajax({
          type: 'post',            
          url: 'controller/token_change.php',
          data: {tokenid:tokenid,token:token,flag:"update_secret_token"},
          dataType :'json',
          cache: false,
          success: function (data) {   
            if(data.success==1){
              $('#edittoken').attr('style','display:block;');
              $('#updatetoken').attr('style','display:none;');
              $('#secret-token').attr('readonly', true);
              $('#secret-token').val(token);
              $.notify({
                wrapper: 'body',
                message: data.message,
                type: 'success',
                position: 3,
                dir: 'rtl',
                duration: 4000
              });
              return false;
            }else{
              $.notify({
                wrapper: 'body',
                message: data.message,
                type: 'error',
                position: 3,
                dir: 'rtl',
                duration: 4000
              });
              return false;
            }
          }
        });
      }else{
        return false;
      }
    }else{
      $.notify({
        wrapper: 'body',
        message: "Please Enter Token.",
        type: 'error',
        position: 3,
        dir: 'rtl',
        duration: 4000
      });
      return false;
    }
  });
  
});


$(document).on('click','#edit_link',function()
{
  $('#edit_link').hide();
  $('#update_link').show();
  document.getElementById("play_store_link").disabled  = false;
});

$(document).on('click','#update_link',function()
{
  

  var link=$('#play_store_link').val();
  var tokenid=$('#tokenid').val();

  var regex = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
  if(!regex .test(link)) 
  {
    alert("Please enter valid URL.");
    return false;
  } 
  else 
  {
    

    $.ajax({
        type: 'post',            
        url: 'controller/token_change.php',
        data: {tokenid:tokenid,link:link,flag:"update_link"},
        // dataType :'json',
        cache: false,
        success: function(data) 
        {   
          $('#edit_link').show();
          $('#update_link').hide();
          document.getElementById("play_store_link").disabled  = true;
        }
      });
  }
      
    
});