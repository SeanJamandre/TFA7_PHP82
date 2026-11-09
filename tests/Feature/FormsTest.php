<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
class FormsTest extends TestCase {
 use RefreshDatabase;
 public function test_customers_validate_create_and_update(): void {
  $this->from('/customers/create')->post('/customers',['full_name'=>'Ana','email'=>'invalid'])->assertSessionHasErrors('email')->assertSessionHasInput('full_name','Ana');
  $this->post('/customers',['full_name'=>'Ana','email'=>'ana@example.com'])->assertRedirect('/customers');
  $c=Customer::first();
  $this->get("/customers/{$c->id}/edit")->assertOk()->assertSee('ana@example.com');
  $this->put("/customers/{$c->id}",['full_name'=>'Ana Reyes','email'=>'ana@example.com'])->assertRedirect('/customers');
  $this->assertDatabaseHas('customers',['full_name'=>'Ana Reyes']);
 }
 public function test_username_unique_but_same_username_allowed_on_update(): void {
  $this->post('/users',['username'=>'sean','full_name'=>'Sean'])->assertRedirect('/users');
  $this->post('/users',['username'=>'sean','full_name'=>'Other'])->assertSessionHasErrors('username');
  $u=User::first();
  $this->put("/users/{$u->id}",['username'=>'sean','full_name'=>'Sean James'])->assertSessionHasNoErrors();
  $this->post('/users',[])->assertSessionHasErrors(['username','full_name']);
 }
 public function test_avatar_is_prepared_preserved_and_replaced(): void {
  Storage::fake('public');
  $u=User::create(['username'=>'test','full_name'=>'Test']);
  $data=['username'=>'test','full_name'=>'Test'];
  $this->put("/users/{$u->id}",$data+['avatar'=>UploadedFile::fake()->image('face.png',400,300)])->assertSessionHasNoErrors();
  $old=$u->fresh()->avatar;
  Storage::disk('public')->assertExists($old);
  $size=getimagesize(Storage::disk('public')->path($old));
  $this->assertSame([256,256],[$size[0],$size[1]]);
  $this->assertSame('image/jpeg',$size['mime']);
  $this->put("/users/{$u->id}",$data)->assertSessionHasNoErrors();
  $this->assertSame($old,$u->fresh()->avatar);
  $this->put("/users/{$u->id}",$data+['avatar'=>UploadedFile::fake()->image('next.jpg')])->assertSessionHasNoErrors();
  Storage::disk('public')->assertMissing($old);
  Storage::disk('public')->assertExists($u->fresh()->avatar);
 }
 public function test_bad_uploads_are_rejected_and_placeholder_is_shown(): void {
  Storage::fake('public');
  User::create(['username'=>'demo','full_name'=>'Demo']);
  $this->get('/users')->assertOk()->assertSee('avatar-placeholder.svg');
  $data=['username'=>'new','full_name'=>'New'];
  $this->post('/users',$data+['avatar'=>UploadedFile::fake()->create('bad.txt',1,'text/plain')])->assertSessionHasErrors('avatar');
  $this->post('/users',$data+['avatar'=>UploadedFile::fake()->image('big.jpg')->size(2049)])->assertSessionHasErrors('avatar');
  $this->assertCount(0,Storage::disk('public')->allFiles());
 }
}
