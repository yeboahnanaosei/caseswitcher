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
 * @version 0.1.2-beta
 * @author  Nana Osei Yeboah <yeboahnanaosei@gmail.com>
 * @link    https://github.com/yeboahnanaosei/case-switcher
 * @license GPLv3.0
 */
namespace caseswitcher;

class CaseSwitcher
{
    private $path;
    private $resourceType;      // Is the path a file or a directory
    private $caseType;          // Should the file be renamed to uppercase or lowercase?
    private $recursion;
    private $errMsg;
    private $restrictedPaths = ['/', '/home', '/var', __DIR__]; // restricted path on unix file systems


    /**
     * Constructor
     *
     * @param string $path The path to the resource
     * @param string $case The case to rename the files to. Defaults to 'lower'
     * @param string $recursion Specifies if subfolders should also be renamed;
     */
    public function __construct(string $path, string $case = 'lower', string $recursion = 'false')
    {
        $this->path            = realpath($path);
        $this->caseType        = $case;
        $this->recursion       = $recursion;
        $this->restrictedPaths = array_map('realpath', $this->restrictedPaths);

        switch (true) {
            case is_file($this->path):
                $this->resourceType = 'file';
                break;
            case is_dir($this->path):
                $this->resourceType = 'dir';
                break;
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
                    return $this->renameDir();
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
     * Renames a single file if the supplied path points to a single file
     *
     * @return bool True if file name is converted successfully, false on failure
     */
    private function renameFile() : bool
    {
        $file = new \SplFileInfo($this->path);
        $oldFile   = $file->getPathName();
        $directory = $file->getPath();
        $filename  = $this->changeCase(pathinfo($file->getFilename(), PATHINFO_FILENAME));
        $fileExt   = $this->getExtension($file->getExtension());
        $newFile   = "{$directory}" . DIRECTORY_SEPARATOR. "{$filename}{$fileExt}";
        
        if (rename($oldFile, $newFile)) {
            return true;
        } else {
            $this->errMsg =
            'An unknown error occured. Make sure the path is valid and you have permissions over the file';
            return false;
        }
    }

    /**
     * Rename contents of a directory either one level deep or recursively
     *
     * @return bool True if the renaming succeeds
     */
    private function renameDir()
    {
        switch ($this->recursion) {
            case 'true':
                $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($this->path),
                \RecursiveIteratorIterator::CHILD_FIRST
                );
                break;

            case 'false':
                $iterator = new \DirectoryIterator($this->path);
                break;
        }

        foreach ($iterator as $file) {
            $oldFile   = $file->getPathName();
            $directory = $file->getPath();
            $filename  = $this->changeCase(pathinfo($file->getFilename(), PATHINFO_FILENAME));
            $fileExt   = $this->getExtension($file->getExtension());
            $newFile   = "{$directory}" . DIRECTORY_SEPARATOR. "{$filename}{$fileExt}";
            @rename($oldFile, $newFile);
        }
        return true;
    }

    /**
     * Converts filename to the requested case
     *
     * @param string $fileName Name of the file
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
     * Gets the extension of the file
     *
     * @return string The extension of the file
     */
    private function getExtension($file)
    {
        return (empty($file)) ? '' : ".{$file}";
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
