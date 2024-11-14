<?php

namespace App\Core;

class View
{
    public static function render($template, $data = [])
    {
        $layoutPath = __DIR__ . '/../Views/layout/layout.html';
        $templatePath = __DIR__ . '/../Views/' . $template;

        // Extract data for use in the template
        extract($data);

        // Capture the content and include page-specific CSS and JS
        ob_start();
        if (file_exists($templatePath)) {
            include $templatePath;
        } else {
            echo "Template not found: $template";
        }
        $content = ob_get_clean();

        // Define page-specific CSS and JS variables for layout
        $page_css = $page_css ?? '';
        $page_js = $page_js ?? '';
        $title = $title ?? 'Default Title';

        // Load and render layout with replacements
        if (file_exists($layoutPath)) {
            ob_start();
            include $layoutPath;
            $layoutContent = ob_get_clean();

            // Replace placeholders in layout
            $layoutContent = str_replace('{{ page_css }}', $page_css, $layoutContent);
            $layoutContent = str_replace('{{ content }}', $content, $layoutContent);
            $layoutContent = str_replace('{{ page_js }}', $page_js, $layoutContent);
            $layoutContent = str_replace('{{ title }}', htmlspecialchars($title), $layoutContent);

            echo $layoutContent;
        } else {
            echo "Layout not found: layout.html";
        }
    }
}
