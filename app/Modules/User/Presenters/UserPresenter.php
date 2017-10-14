<?php namespace App\Modules\User\Presenters;

use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{

    /**
     * @return string
     */
    public function avatar()
    {
        return !is_null($this->social_avatar) ?: "/images/defualt-profiles.png";
    }

    public function fullName()
    {
        return $this->name;
    }
}