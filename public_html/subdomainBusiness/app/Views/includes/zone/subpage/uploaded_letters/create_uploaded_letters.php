<div class="form-group">
  <?=form_open_multipart("Zonedashboard/save_upload_letters", "name='ul_form' id='ul_form'");?>
  <input type="hidden" id="letter_id" name="letter_id" value="-1"/>
  <input type="hidden" id="iszoneid" value="<?=$zone_id?>"/>
  <p class="form-group-row">
    <label for="ul_name" class="fleft w_200">Letter Name</label>
    <input type="text" id="ul_name" name="ul_name" class="w_536" placeholder="Specify Letter Name"/>
  </p>
  <div class="uploaded_letters_file">
    <p >
      <label for="ul_file" class="fleft w_200">Letter File Name</label>
      <input type="file" id="<?=$zone_id?>" name="<?=$zone_id?>" class="upload_letter" onchange="return upload_Image('<?=$zone_id?>','<?php echo site_url("Zonedashboard/upload_letter/".$zone_id."/ul_form");?>','ul_form');"/>
      <br/>
      <p class="form-group-row" style="margin-left:200px;">Allowed  formats : (<?php echo strtoupper('docx|doc|pdf');?>)</p>
      <p  class="form-group-row" style="margin-left:200px;">Max Size : ( 1 MB)</p>
      <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
    <div id="upload_letters" style="margin-left:200px;">
      <input type="hidden" id="ups_letter" name="ups_letter" />
    </div>
    </p>
  </div>
  <p>
    <label for="ul_desc" class="fleft w_200">Description</label>
    <textarea rows="10" cols="45" style="width: 536px; height: 150px" id="ul_desc" name="ul_desc"></textarea>
  </p>
  <? if(!empty($org_list)){ ?>
  <p>
    <label for="ul_org" class="fleft w_200">Shared In Organization</label>
  <div class="dropdown-uploadletters">
    <table cellpadding="0" cellspacing="0" width="100%" class="m_top_0i">
      <tr >
        <td><input id="upload_letters_checkbox_0" type="checkbox" class="upload_letters_checkbox" value="0" onclick="return select_all_category(this);"/></td>
        <td class="option"><label for="upload_letters_checkbox_0">
          <div>All Organization</div>
          </label></td>
      </tr>
      <? foreach($org_list as $key=>$val){?>
      <tr >
        <td><input id="upload_letters_checkbox_<?=$val['id']?>" type="checkbox" class="upload_letters_checkbox" value="<?=$val['id']?>" onclick="individual_checkbox_upload_letters()"/></td>
        <td class="option"><label for="upload_letters_checkbox_<?=$val['id']?>">
          <div>
            <?=$val['name']?>
          </div>
          </label></td>
      </tr>
      <? } ?>
    </table>
  </div>
  </p>
  <? } ?>
  <?=form_close()?>
  <input type="hidden" name="upload_status" value="" id="upload_status" />
  <button onclick="save_letters($(this).prev('form'))" style="margin-left:200px;">Save</button>
  <button id="cancel_edit" onclick="cancel_edit();" style="display:none;">Cancel</button>
</div>