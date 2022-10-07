<?php

namespace App\Models;

use App\Http\Filters\ContactUsFilter;
use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $filter = ContactUsFilter::class;


    protected $table    =   'contact_us';
    protected $guarded  =   ['id'];
}
