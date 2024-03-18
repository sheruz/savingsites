<?php 
require_once "config.php";
$catget = "SELECT * FROM  multiPurFoodCategory";
$catres = mysqli_query($dbhandle, $catget); 

session_start();
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
   
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 style="text-align: center;margin-bottom: 0;margin-top: 46px;padding-bottom: 40px;">Add Category</h1>
      </div>
      <form class="img-view-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="col-md-12">
          <input type="text" name="category" class="form-control divset" id="imagecategory" placeholder="Enter New Category">
          <button type="button" class="btn btn-success catsave divset1">Save</button>
        </div>
     
      </form>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table  id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Category Id</th>
                <th>Category Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="categorydata">
              <?php while($row=mysqli_fetch_array($catres)){ ?>
              <tr>
                <td width="10%"><?= $row['id'];?></td>
                <td width="20%"><?= $row['foodCategoryName'];?></td>
                <td width="10%"><!-- <i rowid='<?= $row['id']?>' class="fa-solid fa-trash font trashdata"></i> --> <i rowid='<?= $row['id']?>' rowname="<?= $row['foodCategoryName'];?>" class="fa-solid fa-pen-to-square font updateImage"></i></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>




<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="snapPop9">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #198754;color: #fff;">
        <h4 class="modal-title" id="myModalLabel">Update Category</h4>
        <button type="button" class="close closeupdate" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <input type="text" name="category" class="form-control divset" id="updateimagecategory" placeholder="Update Category">
        </div>
      </div> 
      <div style="background: #198754;color: #fff;">
        <button type="button" class="btn btn-success updatecategory">Update</button>
      </div>
    </div>
  </div>
</div>
</div>


</div>








  
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function(){
      ajaxcall();
      $('.closeprev').click(function(){
        $('#imagepreview').css('display','none'); 
        $('#imagepreview').addClass('fade'); 
      });
      
      $('.trashdata').click(function(){
        var id = $(this).attr('rowid');
        var $this = $(this);  
        if (confirm('Are You Sure To Delete')) {
          $.ajax({ 
            type:'POST',
            url :"/scrap/uploadimagefunction.php",
            data:  {'delid': id,'type':'category'},
            dataType:'json',
            success: function(r) {
              if(r == 1){
                $this.closest('tr').remove();
              }
            }
          }); 
        }
      });
      $(document).on('click','#openeditmodal', function(){
          $('#categorymodal').removeClass('fade');
        $('#categorymodal').css('display', 'block');
      });

      $(document).on('click', '.catsave', function(){
        var newcat = $('#imagecategory').val();
        if(newcat == ''){
          alert("Please enter Category");
          return false;
        }
        if(!isNaN(newcat)){
          alert("Only Caracter Allowed");
          return false;
        }
        var type = 'newcatadd';
        $.ajax({ 
          type:'POST',
          url :"/scrap/uploadimagefunction.php",
          data:  {'newcat':newcat,'type':type},
          dataType:'json',
          success: function(r) {
            alert(r.msg);
            $('#imagecategory').val('');
            var table = $('#example').DataTable();
            table.destroy();
             ajaxcall();
          }
        })
      });

      $('.updateImage').click(function(){
        var id = $(this).attr('rowid');
        var name = $(this).attr('rowname');
        $('#updateimagecategory').val(name);
        $('#updateimagecategory').attr('catid', id);
        $('#preview').addClass('hide');
        $('#snapPop9').removeClass('fade');
        $('#snapPop9').css('display', 'block');
      });

      $('.updatecategory').click(function(){
        var catname = $('#updateimagecategory').val();
        var catid = $('#updateimagecategory').attr('catid');
        var type = 'updatecatadd';
        if(catname == ''){
          alert("Please enter Category");
          return false;
        }
        if(!isNaN(catname)){
          alert("Only Caracter Allowed");
          return false;
        }
        $.ajax({ 
          type:'POST',
          url :"/scrap/uploadimagefunction.php",
          data:  {'catname':catname,'catid':catid,'type':type},
          dataType:'json',
          success: function(r) {
            alert(r.msg);
            $('#updateimagecategory').val('');
            $('#updateimagecategory').attr('catid','');
            $('#snapPop9').addClass('fade');
            $('#snapPop9').css('display', 'none');
            var table = $('#example').DataTable();
            table.destroy();
            ajaxcall();
          }
        }) 
      })
    });
    
  function ajaxcall(){
    var html = '';
    $.ajax({ 
      type:'POST',
      url :"/scrap/uploadimagefunction.php",
      data: {'fetch':'category'} ,
      dataType:'json',
      success: function(r) {
        $.each(r, function(key,v) {
          console.log(v);
          html += '<tr>';
          html += '<td>'+v.id+'</td>';
          html += '<td>'+v.foodCategoryName+'</td>';
          // html += '<td width="10%"><i rowid='<?//= $row['id']?>' class="fa-solid fa-trash font trashdata"></i> <i rowid='<?//= $row['id']?>' rowname="<?//= $row['foodCategoryName'];?>" class="fa-solid fa-pen-to-square font updateImage"></i></td>';
          html += '<td width="10%"><i rowid="'+v.id+'" rowname="'+v.foodCategoryName+'" class="fa-solid fa-pen-to-square font updateImage"></i></td>';
          html += '</tr>';
        });
        $('#categorydata').html(html); 
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

