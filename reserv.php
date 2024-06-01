<?php

// // Проверка, если скрипт был запущен через CLI
// if (php_sapi_name() === 'cli') {
//     // Обработка аргументов, переданных через CLI
//     $options = getopt('f:');

//     if (isset($options['f'])) {
//         $filePath = $options['f'];
//         echo $filePath;
//     } else {
//         echo "Использование: php index.php -f file_path \n";
//         exit();
//     }
// } else {
//     // Обработка запроса, если скрипт был запущен как сервер
//     header('Content-Type: text/plain');
//     echo $content;
// }

// $filePath = __DIR__ . '/russian.txt';

// $encodings = ['ASCII', 'Windows-1251', 'KOI8-R', 'ISO-8859-5', 'ISO-8859-7', 'ISO-8859-6', 'EUC-JP', 'Shift_JIS', 'GB2312', 'Big5'];

// $file = file_get_contents($filePath, false, null, 0, 100);

// $typeEncoding = mb_detect_encoding($file, $encodings, true);

// if (array_search($typeEncoding, $encodings)) {

//     $fullFile = file_get_contents($filePath);

//     $encodinfData = mb_convert_encoding($fullFile, 'UTF-8', $typeEncoding);

//     file_put_contents('UTF-8_'.basename($filePath), $encodinfData);
// }

// if(file_exists('UTF-8_'.basename($filePath))) {

//     $stream = fopen('UTF-8_'.basename($filePath), 'r');

//     $sumLitters = [];

//     while($sword = fgets($stream)) {

//         $litter = mb_strtolower(mb_substr($sword, 0, 1));

//         if(!is_dir(__DIR__."/library/$litter")) {
//             mkdir(__DIR__."/library/$litter");
//         }

//         file_put_contents(__DIR__."/library/$litter/swords.txt", $sword, FILE_APPEND | LOCK_EX);

//     }

// }


// if(is_dir(__DIR__."/library")) {
//     rDirConunter(__DIR__."/library");
// }

// function rDirConunter(string $startPath) {

//     if(is_dir($startPath)) {

//         $stream = opendir($startPath);

//         while (($item = readdir($stream)) !== false) {

//             if ($item !== '.' && $item !== '..') {

//                 $path = $startPath . '/' . $item;

//                 if (is_file($path)) {

//                     writeCountLitter($path, counterLitter($path));

//                 } elseif (is_dir($path)) {

//                     rDirConunter($path);

//                 } else {

//                     echo "$item - другой тип\n";
                    
//                 }
//             }
//         }
//     }
// }

// function writeCountLitter(string $path, string $string) {

//     $result = file_put_contents($path, $string, FILE_APPEND | LOCK_EX);

//     return $result;
// }

// function counterLitter(string $filePath): string
// {

//     $string = file_get_contents($filePath);

//     $litter = mb_substr($string, 0, 1);

//     $arr = preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);

//     $mathes = preg_grep("/$litter/i", $arr);

//     $count = count($mathes);

//     return "Количество $litter символов:   $count";
// }