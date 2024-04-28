<?php

namespace App;

class Controller {
    protected $template = "clean_default";
    protected $cdns = [
        'css' => ['css/custom.css'],
        'js' => []
    ];

    protected $title = ENV['APP_NAME'];
    protected $page = '';

    protected function render($view, $data = []) {
        $this->includeDefaultInData($data);

        extract($data);
        include "Views/$view.php";
    }

    protected function renderPartial($view, $data = []) {
        $this->includeDefaultInData($data);

        ob_start();
        include "Views/$view.php";
        $content = ob_get_clean();
        $data['content'] = $content;

        extract($data);

        include "Views/templates/{$this->template}.php";
    }

    protected function includeDefaultInData(&$data) {
        $data['cdns'] = $this->cdns;
        $data['title'] = $this->title . ($this->page ? " - $this->page" : '');
    }

    protected function addCSS($css) {
        $this->cdns['css'][] = "css/$css";
    }

    protected function addJS($js) {
        $this->cdns['js'][] = "js/$js";
    }
}