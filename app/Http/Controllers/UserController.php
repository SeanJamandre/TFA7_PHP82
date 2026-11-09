<?php
namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\AvatarService;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller {
 public function index() { return view('users.index',['users'=>User::latest()->get()]); }
 public function create() { return view('users.form',['user'=>new User]); }
 public function store(UserRequest $request, AvatarService $avatars) {
  $this->save($request,new User,$avatars);
  return to_route('users.index')->with('success','User created.');
 }
 public function edit(User $user) { return view('users.form',compact('user')); }
 public function update(UserRequest $request, User $user, AvatarService $avatars) {
  $this->save($request,$user,$avatars);
  return to_route('users.index')->with('success','User updated.');
 }
 private function save(UserRequest $request, User $user, AvatarService $avatars): void {
  $data = $request->safe()->only(['username','full_name']);
  $old = $user->avatar; $new = null;
  if ($request->hasFile('avatar')) { $new = $avatars->store($request->file('avatar')); $data['avatar'] = $new; }
  try { $user->fill($data)->save(); }
  catch (\Throwable $exception) { if ($new) { Storage::disk('public')->delete($new); } throw $exception; }
  if ($new && $old && str_starts_with($old,'avatars/')) { Storage::disk('public')->delete($old); }
 }
}
