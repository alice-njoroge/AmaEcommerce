<?php

namespace App\Controller;

use App\Entity\User;
use App\Templates\TemplateFileName;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class ExportDocumentsController extends AbstractController
{
    public function __construct(private readonly TemplateFileName $templateFileName) {}

    /**
     * @throws Exception
     */
    #[Route('/export-products', name: 'app_export', methods: ['GET'])]
    public function exportProducts(): JsonResponse
    {
        $templateProcessor = new TemplateProcessor($this->templateFileName->getTemplateName());
        $user = $this->getUser();
        assert($user instanceof User);

        $templateProcessor->setValue('firstname', $user->getEmail());
        $templateProcessor->setValue('lastname', 'Doe');
        $replacements = [
            ['customer_name' => 'Batman', 'customer_address' => 'Gotham City'],
            ['customer_name' => 'Superman', 'customer_address' => 'Metropolis'],
        ];
        $templateProcessor->cloneBlock('block_name', 0, true, false, $replacements);

        $pathToSave = __DIR__.'/outputSample.docx';
        $templateProcessor->saveAs($pathToSave);

        return new JsonResponse(['message' => 'exported!!']);
    }
}
