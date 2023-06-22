<?php

namespace Legebeker\SmartyLinter;

use Legebeker\SmartyLinter\Checker;

class Linter
{
    private int $errors = 0;
    private string $basePath;

    public final function run($argv)
    {
        echo 'Smarty Linter' . PHP_EOL;
        $this->basePath = realpath(__DIR__ . '/../../../../');
        $this->checkFiles($argv);
        echo 'Done. ' . $this->errors . ' errors found.' . PHP_EOL;
    }

    private function checkFiles($argv)
    {
        $files = $this->getFiles();
        foreach ($files as $file) {
            $this->checkFile($file);
        }
    }

    private function getFiles()
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->basePath, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        $templateFiles = [];
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'tpl' && !strpos($file->getPathname(), '/vendor/')) {
                $templateFiles[] = $file->getPathname();
            }
        }

        return $templateFiles;
    }

    private function checkFile($file)
    {
        $contents = file_get_contents($file);
        $filepath = substr($file, strlen($this->basePath) + 1);

        $this->checkContents($contents, $filepath);
    }

    private function checkContents($contents, $filepath)
    {
        // all checks go here
        $this->errors += Checker::checkTrailingWhitespace($contents, $filepath);
        $this->errors += Checker::checkTrailingNewline($contents, $filepath);
        $this->errors += Checker::checkMoreThanOneWhitespace($contents, $filepath);
        $this->errors += Checker::containsComment($contents, $filepath);
        $this->errors += Checker::checkLineLength($contents, $filepath);
        $this->errors += Checker::checkIndentation($contents, $filepath);
    }
}
