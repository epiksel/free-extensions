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
        
        <div class="account_left_column"><img src="catalog/view/theme/<?php echo $this->config->get('config_template') ?>/image/account/delivery.png" alt="<?php echo $text_address; ?>"><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a><br><?php echo $text_address; ?></div>
        
        <div class="account_right_column"><img src="catalog/view/theme/<?php echo $this->config->get('config_template') ?>/image/account/wishlist.png" alt="<?php echo $text_wishlist; ?>"><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a><br><?php echo $text_wishlist; ?></div>
      </ul>
    </div>
    <h2><?php echo $text_my_orders; ?></h2>
    <div class="content">
      <ul>
        <div class="account_left_column"><img src="catalog/view/theme/<?php echo $this->config->get('config_template') ?>/image/account/orders.png" alt="Order History"><a href="<?php echo $order; ?>"><?php echo $text_my_orders; ?></a><br><?php echo $text_order; ?></div>
        
        <div class="account_right_column"><img src="catalog/view/theme/<?php echo $this->config->get('config_template') ?>/image/account/download.png" alt="<?php echo $text_download; ?>"><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a><br><?php echo $text_download; ?></div>
        <?php if ($reward) { ?>
        <div class="account_left_column"><img src="catalog/view/theme/<?php echo $this->config->get('config_template') ?>/image/account/reward.png" alt="<?php echo $text_reward; ?>"><a href="<?php echo $reward; ?>"><?php echo $text_reward; ?></a><br><?php echo $text_reward; ?></div>
        <?php } ?>
        <div class="account_right_column"><img src="catalog/view/theme/<?php echo $this->config->get('config_template') ?>/image/account/return.png" alt="<?php echo $text_return; ?>"><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a><br><?php echo $text_return; ?></div>
        
        <div class="account_left_column"><img src="catalog/view/theme/<?php echo $this->config->get('config_template') ?>/image/account/trans.png" alt="<?php echo $text_transaction; ?>"><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a><br><?php echo $text_transaction; ?></div>
      </ul>
    </div>
    <h2><?php echo $text_my_newsletter; ?></h2>
    <div class="content">
      <ul>
        <div class="account_left_column"><img src="catalog/view/theme/<?php echo $this->config->get('config_template') ?>/image/account/newsletter.png" alt="<?php echo $text_my_newsletter; ?>"><a href="<?php echo $newsletter; ?>"><?php echo $text_my_newsletter; ?></a><br><?php echo $text_newsletter; ?></div>
      </ul>
    </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?> 