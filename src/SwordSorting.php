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
        if(!is_dir(SwordSorting::LIBRARY_PATH)) {
            mkdir(SwordSorting::LIBRARY_PATH);
        }

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

}