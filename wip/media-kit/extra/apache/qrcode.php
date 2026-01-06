<?php 
require __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

$writer = new PngWriter();

$programId = $_REQUEST['id'];

// Create QR code
$qrCode = new QrCode(
    data: 'http://192.168.1.34/?id='.$programId.'&token=ADG123232F',
    encoding: new Encoding('UTF-8'),
    errorCorrectionLevel: ErrorCorrectionLevel::Low,
    size: 300,
    margin: 10,
    roundBlockSizeMode: RoundBlockSizeMode::Margin,
    foregroundColor: new Color(0, 0, 0),
    backgroundColor: new Color(255, 255, 255)
);

// Create generic logo

$logo = new Logo(
    path: __DIR__.'/assets/logo.png',
    resizeToWidth: 50,
    punchoutBackground: true
);


// Create generic label
$label = new Label(
    text: 'Blank media card #'.$programId,
    textColor: new Color(0, 0, 0)
);

$result = $writer->write($qrCode, $logo, $label);

// Validate the result
// Please install "khanamiryan/qrcode-detector-decoder" 
//$writer->validateResult($result, 'Life is too short to be generating QR codes');

// Save it to a file
$result->saveToFile('/home/folk/folk-data/kits/store/qrcodes/'. $programId .'.png');


// Directly output the QR code
header('Content-Type: '.$result->getMimeType());
echo $result->getString();


// Generate a data URI to include image data inline (i.e. inside an <img> tag)
$dataUri = $result->getDataUri();
?>