<?php

//https://laravel.com/docs/8.x/database
//https://www.thiscodeworks.com/how-to-call-a-controller-function-in-another-controller-in-laravel-5-php/60ba3bcb2a26a50014a43d66

namespace App\Http\Controllers;

use App\Models\grupoUtilizador;
use App\Models\Grupo;
use App\Models\Publicacao;
use App\Models\User;
use App\Http\Controllers\PostController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Image;

/*
FR.212 Manage Group Invitations-->Here + Notifications 
*/

//Don't need to make a function to comment on group because those comments only concern the owner of the post

class GrupoController extends Controller
{
    public function show($id) { //settings + posts (kinda like profile)
        $group=Grupo::find($id);
       
        if(is_null($group))
               return view('layouts.error204');

        $posts=Publicacao::where('idgrupo',$id)->where('idutilizador','!=',NULL)->get();

        if(Auth::guard('admin')->check()){
                return view('admin.admin_view_group_mem_pub',[
                    'group'=>$group,
                    'posts'=>$posts
                ]);
        }

        //Visitantes and non group members can see the same amount of info, except the last ones can ask to join
        //They can't see posts or members(see the last one in blade)

        if($group->privacidade=='public' || grupoUtilizador::where('idutilizador',Auth::id())->where('tipo_pedido','confirmed')->exists() || $group->moderador==Auth::id()){
            //Get posts

            if(Auth::guard('admin')->check()){
                return view('admin.admin_view_group_mem_pub',[
                    'group'=>$group,
                    'posts'=>$posts
                ]);
            }

            return view('pages.view_group_mem_pub',[
                'group'=>$group,
                'posts'=>$posts
            ]);
        }

        return view('pages.view_group_priv',[
            'group'=>$group
        ]);    
    }

    public function getCreateView(){
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        return view('pages.create_grupo');
    }

    public function create(Request $request) {
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $group=new Grupo();
        $validated=$request->validate([
            'name'=>'required|max:255',
            'description'=>'max:255',
            'profile-pic'=>'required|mimes:jpg,png,jpeg|max:5048',
            'header-pic'=>'required|mimes:jpg,png,jpeg|max:5048'
        ]);
        if($request->btnradio=='public'){
            $group->privacidade='public';
        }
        if($request->btnradio=='private'){
            $group->privacidade='private';
        }
        if($request->btnradio1=='lazer'){
            $group->tipo='lazer';
        }
        if($request->btnradio1=='work'){
            $group->tipo='work';
        }
        $group->nome=$request['name'];
        $group->descricao=$request['description'];
        if($request->hasFile('profile-pic')){

            $newImageName = 'assets/img/' . time() . '-' . pathinfo($request['profile-pic']->getClientOriginalName(),PATHINFO_FILENAME) . '.' . $request['profile-pic']->extension();
            $request['profile-pic']->move(public_path('/assets/img'),$newImageName);
            $group->fotoperfil = $newImageName;
        }
        if($request->hasFile('header-pic')){

            $newImageName2 = 'assets/img/' . time() . '-' . pathinfo($request['header-pic']->getClientOriginalName(),PATHINFO_FILENAME) . '.' . $request['header-pic']->extension();
            $request['header-pic']->move(public_path('/assets/img'),$newImageName2);
            $group->fotoheader = $newImageName2;
        }
        $group->moderador=Auth::id();
        $group->save();

        $users_invite=User::where('id','!=',Auth::id())->get();

        return view('pages.invite_people',[
            'group'=>$group,
            'users'=>$users_invite
        ]);
                  
    }

    public function showMembers($id){
        $group=Grupo::find($id);
        if(is_null($group)){
            return view('layouts.error204');
        }
        if(Auth::guard('admin')->check()){
            return view('admin.show_group_members',[
                'group'=>$group,
                'users'=>$group->members
            ]);
        }
        if(!Auth::check()) return redirect('/login'); 
        if($group->privacidade=='public' || grupoUtilizador::where('idutilizador',Auth::id())->where('tipo_pedido','confirmed')->exists() || $group->moderador=Auth::id()){
            return view('pages.group_members',[
                'group'=>$group,
                'users'=>$group->members
            ]);
        }
        else{
            return view('layouts.error403');
        }
    }

