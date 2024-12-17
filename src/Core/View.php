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

        // Set visibility flags based on the template
        $show_nav = ($template !== 'login.html');
        $show_footer = ($template !== 'login.html');

        if (file_exists($layoutPath)) {
            ob_start();
            include $layoutPath;
            $layoutContent = ob_get_clean();

            // Replace placeholders
            $layoutContent = str_replace('{{ page_css }}', $page_css, $layoutContent);
            $layoutContent = str_replace('{{ content }}', $content, $layoutContent);
            $layoutContent = str_replace('{{ page_js }}', $page_js, $layoutContent);
            $layoutContent = str_replace('{{ title }}', htmlspecialchars($title), $layoutContent);

            // Replace visibility flags with PHP logic
            $layoutContent = str_replace('{{ show_nav }}', $show_nav, $layoutContent);
            $layoutContent = str_replace('{{ show_footer }}', $show_footer, $layoutContent);

            echo $layoutContent;
        } else {
            echo "Layout not found: layout.html";
        }
    }
}
