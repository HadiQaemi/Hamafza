<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use LaratrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user';
    protected $fillable = [
        'Uname', 'Email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

//    public function province()
//    {
//        return $this->hasOne('App\Models\Hamahang\ProvinceCity\Province', 'id', 'Province');
//    }
    public function org_charts(){
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_charts');
    }
    public function chart_items_posts(){
        return $this->hasMany('App\Models\Hamahang\OrgChart\org_charts_items_posts');
    }
    public function ticket(){
        return $this->hasMany('App\Models\Hamahang\Ticket\Ticket','uid','id');
    }

    public function getAvatarLinkAttribute()
    {
        return route('FileManager.DownloadFile', ['type' => 'ID', 'id' => $this->avatar ? enCode($this->avatar) : -1, 'default_img' => 'user_avatar.png']);
    }

    public function getSmallAvatarAttribute()
    {
        return '<a href="' . url($this->Uname) . '"><img src="' . $this->avatar_link  . '" style="border: 1px solid #eee; padding: 1px; margin: 0 5px; border-radius: 25px; height: 25px; width: 25px;" /></a>';
    }
    public function getBetweenSmallandBigAttribute()
    {
        return '<a href="' . url($this->Uname) . '"><img src="' . $this->avatar_link . '" style="border: 1px solid #eee; padding: 1px; margin: 0 5px; border-radius: 30px; height: 30px; width: 30px;" /></a>';;
    }

    public function getSmallAvatar2Attribute()
    {
        return '<a target="_blank" href="' . url($this->Uname) . '"><img src="' . $this->avatar_link . '"  style="border: 1px solid #eee; padding: 1px; margin: 0 5px; border-radius: 35px; height: 35px; width: 35px;" /></a>';
    }

    public function getMediumAvatarAttribute()
    {
        return '<a target="_blank" href="' . url($this->Uname) . '"><img src="' . $this->avatar_link . '"  style="border: 1px solid #eee; padding: 1px; margin: 0 5px; border-radius: 50px; height: 50px; width: 50px;" /></a>';
    }

    public function getLargAvatarAttribute()
    {
        return '<a target="_blank" href="' . url($this->Uname) . '"><img src="' . $this->avatar_link . '"  style="border: 1px solid #eee; padding: 1px; margin: 0 5px; border-radius: 80px; height: 80px; width: 80px;" /></a>';
    }

    public function posts()
    {
        return $this->hasMany('App\Models\hamafza\Post', 'uid');
    }

    public function getApiPostsAttribute()
    {
        $res = [];

        foreach ($this->posts as $post)
        {
            $user_avarat_url = route('FileManager.DownloadFile', ['type' => "ID", 'id' => $post->user->avatar, 'default_img' => 'user_avatar.png']);
            $user = $post->user;
            $comments = $post->comments;
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
        return $res;
    }

    public function post_comments()
    {
        return $this->hasMany('App\Models\hamafza\PostComment', 'uid');
    }

    public function profile()
    {
        return $this->hasOne('App\Models\hamafza\UserProfile', 'uid');
    }

    public function avatar_info()
    {
        return $this->hasOne('App\Models\Hamahang\FileManager\FileManager', 'id', 'avatar');
    }

    /*
    public static function sumScoresStatic($user_id = -1)
    {
        $r = null;
        $user_id = -1 == $user_id ? auth()->id() : $user_id ;
        $r = DB::table('hamahang_scores AS S')
            ->join('hamahang_basicdata_values AS V', 'S.type_value_id', '=', 'V.id')
            ->where('V.parent_id', '1')
            ->where('S.uid', $user_id)
            ->select('V.value')
            ->get()->sum('value');
        return $r;
    }
    */

    public function getTotalScoresAttribute()
    {
        return $this->sumScores + $this->sumRewardsAdd - $this->sumRewardsReduce;
    }

    public function getFullNameAttribute()
    {
        return trim($this->Name) . ' ' . trim($this->Family);
    }

    public function getSumScoresAttribute()
    {
        return $this->scores()->get()->sum('value');
        //return self::sumScoresStatic();
    }

    public function getSumRewardsAddAttribute()
    {
        return $this->rewards_add()->get()->sum('score');
    }

    public function getSumRewardsReduceAttribute()
    {
        return $this->rewards_reduce()->get()->sum('score');
    }

    public function scores()
    {
        return $this->hasMany('App\Models\Hamahang\Score', 'uid');
    }

    public function spec_scores($type_value_id)
    {
        return $this->hasMany('App\Models\Hamahang\Score', 'uid')->where('type_value_id', $type_value_id);
    }

    public function rewards_add()
    {
        return $this->hasMany('App\Models\Hamahang\Reward', 'to_user_id');
    }

    public function rewards_reduce()
    {
        return $this->hasMany('App\Models\Hamahang\Reward', 'from_user_id');
    }

    public function endorsed_specials()
    {
        return $this->belongsToMany('App\Models\hamafza\UserSpecial', 'user_special_endorse', 'user_id', 'user_special_id');
    }

    public function subject_members_follow()
    {
        return $this->belongsToMany('App\Models\hamafza\Subject', 'subject_member', 'uid', 'sid')
            ->where('subjects.follow','>','0');
    }

    public function subject_members_like()
    {
        return $this->belongsToMany('App\Models\hamafza\Subject', 'subject_member', 'uid', 'sid')->where('subjects.like','>','0');
    }

    public function user_specials()
    {
        return $this->hasMany('App\Models\hamafza\UserSpecial', 'user_id', 'id');
    }

    public function specials()
    {
        return $this->belongsToMany('App\Models\hamafza\Keyword', 'user_special', 'user_id', 'keyword_id')->withPivot('id');;
    }

    public function getApiSpecialsAttribute()
    {
        $res = [];
        foreach ($this->specials as $special)
        {
            $res[] =
                [
                    [
                        'field' => 'title',
                        'title' => 'عنوان',
                        'value' => "$special->title"
                    ]
                ];
        }
        return $res;
    }


    public function works()
    {
        return $this->hasMany('App\Models\hamafza\UserWork', 'uid', 'id');
    }

    public function getApiWorksAttribute()
    {
        $res = [];
        foreach ($this->works as $work)
        {
            $res[] =
                [
                    [
                        'field' => 'post',
                        'title' => 'مسئولیت',
                        'value' => "$work->post"
                    ],
                    [
                        'field' => 'organ',
                        'title' => 'سازمان',
                        'value' => "$work->company"
                    ],
                    [
                        'field' => 'unit',
                        'title' => 'واحد سازمانی',
                        'value' => "$work->vahed"
                    ],
                    [
                        'field' => 'province',
                        'title' => 'استان',
                        'value' => "$work->province"
                    ],
                    [
                        'field' => 'city',
                        'title' => 'شهر',
                        'value' => "$work->city"
                    ],
                    [
                        'field' => 'start_date',
                        'title' => 'زمان شروع',
                        'value' => "$work->s_year"
                    ],
                    [
                        'field' => 'end_date',
                        'title' => 'زمان پایان',
                        'value' => "$work->e_year"
                    ],
                    [
                        'field' => 'description',
                        'title' => 'توضیحات',
                        'value' => "$work->comment"
                    ],
                ];
        }
        return $res;
    }


    public function educations()
    {
        return $this->hasMany('App\Models\hamafza\UserEducation', 'uid', 'id');
    }

    public function getApiEducationsAttribute()
    {
        $res = [];
        foreach ($this->Educations as $education)
        {
            $res[] =
                [
                    [
                        'field' => 'field',
                        'title' => 'رشته تحصیلی',
                        'value' => "$education->location"
                    ],
                    [
                        'field' => 'tendency',
                        'title' => 'گرایش',
                        'value' => "$education->trend"
                    ],
                    [
                        'field' => 'level',
                        'title' => 'مقطع تحصیلی',
                        'value' => "$education->level"
                    ],
                    [
                        'field' => 'university',
                        'title' => 'دانشگاه',
                        'value' => "$education->university"
                    ],
                    [
                        'field' => 'start_date',
                        'title' => 'تاریخ شروع',
                        'value' => "$education->s_year"
                    ],
                    [
                        'field' => 'end_date',
                        'title' => 'تاریخ پایان',
                        'value' => "$education->e_year"
                    ],
                    [
                        'field' => 'description',
                        'title' => 'توضیحات',
                        'value' => "$education->comment"
                    ],
                ];
        }
        return $res;
    }


    public function follower_persons()
    {
        return $this->belongsToMany('App\User', 'user_friend', 'uid', 'fid')->select('user.id');
    }

    public function followed_persons()
    {
        return $this->belongsToMany('App\User', 'user_friend', 'fid', 'uid');
    }

    public function UserGroupsANDChannels()
    {
        return $this->belongsToMany('App\Models\hamafza\Groups', 'user_group_member', 'uid', 'gid')
            ->withPivot('gid', 'relation', 'admin');
    }

    public function getApiUserGroupsAttribute()
    {
        $res = [];
        foreach ($this->UserGroupsANDChannels as $Group)
        {
            $pivot = $Group->pivot;
            $membership_title = $pivot->admin == 1 ? 'مدیر هستم' : 'عضو هستم';
            $res[] =
                [
                    'id' => "$pivot->gid",
                    'title' => "$Group->name",
                    'img' => 'https://srfatemi.ir/pics/group/Groups.png',
                    'count_new' => "$Group->new",
                    'membership_type' => "$pivot->relation",
                    'membership_title' => "$membership_title"
                ];
        }
        return $res;
    }

    public function getApiUserGroupsCountAttribute()
    {
        return $this->UserGroupsANDChannels->count();
    }

    public function getApiUserPersonsAttribute()
    {
        $followed_persons = array_unique(array_column($this->followed_persons->toArray(), 'id'));
        $follower_persons = array_unique(array_column($this->follower_persons->toArray(), 'id'));
        //$mutual_follow = array_diff($followed_persons, $follower_persons);
        $mutual_follow = array_intersect($followed_persons, $follower_persons);
        $just_followed_persons = array_diff($followed_persons, $mutual_follow);
        $just_follower_persons = array_diff($follower_persons, $mutual_follow);
        $res = [];
        foreach ($mutual_follow as $person_id)
        {
            $person = self::find($person_id);
            $res[] =
                [
                    'user_id' => "$person->uid",
                    'username' => "$person->Uname",
                    'first_name' => "$person->Name",
                    'last_name' => "$person->Family",
                    'pic' => "$person->AvatarLink",
                    'follow_her_type' => '1',
                    'follow_me_type' => '1',
                ];
        }
        foreach ($just_followed_persons as $person_id)
        {
            $person = self::find($person_id);
            $res[] =
                [
                    'user_id' => "$person->uid",
                    'username' => "$person->Uname",
                    'first_name' => "$person->Name",
                    'last_name' => "$person->Family",
                    'pic' => "$person->AvatarLink",
                    'follow_her_type' => '0',
                    'follow_me_type' => '1',
                ];
        }
        foreach ($just_follower_persons as $person_id)
        {
            $person = self::find($person_id);
            $res[] =
                [
                    'user_id' => "$person->uid",
                    'username' => "$person->Uname",
                    'first_name' => "$person->Name",
                    'last_name' => "$person->Family",
                    'pic' => "$person->AvatarLink",
                    'follow_her_type' => '1',
                    'follow_me_type' => '0',
                ];
        }
        return $res;
    }

    public function getUserPersonsCountAttribute()
    {
        $followed_persons = array_unique(array_column($this->followed_persons->toArray(), 'id'));
        $follower_persons = array_unique(array_column($this->follower_persons->toArray(), 'id'));
        $total_person = array_unique($follower_persons + $followed_persons);
        return count($total_person);
    }

    public function Announces()
    {
        return $this->hasMany('App\Models\hamafza\Announces', 'uid', 'id');
    }

    public function getAnnouncesCountAttribute()
    {
        $res = $this->Announces()->count();
        return $res;
    }

    public function getApiAnnouncesAttribute()
    {
        $res = [];
        foreach ($this->Announces as $note)
        {
            $res[] =
                [
                    'id' => "$note->id",
                    'title' => "$note->title",
                    'description' => "$note->comment",
                    'quote' => "$note->quote",
                    'page_id' => "$note->pid",
                    'reg_date' => "$note->jalali_reg_date"
                ];
        }

        return $res;
    }

    public function MyTasks()
    {
        return $this->belongsToMany('App\Models\Hamahang\Tasks\tasks', 'hamahang_task_assignments', 'employee_id', 'task_id');
    }

    public function getMyTasksCountAttribute()
    {
        return $this->MyTasks->count();
    }

    public function MyAssignedTasks()
    {
        return $this->belongsToMany('App\Models\Hamahang\Tasks\tasks', 'hamahang_task_assignments', 'assigner_id', 'task_id');
    }

    public function getMyAssignedTasksCountAttribute()
    {
        return $this->MyAssignedTasks->count();
    }

    public function MyDraftTasks()
    {
        return $this->hasMany('App\Models\Hamahang\Tasks\drafts', 'user_id', 'id');
    }

    public function getMyDraftTasksCountAttribute()
    {
        return $this->MyDraftTasks->count();
    }

    public function menuItems()
    {
        return $this->morphedByMany('App\Models\MenuItem', 'target');
    }

    public function _roles()
    {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }

    public function Forms()
    {
        return $this->hasMany('App\Models\hamafza\Form', 'admin');
    }

    public function getFormsCountAttribute()
    {
        return $this->Forms()->count();
    }

    public function Highlights()
    {
        return $this->hasMany('App\Models\hamafza\Highlight', 'uid');
    }

    public function getHighlightsCountAttribute()
    {
        return $this->Highlights()->count();
    }

    public function Emails()
    {
        return $this->hasMany('App\Models\hamafza\Emails', 'uid');
    }

    public function getEmailsCountAttribute()
    {
        return $this->Emails()->count();
    }

    public function getNewEmailsCountAttribute()
    {
        return $this->Emails()
            ->where('read', '0')
            ->where('view', '0')
            ->count();
    }

    public function RecieveTickets()
    {
        return $this->belongsToMany('App\Models\hamafza\Ticket', 'ticket_recieve', 'uid', 'tid');
    }

    public function getRecieveTicketsCountAttribute()
    {
        return $this->RecieveTickets()
            ->where('ticket_recieve.del', '0')
            ->count();
    }

    public function getNewRecieveTicketsCountAttribute()
    {
        return $this->RecieveTickets()
            ->where('ticket_recieve.del', '0')
            ->where('ticket_recieve.view', '0')
            ->count();
    }

    public function SendTickets()
    {
        return $this->hasMany('App\Models\hamafza\Ticket', 'uid', 'id');
    }

    public function getSendTicketsCountAttribute()
    {
        return $this->SendTickets()->count();
    }

    /*
    public function rewards()
    {
        return $this->hasMany('App\Models\Hamahang\Reward','from_user_id');
    }
    */

    public function getRegDateAttribute($value)
    {
        return HDate_GtoJ($value, 'Y/m/d');
    }

    public function subject_policies()
    {
        return $this->morphedByMany('App\Models\hamafza\Subject', 'target', 'hamahang_user_policies','user_id','target_id');
    }

    public function subject_type_policies()
    {
        return $this->morphedByMany('App\Models\hamafza\SubjectType', 'target', 'hamahang_user_policies','user_id','target_id');
    }

    public function subject_type_policies_personal()
    {
        return $this->morphedByMany('App\Models\hamafza\SubjectType', 'target', 'hamahang_user_policies','user_id','target_id')->wherePivot('type','1');
    }

    public function subject_type_policies_Official()
    {
        return $this->morphedByMany('App\Models\hamafza\SubjectType', 'target', 'hamahang_user_policies','user_id','target_id')->wherePivot('type','2');
    }

    public function get_bookmarks($uid)
    {
        return $this->hasMany('App\Models\Hamahang\Bookmark')->where('user_id', $uid);
    }
    
    

    public function bookmarks($term)
    {
        $term = trim($term);
        $user = $this->get_bookmarks(auth()->id())->where('target_table', 'App\User');
        $page = $this->get_bookmarks(auth()->id())->where('target_table', 'App\Models\hamafza\Pages');
        $subject = $this->get_bookmarks(auth()->id())->where('target_table', 'App\Models\hamafza\Subject');
        $group = $this->get_bookmarks(auth()->id())->where('target_table', 'App\Models\Hamahang\Group');
        $channel = $this->get_bookmarks(auth()->id())->where('target_table', 'App\Models\Hamahang\Channel');
        if ($term)
        {
            $user->where('title', 'like', "%$term%");
            $page->where('title', 'like', "%$term%");
            $subject->where('title', 'like', "%$term%");
            $group->where('title', 'like', "%$term%");
            $channel->where('title', 'like', "%$term%");
        }
        $r['user'] = $user->get();
        $r['page'] = $page->get();
        $r['subject'] = $subject->get();
        $r['group'] = $group->get();
        $r['channel'] = $channel->get();
        return $r;
    }

    public function subjects()
    {
        return $this->hasMany('App\Models\hamafza\Subject', 'admin')->where('archive', '0')->whereHas('pages');
    }
    
    public function getApiBookmarksAttribute($term,$uid)
    {
        $term = trim($term);
        $user = $this->get_bookmarks($uid)->where('target_table', 'App\User');
        $page = $this->get_bookmarks($uid)->where('target_table', 'App\Models\hamafza\Pages');
        $subject = $this->get_bookmarks($uid)->where('target_table', 'App\Models\hamafza\Subject');
        $group = $this->get_bookmarks($uid)->where('target_table', 'App\Models\Hamahang\Group');
        $channel = $this->get_bookmarks($uid)->where('target_table', 'App\Models\Hamahang\Channel');
        if ($term)
        {
            $user->where('title', 'like', "%$term%");
            $page->where('title', 'like', "%$term%");
            $subject->where('title', 'like', "%$term%");
            $group->where('title', 'like', "%$term%");
            $channel->where('title', 'like', "%$term%");
        }
        $r['user'] = $user->get();
        $r['page'] = $page->get();
        $r['subject'] = $subject->get();
        $r['group'] = $group->get();
        $r['channel'] = $channel->get();
        return $r;
    }
    
    

}
