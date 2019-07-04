<?php

namespace App\Models\Org;

use App\Traits\DataTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use App\Models\LogAdmin;
use App\Models\User;
use PDF;
use App\Models\ScoreDocs;
use Illuminate\Support\Facades\Auth;

class OrganizationDeal extends Model
{
    use DataTable;
    use Notifiable;
    use SoftDeletes;

    const DEAL_TYPE_SELL = 'sell';  // продажа
    const DEAL_TYPE_BUY = 'buy';    // покупка

    const DEAL_SUBTYPE_NEW = 'new';  //новое
    const DEAL_SUBTYPE_USED = 'used';    // бу
    const DEAL_SUBTYPE_NA = 'na';    // без подтипа (для покупки , например)

    const DEAL_STATUS_MODERATION        = 'moderation'; // сделка на модерации
//    const DEAL_STATUS_APPROVE           = 'moderation'; // сделка проверена и разрешена к показу
    const DEAL_STATUS_APPROVE           = 'approve'; // сделка проверена и разрешена к показу - временно показываем заявки на модерации
    const DEAL_STATUS_ARCHIVE           = 'archive'; // сделка в архиве
    const DEAL_STATUS_BANNED            = 'banned';  // сделка заблокирована

    // статус оплаченности объявления
    const DEAL_STATUS_PAYMENT_PAID      = 'paid'; // размещение оплачено 
    const DEAL_STATUS_PAYMENT_NOT_PAID  = 'not_paid'; // размещение не оплачено и нуждается в оплате
    const DEAL_STATUS_PAYMENT_FREE      = 'free'; // размещение бесплатное


