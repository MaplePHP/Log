<?php

namespace PHPFuse\Log\Handlers;

use PHPFuse\Http\Interfaces\StreamInterface;
use PHPFuse\Http\Stream;

class StreamHandler extends AbstractHandler
{

    const MAX_SIZE = 5000; // KB
    const MAX_COUNT = 10;

    private $file;
    private $stream;
    private $dir;
    private $info;
    private $size;
    private $count;

    function __construct(string $file, ?int $size = NULL, ?int $count = NULL) 
    {
        $this->file = basename($file);
        $this->dir = dirname($file)."/";
        $this->size = !is_null($size) ? ($size*1024) : $size;
        $this->count = $count;
    }

    /**
     * Stream handler
     * @param  string $level
     * @param  string $message
     * @param  string $date
     * @return void
     */
    function handler(string $level, string $message, array $context, string $date): void 
    {
        $message = sprintf($message, json_encode($context));
        
        $this->rotate();
        $this->stream()->seek(0);
        $this->stream()->write("{$date} [{$level}] {$message}");
        $this->stream()->write("\n");
    }

    /**
     * Create stream
     * @return StreamInterface
     */
    protected function stream(): StreamInterface
    {
        if(is_null($this->stream)) {
            if(!is_writable($this->dir)) throw new \Exception("The directory \"{$this->dir}\" is not writable!", 1);   
            $this->stream = new Stream($this->dir.$this->file, "a");
        }
        return $this->stream;
    }

    /**
     * File rotation
     * @return void
     */
    protected function rotate(): void 
    {
        if(!is_null($this->size)) {
            $file = $this->dir.$this->file;
            $filename = $this->fileInfo("filename");
            $extension = $this->fileInfo("extension");

            if(is_file($file) && (filesize($file) > $this->size)) {
                $files = glob($this->dir."{$filename}*[0-9].{$extension}");
                $count = count($files);
                sort($files);

                if(!is_null($this->count) && ($count >= $this->count)) {
                    for($i = 0; $i < (($count-$this->count)+1); $i++) unlink($files[$i]);
                }
                $date = time();
                rename($file, $this->dir.$filename."-{$date}.{$extension}");
            }
        }
    }

    /**
     * Get file information
     * @param  string $key [description]
     * @return [type]      [description]
     */
    private function fileInfo(string $key): ?string 
    {
        if(is_null($this->info)) $this->info = pathinfo($this->file);
        return ($this->info[$key] ?? NULL);
    }

}