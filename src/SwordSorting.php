<?php

namespace Fluid\Line;

class SwordSorting {

    private const LIBRARY_PATH = __DIR__.'/../library/';

    public function __construct(

        private string $filePath

    )
    {
        $this->filePath = $filePath;
    }

    public function swordsSort(): void
    {
        if(file_exists($this->filePath)) {

            $stream = fopen($this->filePath, 'r');

            while($sword = fgets($stream)) {

                $letter = mb_strtolower(mb_substr($sword, 0, 1));

                if(!is_dir(SwordSorting::LIBRARY_PATH.$letter)) {
                    mkdir(SwordSorting::LIBRARY_PATH.$letter);
                }

                file_put_contents(SwordSorting::LIBRARY_PATH."$letter/swords.txt", $sword, FILE_APPEND | LOCK_EX);

            }
        }
    }

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

    public function counterLittres(string $dirPath = self::LIBRARY_PATH)
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

                    $this->counterLittres($path);

                } else {

                    echo "$item - другой тип \n";
                    
                }
            }
        }
    }
}