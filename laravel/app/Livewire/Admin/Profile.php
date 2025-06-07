<?php

namespace App\Livewire\Admin;

use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\User;

class Profile extends Component
{
    public $tab = null;
    public $tabName = 'personal_details';
    protected $queryString = ['tab' => ['keep' => true]];

    public $name, $email,$username, $bio;
    public function selectTab($tab)
    {
        $this->tab = $tab;
    }
    public function mount()
    {
        $this->tab = Request('tab') ? Request('tab') : $this->tabName;

        //
        $user = User::findOrFail(auth()->id());

        $this->name = $user->name;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->bio = $user->bio;

    }
    public function  updatePersonalDetails()
    {
        $user = User::findOrFail(auth()->id());

        $this->validate([
           'name' => 'required',
           'username' => 'required|unique:users,username,'.$user->id,
           'bio' => 'required',
        ]);
        // update user info
        $user->name = $this->name;
        $user->username = $this->username;
        $user->bio = $this->bio;
        $updated = $user->save();
        sleep(0.5);
        if ($updated) {
            $this->dispatch('swal:success', ['message' => 'Профиль успешно обновлён!']);
            $this->dispatch('updateTopUserInfo')->to(TopUserInfo::class);
        } else {
            $this->dispatch('swal:error', ['message' => 'Ошибка']);
        }

    }
    public function render()
    {


        return view('livewire.admin.profile', [
            'user' => User::findOrFail(auth()->id()),
        ]);
    }
}
