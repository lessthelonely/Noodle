<?php
//https://laravel.com/docs/8.x/controllers
//https://laracasts.com/discuss/channels/laravel/edit-user-profile-best-practice-in-laravel-55
//https://www.youtube.com/watch?v=376vZ1wNYPA&list=WL&index=96

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Image;

use App\Models\User;
use App\Models\Publicacao;
use App\Models\utilizadorDocente;
use App\Models\utilizadorEstudante;
use App\Models\Moderador;
use App\Models\Friendship;
use App\Models\Notificacao;

class UserController extends Controller
{    
    public function showProfile($id) 
    {
        $user = User::find($id);
        if(is_null($user))
           return view('layouts.error204');
        $colleagues=$user->friends;

        if($user->privacidade == 'public' || Auth::check() || Auth::guard('admin')->check()){
            
            $posts=Publicacao::where('idutilizador',$id)->where('idgrupo',NULL)->get();          

            $profilePic = $user->fotoperfil;
            
            if(is_null($user->fotoheader)){
               $headerPic='assets/img/banner.jpg';   
              }
             else {
               $headerPic=$user->fotoheader;   
              }
            $instituicaoEnsino = $user->instituicaoensino;

            if(utilizadorEstudante::where('id',$id)->exists()){
                $estudante=utilizadorEstudante::where('id',$id)->get();
                foreach($estudante as $f){
                   $curso=$f->curso;
                   $anocorrente=$f->anocorrente;
                } 
                if(Auth::guard('admin')->check()){
                    return view('admin.admin_profile_estudante', [
                        'user' => $user,
                        'posts'=>$posts,
                        'profilePic' => $profilePic,
                        'headerPic' => $headerPic,
                        'instituicaoEnsino'=>$instituicaoEnsino,
                        'curso'=>$curso,
                        'anoCorrente'=>$anocorrente
                    ]);
                }
                return view('pages.profile_estudante', [
                    'user' => $user,
                    'posts'=>$posts,
                    'profilePic' => $profilePic,
                    'headerPic' => $headerPic,
                    'instituicaoEnsino'=>$instituicaoEnsino,
                    'curso'=>$curso,
                    'anoCorrente'=>$anocorrente,
                    'colleagues'=>$colleagues
                ]);
            }
            
            if( utilizadorDocente::where('id',$id)->exists()) {
                $docente=utilizadorDocente::where('id',$id)->get();
                foreach($docente as $f){
                   $formacao=$f->formacao;
                   $departamento=$f->departamento;
                } 
                if(Auth::guard('admin')->check()){
                    return view('admin.admin_profile_docente', [
                        'user' => $user,
                        'posts'=>$posts,
                        'profilePic' => $profilePic,
                        'headerPic' => $headerPic,
                        'instituicaoEnsino'=>$instituicaoEnsino,
                        'departamento'=>$departamento,
                        'formacao'=>$formacao
                    ]);
                }
                return view('pages.profile_docente', [
                    'user' => $user,
                    'posts'=>$posts,
                    'profilePic' => $profilePic,
                    'headerPic' => $headerPic,
                    'instituicaoEnsino'=>$instituicaoEnsino,
                    'departamento'=>$departamento,
                    'formacao'=>$formacao,
                    'colleagues'=>$colleagues
                ]);
            }

           
        }
        else{
        return view('layouts.error403');
        }
    }
    
    public function config_view($id){
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
       $user = User::find($id);
       if(is_null($user))
           return view('layouts.error204');
       $profilePic = $user->fotoPerfil;
       $headerPic=$user->fotoHeader;

            if(utilizadorEstudante::where('id',$id)->exists()){
                $estudante=utilizadorEstudante::where('id',$id)->get();
                foreach($estudante as $f){
                   $curso=$f->curso;
                   $anocorrente=$f->anocorrente;
                } 
                return view('pages.config_estudante', [
                    'user' => $user,
                    'profilePic' => $profilePic,
                    'headerPic' => $headerPic,
                    'curso'=>$curso,
                    'anoCorrente'=>$anocorrente
                ]);
            }
            
            if( utilizadorDocente::where('id',$id)->exists()) {
                $docente=utilizadorDocente::where('id',$id)->get();
                foreach($docente as $f){
                   $formacao=$f->formacao;
                   $departamento=$f->departamento;
                } 
                return view('pages.config_docente', [
                    'user' => $user,
                    'profilePic' => $profilePic,
                    'headerPic' => $headerPic,
                    'departamento'=>$departamento,
                    'formacao'=>$formacao
                ]);
            }

           
    }
    
