<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Facades\DB;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

 
class ExampleRepository extends EloquentRepositoryAbstract {

    public function __construct()
    {
        $this->Database = DB::table('user');
 
        $this->visibleColumns = array('Uname','Name','Family');
 
        $this->orderBy = array(array('user.id', 'asc'), array('user.Uname', 'desc'));
    }
}