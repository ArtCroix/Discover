<?php

namespace App\Src\ApplicationHelpers;

use App\Models\Application\Submit;
use App\User;
use App\Models\Event;

class PaymentHelper
{
    public static function calculatePriceForTeam(string $event_name, int $team_id)
    {
        $answers = self::getAnswersForPriceCalculation($event_name, $team_id);
        $event = Event::where("event_name", $event_name)->first();
        $current_prices = [];
        $price_types = [];

        foreach ($answers as $key => $answer) {
            if (strpos($key, "price") !== false)
                $price_types[] = $answer;
        }

        $now = date('Y-m-d');
        foreach ($price_types as $key => $price_type) {
            foreach (json_decode($event->price, true)['rub'][$price_type] as $date => $price) {
                if ($now <= $date) {
                    $current_prices[] = $price;
                    break;
                }
            }
            $current_prices[] = $price;
        }
        return array_sum($current_prices);
    }

    public static function getAnswersForPriceCalculation(string $event_name, int $team_id)
    {
        $answers = \DB::select(
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
        $answers = collect($answers)->pluck('value', 'name')->toArray();
        return $answers;
    }
}