    public function addMember($id,$id_user){ //only moderator
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $group=Grupo::find($id);
        if(is_null($group)){
            return view('layouts.error204');
        }
        if($group->moderador==Auth::id()){
            $member= grupoUtilizador::where('idutilizador',$id_user)->where('idgrupo',$id)->update(['tipo_pedido'=>'confirmed']);
            return $member;
        }
        else{
            return view('layouts.error403');
        }

    }

    public function rejectRequest($id,$id_user){
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $group=Grupo::find($id);
        if(is_null($group)){
            return view('layouts.error204');
        }
        if($group->moderador==Auth::id()){
            $member= grupoUtilizador::where('idutilizador',$id_user)->where('idgrupo',$id)->where('tipo_pedido','pending')->get();
            $member->each->delete();
            return $member;
        }
        else{
            return view('layouts.error403');
        }
    }

    public function deleteMember($id,$id_user){ //only moderator
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $group=Grupo::find($id);
        if(is_null($group)){
            return view('layouts.error204');
        }
        if($group->moderador==Auth::id()){
            $member= grupoUtilizador::where('idutilizador',$id_user)->where('idgrupo',$id)->where('tipo_pedido','confirmed')->get();
            $member->each->delete();
            return $member;
        }
        else{
            return view('layouts.error403');
        }
    }

    public function leave($id){ //any group member
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $group=Grupo::find($id);
        if(is_null($group)){
            return view('layouts.error204');
        }
        if(grupoUtilizador::where('idutilizador',Auth::id())->where('tipo_pedido','confirmed')->exists()){
            grupoUtilizador::where('idutilizador',Auth::id())->delete();
            return redirect()->intended('fyf');
        }
        else{
            return view('layouts.error204');
        }

    }

    public function update($id){ 
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $group=Grupo::find($id);
        if(is_null($group)){
            return view('layouts.error204');
        }
        if($group->moderador==Auth::id()){
            if(is_null($group)){
                return view('layouts.error204');
            }
            
            return view('pages.edit_grupo', [
                'group' => $group
            ]);
        }
        else{
            return view('layouts.error403');
        }
    }

    public function edit(Request $request,$id){ //only moderator 
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $group=Grupo::find($id);
        if(is_null($group)){
            return view('layouts.error204');
        }
        if($group->moderador==Auth::id()){
            if(is_null($group)){
                return view('layouts.error204');
            }

            $validated=$request->validate([
                'name'=>'nullable|max:255',
                'description'=>'nullable|max:255',
                'profile-pic'=>'nullable|mimes:jpg,png,jpeg|max:5048',
                'header-pic'=>'nullable|mimes:jpg,png,jpeg|max:5048',
                'btnradio'=>'nullable',
                'btnradio'=>'nullable'
            ]);

            if(!is_null($request['name'])){
                $group->nome=$request['name'];
            }
            if(!is_null($request['description'])){
                $group->descricao=$request['description'];
            }
            if($request->btnradio=='public'){
                $group->privacidade='public';
            }
            if($request->btnradio=='private'){
                $group->privacidade='private';
            }
            if($request->btnradio1=='lazer'){
                $group->tipo='lazer';
            }
            if($request->btnradio1=='work'){
                $group->tipo='work';
            }
            if($request->hasFile('profile-pic')){
     
                 $newImageName = 'assets/img/' . time() . '-' . pathinfo($request['profile-pic']->getClientOriginalName(),PATHINFO_FILENAME) . '.' . $request['profile-pic']->extension();
                 $request['profile-pic']->move(public_path('/assets/img'),$newImageName);
                 $group->fotoperfil = $newImageName;
             }
            if($request->hasFile('header-pic')){
     
                 $newImageName2 = 'assets/img/' . time() . '-' . pathinfo($request['header-pic']->getClientOriginalName(),PATHINFO_FILENAME) . '.' . $request['header-pic']->extension();
                 $request['header-pic']->move(public_path('/assets/img'),$newImageName2);
                 $group->fotoheader = $newImageName2;
             }

            $group->save();

            return redirect()->route('show_group', ['id' => $group->id]);           
        }
        else{
            return view('layouts.error403');
        }

    }

