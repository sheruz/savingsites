<?php 
require_once "config.php";


$sqlget = "SELECT * FROM  multipurposeImage";
$res = mysqli_query($dbhandle, $sqlget);

$catget = "SELECT * FROM  multiPurFoodCategory";
$catres = mysqli_query($dbhandle, $catget);




if(!isset($_SESSION['loggedin'])){
  header("Location: https://savingssites.com/scrap");  
}

$cookie_name = "history_link";
$cookie_value = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
setcookie($cookie_name, $cookie_value, time()+3600, "/"); 
?>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://savingssites.com/assets/scrap/css/custom-scrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">

 

  <style type="text/css">
   .loader-wrapperdiv{
    position: absolute;
    top: 0;
    width: 100%;
    height: 100%;
    background: #000;
    opacity: 0.7;
    z-index: 99999;
}
.hide{
    display: none;
}
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h1 style="text-align: center;margin-bottom: 0;margin-top: 46px;padding-bottom: 40px;">Images</h1>
      </div>
      <div class="col-md-6">
        <h1 style="text-align: center;margin-bottom: 0;margin-top: 46px;padding-bottom: 40px;font-size: 18px;"><a href="imagecategory.php" target="_blank">Add/Edit Category</a></h1>
      </div>

      <form class="img-view-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" id="insertform">
        <div class="col-md-12">
          <select class="form-control divset" id="inscat" name="imagecategory">
            <option value>Select Image Category</option>
            <?php while($r=mysqli_fetch_array($catres)){ ?>
              <option value="<?= $r['id'] ?>"><?= $r['foodCategoryName'] ?></option>
            <?php } ?>
          </select>
          <input type="file" class="form-control divset" id="insimage" name="image[]" multiple placeholder="Upload Image" required><button type="button" id="insertSave" class="btn btn-success divset1">Upload</button>
        </div>
     
      </form>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table  id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Image Id</th>
                <th>Image</th>
                <th>Category Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="imagediv">
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php if(isset($_SESSION['insert']) && $_SESSION['insert'] == true){?> 
    <div class="alert alert-success alert-dismissible fade show divposition" role="alert">
      <strong>Image Uploaded Successfully.</strong>
    </div>
  <?php } 
    $_SESSION['insert'] = false;
  ?>



<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="snapPop9">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #198754;color: #fff;">
        <h4 class="modal-title" id="myModalLabel">Update Image</h4>
        <button type="button" class="close closeupdate" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
         <div class="col-md-6">
          <input type="hidden" name="update" value="1" />
          <input type="hidden" id="imageID" name="imageid" value="1" />
          <select style="width: 100%;" class="form-control divset" id="updatecategory" name="imagecategory">
            <option value>Select Image Category</option> 
          </select>
        </div>
        <div class="col-md-6">
          <input style="width: 100%;" type="file" id="image" class="form-control divset" name="image[]" multiple placeholder="Upload Image">
        </div>
        <div class="col-md-12">
          <img style="width: 100%;" id="updateprev" src=""/>
        </div>
        <div class="col-md-12" id="preview">
          <img style="width: 100%;" id="updateprev" src=""/>
        </div>
        <div class="col-md-12">
        
        </div>
      </form>
        </div> 

         <div style="background: #198754;color: #fff;">
            <button type="button" class="btn btn-success divset1" id="updateImage">Update</button>
      </div>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="imagepreview">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     
      <div class="modal-body">
            <h4 class="modal-title" id="myModalLabel">Preview Image</h4>
        <button type="button" class="close closeprev" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="col-md-12">
          <img style="width: 100%;" id="previmg" src=""/>
        </div>
      </div> 
      </div>
    </div>
  </div>
</div>
<div class="loader-wrapperdiv hide">
  <div class="loadered"></div>
