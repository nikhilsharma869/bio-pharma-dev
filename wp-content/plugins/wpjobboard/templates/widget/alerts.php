<?php echo $theme->before_widget ?>
<?php if($title) echo $theme->before_title.$title.$theme->after_title ?>

<form action="<?php esc_attr_e(wpjb_link_to("alert_confirm")) ?>" method="post">
<input type="hidden" name="add_alert" value="1" />
<ul id="wpjb_widget_alerts" class="wpjb_widget">
    <li>
        <?php _e("Keyword", WPJB_DOMAIN) ?>: <br />
        <input type="text" name="keyword" value="" />
    </li>
    <li>
        <?php _e("E-mail", WPJB_DOMAIN) ?>: <br />
        <input type="text" name="email" value="" />
    </li>
    <li>
        <input type="submit" value="<?php _e("Add Alert", WPJB_DOMAIN) ?>" />
    </li>

</ul>
</form>

<?php echo $theme->after_widget ?>