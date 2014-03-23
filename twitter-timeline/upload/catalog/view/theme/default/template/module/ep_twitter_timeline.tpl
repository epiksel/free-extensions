<script src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: <?php echo $tweet_count; ?>,
  interval: 30000,
  width: '<?php echo $widget_width; ?>',
  height: '<?php echo $widget_height; ?>',
  theme: {
    shell: {
      background: '#<?php echo $shell_background; ?>',
      color: '#<?php echo $shell_color; ?>'
    },
    tweets: {
      background: '#<?php echo $tweet_background; ?>',
      color: '#<?php echo $tweet_color; ?>',
      links: '#<?php echo $tweet_links; ?>'
    }
  },
  features: {
    scrollbar: <?php echo ($scrollbar == '0' ? 'false' : 'true'); ?>,
    loop: <?php echo ($loop == '0' ? 'false' : 'true'); ?>,
    live: <?php echo ($live == '0' ? 'false' : 'true'); ?>,
    behavior: 'all'
  }
}).render().setUser('<?php echo $twitter_username; ?>').start();
</script>