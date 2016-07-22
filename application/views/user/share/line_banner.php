<?php
if (time() > mktime(12,0,0,3,18,2015)) {
    if (isset($user_from_site) && ($user_from_site == 1 || $user_from_site == 2)) { ?>
<a href="http://line.me/ti/p/lThmHAV4NV"> <img class="banner" src="<?php echo base_url() ?>public/user/image/linebanner.jpg"> </a>
<?php
    }
}
?>
