<?php

class core {

    private $config;

    private $root;

    private $title = "Мой пульт";

    private $page = "setup";

    private $message = false;

    public function __construct($root) {
        $this->root = $root;
        $this->readPreferences();
    }

    // сохранить настройки
    public function writePreferences() {
        return file_put_contents($this->root . '/config.json', json_encode($this->config, JSON_UNESCAPED_UNICODE));
    }

    // получить настройки
    public function readPreferences() {
        if (file_exists($this->root . '/config.json')) {
            $this->config = file_get_contents($this->root . '/config.json');
            $this->config = json_decode($this->config, true);
        }
    }

    // установить заголовок страницы
    public function setTitle($title) {
        $this->title = htmlspecialchars($title);
    }

    // получить заголовок страницы
    public function getTitle() {
        return $this->title;
    }

    // выбор шаблона для отображение
    public function setTemplate($page) {
        if (!file_exists(sprintf('%s/theme/%s.php', $this->root, $page))) return;
        $this->page = $page;
    }

    // загрузить страницы
    public function loadPage() {
        include sprintf('%s/theme/header.php', $this->root);
        include sprintf('%s/theme/%s.php', $this->root, $this->page);
        include sprintf('%s/theme/footer.php', $this->root);
    }

    // получить список каналов
    public function getChannelsList() {
        return $this->config['list'];
    }

    // создать канал
    public function createChannel($link, $data) {
        $this->config['list'][htmlspecialchars($link)] = [];
        return $this->editChannel($link, $data);
    }

    // изменить канал
    public function editChannel($link, $data) {
        $link = htmlspecialchars($link);

        if (!$this->isChannel($link)) return false;
        
        foreach ($data as $key => $value) $data[htmlspecialchars($key)] = htmlspecialchars($value);
        
        if (!isset($data['name']) || $data['name'] == '') {
            return [
                'err' => 'Не заполнено имя!'
            ];
        }

        if (!isset($data['image']) || $data['image'] == '') {
            $data['image'] = 'theme/images/favicon.png';
        }

        if (!isset($data['background']) || $data['background'] == '') {
            $data['background'] = '#fff';
        }

        $this->config['list'][$link] = $data;
        $this->writePreferences();

        return true;
    }

    // удалить канал
    public function removeChannel($link) {
        $link = htmlspecialchars($link);

        if (!$this->isChannel($link)) return false;

        unset($this->config['list'][$link]);
        $this->writePreferences();

        return true;
    }

    // проверить, существует ли канал
    public function isChannel($link) {
        $link = htmlspecialchars($link);

        if (isset($this->config['list'][$link])) return true;
        else return false;
    }

    // получить данные канала
    public function getChannelData($link, $field = false) {
        $link = htmlspecialchars($link);

        if ($field !== false) return $this->config['list'][$link][htmlspecialchars($field)];
        return $this->config['list'][$link];
    }

    // установить сообщение формы
    public function setMessage($message, $class) {
        $this->message = sprintf('<div class="%s">%s</div>', $class, $message);
    }

    // получить сообщение формы
    public function getMessage() {
        return $this->message;
    }

    // запустить канал
    public function setChannel($link) {
        $link = htmlspecialchars($link);
        
        if (!$this->isChannel($link)) return false;
        if ($this->config['list'][$link]['url'] == '') $this->config['list'][$link]['url'] = getcwd() . '/theme/images/favicon.png';
        
        var_dump(shell_exec(getcwd() . '/run_player.sh ' . escapeshellarg($this->config['list'][$link]['url']) . ' 2>&1'));
    }

    // получить относительный URL домашней страницы
    public function getHome() {
        return $this->config['home'];
    }

    // запустить установку (если отсутствует конфигурация)
    public function setup() {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);

        $err = false;

        if (!isset($this->config['home']) || $this->config['home'] != $url[0] ||
            (!is_writable($this->root . '/config.json') || !chmod($this->root . '/config.json', 0666)) ||
            !is_writable('/dev/vchiq')) $err = true;

        if ($err) {
            $this->config['home'] = $url[0];

            chmod($this->root . '/run_player.sh', 0777);
            chmod($this->root . '/splash.sh', 0777);

            $this->writePreferences();

            $this->setTitle('Первый запуск');
            $this->setTemplate('setup');
        }
    }
}

?>