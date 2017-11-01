<?php namespace App\Modules\Authentication\Commands;

use App\Modules\User\Data\Repository\UserRepositoryInterface;
use Illuminate\Console\Command;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth as Authenticator;
class AuthenticateWithSocialCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var Socialite
     */
    private $socialite;
    /**
     * @var Authenticator
     */
    private $auth;
    /**
     * @var
     */
    private $listener;
    /**
     * @var
     */
    private $provider;
    /**
     * @var
     */
    private $hasCode;

    /**
     * Create a new command instance.
     *
     * @param $provider
     * @param $hasCode
     * @param $listener
     */
    public function __construct($provider, $hasCode, $listener)
    {
        parent::__construct();
        $this->users = resolve(UserRepositoryInterface::class);
        $this->auth = resolve(Authenticator::class);
        $this->listener = $listener;
        $this->provider = $provider;
        $this->hasCode = $hasCode;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function handle()
    {
        if(! $this->hasCode) return $this->getAuthorizationFirst($this->provider);
        $user = $this->users->findByEmailOrCreate($this->getProvidedUser($this->provider));
        return $this->listener->userHasLoggedIn($user);
    }

    /**
     * Redirect to social to get authorization.
     *
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function getAuthorizationFirst($provider)
    {
        return Socialite::with($provider)->redirect();
    }
    /**
     * Get data about a user from social plathform.
     *
     * @param $provider
     * @return \Laravel\Socialite\Contracts\User
     */
    private function getProvidedUser($provider)
    {
        return Socialite::with($provider)->user();
    }

}
