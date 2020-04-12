<?php

define ('ROOT', dirname(__file__));

include ROOT . '/core.php';

$core = new core(ROOT);

$core->setup();

if (isset($_GET['r'])) {
    // настройки канала
    if ($_GET['r'] == 'preferences') {
        // создание
        if (isset($_GET['new'])) {
            if (isset($_POST['name'])) {
                $r = $core->createChannel(substr(md5(time() . rand(11111, 99999)), -10), [
                    'name' => $_POST['name'],
                    'image' => $_POST['image'],
                    'background' => $_POST['background'],
                    'url' => $_POST['url']
                ]);

                if ($r === true) $core->setMessage('Канал создан!', 'success');
                else $core->setMessage($r['err'], 'warning');
            }

            $core->setTemplate('channel_form');
            $core->setTitle('Новый канал');

        // изменение
        } elseif (isset($_GET['link'])) {
            if (isset($_POST['name'])) {
                $r = $core->editChannel($_GET['link'], [
                    'name' => $_POST['name'],
                    'image' => $_POST['image'],
                    'background' => $_POST['background'],
                    'url' => $_POST['url']
                ]);

                if ($r === true) $core->setMessage('Канал обновлен!', 'success');
                else $core->setMessage($r['err'], 'warning');
            }

            $core->setTemplate('channel_form');
            $core->setTitle('Настройки канала');

        // список каналов с выбором для изменения
        } else {

            // удаление
            if (isset($_GET['remove'])) {
                if ($core->removeChannel($_GET['remove']))
                    $core->setMessage('Канал удален!', 'success');
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