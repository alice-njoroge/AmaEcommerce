<?php

namespace App\Controller;

use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
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
        $phpWord->setDefaultFontSize(12);

        $sectionStyle = [
            'orientation' => 'landscape',
            'marginTop' => 600,
            'colsNum' => 2,
        ];

        $sectionStyle2 = [
            'font' => 'Helvetica',
            'color' => '008080',
            'marginTop' => 600,
            'colsNum' => 2,
            'breakType' => 'continuous',
        ];

        $section = $phpWord->addSection($sectionStyle);
        $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');

        $header = $section->addHeader();
        $footer = $section->addFooter();
        $header->addText('Lorem Ipsum headerrrrrrr');
        $footer->addText('Lorem Ipsum fooooooteeeeer');

        $tableStyle = [
            'borderColor' => '006699',
            'borderSize' => 6,
            'cellMargin' => 50,
            'bgColor' => '66BBFF',
        ];
        $firstRowStyle = ['bgColor' => '66BBFF'];
        $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);
        $table = $section->addTable('myTable');

        $cellStyles = [
            'bgColor' => '9966CC',
            'gridSpan' => 3
        ];
        $table->addRow()->getStyle()->setTblHeader();
        $table->addCell(2000, $cellStyles)->addText('Name');
        $table->addCell(2000)->addText('Age');
        $table->addCell(2000)->addText('Email');
        $table->addCell(2000)->addText('Phone');
        $table->addRow();
        $table->addCell(2000)->addText('John Doe');
        $table->addCell(2000)->addText('30');
        $table->addCell(2000)->addText('johndoe@example.com');
        $table->addCell(2000)->addText('1234567890');

        $section1 = $phpWord->addSection($sectionStyle2);
        $section1->getStyle()->setPageNumberingStart(5);
        $section1->addText(' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eget ante nulla. Nam et mattis lectus. Nulla at turpis eget felis sagittis iaculis vitae vitae lorem. Ut aliquam arcu eu elit elementum, ut volutpat nisi placerat. Nam semper odio et est consectetur, ac tempus risus rhoncus. Quisque quis nibh mauris. Maecenas massa risus, tempus quis metus accumsan, finibus varius dolor. Vivamus at nisl a arcu tempor luctus. Nam at erat efficitur, semper erat at, lobortis nulla. Sed ac turpis lacus. Fusce est urna, volutpat a magna ac, pulvinar ultricies felis. Nulla pharetra ac felis non rhoncus. Duis commodo gravida orci, sed vulputate turpis congue eu. Sed egestas augue consectetur, bibendum nisl ut, tincidunt tortor. Nunc semper fermentum neque quis vulputate. Phasellus ornare massa a ante tincidunt, a porttitor mauris commodo.

Nulla nisi augue, tristique id suscipit quis, semper et ipsum. Aliquam sit amet porttitor eros. Nullam at interdum neque. Donec nibh lectus, pharetra eget sagittis ac, rhoncus a mi. Aliquam eget tellus a libero consectetur placerat. Phasellus in sapien metus. In elementum tortor est, et lobortis urna sodales a. Nulla mollis quis augue id vehicula.');

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
