<?php echo $this->getMessage(); ?>
<div class="info">
    <p>Привет! Похоже, это первый запуск системы.</p>
    <?php if ($this->getMessage() !== false) { ?>
    <p>
        Судя по сообщению сверху, у вас не хватает прав на запись в файл config.json. Выполните команду:
        <div class="code">
            sudo chmod guo+rw <?php echo getcwd(); ?>/config.json
        </div>
    </p>
    <?php } ?>
    <p>Для продолжения работы &ndash; перезагрузите страницу.</p>
</div>