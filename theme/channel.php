<?php

echo sprintf('<a href="?r=%s&link=%s" class="channel%s" style="background-image: url(\'%s\'); background-color: %s;" title="%s"></a>',
                (isset($_GET['r']) && $_GET['r'] == 'preferences' ? 'preferences' : 'setChannel'),
                $link,
                (isset($_GET['r']) && $_GET['r'] == 'setChannel' && $_GET['link'] == $link ? ' selected' : ''),
                $channel['image'],
                $channel['background'],
                $channel['name']
            ) . PHP_EOL;

?>