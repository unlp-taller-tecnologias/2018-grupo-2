<?php

namespace MewesK\TwigExcelBundle\Tests\Twig;

/**
 * Class PdfTwigTest
 * @package MewesK\TwigExcelBundle\Tests\Twig
 */
class PdfTwigTest extends AbstractTwigTest
{
    protected static $TEMP_PATH = '/../../tmp/pdf/';

    //
    // PhpUnit
    //

    /**
     * @return array
     */
    public function formatProvider()
    {
        return [['pdf']];
    }

    //
    // Tests
    //


    /**
     * @param string $format
     * @throws \Exception
     *
     * @dataProvider formatProvider
     */
    public function testBasic($format)
    {
        // Skip PDF test for nightly builds of PHP since mPDF doesn't work
        if (version_compare(phpversion(), '7.0.0-dev', '>=')) {
            return;
        }

        $path = $this->getDocument('cellProperties', $format);

        static::assertFileExists($path, 'File does not exist');
        static::assertGreaterThan(0, filesize($path), 'File is empty');
    }
}
