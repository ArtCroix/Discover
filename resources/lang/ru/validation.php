<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Чек-бокс :attribute должен быть отмечен.',
    'confirmed' => 'Значение поля :attribute не совпадает с проверочным.',
    'different' => 'Значение этого поля должно быть уникально в текущей форме',
    'email' => 'Введите корректный e-mail адрес.',
    'EmptyWith' => "Поле «:attribute» должно быть пустым, поскольку представлены поля :values",
    'ImageBase64Ext' => 'Изображение должно быть в указанном формате',
    'ImageBase64Size' => 'Размер файла больше допустимого значения',
    'min' => [
        'numeric' => 'Поле :attribute должно быть не короче :min.',
        'string' => 'Поле :attribute должно содержать не менее :min символов.',
    ],
    'numeric' => 'Поле :attribute должно быть в целом числовом формате',
    'required' => 'Поле :attribute обязательно.',
    'required_with' => 'Поле :attribute обязательно, поскольку указано значение :values.',
    'required_without' => 'Поле :attribute обязательно, если не указаны значения :values.',
    'unique' => 'Данный :attribute уже занят.',
    'VenueParticipantLimit' => "Свободных мест на площадке не осталось",
    'required_if' => 'Поле :attribute обязательно, если поле :other имеет значение :value.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */
    'attributes' => [
        'team_name' => 'название команды',
        'division' => 'дивизион',
        'additional_info' => 'Любая дополнительная информация, которую нам нужно знать о вашей команде',
        'agreement' => 'согласия на обработку персональных данных',
        'chief_firstname' => 'имя руководителя',
        'chief_lastname' => 'фамилия руководителя',
        'chief_position' => 'должность руководителя',
        'chief_sex' => 'пол руководителя',
        'city' => 'город',
        'coach_firstname' => 'имя тренера',
        'coach_food' => 'тип питания тренера',
        'coach_lastname' => 'фамилия тренера',
        'coach_price_type' => 'тип оплаты тренера',
        'coach_size' => 'размер футболки тренера',
        'coach_user_phone' => 'телефон тренера',
        'coach_participate' => 'участие тренера',
        'coach_phone' => 'телефон тренера',
        'country' => 'страна',
        'email' => 'адрес e-mail',
        'firstname_1' => 'имя первого участника',
        'firstname_2' => 'имя второго участника',
        'firstname_3' => 'имя третьего участника',
        'middlename_1' => 'отчество первого участника',
        'middlename_2' => 'отчество второго участника',
        'middlename_3' => 'отчество третьего участника',
        'food_1' => 'тип питания первого участника',
        'food_2' => 'тип питания второго участника',
        'food_3' => 'тип питания третьего участника',
        'lastname_1' => 'фамилия первого участника',
        'lastname_2' => 'фамилия второго участника',
        'lastname_3' => 'фамилия третьего участника',
        'leisure' => 'Как ваша команда предпочитает провести выходной день?',
        'login' => 'логин',
        'password' => 'пароль',
        'price_type_1' => 'тип оплаты первого участника',
        'price_type_2' => 'тип оплаты второго участника',
        'price_type_3' => 'тип оплаты третьего участника',
        'size_1' => 'размер футболки первого участника',
        'size_2' => 'размер футболки второго участника',
        'size_3' => 'размер футболки третьего участника',
        'university' => 'университет',
        'user_email_1' => 'емейл первого участника',
        'user_email_2' => 'емейл второго участника',
        'user_email_3' => 'емейл третьего участника',
        'user_email_4' => 'емейл тренера',
        'user_phone_1' => 'телефон первого участника',
        'user_phone_2' => 'телефон второго участника',
        'user_phone_3' => 'телефон третьего участника',
        'lastname' => 'фамилия',
        'firstname' => 'имя',
        'middlename' => 'отчество',
        'citizenship' => 'гражданство',
        'phone' => 'телефон',
        'address' => 'адрес',
        'passport_seria' => 'серия паспорта',
        'passport_number' => 'номер паспорта',
        'date_of_issue' => 'дата выдачи',
        'issued_by' => 'кем выдан',
    ],

];
