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

    public static function checkTrailingNewline($contents, $filepath): int
    {
        $errors = 0;
        if (substr($contents, -1) === PHP_EOL) {
            echo 'Trailing newline found in ' . $filepath . PHP_EOL;
            $errors++;
        }
        return $errors;
    }

    public static function checkMoreThanOneWhitespace($contents, $filepath): int
    {
        $errors = 0;
        while (true) {
            if (preg_match('/\n{3,}/', $contents)) {
                echo 'More than 2 consecutive newlines found in ' . $filepath . PHP_EOL;
                $errors++;
            }
            $contents = preg_replace('/ {2,}/', ' ', $contents, -1, $count);
            if ($count === 0) {
                break;
            }
        }
        return $errors;
    }

    public static function containsComment($contents, $filepath): int
    {
        $lines = explode(PHP_EOL, $contents);
        $errors = 0;
        foreach ($lines as $lineNumber => $line) {
            if (strpos($line, '{*') !== false || strpos($line, '<!--') !== false) {
                echo 'Comment found on line ' . ($lineNumber + 1) . ' in ' . $filepath . PHP_EOL;
                $errors++;
            }
        }
        return $errors;
    }

    public static function checkLineLength($contents, $filepath): int
    {
        $lines = explode(PHP_EOL, $contents);
        $errors = 0;
        foreach ($lines as $lineNumber => $line) {
            if (strlen($line) > 150) {
                echo 'Line ' . ($lineNumber + 1) . ' in ' . $filepath . ' is longer than 150 characters.' . PHP_EOL;
                $errors++;
            }
        }
        return $errors;
    }

    public static function checkIndentation($contents, $filepath): int
    {
        $lines = explode(PHP_EOL, $contents);
        $errors = 0;
        foreach ($lines as $lineNumber => $line) {
            if (preg_match('/^\s+/', $line, $matches)) {
                $indentation = strlen($matches[0]);
                if (substr($matches[0], 0, 1) === "\t") {
                    echo 'Tab found on line ' . ($lineNumber + 1) . ' in ' . $filepath . PHP_EOL;
                    $errors++;
                    continue;
                }
                if ($indentation % 4 !== 0) {
                    echo 'Line ' . ($lineNumber + 1) . ' in ' . $filepath . ' has an indentation of ' . $indentation . ' spaces.' . PHP_EOL;
                    $errors++;
                    continue;
                }
                // if (preg_match('/^\s+/', $line, $matches)) {
                //     $indentation = strlen($matches[0]);
                //     if ($indentation % 4 === 0) {
                //         $expectedIndentation = $indentation / 4;
                //         $previousLine = $lines[$lineNumber - 1] ?? '';
                //         if (preg_match('/\{/', $previousLine)) {
                //             $expectedIndentation++;
                //         }
                //         if (preg_match('/\}/', $previousLine)) {
                //             $expectedIndentation--;
                //         }
                //         if (preg_match('/\{/', $line)) {
                //             $expectedIndentation--;
                //         }
                //         if (preg_match('/\}/', $line)) {
                //             $expectedIndentation++;
                //         }
                //         if (preg_match('/\{/', $line) && preg_match('/\}/', $line)) {
                //             $expectedIndentation--;
                //         }
                //         if (preg_match('/<[^\/]/', $line)) {
                //             $expectedIndentation++;
                //         }
                //         if (preg_match('/<\//', $line)) {
                //             $expectedIndentation--;
                //         }
                //         if (preg_match('/<[^\/]/', $previousLine)) {
                //             $expectedIndentation--;
                //         }
                //         if (preg_match('/<\//', $previousLine)) {
                //             $expectedIndentation++;
                //         }
                //         if (preg_match('/<[^\/]/', $previousLine) && preg_match('/<\//', $previousLine)) {
                //             $expectedIndentation--;
                //         }
                //         if (preg_match('/\{/', $previousLine) && preg_match('/\}/', $previousLine)) {
                //             $expectedIndentation++;
                //         }
                //         if (preg_match('/\{/', $previousLine) && preg_match('/\}/', $previousLine)) {
                //             $expectedIndentation--;
                //         }
                //         if ($expectedIndentation !== $indentation / 4) {
                //             echo 'Line ' . ($lineNumber + 1) . ' in ' . $filepath . ' has an indentation of ' . $indentation / 4 . ' spaces, but ' . $expectedIndentation . ' spaces were expected.' . PHP_EOL;
                //             $errors++;
                //         }
                //     }
                // }
            }
        }
        return $errors;
    }
}
