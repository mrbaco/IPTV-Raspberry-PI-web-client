<?php echo $this->getFormMessage(); ?>
<form action="" method="post">
    <p>
        <label>
            Название:<br />
            <input autocomplete="off" type="text" name="name" value="<?php echo isset($_GET['link']) ? $this->getChannelData($_GET['link'], 'name') : ''; ?>" />
        </label>
    </p>
    <p>
        <label>
            Ссылка на логотип:<br />
            <input autocomplete="off" type="text" name="image" value="<?php echo isset($_GET['link']) ? $this->getChannelData($_GET['link'], 'image') : ''; ?>" />
        </label>
    </p>
    <p>
        <label>
            Цвет фона:<br />
            <input autocomplete="off" type="text" name="background" value="<?php echo isset($_GET['link']) ? $this->getChannelData($_GET['link'], 'background') : ''; ?>" />
        </label>
        <?php

        if (isset($_GET['link']) &&  $this->getChannelData($_GET['link'], 'image') != '') {
            echo sprintf('<div class="channel" style="background-image: url(\'%s\'); background-color: %s;"></div>',
                $this->getChannelData($_GET['link'], 'image'),
                $this->getChannelData($_GET['link'], 'background')
            );
        }

        ?>
    </p>
    <p>
        <label>
            Ссылка на трансляцию:<br />
            <input autocomplete="off" type="text" name="url" value="<?php echo isset($_GET['link']) ?  $this->getChannelData($_GET['link'], 'url') : ''; ?>" />
        </label>
    </p>
    <input type="submit" value="Сохранить" /><?php echo isset($_GET['link']) ? '&nbsp;<a onclick="if (!confirm(\'Вы действительно хотите удалить канал?\')) return false;" href="?r=preferences&remove=' . htmlspecialchars($_GET['link']) . '">Удалить канал</a>' : ''; ?>
</form>
<?php if (isset($_GET['r'])) include ROOT . '/theme/back.php'; ?>