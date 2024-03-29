<?php

namespace MaplePHP\Log\Handlers;

use MaplePHP\Http\Interfaces\StreamInterface;
use MaplePHP\Http\Stream;

class StreamHandler extends AbstractHandler
{
    public const MAX_SIZE = 5000; // KB
    public const MAX_COUNT = 10;

    private $file;
    private $stream;
    private $dir;
    private $info;
    private $size;
    private $count;

    public function __construct(string $file, ?int $size = null, ?int $count = null)
    {
        $this->file = basename($file);
        $this->dir = dirname($file) . "/";
        $this->size = !is_null($size) ? ($size * 1024) : $size;
        $this->count = $count;
    }

    /**
     * Stream handler
     * @param  string $level
     * @param  string $message
     * @param  array  $context
     * @param  string $date
     * @return void
     */
    public function handler(string $level, string $message, array $context, string $date): void
    {
        $encode = json_encode($context);
        $message = sprintf($message, $encode);
        $this->rotate();
        $this->stream()->seek(0);
        $this->stream()->write("[{$date}] [{$level}] {$message} {$encode}");
        $this->stream()->write("\n");
    }

    /**
     * Create stream
     * @return StreamInterface
     */
    protected function stream(): StreamInterface
    {
        if (is_null($this->stream)) {
            if (!is_writable($this->dir)) {
                throw new \Exception("The directory \"{$this->dir}\" is not writable!", 1);
            }
            $this->stream = new Stream($this->dir . $this->file, "a");
        }
        return $this->stream;
    }

    /**
     * File rotation
     * @return void
     */
    protected function rotate(): void
    {
        if (!is_null($this->size)) {
            $file = $this->dir . $this->file;
            $filename = $this->fileInfo("filename");
            $extension = $this->fileInfo("extension");

            if (is_file($file) && (filesize($file) > $this->size)) {
                $files = glob($this->dir . "{$filename}*[0-9].{$extension}");
                $count = count($files);
                sort($files);

                if (!is_null($this->count) && ($count >= $this->count)) {
                    for ($i = 0; $i < (($count - $this->count) + 1); $i++) {
                        unlink($files[$i]);
                    }
                }
                $date = time();
                rename($file, $this->dir . $filename . "-{$date}.{$extension}");
            }
        }
    }

    /**
     * Get file information
     * @param  string $key
     * @return string|null
     */
    private function fileInfo(string $key): ?string
    {
        if (is_null($this->info)) {
            $this->info = pathinfo($this->file);
        }
        return ($this->info[$key] ?? null);
    }
}
