<?php namespace App\Http\Controllers;

use App\Exceptions\DataWrongException;
use App\Service\FileService;
use App\User;
use Illuminate\Http\Response;

class FilesController extends Controller {

    const MODEL = "App\File";

    use RESTActions;

    /**
     * @var FileService $fileService
     */
    protected $fileService;

    /**
     * FileController constructor.
     *
     * @param  FileService $fileService
     * @return void
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @param int $id
     * @throws DataWrongException
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id)
    {
        $user = User::where('id', $id)->first();
        $file = $this->fileService->getFileFromStorage($user->avatar, 'avatar');

        return response($file, Response::HTTP_OK)->header('Content-Type', $user->avatar_type);
    }
}
