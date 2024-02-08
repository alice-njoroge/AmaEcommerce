<?php

namespace App\Controller;

use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\SimpleType\DocProtect;
use PhpOffice\PhpWord\Style\Font;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class ExportDocumentsController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/export-products', name: 'app_export', methods: ['GET'])]
    public function exportProducts(): JsonResponse
    {
        // new instance of the word document
        $phpWord = new PhpWord();
        Settings::setDefaultPaper('Letter');
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(20);
        // password protection
        $documentProtection = $phpWord->getSettings()->getDocumentProtection();
        $documentProtection->setEditing(DocProtect::READ_ONLY);
        $documentProtection->setPassword('myPass');

        // any element you append to a document must reside inside of a Section
        $section = $phpWord->addSection();

        // Adding Text element to the Section having font styled by default...
        $section->addText(
            '"Learn from yesterday, live for today, hope for tomorrow. '
            .'The important thing is not to stop questioning." '
            .'(Albert Einstein)'
        );

        // Adding Text element with font customized inline...
        $section->addText(
            '"Great achievement is usually born of great sacrifice, '
            .'and is never the result of selfishness." '
            .'(Napoleon Hill)',
            ['name' => 'Tahoma', 'size' => 10, 'color' => '008080']
        );

        // Adding Text element with font customized using named font style...
        $fontStyleName = 'oneUserDefinedStyle';
        $phpWord->addFontStyle(
            $fontStyleName,
            ['name' => 'Tahoma', 'size' => 10, 'color' => '008080', 'bold' => true]
        );
        $section->addText(
            '"The greatest accomplishment is not in never falling, '
            .'but in rising again after you fall." '
            .'(Vince Lombardi)',
            $fontStyleName
        );

        // Adding Text element with font customized using explicitly created font style object...
        $fontStyle = new Font();
        $fontStyle->setBold(true);
        $fontStyle->setName('Tahoma');
        $fontStyle->setSize(13);
        $fontStyle->setColor('008080');
        $myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
        $myTextElement->setFontStyle($fontStyle);

        // Saving the document as OOXML file...
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('helloWorld.docx');

        // Saving the document as HTML file...
        $objWriter = IOFactory::createWriter($phpWord, 'HTML');
        $objWriter->save('helloWorld.html');

        // Saving the document as ODF file...
        $objWriter = IOFactory::createWriter($phpWord, 'ODText');
        $objWriter->save('helloWorld.odt');


        return new JsonResponse(['message' => 'exported!!']);
    }
}
