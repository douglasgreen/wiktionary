<?php

namespace Wiktionary;

use Exception;

class PageReader {
    private $fileName;
    private $bz;
    private $parts = '';

    public function __construct(string $fileName) {
        $this->fileName = $fileName;
        $this->openFile();
    }

    private function openFile(): void {
        $this->bz = bzopen($this->fileName, "r");
        if (!$this->bz) {
            throw new Exception("Couldn't open {$this->fileName}");
        }
    }

    public function getPage(): ?string {
        while (!feof($this->bz)) {
            if (!$this->parts) {
                $text = bzread($this->bz, 4096);
                $this->parts = preg_split(
                    '#(<page|</page>)#',
                    $text,
                    -1,
                    PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE
                );
            }

            while ($this->parts) {
                $part = array_shift($this->parts);
                if ($part == '</page>') {
                    // Return the page for processing, and reset $page for the next call
                    $page .= $part;
                    return $page;
                } elseif ($part == '<page') {
                    $page = $part;
                } elseif ($page) {
                    $page .= $part;
                }
            }
        }

        bzclose($this->bz);
        return null;
    }
}
