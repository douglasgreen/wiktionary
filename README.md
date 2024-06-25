# wiktionary

Process and extract information from
[Wiktionary downloads](https://dumps.wikimedia.org/backup-index.html).

## Project setup

Standard config files for linting and testing are copied into place from a GitHub repository called
[config-setup](https://github.com/douglasgreen/config-setup). See that project's README page for
details.

## Downloading

1. Go to the download page.
2. Click the latest enwiktionary link.
3. Download "Articles, templates, media/file descriptions, and primary meta-pages."
4. Save in data directory.

## Preparing

1. Check if you have bz2 support: `php -m | grep bz2`
2. If not, then install: `sudo apt-get install php-bz2`

## References

-   [Wiktionary:Entry layout](https://en.wiktionary.org/wiki/Wiktionary:Entry_layout)
-   [ENGLAWI: From Human- to Machine-Readable Wiktionary](https://aclanthology.org/2020.lrec-1.369.pdf)
