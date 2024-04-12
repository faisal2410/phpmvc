<?php

declare(strict_types=1);

namespace Framework;

class MVCTemplateViewer implements TemplateViewerInterface
{
    public function render(string $template, array $data = []): string
    {
        $code = file_get_contents(dirname(__DIR__, 2) . "/views/$template");

        $code = $this->replaceVariables($code);

        return $code;
/*
        extract($data, EXTR_SKIP);

        ob_start();

        require dirname(__DIR__, 2) . "/views/$template";

        return ob_get_clean();
*/
    }

    private function replaceVariables(string $code): string
    {
        return preg_replace("#{{\s*(\S+)\s*}}#", "<?= htmlspecialchars(\$$1) ?>", $code);
    }
}