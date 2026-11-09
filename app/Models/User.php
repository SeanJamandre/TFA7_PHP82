<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
// Account records for this classroom POS module; login is handled by TFA6 if present.
class User extends Model { protected $fillable = ['username', 'full_name', 'avatar']; }
