<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Image;

use App\Models\User;
use App\Models\Publicacao;
use App\Models\Gosto;
use App\Models\Comentario;
use App\Models\Friendship;
use App\Models\Grupo;
use App\Models\Notificacao;

class NotificacaoController extends Controller
{
    public function show() {
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        
        $notifications = Auth::user()
            ->notifications()
            ->notSeen()
            ->orderBy('datatempo', 'desc')
            ->get();

        $friend_request=User::find(Auth::id())->friendship_request;

        $group_request=User::find(Auth::id())->grouprequests;
        

        return view('pages.notifications', [
            'notifications' => $notifications,
            'friendship_request'=>$friend_request,
            'group_request'=>$group_request
        ]);
    }

    public function viewed($id){
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $notification = Notificacao::find($id);
        if(is_null($notification)){
            return view('layouts.error204');
        }
        $notification->vista=true;
        $notification->save();
        return $notification;      
    }
}