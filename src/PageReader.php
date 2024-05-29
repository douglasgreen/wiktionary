<?php

declare(strict_types=1);

namespace DouglasGreen\Wiktionary;

class PageReader
{
    /**
     * @var resource The file handle for the bzip2 compressed file.
     */
    private $bzHandle;

    /**
     * @var array The buffer for storing partial page data.
     */
    private array $parts = [];

    /**
     * Constructor for the PageReader class.
     *
     * @param string $fileName The name of the file to read from.
     *
     * @throws \Exception If the file cannot be opened.
     */
    public function __construct(
        private readonly string $fileName
    ) {
        $this->openFile();
    }

    /**
     * Retrieves the next page from the file.
     *
     * @return string|null The page content, or null if the end of the file is reached.
     */
    public function getPage(): ?string
    {
        $page = '';
        while (! feof($this->bzHandle)) {
            if ($this->parts !== []) {
                // Keep reading text while tag is split at end.
                $text = '';
                do {
                    $text .= bzread($this->bzHandle, 1024);
                } while (preg_match('/<[^>]*$/', $text) === 1 && ! feof($this->bzHandle));

                $parts = preg_split(
                    '#(<page|</page>)#',
                    $text,
                    -1,
                    PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE
                );
                if ($parts === false) {
                    throw new \Exception('Bad regexp');
                }

                $this->parts = $parts;
            }

            while ($this->parts !== []) {
                $part = array_shift($this->parts);
                if ($part === '</page>') {
                    // Return the page for processing, and reset $page for the next call
                    $page .= $part;
                    return $page;
                }

                if ($part === '<page') {
                    $page = $part;
                } elseif ($page !== '' && $page !== '0') {
                    $page .= $part;
                }
            }
        }

        bzclose($this->bzHandle);
        return null;
    }

    /**
     * Opens the compressed file for reading.
     *
     * @throws \Exception If the file cannot be opened.
     */
    private function openFile(): void
    {
        $bzHandle = bzopen($this->fileName, 'r');
        if ($bzHandle === false) {
            throw new \Exception("Couldn't open " . $this->fileName);
        }

        $this->bzHandle = $bzHandle;
    }
}