    public function delete($id){ //need to check if auth is moderator
        if(!(Auth::check() || Auth::guard('admin')->check())) return redirect('/login');
        if(!Auth::guard('admin')->check()){
            if(Auth::user()->is_banned) return view('layouts.error403');
        }
        $group=Grupo::find($id);
        if(is_null($group)){
            return view('layouts.error204');
        }
        if($group->moderador==Auth::id() || Auth::guard('admin')->check()){
            $group->delete();
        }
        else{
            return view('layouts.error403');
        }
        if(Auth::guard('admin')->check()){
            return redirect()->intended(route('admin.admin_view_users'));
        }
        return redirect()->intended('fyf');
    }

    public function askToJoin($id){
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $group=Grupo::find($id);
        if(is_null($group)){
            return view('layouts.error204');
        }
        if(!(grupoUtilizador::where('idgrupo',$id)->where('idutilizador',Auth::id())->exists())){
            $member= new grupoUtilizador();
            $member->idgrupo=$id;
            $member->idutilizador=Auth::id();
            $member->tipo_pedido='pending';
            $member->save();
            return $member;
        }
        else{
            //you already asked to join stay calm
        }
    }

    public function viewRequests($id){
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $group=Grupo::find($id);
        if(is_null($group)){
            return view('layouts.error204');
        }
        if($group->moderador==Auth::id()){
            if($group->requests->isEmpty()){
                return view('layouts.error204');
            }
            return view('pages.group_requests',[
                'group'=>$group
            ]);
        }
        else{
            return view('layouts.error403');
        }
    }

    public function addPost(Request $request, $idgroup){
      if(!Auth::check()) return redirect('/login');
      if(Auth::user()->is_banned) return view('layouts.error403');
      $group=Grupo::find($idgroup);
      if(is_null($group)){
          return view('layouts.error204');
      }
      $post=new Publicacao();
      $post->numerogostos=0;
      $post->numerocomentarios=0;
      $validated=$request->validate([
        'body'=>'max:255',
        'annex'=>'mimes:jpg,png,jpeg|max:5048'
     ]);
     
      $post->conteudo=$request['body'];
      if($request->hasFile('annex')){
        $newImageName = 'assets/img/' . time() . '-' . pathinfo($request['annex']->getClientOriginalName(),PATHINFO_FILENAME) . '.' . $request['annex']->extension();
        $request['annex']->move(public_path('/assets/img'),$newImageName);
        $post->anexo = $newImageName;
     }

      $post->idutilizador= Auth::id();
      
      $post->privacidade=$group->privacidade;
      $post->idgrupo=$idgroup;
      $post->save();
      $post->member=Auth::user();
        
      return back();
    }

    public function sendRequestUser($id, $id_user){
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $group=Grupo::find($id);
        if(is_null($group)){
            return view('layouts.error204');
        }
        if($group->moderador==Auth::id()){
            if(!(grupoUtilizador::where('idgrupo',$id)->where('idutilizador',$id_user)->exists())){
                $member= new grupoUtilizador();
                $member->idgrupo=$id;
                $member->idutilizador=$id_user;
                $member->tipo_pedido='group_join';
                $member->save();
                return $member;
            }
        }
        else{
            return view('layouts.error403');
        }
    }

    public function acceptJoin($id){
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $group=Grupo::find($id);
        if(is_null($group)){
            return view('layouts.error204');
        }
        if(grupoUtilizador::where('idgrupo',$id)->where('idutilizador',Auth::id())->where('tipo_pedido','group_join')->exists()){
            $member= grupoUtilizador::where('idutilizador',Auth::id())->where('idgrupo',$id)->update(['tipo_pedido'=>'confirmed']);
            return $member;
        }
    }

    public function rejectJoin($id){
        if(!Auth::check()) return redirect('/login');
        if(Auth::user()->is_banned) return view('layouts.error403');
        $group=Grupo::find($id);
        if(is_null($group)){
            return view('layouts.error204');
        }
        if(grupoUtilizador::where('idgrupo',$id)->where('idutilizador',Auth::id())->where('tipo_pedido','group_join')->exists()){
            $member=grupoUtilizador::where('idutilizador',Auth::id())->where('idgrupo',$id)->where('tipo_pedido','group_join')->get();
            $member->each->delete();
            return $member;
        }
    else{
        return view('layouts.error403');
    }
    }
}

