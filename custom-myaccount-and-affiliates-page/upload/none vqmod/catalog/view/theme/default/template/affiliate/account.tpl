<?php echo $header; ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <h2><?php echo $text_my_account; ?></h2>
  <div class="content">
    <ul>
      <div class="account_left_column"><img src="catalog/view/theme/<?php echo $this->config->get('config_template') ?>/image/account/edit.png" alt="<?php echo $text_edit; ?>"><a href="<?php echo $edit; ?>"><?php echo $text_my_account; ?></a><br><?php echo $text_edit; ?></div>
      <div class="account_right_column"><img src="catalog/view/theme/<?php echo $this->config->get('config_template') ?>/image/account/password.png" alt="<?php echo $text_password; ?>"><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a><br><?php echo $text_password; ?></div>
      <div class="account_left_column"><img src="catalog/view/theme/<?php echo $this->config->get('config_template') ?>/image/account/payment.png" alt="<?php echo $text_payment; ?>"><a href="<?php echo $payment; ?>"><?php echo $text_payment; ?></a><br><?php echo $text_payment; ?></div>
    </ul>
  </div>
  <h2><?php echo $text_my_tracking; ?></h2>
  <div class="content">
    <ul>
      <div class="account_left_column"><img src="catalog/view/theme/<?php echo $this->config->get('config_template') ?>/image/account/tracking.png" alt="<?php echo $text_tracking; ?>"><a href="<?php echo $tracking; ?>"><?php echo $text_tracking; ?></a><br><?php echo $text_tracking; ?></div>
    </ul>
  </div>
  <h2><?php echo $text_my_transactions; ?></h2>
  <div class="content">
    <ul>
      <div class="account_left_column"><img src="catalog/view/theme/<?php echo $this->config->get('config_template') ?>/image/account/trans.png" alt="<?php echo $text_transaction; ?>"><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a><br><?php echo $text_transaction; ?></div>
    </ul>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>