<?php
namespace App\Services;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Validation\ValidationException;
class AvatarService {
 public function store(UploadedFile $file): string {
  try {
   $manager = new ImageManager(new Driver());
   $image = $manager->read($file->getRealPath())->cover(256,256);
   $encoded = (string) $image->toJpeg(85);
  } catch (\Throwable $exception) {
   throw ValidationException::withMessages(['avatar'=>'This image could not be processed. Try another JPG or PNG.']);
  }
  $path = 'avatars/'.Str::uuid().'.jpg';
  Storage::disk('public')->put($path,$encoded);
  return $path;
 }
}
