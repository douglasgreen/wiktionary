<?php

namespace Wiktionary;

use Exception;

/**
 * @class Read and process pages from a compressed file.
 *
 * This class reads pages from a compressed file using the bzip2 format.  It
 * provides methods to retrieve individual pages from the file for processing.
 */
class PageReader {
    /**
     * @var string The name of the file to read from.
     */
    private $fileName;

    /**
     * @var resource The file handle for the bzip2 compressed file.
     */
    private $bz;

    /**
     * @var array The buffer for storing partial page data.
     */
    private $parts = '';

    /**
     * Constructor for the PageReader class.
     *
     * @param string $fileName The name of the file to read from.
     *
     * @throws Exception If the file cannot be opened.
     */
    public function __construct(string $fileName) {
        $this->fileName = $fileName;
        $this->openFile();
    }

    /**
     * Retrieves the next page from the file.
     *
     * @return string|null The page content, or null if the end of the file is reached.
     */
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

            $page = null;
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

    /**
     * Opens the compressed file for reading.
     *
     * @throws Exception If the file cannot be opened.
     */
    private function openFile(): void {
        $this->bz = bzopen($this->fileName, "r");
        if (!$this->bz) {
            throw new Exception("Couldn't open {$this->fileName}");
        }
    }
}
