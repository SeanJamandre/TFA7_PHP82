<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UserRequest extends FormRequest {
 public function authorize(): bool { return true; }
 public function rules(): array {
  $unique = Rule::unique('users','username');
  if ($user = $this->route('user')) { $unique->ignore($user); }
  return ['username'=>['required','string','max:255',$unique], 'full_name'=>['required','string','max:255'], 'avatar'=>['nullable','image','mimes:jpg,jpeg,png','max:2048','dimensions:max_width=4096,max_height=4096']];
 }
}
