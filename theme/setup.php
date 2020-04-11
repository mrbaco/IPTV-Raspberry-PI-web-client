<?php echo $this->getMessage(); ?>
<div class="info">
    <p>Привет! Похоже, это первый запуск системы.</p>
    <?php if (!is_writable($this->root . '/config.json')) { ?>
    <p>
        У вас не хватает прав на запись в файл config.json. Выполните команду:
        <div class="code">
            sudo chmod guo+rw <?php echo getcwd(); ?>/config.json
        </div>
    </p>
    <?php } ?>
    <?php if (!is_writable('/dev/vchiq')) { ?>
    <p>
        У вас не хватает прав на запись в файл /dev/vchiq. Выполните команду:
        <div class="code">
            sudo usermod -a -G video <?php $user = posix_getpwuid(posix_geteuid()); echo $user['name']; ?>
        </div>
    </p>
    <?php } ?>
    <p>Для продолжения работы &ndash; перезагрузите страницу.</p>
</div>