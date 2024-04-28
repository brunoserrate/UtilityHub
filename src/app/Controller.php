<?php

namespace App;

class Controller {
    protected $template = "clean_default";
    protected $cdns = [
        'css' => [
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        ],
        'js' => [
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        ]
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

    protected function setCSS($css) {
        $this->cdns['css'][] = $css;
    }
}