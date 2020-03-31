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
    'email' => 'Введите корректный е-мейл адрес.',
    'required' => 'Поле :attribute обязательно.',
    'numeric' => 'Поле :attribute должно быть в целом числовом формате',
    'unique' => 'Данный :attribute уже занят.',
    'min' => [
        'numeric' => 'Поле :attribute должно быть не короче :min.',
        'string' => 'Поле :attribute должно содержать не менее :min символов.',
    ],
    'required_without' => 'Поле :attribute обязательно, если не указаны значения :values.',
    'required_with' => 'Поле :attribute обязательно, поскольку указано значение :values.',
    'ImageBase64Ext' => 'Изображение должно быть в указанном формате',
    'ImageBase64Size' => 'Размер файла больше допустимого значения',
    'VenueParticipantLimit' => "Свободных мест на площадке не осталось",
    'EmptyWith' => "Поле «:attribute» должно быть пустым, поскольку представлены поля :values",

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
        'venueEmail' => 'email контактного лица',
        'venueName' => 'название площадки',
        'venueCapacity' => 'вместимость площадки',
        'startTime' => 'время начала',
        'venueAddress' => 'адрес площадки',
        'venueObjects' => 'предметы площадки',
        'venueLogo' => 'логотип площадки',
        'contactFIO' => 'ФИО контактного лица',
        'country' => 'страна',
        'city' => 'город',
        'password' => 'пароль',
        'school' => 'школа',
        'lastname' => 'фамилия',
        'firstname' => 'имя',
        'thirdname' => 'отчество',
        'grade' => 'класс',
        'birth_date' => 'дата рождения',
        'is_school_finished' => '«я уже закончил(-а) школу»',
        'agreement' => '«согласие на обработку персональных данных»',
    ],

];
