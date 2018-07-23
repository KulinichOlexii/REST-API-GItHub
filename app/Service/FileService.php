<?php

namespace App\Service;

use App\Exceptions\CreateException;
use App\Exceptions\DataWrongException;
use File;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\UploadedFile;

class FileService
{
    /**
     * @var FilesystemManager
     */
    protected $filesystem;

    /**
     * @var string
     */
    private $storeFolder;

    /**
     * FileService constructor.
     * @param FilesystemManager $filesystem
     */
    public function __construct(FilesystemManager $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->storeFolder = config('filesystems.disks.' . $this->filesystem->getDefaultDriver() . '.containers_path');
    }

    /**
     * @param $containerName
     * @param null $filename
     * @return string
     */
    protected function getPath($containerName, $filename = null)
    {
        return $this->storeFolder . '/' . $containerName . '/' . $filename;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @throws CreateException
     */
    public function storeFile(UploadedFile $uploadedFile, $filename, $containerName)
    {
        $storePath = $this->getPath($containerName, $filename);
        try {
            $this->filesystem->put($storePath, file_get_contents($uploadedFile->getRealPath()));
        } catch (\Exception $exception) {
            throw new CreateException($exception->getMessage());
        }
    }

    /**
     * @param $filename
     * @return string
     * @throws DataWrongException
     */
    public function getFileFromStorage($filename, $containerName)
    {
        $path = $this->getPath($containerName, $filename);
        if ($this->filesystem->exists($path)) {
            return $this->filesystem->disk()->get($path);
        } else {
            throw new DataWrongException(['message' => 'File ' . $filename . ' is absent']);
        }
    }
}