<?php echo $header; ?>
<script type="text/javascript">
	function fn_submit_form()
	{
		var error = false;
		$("textarea[name='thread_enquiry[]']").each(function(index){
			if($(this).val() == "")
			{
				error = true;
				$(this).focus();
			}
		});
		
		if(error == true)
		{
			alert("There is empty content!");
		}
		else
		{
			$('#form').submit();	
		}
			
	}
</script>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="fn_submit_form();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <input type="hidden" name="customer_support_id" value="<?php echo $customer_support_id;?>" />
        <input type="hidden" name="customer_support_topic_id" value="<?php echo $customer_support_topic_id;?>" />
        <table class="form" style="table-layout: fixed;">
          <tr>
            <td><?php echo $entry_no; ?></td>
            <td><?php echo $customer_support_id;?></td>
          </tr>
          <tr>
            <td><?php echo $entry_store; ?></td>
            <td><?php echo $store_name;?></td>
          </tr>
          <tr>
            <td><?php echo $entry_1st_category; ?></td>
            <td><?php echo $customer_support_1st_category;?></td>
          </tr>
          <tr>
            <td><?php echo $entry_2nd_category; ?></td>
            <td><?php echo $customer_support_2nd_category;?></td>
          </tr>
          <tr>
            <td><?php echo $entry_reference; ?></td>
            <td><?php echo $reference;?></td>
          </tr>
          <tr>
            <td><?php echo $entry_customer; ?></td>
            <td><?php echo $lastname;?>, <?php echo $firstname;?></td>
          </tr>
          <tr>
            <td><?php echo $entry_subject; ?></td>
            <td><?php
          		if($status == 0)
          		{
          			echo "<s>";
          		} 
          		echo $subject;
          		if($status == 0)
          		{
          			echo "</s> Deleted by customer";
          		} 
          	?></td>
          </tr>
          <tr>
            <td><?php echo $entry_enquiry; ?></td>
            <td><?php echo nl2br($enquiry);?></td>
          </tr>
          <?php
			if(!empty($threads))
			{
				foreach($threads as $key2 => $thread)
        		{
		?>
          <tr>
            <td><?php
					if($thread['customer_id'] == 0)
					{
						echo $text_answered;
					}
					else
					{
						echo $thread['firstname']." ".$thread['lastname'];
					}
				?></td>
            <td><?php
					if($thread['customer_id'] == 0)
					{
				?>
              <input type="hidden" name="thread_customer_support_id[]" value="<?php echo $thread['customer_support_id'];?>" />
              <textarea name="thread_enquiry[]" style="width:95%;height:150px;"><?php echo $thread['enquiry'];?></textarea>
              <br />
              (<?php echo $entry_date_added; ?> <?php echo $thread['date_added'];?>)
              <?php
					}
					else
					{
				?>
              <?php echo $thread['enquiry'];?> <br />
              (<?php echo $entry_date_added; ?> <?php echo $thread['date_added'];?>)
              <?php
					}
				?></td>
          </tr>
          <?php
        		}
        	}
        ?>
          <tr>
            <td><?php echo $entry_customer_support_status; ?></td>
            <td><select name="customer_support_status">
                <?php 
          		foreach($list_customer_support_status as $status)
          		{
          	?>
                <option value="<?php echo $status;?>" <?php echo (strcasecmp($status, $customer_support_status) == 0 ? "selected='selected'": ""); ?>><?php echo $status;?></option>
                <?php
          		}
          	?>
              </select></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_answer; ?></td>
            <td><textarea name="answer" style="width:95%;height:150px;"><?php echo $answer; ?></textarea>
              <?php if ($error_answer) { ?>
              <span class="error"><?php echo $error_answer; ?></span>
              <?php } ?>
              <br />
              <input type="checkbox" name="notify_customer" value="notify" />
              &nbsp;<?php echo $text_notify_customer;?></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>