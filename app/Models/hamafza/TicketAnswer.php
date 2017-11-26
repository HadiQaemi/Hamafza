<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketAnswer extends Model
{
    use softdeletes;
    protected $table = 'ticket_answer';
}