<?php

class View
{
    private $layout = null;

    private $view_path = '';

    private $data = [];

    /**
     * View constructor.
     */
    public function __construct()
    {
        $this->view_path = dirname(dirname(__FILE__)) . '/views/';
        $this->data = [
            'scripts' => []
        ];
    }

    /**
     * Установка лайаута
     *
     * @param $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * Установка данных для шаблона
     *
     * @param $name
     * @param $value
     */
    public function setData($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Добавление js в очередь
     *
     * @param $script
     */
    public function addJs($script)
    {
        if (strpos($script, '<script') === false) {
            $script = '<script src = "' . $script . '"></script>';
        }

        $this->data['scripts'][] = $script;
    }

    /**
     * Вывод всех js из очереди
     *
     * @return string
     */
    public function js()
    {
        return implode("\n", $this->data['scripts']);
    }

    /**
     * Рендеринг шаблона
     *
     * @param $template
     * @param array $data
     * @return false|string
     */
    public function fetch($template, $data = [])
    {
        $data = array_merge($this->data, $data);
        extract($data);
        ob_start();
        $filepath = $this->view_path . $template . '.php';
        if (file_exists($filepath)) {
            include $filepath;
        } else {
            include($this->view_path . '404.php');
        }

        return ob_get_clean();
    }

    /**
     * Рендер и вывод шаблона с учетом лайаута
     *
     * @param $template
     * @param $data
     */
    public function render($template, $data)
    {
        $content = $this->fetch($template, $data);
        if ($this->layout) {
            $content = $this->fetch($this->layout, array_merge($data, array('content' => $content)));
        }

        echo $content;
    }
}
