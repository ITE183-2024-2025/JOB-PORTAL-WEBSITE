<?php

namespace App\Core;

class View
{
    public static function render($template, $data = [])
    {
        $layoutPath = __DIR__ . '/../views/layout/layout.html';
        $templatePath = __DIR__ . '/../views/' . $template;

        extract($data);

        ob_start();
        if (file_exists($templatePath)) {
            include $templatePath;
        } else {
            echo "Template not found: $template";
        }
        $content = ob_get_clean();

        $page_css = $page_css ?? '';
        $page_js = $page_js ?? '';
        $title = $title ?? 'Job Portal';

        // Set sidebar visibility: hide sidebar for login.html
        $sidebar = ($template !== 'login.html') ? true : false;

        if (file_exists($layoutPath)) {
            ob_start();
            include $layoutPath;
            $layoutContent = ob_get_clean();

            $layoutContent = str_replace('{{ page_css }}', $page_css, $layoutContent);
            $layoutContent = str_replace('{{ content }}', $content, $layoutContent);
            $layoutContent = str_replace('{{ page_js }}', $page_js, $layoutContent);
            $layoutContent = str_replace('{{ title }}', htmlspecialchars($title), $layoutContent);

            // Pass the sidebar variable to the layout
            $layoutContent = str_replace('{{ sidebar }}', $sidebar, $layoutContent);

            echo $layoutContent;
        } else {
            echo "Layout not found: layout.html";
        }
    }
}
