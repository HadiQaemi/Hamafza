<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketFile extends Model
{
    use softdeletes;
    protected $table = 'ticket_file';
}