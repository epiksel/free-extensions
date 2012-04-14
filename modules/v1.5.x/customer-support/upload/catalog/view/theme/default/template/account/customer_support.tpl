<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <div class="content">
    <div class="buttons" style="text-align:right;"> <a class="button" href="javascript:fn_open_new_enquiry();"><span><?php echo $button_enquiry; ?></span></a> </div>
    <div id="new-enquiry" style="display:none;">
      <form action="<?php echo str_replace('&', '&amp;', $new_enquiry_action); ?>" method="post" enctype="multipart/form-data" id="form_new_enquiry">
        <input type="hidden" name="customer_support_status" value="<?php echo isset($list_customer_support_status[0])?$list_customer_support_status[0]:'';?>" />
        <table id="new-enquiry-form" class="form">
          <tbody>
            <?php if(!empty($cs_1st_category)){ ?>
            <tr>
              <th style="width:80px;"><?php echo $column_category_1st;?></th>
              <td><select id="customer_support_1st_category_id" name="customer_support_1st_category_id">
                  <?php foreach($cs_1st_category as $key => $category){ ?>
                  <option value="<?php echo $category['customer_support_1st_category_id'];?>" <?php echo $key == 0? 'selected="selected"': '';?>><?php echo $category['customer_support_1st_category'];?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <th><?php echo $column_category_2nd;?></th>
              <td><select id="customer_support_2nd_category_id" name="customer_support_2nd_category_id">
                  <?php if(!empty($cs_2nd_category)){ ?>
                  <?php foreach($cs_2nd_category as $key => $category){ ?>
                  <option value="<?php echo $category['customer_support_2nd_category_id'];?>" <?php echo $key == 0? 'selected="selected"': '';?>><?php echo $category['customer_support_2nd_category'];?></option>
                  <?php } ?>
                  <?php }else{ ?>
                  <option value=""><?php echo $text_none;?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <?php }?>
            <tr>
              <th><?php echo $column_subject;?></th>
              <td><input type="text" id="subject" name="subject" value="" style="width:98%;" /></td>
            </tr>
            <tr>
              <th><?php echo $column_enquiry;?></th>
              <td><textarea id="enquiry" name="enquiry" style="width:98%;height:150px;"></textarea></td>
            </tr>
            <tr>
              <td colspan="2" style="text-align:right;padding-right:25px;"><a id="button_submit" class="button" href="javascript:fn_submit_new_enquiry('form_new_enquiry');"><span><?php echo $button_submit;?></span></a></td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
    <table class="list">
      <thead>
        <tr>
          <td width="5%"><?php echo $column_no;?></td>
          <td width="10%"><?php echo $column_customer_support_status;?></td>
          <td><?php echo $column_subject;?></td>
          <td width="10%"><?php echo $column_created_at;?></td>
          <td width="10%"><?php echo $column_answered;?></td>
        </tr>
      </thead>
      <tbody>
        <?php if ($customer_supports) { ?>
        <?php foreach ($customer_supports as $customer_support) { ?>
        <tr id="enquiry-<?php echo $customer_support['customer_support_id'];?>" class="<?php echo isset($customer_support['answer']) && $customer_support['answer'] == ''? 'attention':'';?>">
          <td><?php echo $customer_support['customer_support_id'];?></td>
          <td><?php echo $customer_support['customer_support_status'];?></td>
          <td><a href="javascript:fn_enquiry('enquiry-detail-<?php echo $customer_support['customer_support_id'];?>');">[<?php echo $customer_support['reference'];?>] <?php echo $customer_support['subject'];?></a></td>
          <td><?php echo $customer_support['date_added'];?></td>
          <td><?php echo !empty($customer_support['customer_supports_threads'])? $text_answer_y:$text_answer_n ;?></td>
        </tr>
        <tr id="enquiry-detail-<?php echo $customer_support['customer_support_id'];?>" style="display:none;"  class="<?php echo isset($customer_support['answer']) && $customer_support['answer'] == ''? 'attention':'';?>">
          <td colspan="5"><table id="enquiry-content-<?php echo $customer_support['customer_support_id'];?>" class="form"  style="table-layout: fixed;width:100%;">
              <tbody>
                <?php if($customer_support['customer_support_1st_category'] || $customer_support['customer_support_1st_category']){ ?>
                <tr>
                  <th width="20%"><?php echo $column_category_1st;?></th>
                  <td width="29%"><?php echo $customer_support['customer_support_1st_category'];?></td>
                  <th width="20%"><?php echo $column_category_2nd;?></th>
                  <td><?php echo $customer_support['customer_support_2nd_category'];?></td>
                </tr>
                <?php } ?>
                <tr>
                  <th width="10%"><?php echo $column_enquiry;?></th>
                  <td colspan="3"><?php echo nl2br($customer_support['enquiry']);?> <br />
                    <span style="float:right;font-style:italic;font-weight:bold;">(<?php echo $text_enquiry_date;?> <?php echo $customer_support['date_added'];?> <?php echo nl2br($customer_support['time_added']);?>)</span></td>
                </tr>
                <?php if (!empty($customer_support['customer_supports_threads'])) { ?>
                <?php foreach($customer_support['customer_supports_threads'] as $key2 => $thread) { ?>
                <tr>
                  <th><?php if($thread['customer_id'] == $this->customer->getId()) { ?>
                    <?php echo $column_enquiry; } else { echo $column_answer; } ?> </th>
                  <td colspan="3" style="padding:10px;"><?php echo nl2br($thread['enquiry']);?> <br />
                    <span style="float:right;font-style:italic;font-weight:bold;">(<?php echo $text_answer_date;?> <?php echo date($this->language->get('date_format_short'), strtotime($thread['date_added']));?> <?php echo date($this->language->get('time_format'), strtotime($thread['date_added']));?>)</span></td>
                </tr>
                <?php } } else { ?>
                <tr>
                  <td colspan="4" style="text-align: right;"><a id="button_delete_<?php echo $customer_support['customer_support_id'];?>" href="javascript:fn_delete_enquiry('<?php echo $customer_support['customer_support_id'];?>');" class="button"><span><?php echo $button_delete;?></span></a></td>
                </tr>
                <?php } ?>
                <tr>
                  <th></th>
                  <td colspan="3" style="padding:10px;"><form action="<?php echo str_replace('&', '&amp;', $new_enquiry_action); ?>" method="post" enctype="multipart/form-data" id="form_enquiry_<?php echo $customer_support['customer_support_id'];?>">
                      <input type="hidden" name="t_topic_id" value="<?php echo $customer_support['customer_support_topic_id'];?>" />
                      <textarea id="enquiry" name="enquiry" style="width:100%;height:150px;"></textarea>
                      <select name="customer_support_status">
                        <?php foreach($list_customer_support_status as $status){ ?>
                        <option value="<?php echo $status;?>" <?php echo (strcasecmp($customer_support['customer_support_status'], $status) == 0 ? "selected='selected'": "");?>><?php echo $status;?></option>
                        <?php }?>
                      </select>
                      &nbsp;&nbsp;&nbsp;<a id="button_submit_enquiry" class="button" href="javascript:fn_submit_new_enquiry('form_enquiry_<?php echo $customer_support['customer_support_id'];?>');"><span><?php echo $button_submit;?></span></a>
                    </form></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
          <td colspan="5"><?php echo $text_no_results; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <div class="pagination" style="margin-top:0;"><?php echo $pagination; ?></div>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?> 
<script type="text/javascript">
	$("#customer_support_1st_category_id").change(function(){
		$('#customer_support_2nd_category_id').load('index.php?route=account/customer_support/get_2nd_category&1st_category=' + $("#customer_support_1st_category_id").val());	
	});
	
	
	function fn_enquiry(row_id){
		$("#" + row_id).toggle();
	}

	function fn_open_new_enquiry(){
		$('.success, .warning').remove();
		$("#new-enquiry").toggle();
	}
	
	function fn_submit_new_enquiry(frm_id){
		$.ajax({
			type: 'POST',
			url: '<?php echo $new_enquiry_action;?>',
			dataType: 'json',
			data: $("#"+frm_id).serialize(),
			beforeSend: function() {
				$('.success, .warning').remove();
				$('#button_submit', '#'+frm_id).attr('disabled', 'disabled');
				$('#'+frm_id).before('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
			},
			complete: function() {
				$('#button_submit', '#'+frm_id).attr('disabled', '');
				$('.attention').remove();
			},
			success: function(data) {
				if (data.error) {
					$('#'+frm_id).before('<div class="warning">' + data.error + '</div>');
				}
				
				if(data.success) {
					$('#'+frm_id).before('<div class="success">' + data.success + '</div>');
					
					$('#subject', '#'+frm_id).val('');
					$('#enquiry', '#'+frm_id).val('');
					alert(data.success);
					location.reload();
				}
			}
		})
	}
	
	function fn_delete_enquiry(enquiry_id){
		if(confirm("<?php echo $text_confirm_delete;?>") == false) return;
		$.ajax({
			type: 'POST',
			url: '<?php echo $delete_enquiry_action;?>',
			dataType: 'json',
			data: 'enquiry_id=' + enquiry_id,
			beforeSend: function() {
				$('.success, .warning').remove();
				$('#button_delete_' + enquiry_id).attr('disabled', 'disabled');
				$('#enquiry-content-' + enquiry_id).before('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
			},
			complete: function() {
				$('#button_delete_' + enquiry_id).attr('disabled', '');
				$('.attention').remove();
			},
			success: function(data) {
				if (data.error) {
					$('#enquiry-content-'+enquiry_id).before('<div class="warning">' + data.error + '</div>');
				}
				
				if(data.success) {
					$('#new-enquiry').before('<div class="success">' + data.success + '</div>');
					$('#enquiry-' + enquiry_id).remove();
					$('#enquiry-detail-' + enquiry_id).remove();
				}
			}
		});
	}	
</script>