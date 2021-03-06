<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Component;
use App\Category;
use App\Rating;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryId = null)
    {
        if(\Auth::check() && \Auth::user()->state == 'inactive'){
//            dd('ok');
            \Auth::logout();
            return redirect()->back()->with(['message' => 'Su cuenta ha sido bloqueada por incumplir las normas de la comunidad. Para más información contacte con el administrador en el email admin@admin.com.', 'status' => 'error']);

        }


        if (\Auth::check()){
            $identity = \Auth::user()->id;
            $user = \Auth::user();
            $userLevel = \Auth::user()->level;
            $ratings = Rating::where('user_id', $user->id)
                                ->count();
//            dd($ratings);

            //funcion para determinar la antiguedad del usuario
            function seniority($created_at)
            {
                $today = date("Y-m-d H:i:s");
                $seniority	= (strtotime($today)-strtotime($created_at))/86400;
                $seniority 	= abs($seniority);
                $seniority = floor($seniority);
                return $seniority;
            }

            // verificamos el nivel del usuario
            if ($userLevel == 'novato'){
                $seniority = seniority($user->created_at);
//                dd('la antiguedad es: '.$seniority);
                if($ratings > 25 && $ratings < 50 && $seniority > 180 && $seniority < 720){
                    $user->level = 'avanzado';
                    $user->update();
                }
                if ($ratings >= 50 && $seniority >= 720){
                    $user->level = 'experto';
                    $user->update();
                }

            } elseif ($userLevel == 'avanzado'){
                $seniority = seniority($user->created_at);
                if ($ratings >= 50 && $seniority >= 720){
                    $user->level = 'experto';
                    $user->update();
                }
            }

//            $userUpdated = \Auth::user();
//            dd('el user era ' . $userLevel.' y ahora es '.$userUpdated->level.' Con valoraciones: '.$ratings);

        } else{
            $identity = 0;
        }

        if(!empty($categoryId)){
            $components = Component::orderBy('id', 'desc')
                ->where('category_id', $categoryId)
                ->paginate(6);
            $categories = Category::orderBy('id')->get();
        } else {
            $components = Component::orderBy('id', 'desc')
//                ->where('state', 'publicado')
//                ->where('categoryId', $categoryId)
                ->paginate(6);
            $categories = Category::orderBy('id')->get();
        }

//        para mostrar la portada
        if(!isset($_COOKIE['en']) && !\Auth::check()){
            setcookie("en", 0, time()+1200);
            return view('index');
        }


        return view('home', [
            'identity' => $identity,
            'categories' => $categories,
            'components' => $components,
        ]);
    }

    public function terminosDeUso() {
        $categories = Category::orderBy('id')->get();
        return view('importantInfo.terminosDeUso', [
            'categories' => $categories,
        ]);
    }

    public function privacyPolicy() {
        $categories = Category::orderBy('id')->get();
        return view('importantInfo.privacyPolicy', [
            'categories' => $categories,
        ]);
    }

    public function cookiesPolicy() {
        $categories = Category::orderBy('id')->get();
        return view('importantInfo.cookiesPolicy', [
            'categories' => $categories,
        ]);
    }
}
