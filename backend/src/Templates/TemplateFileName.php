<?php

namespace App\Templates;

class TemplateFileName
{
    private const TEMPLATE_NAME = __DIR__.'/SimpleDoc.docx';

    public function getTemplateName(): string
    {
        return self::TEMPLATE_NAME;
    }
}
