<?php

namespace App\Models\hamafza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Subject extends Model
{
    use softdeletes;
    protected $table = 'subjects';

    public function subject_type()
    {
        return $this->belongsTo('App\Models\hamafza\SubjectType', 'kind');
    }

    public function pages()
    {
        return $this->hasMany('App\Models\hamafza\Pages', 'sid');
    }

    public function thesaurus_keywords()
    {
        return $this->belongsToMany('App\Models\hamafza\Keyword', 'thesaurus_keywords', 'subject_id', 'keyword_id');
    }

    public function keywords()
    {
        return $this->belongsToMany('App\Models\hamafza\Keyword', 'subject_key', 'sid', 'kid');
    }

    public function fieldsValue()
    {
        return $this->hasMany('App\Models\hamafza\SubjectFieldValue', 'sid', 'id');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\hamafza\Post', 'sid', 'id');
    }

    public static function page_tabs($subject_id)
    {
        //\DB::enableQueryLog();
        $pages =
            \DB::table('pages as p')
                ->leftJoin('subjects as s', 's.id', '=', 'p.sid')
                ->leftJoin('subject_type_tab as stt', 'stt.tid', '=', 'p.type')
                ->join('tab_view as tv', 'tv.tabid', '=', 'stt.id')
                ->where('p.sid', '=', $subject_id)
                ->whereColumn('stt.stid', '=', 's.kind')
                ->where('tv.sid', '=', $subject_id)
                ->where('stt.view', '=', '1')
                ->select('p.id as link', 'p.id as href', 'stt.name as title')
                ->groupBy('p.id')
                ->orderBy('stt.orders')
                ->get();
        //dd($pages,\DB::getQueryLog());
        $pages_tabs = json_decode(json_encode($pages));
        foreach ($pages_tabs as $value)
        {
            $value->selected = "false";
            if ($subject_id == $value->href)
            {
                $value->selected = "true";
            }
        }
        return $pages_tabs;
    }

    public function product_info()
    {
        return $this->hasOne('App\Models\Hamahang\SubjectsProductInfo', 'subject_id');
    }

    public function subject_like()
    {
        return $this->hasMany('App\Models\Hamahang\SubjectLike', 'sid');
    }

    public function getApiPostsAttribute()
    {
        $res = [];
        if (isset($this->posts))
        {
            foreach ($this->posts as $post)
            {
                $user_avarat_url = route('FileManager.DownloadFile', ['type' => "ID", 'id' => $post->user->avatar]);
                $user = $post->user;
                $comments= $post->comments;
                $comments_count = $comments->count();
                $liks = $post->user_likes;
                $liks_count = $liks->count();
                $res [] =
                    [
                        'post_id' => "$post->id",
                        'user_id' => "$post->uid",
                        'pic' => "$user_avarat_url",
                        'time' => "$post->HumanCreateTime",
                        'full_name' => "$user->FullName",
                        'post' => "$post->desc",
                        'comment_count' => "$comments_count",
                        'like_count' => "$liks_count"
                    ];
            }
        }
        return $res;
    }

    public function getShortFirstPageDescriptionAttribute()
    {
        //$subject = Subject::find(36626);
        if (isset($this->pages[0]))
        {
            $page = $this->pages[0];
            $description = $page->description;
        } else
        {
            $description = false;
        }
        return $description;
    }

    public function getDefImageExistAttribute()
    {
        //$subject = Subject::find(36626);
        if (isset($this->pages[0]))
        {
            $page = $this->pages[0];
            $defimage = $page->defimage;
        } else
        {
            $defimage = false;
        }
        return $defimage;
    }

    public function getDefImageUrlAttribute()
    {
        //$subject = Subject::find(36626);
        if (isset($this->pages[0]))
        {
            $page = $this->pages[0];
            $defimage = $page->defimage;
        } else
        {
            $defimage = -1;
        }
        return route('FileManager.DownloadFile', ['type' => 'ID', 'id' => enCode($defimage)]);
    }

    public function getDefImageAttribute()
    {
        return '<img src="' . $this->DefImageUrl . '" />';
    }

    public function listfields()
    {
        return $this->belongsToMany('App\Models\hamafza\SubjectTypeField', 'subject_fields_report', 'sid', 'field_id');
    }

    //policy
    public function user_policies_view()
    {
        return $this->morphToMany('App\User', 'target', 'hamahang_user_policies','target_id','user_id')->wherePivot('type','1');
    }

    public function role_policies_view()
    {
        return $this->morphToMany('App\Role', 'target', 'hamahang_role_policies','target_id','role_id')->wherePivot('type','1');
    }

    public function user_policies_edit()
    {
        return $this->morphToMany('App\User', 'target', 'hamahang_user_policies','target_id','user_id')->wherePivot('type','2');
    }

    public function role_policies_edit()
    {
        return $this->morphToMany('App\Role', 'target', 'hamahang_role_policies','target_id','role_id')->wherePivot('type','2');
    }

    public function getPermittedUsersViewAttribute()
    {
        $permitted_users = $this->user_policies_view()->get(['hamahang_user_policies.user_id', 'Name', 'Family'])->toArray();
        return $permitted_users;
    }

    public function getPermittedRolesViewAttribute()
    {
        $permitted_roles = $this->role_policies_view()->get(['hamahang_role_policies.role_id', 'name', 'display_name'])->toArray();
        return $permitted_roles;
    }

    public function getPermittedUsersEditAttribute()
    {
        $permitted_users = $this->user_policies_edit()->get(['hamahang_user_policies.user_id', 'Name', 'Family'])->toArray();
        return $permitted_users;
    }

    public function getPermittedRolesEditAttribute()
    {
        $permitted_roles = $this->role_policies_edit()->get(['hamahang_role_policies.role_id', 'name', 'display_name'])->toArray();
        return $permitted_roles;
    }
    //policy

    public function getJalaliRegDateAttribute()
    {
        return HDate_GtoJ($this->reg_date, "H:i - Y/m/d");
    }

    public function getJalaliRegDateNameAttribute()
    {
        $diff = h_human_date(strtotime($this->reg_date));
        $r = false === $diff ? $this->JalaliRegDate : "$diff " . trans('enquiry.past');
        return $r;
    }

    public function owner()
    {
        return $this->hasOne('App\User', 'id', 'admin');
    }

    public function getIsOwnerAttribute()
    {
        return $this->admin == auth()->id();
    }

    public function getLastEditionAttribute()
    {
        $biggerDate = '0000-00-00 00:00:00';

        foreach($this->pages()->get() as $page){
            if($page->edit_date >  $biggerDate)
                $biggerDate = $page->edit_date;
        }

        return HDate_GtoJ($biggerDate, "H:i - Y/m/d");
    }

    /*
    public function getMeta---FieldsAttribute()
    {
        dd($this->toArray());
        $r = [];
        $fields = $this->listfields;
        $values = $this->fieldsValue;
        foreach ($fields as $k => $v)
        {
            $r[$v['name']] = $values[$k]['field_value'];
        }
        return $r;
    }
    */

    public function getMetaFieldsAttribute()
    {
        $fields = $this->subject_type->fields;
        foreach ($fields as $field)
        {
            $value = $this->fieldsValue()->where('field_id', $field->id)->first();
            if ($value)
            {
                $field->field_value = $value->field_value;
            } else
            {
                $field->field_value = '';
            }
        }
        return $fields;
    }

    public function tabs()
    {
        return $this->belongsToMany('\App\Models\hamafza\SubjectTypeTab','tab_view', 'sid', 'tabid');
    }

}