    public function config($id,Request $request){
         if(!Auth::check()) return redirect('/login');
         if(Auth::user()->is_banned) return view('layouts.error403');
        $user=User::find($id);
        if(is_null($user))
           return view('layouts.error204');

        $validated=$request->validate([
            'name'=>'max:255',
            'profile-pic'=>'mimes:jpg,png,jpeg|max:5048',
            'header-pic'=>'mimes:jpg,png,jpeg|max:5048'
        ]);

        if(!is_null($request['name'])){
            $user->nome=$request['name'];
        }
        if(!is_null($request['birthdate'])){
            $user->datanascimento=$request['birthdate'];
        }
        if($request->btnradio=='public'){
           $user->privacidade='public';
        }
        if($request->btnradio=='private'){
           $user->privacidade='private';
        }
        if($request->hasFile('profile-pic')){

            $newImageName = 'assets/img/' . time() . '-' . pathinfo($request['profile-pic']->getClientOriginalName(),PATHINFO_FILENAME) . '.' . $request['profile-pic']->extension();
            $request['profile-pic']->move(public_path('/assets/img'),$newImageName);
            $user->fotoperfil = $newImageName;
        }
        if($request->hasFile('header-pic')){

            $newImageName2 = 'assets/img/' . time() . '-' . pathinfo($request['header-pic']->getClientOriginalName(),PATHINFO_FILENAME) . '.' . $request['header-pic']->extension();
            $request['header-pic']->move(public_path('/assets/img'),$newImageName2);
            $user->fotoheader = $newImageName2;
        }

        $validated1=$request->validate([
            'course'=>'max:255',
            'year'=>'numeric'
        ]);

        if(utilizadorEstudante::where('id',$id)->exists()){
           if(!is_null($request['course'])){
            utilizadorEstudante::where('id',$id)->update([
                    'curso'=> $request->course]);
        }
           if(!is_null($request['year'])){
            utilizadorEstudante::where('id',$id)->update([
                    'anocorrente'=> $request->year
                    ]);
        }
        }

        $validated2=$request->validate([
            'formation'=>'max:255',
            'departamento'=>'max:255'
        ]);
        if(utilizadorDocente::where('id',$id)->exists()){
           if(!is_null($request['formation'])){
            utilizadorDocente::where('id',$id)->update([
                    'formacao'=> $request->formation]);
        }
           if(!is_null($request['department'])){
            utilizadorDocente::where('id',$id)->update([
                    'departamento'=> $request->department
                    ]);
        }
        }
        
        $user->save();
        return redirect()->route('show_profile', ['id' => Auth::id()]);           
    }

    //Delete user
    public function delete(Request $request, $id){
        if(!Auth::check()) return redirect('/login');
        $user = User::find($id);
        if(is_null($user))
           return view('layouts.error204');
        $user->delete(); //Don't have to do it directly on utilizadorEstudante and utilizadorDocente because of the DELETE ON CASCADE
        return redirect()->intended('login');
    } 
    
    public function choosePath(){
       $user=User::find(Auth::id());
       if(is_null($user))
           return view('layouts.error204');
       return view('pages.choose_path', [
                    'user' => $user
                ]);
    }
    
    public function createDocente(Request $request){
       $user=Auth::id();
       if(is_null($user))
           return view('layouts.error204');
       $validated=$request->validate([
            'formation'=>'required|max:255',
            'department'=>'required|max:255'
       ]);
       $formacao=$request['formation'];
       $departamento=$request['department'];
       $docente= new utilizadorDocente();
       $docente->id=$user;
       $docente->departamento=$departamento;
       $docente->formacao=$formacao;
       $docente->save();
        return redirect()->route('show_profile', ['id' => Auth::id()]);           
    }
    
    public function createEstudante(Request $request){
       $user=Auth::id();
       if(is_null($user))
           return view('layouts.error204');
       $validated=$request->validate([
            'course'=>'required|max:255',
            'media'=>'required|numeric',
            'year'=>'required|numeric'
       ]);
       $curso=$request['course'];
       $ano=$request['year'];
       $media=$request['media'];
       $estudante=new utilizadorEstudante();
       $estudante->id=$user;
       $estudante->curso=$curso;
       $estudante->media=$media;
       $estudante->anocorrente=$ano;
       $estudante->save();
        return redirect()->route('show_profile', ['id' => Auth::id()]);           
    }

    public function showFriends(){
        if(!Auth::check()) return redirect('/login');
        $users=User::find(Auth::id())->friends;
        if($users->isEmpty()){
            return view('layouts.error204');
        }
        return view('pages.friends',['users'=>$users]);
    }

    public function breakup($id){
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        
        if(Friendship::where('utilizador1',Auth::id())->where('utilizador2',$id)->where('tipo_pedido','confirmed')->exists()){
            $friend=Friendship::where('utilizador1',Auth::id())->where('utilizador2',$id)->where('tipo_pedido','confirmed')->get();
            $friend->each->delete();

            Notificacao::where('idutilizador',Auth::id())->where('idposter',$id)->delete();
            return $friend;
        }
        else if(Friendship::where('utilizador1',$id)->where('utilizador2',Auth::id())->where('tipo_pedido','confirmed')->exists()){
            $friend=Friendship::where('utilizador1',$id)->where('utilizador2',Auth::id())->where('tipo_pedido','confirmed')->get();
            $friend->each->delete();

            Notificacao::where('idutilizador',Auth::id())->where('idposter',$id)->delete();
            return $friend;
        }
        else{
            return view('layouts.error204');
        }
    }
    
    public function sendFriendshipRequest($id){
        /*
            Sending a friend request: utilizador1 = id of the user who is sending
            the friend request, utilizador2, user who's receiving it. tipo_pedido='pending'
        */
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $friendship = new Friendship();
        $friendship->utilizador1=Auth::id();
        $friendship->utilizador2=$id;
        $friendship->tipo_pedido='pending';
        $friendship->save();

        return $friendship;
    }

    public function reject_friendship_request($id){
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        
        $friend=Friendship::where('utilizador1',$id)->where('utilizador2',Auth::id())->where('tipo_pedido','pending')->get();
        $friend->each->delete();

        return $friend;
    }

    public function accept_friendship_request($id){
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $friend=Friendship::where('utilizador1',$id)->where('utilizador2',Auth::id())->update(['tipo_pedido'=>'confirmed']);
       
        return $friend;
    }
}