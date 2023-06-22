<?php

namespace Legebeker\SmartyLinter;

class Checker
{
    public static function checkTrailingWhitespace($contents, $filepath): int
    {
        $lines = explode(PHP_EOL, $contents);
        $errors = 0;
        foreach ($lines as $lineNumber => $line) {
            if (preg_match('/\s+$/', $line)) {
                echo 'Trailing whitespace found on line ' . ($lineNumber + 1) . ' of ' . $filepath . PHP_EOL;
                $errors++;
            }
        }
        return $errors;
    }
}
