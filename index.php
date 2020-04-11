<?php

define ('ROOT', dirname(__file__));
define ('HOME', '/iptv');

include ROOT . '/core.php';

$core = new core(ROOT);

if (isset($_GET['r'])) {
    // настройки канала
    if ($_GET['r'] == 'preferences') {
        // создание
        if (isset($_GET['new'])) {
            if (isset($_POST['name'])) {
                $r = $core->createChannel(substr(md5(time() . rand(11111, 99999)), -10), [
                    'name' => $_POST['name'],
                    'image' => $_POST['image'],
                    'url' => $_POST['url']
                ]);

                if ($r === true) $core->setFormMessage('Канал создан!', 'success');
                else $core->setFormMessage($r['err'], 'warning');
            }

            $core->setTemplate('channel_form');
            $core->setTitle('Новый канал');

        // изменение
        } elseif (isset($_GET['link'])) {
            if (isset($_POST['name'])) {
                $r = $core->editChannel($_GET['link'], [
                    'name' => $_POST['name'],
                    'image' => $_POST['image'],
                    'url' => $_POST['url']
                ]);

                if ($r === true) $core->setFormMessage('Канал обновлен!', 'success');
                else $core->setFormMessage($r['err'], 'warning');
            }

            $core->setTemplate('channel_form');
            $core->setTitle('Настройки канала');

        // список каналов с выбором для изменения
        } else {

            // удаление
            if (isset($_GET['remove'])) {
                if ($core->removeChannel($_GET['remove']))
                    $core->setFormMessage('Канал удален!', 'success');
            }

            $core->setTemplate('main');
            $core->setTitle('Управление каналами');
        }
    }

    // выбор канала
    if ($_GET['r'] == 'setChannel') {
        $core->setChannel($_GET['link']);
    }
}

$core->loadPage();

?>