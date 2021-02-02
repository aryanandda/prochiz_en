<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SubscribeNewsletter;
use App\Models\User;
use Facebook;
use Image;
use Auth;

class FacebookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->login_helper = Facebook::getRedirectLoginHelper();
        $this->redirect = ($request->has('r')) ? $request->get('r') : url('/');
    }

    /**
     * Redirect to facebook login dialog.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        $permissions = ['public_profile', 'email'];

        return redirect($this->login_helper->getLoginUrl(url('/login/facebook/callback?r='.$this->redirect), $permissions));
    }

    /**
     * Callback after login dialog is called.
     *
     * @return \Illuminate\Http\Response
     */
    public function callback()
    {
        $accessToken = false;

        try {
            $accessToken = $this->login_helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            return redirect($this->redirect);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            return redirect($this->redirect);
        }

        if (!$accessToken) {
            return redirect($this->redirect);
        }

        $oAuth2Client = Facebook::getOAuth2Client();

        if (!$accessToken->isLongLived()) {
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                return redirect($this->redirect);
            }
        }

        $response = Facebook::get('/me?fields=id,name,email', $accessToken->getValue());
        $fbuser = $response->getGraphUser();

        $response = Facebook::get('/me/picture?redirect=false&type=large', $accessToken->getValue());
        $fbpicture = $response->getGraphObject();

        $user = User::email($fbuser['email'])->first();

        if (!$user) {
            $user = new User;
            $user->name = $fbuser['name'];
            $user->email = $fbuser['email'];

            if (!$fbpicture['is_silhouette']) {
                $extension = explode('?', pathinfo($fbpicture['url'], PATHINFO_EXTENSION));
                $user->image = md5($user->email).'-'.uniqid().'.'.$extension[0];
                $storage_path = 'app/public/users';
                $img = file_get_contents($fbpicture['url']);
                Image::make($img)->save(storage_path($storage_path.'/'.$user->image));
                Image::make($img)->fit(200,200)->save(storage_path($storage_path.'/square/'.$user->image));
                Image::make($img)->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path($storage_path.'/small/'.$user->image));
            }

            dispatch(new SubscribeNewsletter($user->name, $user->email));
        }

        $user->facebook_id = $fbuser['id'];
        // $user->facebook_url = $fbuser['link'];
        $user->facebook_token = $accessToken->getValue();
        $user->save();

        Auth::login($user, true);

        return redirect()->intended($this->redirect);
    }

}
