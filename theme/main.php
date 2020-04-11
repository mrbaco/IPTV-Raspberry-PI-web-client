<?php echo $this->getMessage(); ?>

<div class="channels">

    <?php

    $channels = $this->getChannelsList();
    if (sizeof($channels)) {
        foreach ($channels as $link => $channel) {
            include ROOT . '/theme/channel.php';
        }
    }

    ?>

    <?php if ((isset($_GET['r']) && $_GET['r'] != 'preferences') || !isset($_GET['r'])) { ?>

    <a href="?r=preferences&new" class="control new"></a>
    <a href="?r=preferences" class="control preferences"></a>

    <?php } ?>

    <div class="clear"></div>
</div>
<?php if (isset($_GET['r']) && $_GET['r'] == 'preferences') include ROOT . '/theme/back.php'; ?>