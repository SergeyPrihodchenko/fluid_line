<?php

namespace Fluid\Line;

class ConunterLetters {

    private const LIBRARY_PATH = __DIR__.'/../library/';

    private function counterLetter(string $filePath): string
    {

        $string = file_get_contents($filePath);

        $letter = mb_substr($string, 0, 1);

        $arr = preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);

        $mathes = preg_grep("/$letter/i", $arr);

        $count = count($mathes);

        return "Количество $letter символов:   $count";
    }

    private function writeCountLetter(string $path, string $string)
    {
        $result = file_put_contents($path, $string, FILE_APPEND | LOCK_EX);

        return $result;
    }

    public function counterLettres(string $dirPath = self::LIBRARY_PATH)
    {
        if(!is_dir($dirPath)) {
            return false;
        }

        $stream = opendir($dirPath);

        while (($item = readdir($stream)) !== false) {

            if ($item !== '.' && $item !== '..') {

                $path = $dirPath . '/' . $item;

                if (is_file($path)) {

                    $this->writeCountLetter($path, $this->counterLetter($path));

                } elseif (is_dir($path)) {

                    $this->counterLettres($path);

                } else {

                    echo "$item - другой тип \n";
                    
                }
            }
        }
    }
}