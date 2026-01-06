<?php

error_reporting(E_ALL);

header('Content-Type: text/plain; charset=utf-8');

try {
    
    $programId = $_REQUEST['programId'];
    echo 'Program Id: '.$programId;
    $token = $_REQUEST['token'];
    $programName = $_REQUEST['programName'];
    $programDescription = $_REQUEST['programDescription'];

    //FIXME: Fail and report error if programId is not present or doesn't match token

    //FIXME : Check whether the program id is a blank media card.

    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES['upfile']['error']) ||
        is_array($_FILES['upfile']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check $_FILES['upfile']['error'] value.
    switch ($_FILES['upfile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here. 
    if ($_FILES['upfile']['size'] > 1000000) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES['upfile']['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        throw new RuntimeException('Invalid file format.');
    }

    // You should name it uniquely.
    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    if (!move_uploaded_file(
        $_FILES['upfile']['tmp_name'],
        sprintf('/home/folk/folk-data/kits/store/media/%s.%s',
            $programId,
            $ext
        )
       
    )) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    echo 'File is uploaded successfully.';
    
    $jsonFileName = "/home/folk/folk-data/kits/store/json/". $programId. ".json";

    //Open or create the JSON file.
    $meta =  new stdClass();
    $meta->id = $programId;
    $meta->name = $programName;
    $meta->description = $programDescription;
    $meta->cardType = 'media';
    $meta->mediaType = 'image';  //hard coded for now, FIXME: also video, audio....
    $meta->blackMedia = false;

    $jsonMeta = json_encode($meta);

    $jsonFile = fopen($jsonFileName, "w");
    fwrite($jsonFile, $jsonMeta );
    fclose($jsonFile);

    //Update the media card program to reference the media
    // eg. "Wish $this is a media card which displays the image ". $programId .".". $ext;

    $programFile = "/home/folk/folk-data/program/". $programId. ".folk";
    $newCode = "Wish $this is a media card which displays the image ". $programId .".". $ext;
    fwrite($programFile, $newCode );
    fclose($programFile);

    //TODO: Reload code probably through a curl statement which is a bit hacky.

} catch (RuntimeException $e) {

    echo $e->getMessage();

}

?>