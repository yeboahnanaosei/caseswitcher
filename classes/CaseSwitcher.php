<?php
/**
 * CaseSwitcher
 *
 * CaseSwitcher is a simple one-class library that allows
 * you to change or rename files to lowercase or UPPERCASE
 * by calling just one method. Its that simple...
 *
 * PHP 7.0.25+
 *
 * @package CaseSwitcher
 * @version 0.1.1-beta
 * @author  Nana Osei Yeboah <yeboahnanaosei@gmail.com>
 * @link    https://github.com/yeboahnanaosei/case-switcher
 * @license GPLv3.0
 */
namespace caseswitcher;

class CaseSwitcher
{
    private $path;
    private $filename;
    private $fileExt;
    private $directory;
    private $resourceType;      // Is the path a file or a directory
    private $caseType;          // Should the file be renamed to uppercase or lowercase?
    private $errMsg;
    private $restrictedPaths = ['/', '/home', '/var', __DIR__]; // restricted path on unix file systems


    /**
     * Constructor
     *
     * @param string $path The path to the resource
     * @param string $case The case to rename the files to. Defaults to 'lower'
     */
    public function __construct(string $path, string $case = 'lower')
    {
        $this->path           = realpath($path);
        $this->caseType       = $case;
        $this->restrictedPaths = array_map('realpath', $this->restrictedPaths);
 
        if (is_file($this->path)) {
            $this->directory = pathinfo($this->path, PATHINFO_DIRNAME);
            $this->filename  = pathinfo($this->path, PATHINFO_FILENAME);
            $this->resourceType = 'file';
            
            $this->fileExt   = pathinfo($this->path, PATHINFO_EXTENSION);
            if (strlen($this->fileExt) == 0) {
                $this->fileExt = '';
            } else {
                $this->fileExt = '.' . $this->fileExt;
            }
        } elseif (is_dir($this->path)) {
            $this->resourceType = 'dir';
        }
    }

    /**
     * Checks if the supplied path is valid
     *
     * @return bool True if the path is valid, False if it isn't
     */
    private function isValid() : bool
    {
        if (!file_exists($this->path)) {
            $this->errMsg = 'INCORRECT PATH<br>The path you entered does not exist or is incorrect. Please check';
            return false;
        } elseif (in_array($this->path, $this->restrictedPaths)) {
            $this->errMsg = 'THE PATH YOU ENTERED IS RESTRICTED<br>You are not allowed to edit any files here';
            return false;
        } elseif (!is_writable($this->path)) {
            $this->errMsg = 'NO RIGHTS<br>You don\'t have permissions over this file / directory';
            return false;
        } else {
            return true;
        }
    }


    /**
     * Entry point to the class. Calls the appropriate rename method based on the resource type
     *
     * @return bool
     */
    public function rename() : bool
    {
        if ($this->isValid()) {
            switch ($this->resourceType) {
                case 'dir':
                    return ($this->renameDirContents()) ? true : false;
                    break;
                case 'file':
                    return ($this->renameFile()) ? true : false;
                    break;
            }
        } else {
            return false;
        }
    }


    /**
     * Rename files inside a directory if the supplied path is a directory
     *
     * @return bool False if the directory is an empty one
     */
    private function renameDirContents() : bool
    {
        if (count(scandir($this->path)) <= 2) {
            $this->errMsg = 'EMPTY DIRECTORY<br>This is an empty directory. I didn\'t find any files here ';
            return false;
        } else {
            foreach (scandir($this->path) as $file) {
                if (strpos($file, '.') === 0) {
                    continue; // Skip '.' and '..' in the directory listing
                }
                
                chdir($this->path);
                $this->directory = getcwd();
                $this->filename  = pathinfo($file, PATHINFO_FILENAME);
                $this->fileExt   = pathinfo($file, PATHINFO_EXTENSION);
                
                if (strlen($this->fileExt) == 0) {
                    $this->fileExt = '';
                } else {
                    $this->fileExt = '.' . $this->fileExt;
                }
                rename(
                    "{$this->directory}" . DIRECTORY_SEPARATOR . "{$file}",
                    "{$this->directory}" . DIRECTORY_SEPARATOR . $this->changeCase($this->filename) . $this->fileExt
                );
            }
            return true;
        }
    }

    /**
     * Renames a single file if the supplied path points to a single file
     *
     * @return bool True if file name is converted successfully, false on failure
     */
    private function renameFile() : bool
    {
        if (rename(
            $this->path,
            "{$this->directory}" . DIRECTORY_SEPARATOR . $this->changeCase($this->filename) . $this->fileExt
        )
            ) {
            return true;
        } else {
            $this->errMsg = 'An unknown error occured. Make sure the path is valid and you have permissions over the file';
            return false;
        }
    }

    /**
     * Converts filename to the requested case
     *
     * @param string Name of the file
     * @return string The converted version of the filename
     */
    private function changeCase($fileName) : string
    {
        switch ($this->caseType) {
            case 'upper':
                return strtoupper($fileName);
                break;
            case 'lower':
                return strtolower($fileName);
                break;
        }
    }

    /**
     * Get error message
     *
     * @return string The cuurrent error message
     */
    public function getErrorMsg() : string
    {
        return $this->errMsg;
    }
}
