<?=$this->extend("layout/scrapmaster")?>

<?=$this->section("pageTitle")?>
  Savings Sites
<?=$this->endSection()?>
  
<?=$this->section("scrapcontent")?>
<?=$this->include("includes/scrap/modals")?>
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
      <table  id="categorytable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Category Id</th>
            <th>Category Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="categorydata">
        <?php foreach ($data as $k => $v) {
          echo '<tr><td>'.$v['id'].'</td><td>'.$v['foodCategoryName'].'</td><td><i rowid='.$v['id'].' rowname="'.$v['foodCategoryName'].'" class="fa-solid fa-pen-to-square font updateImagcategory"></i></td></tr>';
        } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
</div>
</div>
<script>
  $(document).on('click','#category_close', function(){
      alert("here");
      $('#snapPop9category').css('display','none'); 
      $('#snapPop9category').addClass('fade'); 
    });



    $(document).ready(function(){
      
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

      

      

      
    });
    
  




  </script>


<?=$this->endSection()?>