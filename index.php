<?php

require_once(__DIR__.'/vendor/autoload.php');
require_once(__DIR__.'/push.php');

use Fluid\Line\FileConverter;
use Fluid\Line\FileUploader;
use Fluid\Line\SwordSorting;

if (php_sapi_name() === 'cli') {
    // Обработка аргументов, переданных через CLI
    $options = getopt('f:');

    if (isset($options['f'])) {

        $fileName = $options['f'];

        $fConverter = new FileConverter($fileName);

        $file = $fConverter->converter();

        $sworder = new SwordSorting($file);

        $sworder->swordsSort();

        $sworder->counterLittres();

    } else {
        echo "Использование: php index.php -f file_name \n";
        exit();
    }
} else {

try {

    $repo = Repositiry::getRepository('test', 'test', 'test', 'test');

} catch (\Exception $e) {

    echo $e->getMessage();

}

if(!empty($_FILES['file'])) {

    $file = $_FILES['file'];

    $uploader = new FileUploader($file);

    $fileName = $uploader->upload();

    if (isset($fileName)) {
        $fConverter = new FileConverter($fileName);

        $file = $fConverter->converter();

        $sworder = new SwordSorting($file);

        $sworder->swordsSort();

        $sworder->counterLittres();

        return $fileName;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="/" method="post" enctype="multipart/form-data">
        <label for="file">Поддерживаемые форматы: 'ASCII', 'Windows-1251', 'KOI8-R', 'ISO-8859-5', 'ISO-8859-7', 'ISO-8859-6', 'EUC-JP', 'Shift_JIS', 'GB2312', 'Big5'</label>
        <br>  
        <br>  
        <input type="file" name="file" id="file">
        <br>
        <br>
        <button type="submit">загрузить файл</button>
    </form>
</body>
</html>

<?php
    
}

?>


