<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
      	<a href="<?php echo $manage_category;?>" class="button"><span><?php echo $button_manage_category;?></span></a>
    	<a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
	      <table class="list table-fixed">
	        <thead>
	          <tr>
	            <td width="2%" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
	            <td class="left" width="2%"><?php echo $column_no; ?></td>
				<td class="left" width="10%"><?php echo $column_customer_support_status; ?></td>
				<td class="left" width="15%"><?php echo $column_1st_category; ?></td>
				<td class="left" width="15%"><?php echo $column_2nd_category; ?></td>
				<td class="left">[#<?php echo $column_reference; ?>] <?php echo $column_subject; ?></td>
				<td class="left" width="8%"><?php echo $column_date_added; ?></td>
	            <td class="right" width="10%"><?php echo $column_action; ?></td>
	          </tr>
	        </thead>
	        <tbody>
	          <tr class="filter">
	            <td></td>
	            <td align="right"><input type="text" name="filter_customer_support_id" value="<?php echo $filter_customer_support_id; ?>" size="2" /></td>
	            <td><select name="filter_customer_support_status" style="width:100%;">
	            		<option value=""></option>
	            		<?php foreach($list_customer_support_status as $status){ ?>
	            		<option value="<?php echo $status;?>" <?php echo (strcasecmp($status, $filter_customer_support_status) == 0 ? "selected='selected'": "");?>><?php echo $status;?></option>
	            		<?php }?>
	            	</select></td>
	            <td colspan="2"><select name="filter_cs_category_id" style="width:100%;">
	            		<option value=""></option>
		            	<?php if(!empty($cs_category)){ ?>;
						<?php foreach($cs_category as $key => $category){ ?>
							<option value="<?php echo $category['category_id'];?>" <?php echo $filter_cs_category_id == $category['category_id']? 'selected="selected"': '';?>><?php echo $category['name'];?></option>
						<?php } ?>
						<?php } ?>
					</select></td>
	            <td><input type="text" name="filter_customer_subject" value="<?php echo $filter_customer_subject; ?>" style="width:98%;" /></td>
	            <td><input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" size="12" id="date" /></td>
	            <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
	          </tr>
	          <?php if ($customer_supports) { ?>
	          <?php foreach ($customer_supports as $customer_support) { ?>
	          <tr class="<?php echo isset($customer_support['answer']) && $customer_support['answer'] == ''? 'attention':'';?>" style="font-weight:bold;">
	            <td style="text-align: center;"><?php if ($customer_support['selected']) { ?>
	              <input type="checkbox" name="selected[]" value="<?php echo $customer_support['customer_support_id']; ?>" checked="checked" />
	              <?php } else { ?>
	              <input type="checkbox" name="selected[]" value="<?php echo $customer_support['customer_support_id']; ?>" />
	              <?php } ?></td>
				<td class="left"><?php echo $customer_support['customer_support_id']; ?></td>
				<td class="center" <?php if ($customer_support['customer_support_status']=="Open") { ?> style="color:red;" <?php } ?>><?php echo $customer_support['customer_support_status']; ?></td>
				<td class="left"><?php echo $customer_support['customer_support_1st_category']; ?></td>
				<td class="left"><?php echo $customer_support['customer_support_2nd_category']; ?></td>
	            <td class="left"><?php if($customer_support['reference'] != ''){ ?><a id="enquiry-title-<?php echo $customer_support['reference'];?>">[#<?php echo $customer_support['reference']; ?>]<?php } ?> <?php if($customer_support['status'] == 0){ echo "<s>"; } echo $customer_support['subject']; if($customer_support['status'] == 0){ echo "</s> (Deleted by customer)"; }  ?></a></td>
	            <td class="left"><?php echo $customer_support['date_added']; ?></td>
	            <td class="right"><?php foreach ($customer_support['action'] as $action) { ?>
	              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
	              <?php } ?></td>
	          </tr>
	         <tr style="display:none;" class="enquiry-detail-<?php echo $customer_support['customer_support_id'];?>">
	          	<td colspan="3"><?php echo $customer_support['firstname']; ?> <?php echo $customer_support['lastname']; ?></td>
	          	<td colspan="5" class="content answer" style="padding:10px;"><?php echo nl2br($customer_support['enquiry']);?></td>
	          </tr>
	          <?php if(!empty($customer_support['customer_supports_threads'])) { foreach($customer_support['customer_supports_threads'] as $key2 => $thread) { ?>
	          <tr style="display:none;" class="enquiry-detail-<?php echo $customer_support['customer_support_id'];?>">
	          	<td colspan="3" style="text-align:right;"><?php if($thread['customer_id'] == 0) { echo $text_answered; } else { echo $thread['firstname']." ".$thread['lastname']; } ?></td>
	          	<td colspan="5" class="answer" style="padding:10px;"><?php if($customer_support['status'] == 0){ echo "<s>"; } echo nl2br($thread['enquiry']); if($customer_support['status'] == 0){ echo "</s> (Deleted by customer)"; } ?>
	          		<br />(<?php echo $column_date_added; ?>: <?php echo date($this->language->get('date_format_short'), strtotime($thread['date_added']));?> - <?php echo date($this->language->get('time_format'), strtotime($thread['date_added']));?>)</td>
	          </tr>
	          <?php } } } } else { ?>
	          <tr>
	            <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
	          </tr>
	          <?php } ?>
	        </tbody>
	      </table>
	    </form>
	    <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--

<?php foreach ($customer_supports as $customer_support) { ?>
$('#enquiry-title-<?php echo $customer_support["reference"];?>').click(function() {
  $('.enquiry-detail-<?php echo $customer_support["customer_support_id"];?>').toggle('slow', function() {
    // Animation complete.
  });
});
<?php } ?>

function filter() {
	url = 'index.php?route=catalog/customer_support&token=<?php echo $token; ?>';
	
	var filter_customer_support_id = $('input[name=\'filter_customer_support_id\']').val();
	
	if (filter_customer_support_id) {
		url += '&filter_customer_support_id=' + encodeURIComponent(filter_customer_support_id);
	}
	
	var filter_customer_support_status = $('select[name=\'filter_customer_support_status\']').val();
	
	if (filter_customer_support_status) {
		url += '&filter_customer_support_status=' + encodeURIComponent(filter_customer_support_status);
	}
	var filter_cs_category_id = $('select[name=\'filter_cs_category_id\']').val();
	
	if (filter_cs_category_id) {
		url += '&filter_cs_category_id=' + encodeURIComponent(filter_cs_category_id);
	}
	
	var filter_customer_subject = $('input[name=\'filter_customer_subject\']').val();
	
	if (filter_customer_subject) {
		url += '&filter_customer_subject=' + encodeURIComponent(filter_customer_subject);
	} 
	
	var filter_date_added = $('input[name=\'filter_date_added\']').val();
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}
		
	location = url;
}
//--></script>
<script type="text/javascript" src="view/javascript/jquery/ui/minified/jquery.ui.datepicker.min.js"></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<?php echo $footer; ?>