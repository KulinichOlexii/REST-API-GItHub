<?php namespace App\Http\Controllers\GitHub;

use App\Events\GitHubEvent;
use App\Http\Controllers\Controller;
use App\Service\GitHubService;
use App\Service\WeatherService;
use Illuminate\Http\Request;

class GitHubUsersController extends Controller {

    /**
     * @var GitHubService $gitHubService
     */
    protected $gitHubService;

    /**
     * @var WeatherService $weatherService
     */
    protected $weatherService;

    /**
     * FileController constructor.
     *
     * @param  GitHubService $gitHubService
     * @param  WeatherService $weatherService
     * @return void
     */
    public function __construct(GitHubService $gitHubService, WeatherService $weatherService)
    {
        $this->gitHubService = $gitHubService;
        $this->weatherService = $weatherService;
    }

    /**
     * Sending message to users from GitHub
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'userNames'     => 'required|array',
            'message'  => 'required|string|min:5'
        ]);

        foreach ($request->get('userNames') as $userName){
            $weather = null;
            $user = $this->gitHubService->getUser($userName);

            if (empty($user->getEmail())) continue;

            if (!empty($user->getLocation())){
                $city = stristr(trim($user->getLocation()), ',', true) ?
                    stristr(trim($user->getLocation()), ',', true) : trim($user->getLocation());
                $weather = $this->weatherService->getWeatherByCity($city);
            }
            event(new GitHubEvent($user, $weather, $request->get('message'), env('MAIL_FROM_NAME'), env('MAIL_FROM_ADDRESS')));
        }
        return response()->json(['success' => true], 200);
    }
}