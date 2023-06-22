<?php

namespace Legebeker\SmartyLinter;

class Linter
{
    public final function run($argv)
    {
        $this->checkFiles($argv);
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
        return glob(__DIR__ . '/../../../*.tpl');
    }

    private function checkFile($file)
    {
        echo $file . PHP_EOL;
        // $contents = file_get_contents($file);
        // $this->checkContents($contents);
    }
}
