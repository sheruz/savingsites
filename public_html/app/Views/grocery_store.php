<?=$this->extend("layout/master")?>
<?=$this->section("pageTitle")?>
  Grocery Store
<?=$this->endSection()?>
<?=$this->section("content")?>
<?=$this->include("includes/modals")?>
  <style type="text/css">
    
    .shopoffer p {
      border: 1px solid #eee;
      padding: 15px;
      box-shadow: 0px 0px 10px 0px #e3d1d1;
      margin: 10px;
    }
    .col-4.entered.shopoffer {
      padding: 0;
      margin: 0;
    }
    button.btn.btn-success.design {
      align-items: center;
      margin: 16px 0px;
    }
    a.changes {
      text-decoration: none;
      color: white;
    }
    .styleheadergrocery{
          color: #000;
    font-size: 18px;
    font-weight: 700;
    text-align: right;
    }

    .pagination {
    text-align: center;
     margin: 50px 0;
    display: block;
}
button.btn.btn-info.searchmilesbutton {
    background: #28a745;
}
input#searchmiles {
    padding: 4px;
}
ul.pagination_count {
    padding: 0;
}
.pagination ul {
    display: flex;
    justify-content: center;
}
.pagination ul li {
    padding: 2px 8px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
li.active {
    background: #28a745;
}
.white {
    color: #fff;
}
.login-boxx {
    text-align: center;
    display: block;
    width: 600px;
    box-shadow: 0px 0px 10px #bbb3b3;
    padding: 30px;
    margin: 50px auto;
}
.login-boxx p {
    font-size: 24px;
    font-weight: 700;
}
.textRightSide {
    justify-content: center;
        margin: 30px 0;
}
.header-top {
    border-bottom: none;
    box-shadow: unset;
        margin-top: 50px;
}
h1, .heading-1 {
    font-size: 65px;
    font-weight: 700;
}
  </style>
  
  <section>
    <input type="hidden" id="grocerystore" value="available"/>
    <input type="hidden" id="grocerystoreuid" value="<?= $uid ?>"/>
    <div class="container pt-4">
      <center><h1>Grocery Specials!</h1></center>
      
        <div class="row <?= $hide ?>" bis_skin_checked="1">
          <div class="login-boxx">
          <p class="<?= $hide ?>">Please Login . if not registered please sign up </p>
          <ul class="  user-menu pull-right text-right textRightSide">
            <li class="user-register zoneview">
              <div class="dropdown" bis_skin_checked="1">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownRegister" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-edit text-primary" aria-hidden="true"></i>Sign Up</button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownRegister" bis_skin_checked="1">
                  <a link="userregistration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal" data-target="#emailnoticesignupform02">Residents</a>
                  <a link="business_registration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);" data-zoneid="">Bus. Create Deals </a>
                  <a link="organization_registration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);">Nonprofit Orgs</a>
                  <a link="employee_registration" class="modal_form_open dropdown-item toggle-btn-pop employee_registration" href="javascript:void(0);">Local Employee</a>
                  <a link="visitor_registration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal" data-target="#visitor_registration02">Visitor</a>
                </div>
              </div>
            </li>
            <li class="user-login">
              <div class="dropdown" bis_skin_checked="1">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton13" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-sign-in text-primary" aria-hidden="true"></i>Login</button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton13" bis_skin_checked="1">
                  <a title="neighbour_login" class="loginTextChange1 dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal" data-target="#login-box2" id="neighbors_login">Residents</a>
                  <a title="businesses_login" class="loginTextChange1 dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal" data-target="#login-box2"> Bus. Create Deals </a>
                  <a title="organisations_login" class="loginTextChange1 dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal" data-target="#login-box2">Nonprofit Orgs</a>
                  <a title="employee_login" class="loginTextChange1 dropdown-item toggle-btn-pop" data-toggle="modal" data-target="#login-box2" href="javascript:void(0);">Local Employee</a>
                  <a title="visitor_login" class="loginTextChange1 dropdown-item toggle-btn-pop" data-toggle="modal" data-target="#login-box2" id="#login-box" href="javascript:void(0);">Visitor</a>
                </div>
              </div>
            </li>
          </ul>
          </div>
        </div>


    <!---------------Search start------------>
    <?php if(count($result) > 0){ ?>
    <div class="pagination <?= $show; ?>" bis_skin_checked="1">
        <ul class="pagination_count">
          <li><span class="page page-prev previouslink deactive">«</span></li>
          <?php $count = $rowcountArr/20;
                $count = round($count);
            for ($i=1; $i < $count; $i++) { 
              if($i <= 10){
                if($i == 1){$active = 'active white';}
                else{$active = '';}
                echo '<li class="pageloadgrocery '.$active.'" pagecount="'.$i.'">'.$i.'</li>';
              }
            }
          ?>
          <li><span class="page page-next nextlink">»</span></li>
        </ul>
      </div>
      <div class="<?= $show; ?>"><input type="number" id="searchmiles" placeholder="Enter Miles"/> <button class="btn btn-info searchmilesbutton">Search</button></div>
      <div class="row pt-4 <?= $show; ?>" id="grocerydataajax">
      <?php 
        foreach ($result as $k1 => $v1) { 
          if($ret = parse_url($v1->website) ) {
            if(!isset($ret["scheme"])){ $url = "http://{$v1->website}";}
            else{$url = $v1website;}
          }
          echo '<div class="col-lg-4 col-md-6 col-sm-12 entered shopoffer" ids="'.$v1->id.'">
            <p>
              <b><i class="fa-solid fa-store"></i>   Store:</b> '.$v1->company_name.'<br>
              <b><i class="fa-solid fa-house-chimney"></i>   Address:</b> '.$v1->address.'<br>
              <b><i class="fa-solid fa-phone"></i>   Phone:</b> '.$v1->phone.'<br>
              <button type="button" class="btn btn-success design" style=""><a target="_blank" href="'.$url.'" class="changes">Grocery Specials</a></button>  
            </p>
          </div>';
        } 
      ?>
    </div>
    <div class="pagination <?= $show; ?>" bis_skin_checked="1">
      <ul class="pagination_count">
        <li><span class="page page-prev previouslink deactive">«</span></li>
        <?php 
          $count = $rowcountArr/20;
          $count = round($count);
          for ($i=1; $i < $count; $i++) { 
            if($i <= 10){
              if($i == 1){$active = 'active white';}
              else{$active = '';}
              echo '<li class="pageloadgrocery '.$active.'" pagecount="'.$i.'">'.$i.'</li>';
            }
          }
        ?>
        <li><span class="page page-next nextlink">»</span></li>
      </ul>
    </div>
  <?php }else{echo '<div class="row pt-4 '.$show.'" id="grocerydataajax">Data Not Found</div>';} ?>
  </section>
<?php $this->endSection()?>