<?php

/**
     * SVG output example
     *
     * @created      21.12.2017
     * @author       Smiley <smiley@chillerlan.net>
     * @copyright    2017 Smiley
     * @license      MIT
     *
     * @noinspection PhpComposerExtensionStubsInspection
     */
    use chillerlan\QRCode\{QRCode, QROptions};
    use chillerlan\QRCode\Data\QRMatrix;
    use chillerlan\QRCode\Output\QRGdImagePNG;

function generateQRcode($orderId, $tableNum) {

    $baseUrl= getenv('app.baseURL');
    $data = $baseUrl . '/onlineorder' . '/' .  $orderId . '/' . $tableNum;

    $options = new QROptions;

    $options->version              = 7;
    $options->outputInterface      = QRMarkupSVG::class;
    $options->outputBase64         = false;
    // if set to false, the light modules won't be rendered
    $options->drawLightModules     = false;
    $options->svgUseFillAttributes = false;
    // draw the modules as circles isntead of squares
    $options->drawCircularModules  = true;
    $options->circleRadius         = 0.4;
    // connect paths
    $options->connectPaths         = true;
    // keep modules of these types as square
    $options->keepAsSquare         = [
        QRMatrix::M_FINDER_DARK,
        QRMatrix::M_FINDER_DOT,
        QRMatrix::M_ALIGNMENT_DARK,
    ];
    // https://developer.mozilla.org/en-US/docs/Web/SVG/Element/linearGradient
    $options->svgDefs             = '
        <linearGradient id="rainbow" x1="1" y2="1">
            <stop stop-color="#e2453c" offset="0"/>
            <stop stop-color="#e07e39" offset="0.2"/>
            <stop stop-color="#e5d667" offset="0.4"/>
            <stop stop-color="#51b95b" offset="0.6"/>
            <stop stop-color="#1e72b7" offset="0.8"/>
            <stop stop-color="#6f5ba7" offset="1"/>
        </linearGradient>
        <style><![CDATA[
            .dark{fill: url(#rainbow);}
            .light{fill: #eee;}
        ]]></style>';

    $out = (new QRCode($options))->render($data);

    header('Content-type: image/svg+xml');

    return $out;
}
    
