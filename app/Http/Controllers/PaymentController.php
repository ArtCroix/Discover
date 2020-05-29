<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use App\Src\ApplicationHelpers\TeamHelper;
use App\Models\Application\Submit;
use App\Src\ApplicationHandlers\ApplicationHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Src\ApplicationHandlers\AnswerHandler;
use App\Src\ApplicationHelpers\ApplicationHelper;
use App\Src\ApplicationHelpers\PaymentHelper;

class PaymentController extends Controller
{
    public static function getPriceForUser(string $event_name, int $team_id)
    {
        $answers = PaymentHelper::getAnswersForPriceCalculation($event_name, $team_id);

        if (!empty($answers)) {
            if ($answers['user_email_1'] == $_GET['email']) {
                $email = $answers['user_email_1'];
                $phone = $answers['user_phone_1'];
                $price_type = $answers['price_type_1'];
            } elseif ($answers['user_email_2'] == $_GET['email']) {
                $email = $answers['user_email_2'];
                $phone = $answers['user_phone_2'];
                $price_type = $answers['price_type_2'];
            } elseif ($answers['user_email_3'] == $_GET['email']) {
                $email = $answers['user_email_3'];
                $phone = $answers['user_phone_3'];
                $price_type = $answers['price_type_3'];
            } elseif ($answers['user_email_4'] == $_GET['email']) {
                $email = $answers['user_email_4'];
                $phone = $answers['coach_phone'];
                $price_type = $answers['coach_price_type'];
            } else {
                $email = '';
                $phone = '';
            }
        } else {
            exit('Неверная ссылка');
        }
        return ["price_type" => $price_type, "phone" => $phone];
    }

    public function showPaymentLinks(string $event_name, string $locale = 'ru')
    {
        $team = TeamHelper::getTeamForEvent($event_name, \Auth::user()->id);

        $answers = AnswerHandler::getAnswersForSubmit($team[0]->submit_id);
        $submit = Submit::find($team[0]->submit_id);
        $submitAdditionalData = json_decode($submit->additional_data) ?: (object) ['currency' => 'rub'];
        foreach ($answers as $answer) {
            if (strpos($answer->question['name'], 'user_email') === 0 && $answer->value)
                $user_emails[] = $answer->value;
        }

        $eventApplications = ApplicationHelper::getEventApplicationsForUser($event_name, Auth::user()->id, $locale);

        return view("events.payment_links")->with(["team_id" => $team[0]->team_id, "answers" => $answers, "event_name" => $event_name, "user_emails" => $user_emails, "currency" => $submitAdditionalData->currency, 'eventApplications' => $eventApplications]);
    }

    public function showPaymentPage(string $event_name, int $team_id)
    {
        $data = self::collectDataForPaymentPage($event_name, $team_id, 'rub');
        extract($data);
        return view("events.payment")->with(["price" => $price, "phone" => $phone, "event_name" => $event_name,  "email" => $_GET['email'], "team" => $team]);
    }

    public function showUSDPaymentPage(string $event_name, int $team_id)
    {
        $data = self::collectDataForPaymentPage($event_name, $team_id, 'usd');
        extract($data);
        return view("events.usd_payment")->with(["price" => $price, "phone" => $phone, "event_name" => $event_name,  "email" => $_GET['email'], "team" => $team]);
    }

    public static function collectDataForPaymentPage(string $event_name, int $team_id, string $currency)
    {
        list("price_type" => $price_type, "phone" => $phone) = self::getPriceForUser($event_name, $team_id);
        $team = Team::find($team_id)->load('event');
        $event = $team->event;
        $prices = json_decode($event->price, true)[$currency][$price_type];
        $now = date('Y-m-d');
        foreach ($prices as $date => $price) {
            if ($now <= $date) {
                break;
            }
        }

        return ["price" => $price, "phone" => $phone, "event_name" => $event_name,  "email" => $_GET['email'], "team" => $team->team_name];
    }
}
