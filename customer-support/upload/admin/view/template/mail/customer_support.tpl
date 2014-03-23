<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title; ?></title>
</head>
<body>
<table style="font-family: Verdana,sans-serif; font-size: 11px; color: #374953; width: 600px;">
  <tr>
    <td align="left"><a href="<?php echo $store_url; ?>" title="<?php echo $store_name; ?>"><img src="<?php echo $logo; ?>" alt="<?php echo $store_name; ?>" style="border: none;" ></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><?php echo $text_greeting; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" style="background-color: #069; color:#FFF; font-size: 12px; font-weight: bold; padding: 0.5em 1em;"><?php echo $text_category; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left">
    	<?php echo $category;?>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" style="background-color: #069; color:#FFF; font-size: 12px; font-weight: bold; padding: 0.5em 1em;"><?php echo $text_subject; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left">
    	<?php echo $subject;?>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" style="background-color: #069; color:#FFF; font-size: 12px; font-weight: bold; padding: 0.5em 1em;"><?php echo $text_enquiry; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left">
    	<?php echo $enquiry;?>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" style="background-color: #069; color:#FFF; font-size: 12px; font-weight: bold; padding: 0.5em 1em;"><?php echo $text_lead_url; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left">
    	<a href="<?php echo $lead_url;?>" target="_blank"><?php echo $lead_url;?></a>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-size: 10px; border-top: 1px solid #069;"><a href="<?php echo $store_url; ?>" style="color: #069; font-weight: bold; text-decoration: none;"><?php echo $store_name; ?></a> <?php echo $text_powered_by; ?> <a href="http://www.opencart.com" style="text-decoration: none; color: #374953;">OpenCart</a></td>
  </tr>
</table>
</body>
</html>
