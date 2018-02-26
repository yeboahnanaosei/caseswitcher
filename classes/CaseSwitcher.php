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
        $this->path            = realpath($path);
        $this->caseType        = $case;
        $this->restrictedPaths = array_map('realpath', $this->restrictedPaths);
 
        if (is_file($this->path)) {
            $this->resourceType = 'file';
            $this->directory    = pathinfo($this->path, PATHINFO_DIRNAME);
            
            // Get file name and change it to the requested case
            $this->filename = $this->changeCase(pathinfo($this->path, PATHINFO_FILENAME));
            
            // Get file extension of the file
            // Set extension to empty string if the file has no extension
            $this->fileExt = pathinfo($this->path, PATHINFO_EXTENSION);
            $this->fileExt = (empty($this->fileExt)) ? '' : ".{$this->fileExt}";

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
        } elseif ($this->resourceType == 'dir') {
            // Check if the directory is empty. An empty directory will list two elements "." and ".."
            if (count(scandir($this->path)) <= 2) {
                $this->errMsg = 'EMPTY DIRECTORY<br>This is an empty directory. I didn\'t find any files here ';
                return false;
            }
        }
        
        return true;
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
                    return $this->renameDirContents();
                    break;
                    
                case 'file':
                    return $this->renameFile();
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
        foreach (scandir($this->path) as $file) {
            // Skip '.' and '..' in the directory listing
            if (strpos($file, '.') === 0) {
                continue;
            }
            
            // Get filename of each file and change to requested case
            $this->filename = $this->changeCase(pathinfo($file, PATHINFO_FILENAME));
            
            // Get extension for each file
            $this->fileExt  = pathinfo($file, PATHINFO_EXTENSION);
            $this->fileExt = (empty($this->fileExt)) ? '' : ".{$this->fileExt}";
            
            rename(
                "{$this->path}" . DIRECTORY_SEPARATOR . "{$file}",
                "{$this->path}" . DIRECTORY_SEPARATOR . "{$this->filename}{$this->fileExt}"
            );
        }
        return true;
    }


    /**
     * Renames a single file if the supplied path points to a single file
     *
     * @return bool True if file name is converted successfully, false on failure
     */
    private function renameFile() : bool
    {
        if (rename($this->path, "{$this->directory}" . DIRECTORY_SEPARATOR . "{$this->filename}{$this->fileExt}")) {
            return true;
        } else {
            $this->errMsg =
            'An unknown error occured. Make sure the path is valid and you have permissions over the file';
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