    protected $table = 'organizations_deals';
    protected $fillable = [
        'type_deal',
        'subtype_deal',
        'name',
        'description',
        'pay_type_cash',
        'pay_type_noncash',
        'budget_from',
        'budget_to',
        'fast_deal',
        'favorite_only',
        'deadline_deal',
        'deadline_service',
        'question',
        'finished_at',
        'is_need_kp'
    ];
    protected $dates = ['deleted_at', 'finished_at'];
    static protected $sortable = ['id', 'name', 'organization_id', 'finish', 'status', 'fast_deal', 'favorite_only', 'budget_from', 'budget_to', 'created_at', 'finished_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(\App\Models\Org\Organization::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function winner()
    {
        return $this->belongsTo(\App\Models\Org\Organization::class, 'winner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cities()
    {
        return $this->belongsToMany(\App\Models\Kladr\City::class, 'organizations_deals_cities', 'deal_id', 'city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(\App\Models\Category::class, 'organizations_deals_categories', 'deal_id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany(\App\Models\DealQuestion::class, 'organizations_deals_questions', 'deal_id', 'question_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(\App\Models\Org\Organization::class, 'organizations_deals_members', 'deal_id', 'organization_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedback()
    {
        return $this->hasMany(\App\Models\Feedback::class, 'deal_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(\App\Models\Org\OrganizationDealAnswer::class, 'deal_id');
    }

    public function getAnswersByMember()
    {
        $answers = $this->answers()->with('question')->get();

        foreach($this->members as $key => $member) {
            $orgAnswers = [];

            foreach ($answers as $answer) {;
                if ($member->id == $answer->organization_id) {
                    $orgAnswers[] = [
                        'question' => ($answer->question_id) ? $answer->question->question : $this->question,
                        'answer' => $answer->answer,
                    ];
                }
            }

            $this->members[$key]['deal_answers'] = $orgAnswers;
        }
    }

        /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function imagesDeals()
    {
        return $this->hasMany(\App\Models\Org\ImagesDeals::class, 'deal_id'); // один ко многим
    }

    public function favouritedFromUsers()
    {
        return $this->belongsToMany(\App\Models\User::class, 'user_selected_deals','deal_id',  'user_id' );
    }

    public function paymentServices()
    {
        return $this->hasMany(\App\Models\Payment\UserSubscription::class, 'deal_id');
    }

    public function paymentActiveServices()
    {
        return $this->paymentServices()->where('status' , '=', \App\Models\Payment\Subscription::SUBSCRIPTION_STATUS_ACTIVE)->orderBy('started_at', 'DESC');
    }

    public function paymentNotFinishedServices()
    {
        return $this->paymentServices()->where('status' , '<>', \App\Models\Payment\Subscription::SUBSCRIPTION_STATUS_FINISHED)->orderBy('started_at', 'DESC');
    }

    public function finishPaymentActiveService()
    {   
        return $this->paymentActiveServices()
                    ->where('status' , '<>', \App\Models\Payment\Subscription::SUBSCRIPTION_STATUS_FINISHED)
                    ->update(['status' =>  \App\Models\Payment\Subscription::SUBSCRIPTION_STATUS_FINISHED, 'finished_at' => Carbon::now()]);
    }

    public function finishPaymentAllService()
    {   
        return $this->paymentNotFinishedServices()
                    ->where('status' , '<>', \App\Models\Payment\Subscription::SUBSCRIPTION_STATUS_FINISHED)
                    ->update(['status' =>  \App\Models\Payment\Subscription::SUBSCRIPTION_STATUS_FINISHED, 'finished_at' => Carbon::now()]);
    }


    public function score ($unique_id, $summ, $userCreateScore) {
        $user = User::where('unique_id', $unique_id)->with('organization')->first();

        $monthes = [
            1 => 'января', 2 => 'Февраля', 3 => 'марта', 4 => 'апреля',
            5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа',
            9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'
        ];
        $dt = strtotime(Carbon::now()->format('d.m.Y H:i:s'));
        $dt_str = date('j ' . $monthes[date('n', $dt)] . ' Y', $dt);
        $str_total_price_score = $this->mb_ucfirst($this->num2str($summ));

        $numberScore = $this->getNumberScore($unique_id);

        $this->saveScore($user, $numberScore, $dt_str, $summ, $userCreateScore);

        setlocale(LC_ALL, 'ru_RU.UTF-8');
        $pdf = new PDF();
        $pdf::setOptions(['dpi' => 150, 'defaultFont' => 'Times-Roman']);
        $pdf::setPaper('A4', 'landscape');
        $fileName = $unique_id . '_' . $numberScore . '.pdf';
        $pdf::loadView('admin.score.score', ['user' => $user, 'unique_id' => $unique_id, 'numberScore' => $numberScore,
            'dt_str' => $dt_str, 'str_summ' => $str_total_price_score, 'summ' => $summ])->save($fileName);

        $data=[
            "unique_id"=>$unique_id,
            "summ"=>$summ

        ];

        $log = [
            'method' => __METHOD__,
            'data' => json_encode($data),
            'user_id' => $userCreateScore->id
        ];
        LogAdmin::create($log)->save();

        return $fileName;
    }

    private function getNumberScore($unique_id)
    {
        $score = ScoreDocs::where('unique_id', $unique_id)->orderBy('created_at', 'desc')->first();
        if (empty($score))
            return 1;

        return $score->number_score + 1;
    }
    private function saveScore($user, $numberScore, $dt_score, $summ, $userCreateScore)
    {
        $model = new ScoreDocs();
        $model->owner_id = $user->id;
        $model->organization_id = $user->organization->id;
        $model->unique_id = $user->unique_id;
        $model->number_score = $numberScore;
        $model->dt_score = $dt_score;
        $model->summ = $summ;
        $model->user_id = $userCreateScore->id;
        $model->save();
    }


    private function mb_ucfirst($word, $charset = "utf-8")
    {
        return mb_strtoupper(mb_substr($word, 0, 1, $charset), $charset) . mb_substr($word, 1, mb_strlen($word, $charset) - 1, $charset);
    }

    private function num2str($num)
    {
        $nul = 'ноль';
        $ten = [
            ['', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
            ['', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
        ];
        $a20 = ['десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать',
            'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать'];
        $tens = [2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто'];
        $hundred = ['', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот'];
        $unit = [ // Units
            ['копейка', 'копейки', 'копеек', 1],
            ['рубль', 'рубля', 'рублей', 0],
            ['тысяча', 'тысячи', 'тысяч', 1],
            ['миллион', 'миллиона', 'миллионов', 0],
            ['миллиард', 'милиарда', 'миллиардов', 0],
        ];
        //
        $num = str_replace(',', '.', $num);
        list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
        $out = [];
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
                if (!intval($v))
                    continue;
                $uk = sizeof($unit) - $uk - 1; // unit key
                $gender = $unit[$uk][3];
                list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2 > 1)
                    $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; # 20-99
                else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk > 1)
                    $out[] = $this->morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
            } //foreach
        } else $out[] = $nul;
        $out[] = $this->morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
        $out[] = $kop . ' ' . $this->morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
    }

    /**
     * Склоняем словоформу
     */
    private function morph($n, $f1, $f2, $f5)
    {
        $n = abs(intval($n)) % 100;
        if ($n > 10 && $n < 20)
            return $f5;
        $n = $n % 10;
        if ($n > 1 && $n < 5)
            return $f2;
        if ($n == 1)
            return $f1;
        return $f5;
    }

}
