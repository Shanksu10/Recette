<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Repositories\Repository;
use App\Rules\MatchOldPassword;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Laravel\Fortify\Rules\Password;

class LoginController extends Controller
{
    protected Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /*
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view("auth.register");
    }
    */

    public function myAccount()
    {
        if(Auth::user() == null)
            return redirect()->route('login');
        return view('user.myAccount', [
            'user' => Auth::user()
        ]);
    }

    public function modificationsAccount(Request $request)
    {
        if(Auth::user() == null)
            return redirect()->route('login');
        $rules = [
            'firstNameModif' => ['required', 'regex:/^[a-zA-Z ]+$/', 'max:255'],
            'lastNameModif' => ['required', 'regex:/^[a-zA-Z ]+$/', 'max:255'],
            'emailModif' => ['in:'. Auth::user()->email],
            'birthdayModif' => ['required', 'date', 'after_or_equal:01/01/1920', 'before:01/01/2013'],
            'pictureModif' => ['nullable', 'image', 'mimes:jpeg,png,jpg']
        ];
        $messages = [
            'firstNameModif.required' => 'Ce champ est obligatoire.',
            'firstNameModif.regex' => 'Forme non compatible.',
            'firstNameModif.max' => 'Prénom trés long.',
            'lastNameModif.required' => 'Ce champ est obligatoire.',
            'lastNameModif.regex' => 'Forme non compatible.',
            'lastNameModif.max' => 'Prénom trés long.',
            'emailModif.in' => 'Vous n\'avez pas le droit de changer l\'adresse mail',
            'birthdayModif.required' => 'Ce champ est obligatoire.',
            'birthdayModif.date' => 'Ce champ accepte que la forme date.',
            'birthdayModif.after_or_equal' => 'La date de naissance doit être aprés 01/01/1920',
            'birthdayModif.before' => 'La date de naissance ne doit pas dépasser 01/01/2013',
            'pictureModif.image' => 'La photo de profile doit être une image',
            'pictureModif.mimes' => 'Les formats acceptées sont: jpeg, png, jpg.'
        ];
        $validatedData = $request->validate($rules, $messages);
        if($request['pictureModif'] != null)
        {
            $oldPictureUser = Auth::user()->picture;

            $image = $request->pictureModif;
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('/assets/img/user/'), $imageName);

            if(File::exists(public_path('/assets/img/user/' . $oldPictureUser))){
                File::delete(public_path('/assets/img/user/' . $oldPictureUser));
              }
        }
        else
        {
            $imageName = Auth::user()->picture;
        }
        try {
            $modif = [
                'first_name' => $validatedData['firstNameModif'],
                'last_name' => $validatedData['lastNameModif'],
                'birthday' => $validatedData['birthdayModif'],
                'picture' => $imageName
            ];
            $modifiedNumberRow = $this->repository->updateUser(Auth::user()->id, $modif);
            return redirect()->route('app_my_account')->with('success', 'Vos informations sont bien mises à jour !');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors("Mise à jour échouée !");
        }
    }

    public function updatePasswordForm()
    {
        if(Auth::user() == null)
            return redirect()->route('login');
        return view('user.update_password_form');
    }

    public function updatePassword(Request $request)
    {
        if(Auth::user() == null)
            return redirect()->route('login');
        $rules = [
            'current_password' => [
                                'required',
                                new MatchOldPassword()
                        ],
            'password' => ['required', 'string', new Password, 'confirmed', 'different:current_password'],
            'password_confirmation' => ['required', 'same:password']
        ];
        $messages = [
            'current_password.required' => 'Vous devez mentionner l\'ancien mot de passe.',
            'password.required' => 'Vous devez écrire un nouveau mot de passe.',
            'password.different' => 'Entrez un mot de passe différent de l\'ancien.',
            'password_confirmation.required' => 'Vous devez confirmer le nouveau mot de passe.',
        ];
        $validatedData = $request->validate($rules, $messages);
        try {
            $this->repository->changePassword(Auth::user()->id, $validatedData['current_password'], $validatedData['password']);
            return redirect()->route('app_my_account')->with('success', 'Votre mot de passe a été bien changé.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors("Impossible de modifier le mot de passe !");
        }
    }
}