</div>





  
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function(){
      ajaxcall();
      $('.closeupdate').click(function(){
        $('#snapPop9').css('display','none'); 
        $('#snapPop9').addClass('fade'); 
      });
      $('.closeprev').click(function(){
        $('#imagepreview').css('display','none'); 
        $('#imagepreview').addClass('fade'); 
      });
      
      $("#image").change(function () {
        imagePreview(this);
      });



      

      $('#insertSave').click(function(){
        var catid = $('#inscat option:selected').val();
        var image = $('#insimage').val();
        if(catid == '' || catid == undefined){
          alert("Please Select Category");
          return false;
        }
        if(image == '' || image == undefined){
          alert("Please Select Image");
          return false;
        }
        var fd = new FormData();
        var totalfiles = document.getElementById('insimage').files.length;
        for (var index = 0; index < totalfiles; index++) {
          fd.append("image[]", document.getElementById('insimage').files[index]);
        }
        fd.append('insertImage',1);
        fd.append('category',catid);
        $.ajax({ 
          type:'POST',
          url :"/scrap/uploadimagefunction.php",
          data: fd,
          contentType: false,
          processData: false,
          dataType:'json',
          beforeSend: function() {
            $('.loader-wrapperdiv').removeClass('hide');
          },
          complete: function() {
            $('.loader-wrapperdiv').addClass('hide');
          },
          success: function(r) {
            $('#inscat').val('');
            $('#insimage').val('');
            alert(r.msg); 
            var table = $('#example').DataTable();
            table.destroy();
            ajaxcall();
          }
        });
      });

      $('#updateImage').click(function(){
        var catid = $('#updatecategory option:selected').val();
        var imageID = $('#imageID').val();
        var image = $('#image').val();
        if(catid == '' || catid == undefined){
          alert("Please Select Category");
          return false;
        }
        var fd = new FormData();
        var totalfiles = document.getElementById('image').files.length;
        for (var index = 0; index < totalfiles; index++) {
          fd.append("image[]", document.getElementById('image').files[index]);
        }
        fd.append('updateImage',1);
        fd.append('category',catid);
        fd.append('imageID',imageID);
        $.ajax({ 
          type:'POST',
          url :"/scrap/uploadimagefunction.php",
          data: fd,
          contentType: false,
          processData: false,
          dataType:'json',
          beforeSend: function() {
            $('.loader-wrapperdiv').removeClass('hide');
          },
          complete: function() {
            $('.loader-wrapperdiv').addClass('hide');
          },
          success: function(r) {
            $('#updatecategory').val('');
            $('#image').val('');
            $('#image').val('');
            $('#snapPop9').css('display','none'); 
            $('#snapPop9').addClass('fade');
            alert(r.msg); 
            var table = $('#example').DataTable();
            table.destroy();
            ajaxcall();
          }
        });
      });
    });

  function selectcategoryajaxcall(id){
    var html = '';
    var selected ="";
    $.ajax({ 
      type:'POST',
      url :"/scrap/uploadimagefunction.php",
      data: {'fetch':'category'} ,
      dataType:'json',
      success: function(r) {
        $.each(r, function(key,v) {
          if(id == v.id){
            var selected ="selected";
          }
          html += '<option '+selected+' value="'+v.id+'">'+v.foodCategoryName+'</option>' 
        });
        $('#updatecategory').html(html); 
      }
    })
  }
  function imagePreview(fileInput) {
    $("#updateprev").addClass('hide');
    $("#preview").removeClass('hide');
    if(fileInput.files && fileInput.files[0]) {
      var fileReader = new FileReader();
      fileReader.onload = function (event) {
        $('#preview').html('<img style="width:100%;height:250px;" src="'+event.target.result+'"/>');
      };
      fileReader.readAsDataURL(fileInput.files[0]);
    }
  }

  function imagepreview1($this){
    var src = $this.attr('src');
    $("#previmg").attr('src',src);
    $('#imagepreview').removeClass('fade');
    $('#imagepreview').css('display', 'block');
  }

  function trashdata(id){
    var $this = $(this);  
    if (confirm('Are You Sure To Delete')) {
      $.ajax({ 
        type:'POST',
        url :"/scrap/uploadimagefunction.php",
        data:  {'delid': id},
        dataType:'json',
        beforeSend: function() {
          $('.loader-wrapperdiv').removeClass('hide');
        },
        complete: function() {
          $('.loader-wrapperdiv').addClass('hide');
        },
        success: function(r) {
          if(r == 1){
            $this.closest('tr').remove();
            var table = $('#example').DataTable();
            table.destroy();
            ajaxcall();
          }
        }
      }); 
    }else{
      alert('Image Safe');
    }
  }

  function updateImage(id){
    $('#preview').addClass('hide');
    $.ajax({ 
      type:'POST',
      url :"/scrap/uploadimagefunction.php",
      data:  {'updateid': id},
      dataType:'json',
      beforeSend: function() {
        $('.loader-wrapperdiv').removeClass('hide');
      },
      complete: function() {
        $('.loader-wrapperdiv').addClass('hide');
      },
      success: function(r) {
        selectcategoryajaxcall(r.category);
        $("#updateprev").attr('src','https://savingssites.com/assets/CommonImages/'+r.image+'');
        $('#snapPop9').removeClass('fade');
        $('#snapPop9').css('display', 'block');
        $('#imageID').val(r.id);
      }
    })
  } 
  
  function ajaxcall(){
    var html = '';
    $.ajax({ 
      type:'POST',
      url :"/scrap/uploadimagefunction.php",
      data: {'fetch':'image'} ,
      dataType:'json',
      success: function(r) {
        $.each(r, function(key,v) {
          html += '<tr>';
          html += '<td width="10%">'+v.id+'</td>';
          html += '<td width="30%"><img onclick="imagepreview1($(this))" class="imageSize" src="https://savingssites.com/assets/CommonImages/'+v.image+'"/></td>';
          html += '<td width="20%">'+v.catname+'</td>';
          html += '<td width="10%"><i onclick="trashdata('+v.id+')" class="fa-solid fa-trash font trashdata"></i> <i rowid='+v.id+' onclick="updateImage('+v.id+')" class="fa-solid fa-pen-to-square font updateImage"></i></td>';
          html += '</tr>';
        });
        $('#imagediv').html(html); 
        datatable(); 
      }
    })
  }
  
  function datatable(){
    document.title='Simple DataTable';
    $('#example').DataTable(
      {
        "dom": '<"dt-buttons"Bf><"clear">lirtp',
        "paging": true,
        "autoWidth": true,
        "buttons": [
          'colvis',
          'copyHtml5',
          'csvHtml5',
          'excelHtml5',
          'pdfHtml5',
          'print'
        ]
      }
    );
  }
</script>
</body>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

