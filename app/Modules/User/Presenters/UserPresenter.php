<?php namespace App\Modules\User\Presenters;

use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{

    /**
     * @return string
     */
    public function currentAvatar()
    {
        return !is_null($this->avatar) ?: "/images/defualt-profiles.png";
    }

    public function fullName()
    {
        return $this->name;
    }

    public function nickName()
    {
        return $this->nickname;
    }
}