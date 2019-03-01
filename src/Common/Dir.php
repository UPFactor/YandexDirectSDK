<?php

namespace YandexDirectSDK\Common;

use Exception;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use FilesystemIterator;
use SplFileInfo;

/**
 * Class Dir
 *
 * @method static Dir bind(string $path)
 *
 * @package Sim\Common
 */
class Dir extends FileInfo
{
    /**
     * Create document root directory instance
     *
     * @return Dir
     * @throws Exception
     */
    public static function documentRoot(){
        if (!($path = realpath($_SERVER['DOCUMENT_ROOT']))){
            throw new Exception('Directory from variable $_SERVER[\'DOCUMENT_ROOT\'] not found');
        }
        return new static($path);
    }

    /**
     * Check whether the directory exists.
     *
     * @param callable|null $callable
     * @return bool
     */
    public function exists(callable $callable = null){

        if (file_exists($this->path) and is_dir($this->path)){
            if (!is_null($callable)){
                $callable($this);
            }
            return $this->valid = true;
        }

        return $this->valid = false;
    }

    /**
     * Create a new directory with the given content if it does not exist.
     *
     * @return $this
     * @throws Exception
     */
    public function existsOrCreate(){
        if (!$this->exists()) {
            $this->create();
        }

        return $this;
    }

    /**
     * Delete directory if it exists
     *
     * @return $this
     * @throws Exception
     */
    public function missingOrDelete(){
        if ($this->exists()){
            $this->delete();
        }

        return $this;
    }

    /**
     * Determine if the directory is empty.
     *
     * @param callable|null $callable
     * @return bool
     * @throws Exception
     */
    public function isEmpty(callable $callable = null){
        if (count(scandir($this->path(), SCANDIR_SORT_NONE)) <= 2){
            if (!is_null($callable)){
                $callable($this);
            }
            return true;
        }

        return false;
    }

    /**
     * Determine if the directory is not empty.
     *
     * @param callable|null $callable
     * @return bool
     * @throws Exception
     */
    public function isNotEmpty(callable $callable = null){
        if (!$this->isEmpty()){
            if (!is_null($callable)){
                $callable($this);
            }
            return true;
        }

        return false;
    }

    /**
     * Retrieve a array with the results of calling a provided function
     * on every element in the directory.
     *
     * @param callable $callable
     * @param bool $childFirst
     * @return array
     * @throws Exception
     */
    public function map(callable $callable, $childFirst = false){

        $result = [];

        foreach($this->iterator($childFirst) as $item) {
            /** @var SplFileInfo $item */
            $result[] = $callable(new FileInfo($item->getPathname()));
        }

        return $result;
    }

