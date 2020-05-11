<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use App\Models\Application\Submit;
use App\Src\ApplicationHandlers\ApplicationHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class PaymentController extends Controller
{
    /*     public function __construct()
    {
       
    }
 */
    public static function getPriceForUser(string $event_name, int $team_id)
    {
        $prices_type = \DB::select(
            'with A as(SELECT
                teams.submit_id,
                `events`.event_name
                FROM
                teams
                INNER JOIN `events` ON teams.event_id = `events`.id
                INNER JOIN submits ON teams.submit_id = submits.id
                INNER JOIN applications ON submits.application_id = applications.id
                WHERE
                applications.type = "team_registration" AND
                `events`.event_name = :event_name AND teams.id = :team_id

                GROUP BY submit_id
                )
                SELECT answers.`value`, questions.`name` 

                from answers JOIN questions on answers.question_id=questions.id
                join A on answers.submit_id=A.submit_id
                WHERE (questions.name like "%user_email%" or questions.name like "%price_type%" or questions.name like "%phone%") and answers.`value` is not null',
            ['event_name' => $event_name, 'team_id' => $team_id]
        );

        $prices_type = collect($prices_type)->pluck('value', 'name')->toArray();
        if (!empty($prices_type)) {
            if ($prices_type['user_email_1'] == $_GET['email']) {
                $email = $prices_type['user_email_1'];
                $phone = $prices_type['user_phone_1'];
                $price_type = $prices_type['price_type_1'];
            } elseif ($prices_type['user_email_2'] == $_GET['email']) {
                $email = $prices_type['user_email_2'];
                $phone = $prices_type['user_phone_2'];
                $price_type = $prices_type['price_type_2'];
            } elseif ($prices_type['user_email_3'] == $_GET['email']) {
                $email = $prices_type['user_email_3'];
                $phone = $prices_type['user_phone_3'];
                $price_type = $prices_type['price_type_3'];
            } elseif ($prices_type['user_email_4'] == $_GET['email']) {
                $email = $prices_type['user_email_4'];
                $phone = $prices_type['user_phone_4'];
                $price_type = $prices_type['price_type_4'];
            } else {
                $email = '';
                $phone = '';
            }
        } else {
            exit('Неверная ссылка');
        }
        // dd($prices_type);
        // dump($prices_type);
        return ["price_type" => $price_type, "phone" => $phone];
    }

    public function showPaymentPage(string $event_name, int $team_id)
    {
        list("price_type" => $price_type, "phone" => $phone) = self::getPriceForUser($event_name, $team_id);
        $event = Event::where("event_name", $event_name)->first();
        $prices = json_decode($event->price, true)['rub'][$price_type];
        $now = date('Y-m-d');
        foreach ($prices as $date => $price)
            if ($now <= $date) {
                break;
            }
        return view("events.payment")->with(["price" => $price, "phone" => $phone, "event_name" => $event_name,  "email" => $_GET['email']]);
    }

    public function showUSDPaymentPage(string $event_name, int $team_id)
    {
        list("price_type" => $price_type, "phone" => $phone) = self::getPriceForUser($event_name, $team_id);
        $event = Event::where("event_name", $event_name)->first();
        $prices = json_decode($event->price, true)['usd'][$price_type];
        $now = date('Y-m-d');
        foreach ($prices as $date => $price)
            if ($now <= $date) {
                break;
            }
        return view("events.usd_payment")->with(["price" => $price, "phone" => $phone, "event_name" => $event_name,  "email" => $_GET['email']]);
    }

    public function toPay()
    {
    }
}