    /**
     * Retrieve a new array with all elements in the directory that pass the test implemented
     * by the provided function.
     *
     * @param callable $callable
     * @param bool $childFirst
     * @return array
     * @throws Exception
     */
    public function filter(callable $callable, $childFirst = false){

        $result = [];

        foreach($this->iterator($childFirst) as $item) {
            $item = new FileInfo($item->getPathname());

            if ($callable($item) !== false){
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * Executes a provided function once for each directory element.
     *
     * @param callable $callable
     * @param bool $childFirst
     * @return $this
     * @throws Exception
     */
    public function each(callable $callable, $childFirst = false){

        foreach($this->iterator($childFirst) as $item) {
            /** @var SplFileInfo $item */
            $callable(new FileInfo($item->getPathname()));
        }

        return $this;
    }

    /**
     * Gets the total size of all files in the directory.
     *
     * @return int
     * @throws Exception
     */
    public function size(){
        $size = 0;

        $this->each(function(FileInfo $item) use (&$size){
            if ($item->isLink() or $item->isDirectory()){
                return;
            }

            $size += $item->size();
        });

        return $size;
    }

    /**
     * Gets the directory hash.
     *
     * @param string $salt
     * @return string
     * @throws Exception
     */
    public function hash($salt = ''){
        $base = $this->map(function(FileInfo $item){
            if ($item->isLink() or $item->isDirectory()){
                return $item->name();
            } else {
                return $item->name().sha1_file($item->path());
            }
        });

        return sha1($salt.$this->name().json_encode($base));
    }

    /**
     * Rename the directory.
     *
     * @param $name
     * @return $this
     * @throws Exception
     */
    public function rename($name){
        $oldPath = $this->path();
        $newPath = Str::end(dirname($oldPath), DIRECTORY_SEPARATOR).$name;

        if (@rename($oldPath, $newPath)){
            $this->path = $newPath;
            $this->valid = true;

            return $this;
        }

        throw new Exception("Failed to rename the directory [{$oldPath}] to [{$newPath}].");
    }

    /**
     * Change current directory.
     *
     * @param $path
     * @return $this
     * @throws Exception
     */
    public function change($path){

        if (($realPath = realpath($path)) === false){
            $path = $this->realPath() . Str::begin($path, DIRECTORY_SEPARATOR);
            $realPath = realpath($path);
        }

        if (file_exists($realPath) and is_dir($realPath)){
            $this->path = $realPath;
            $this->valid = true;

            return $this;
        }

        throw new Exception("Failed to change directory to [{$path}].");
    }

    /**
     * Create the directory.
     *
     * @return $this
     * @throws Exception
     */
    public function create(){
        if (mkdir($this->path,0777,true) === false) {
            throw new Exception("Failed creating directory [{$this->path}]");
        }

        $this->valid = true;

        return $this;
    }

    /**
     * Create a new file in the directory.
     *
     * @param string $filename
     * @param string $content
     * @return File
     * @throws Exception
     */
    public function createFile($filename, $content){
        $this->existsOrCreate();
        return (new File($this->realPath() . Str::begin($filename, DIRECTORY_SEPARATOR)))->put($content);
    }

    /**
     * Create a new subdirectory in the directory.
     *
     * @param $dirname
     * @return mixed
     * @throws Exception
     */
    public function createSubDirectory($dirname){
        $this->existsOrCreate();
        return (new static($this->realPath() . Str::begin($dirname, DIRECTORY_SEPARATOR)))->create();
    }

    /**
     * Clear the directory.
     *
     * @param callable|null $callable
     * @return $this
     * @throws Exception
     */
    public function clear(callable $callable = null){

        foreach($this->iterator(true) as $item) {

            /** @var SplFileInfo $item */

            $path = $item->getPathname();

            if ($item->isLink() and $item->isDir()){
                unlink($path);
                continue;
            }

            if ($item->isDir()){
                @rmdir($path);
                continue;
            }

            if (!is_null($callable)){
                if ($callable(new File($path)) === false){
                    continue;
                }
            }

            unlink($path);
        }

        return $this;
    }

    /**
     * Delete the directory.
     *
     * @return $this
     * @throws Exception
     */
    public function delete(){

        if ($this->isLink()){
            $result = @unlink($this->path());
        } else {
            $this->clear();
            $result = @rmdir($this->path());
        }

        if ($result){
            $this->valid = false;
        }

        return $this;
    }

    /**
     * Directory instance initialization.
     *
     * @param $path
     * @return bool
     * @throws Exception
     */
    protected function initialize($path){
        if (is_string($path)){
            $this->path = $path;
            $this->valid = is_dir($path);
            return true;
        }

        throw new Exception("Invalid directory name. Expected [string], passed [" . gettype($path) . "].");
    }

    /**
     * Recursive iterator of the current directory.
     *
     * @param bool $childFirst
     * @return RecursiveIteratorIterator
     * @throws Exception
     */
    protected function iterator($childFirst = false){

        $path = $this->realPath();

        if ($path === false){
            throw new Exception("The path [{$this->path}] does not exist");
        }

        $sort = $childFirst === true ?
            RecursiveIteratorIterator::CHILD_FIRST :
            RecursiveIteratorIterator::SELF_FIRST;

        return new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $path,
                FilesystemIterator::SKIP_DOTS
            ),
            $sort
        );
    }
}