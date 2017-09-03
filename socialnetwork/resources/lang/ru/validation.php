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

    'accepted'             => ':attribute должен быть принят..',
    'active_url'           => ':attribute не является допустимым URL.',
    'after'                => ':attribute Должна быть дата после :date.',
    'after_or_equal'       => ':attribute Должна быть датой после или равной :date.',
    'alpha'                => ':attribute Могут содержать только буквы.',
    'alpha_dash'           => ':attribute Могут содержать только буквы, цифры и тире.',
    'alpha_num'            => ':attribute Могут содержать только буквы и цифры.',
    'array'                => ':attribute Должен быть массивом.',
    'before'               => ':attribute Должна быть дата до :date.',
    'before_or_equal'      => ':attribute Должна быть дата до или равна :date.',
    'between'              => [
        'numeric' => ':attribute должна быть между :min и :max.',
        'file'    => ':attribute должна быть между :min и :max килобайтами.',
        'string'  => ':attribute должна быть между :min и :max символами.',
        'array'   => ':attribute должна быть между :min и :max значениями.',
    ],
    'boolean'              => ':attribute Поле должно быть истинным или ложным.',
    'confirmed'            => 'Пароли не совпадают.',
    'date'                 => ':attribute Недействительная дата.',
    'date_format'          => ':attribute Не соответствует формату :format.',
    'different'            => ':attribute и :other Должны быть разными.',
    'digits'               => ':attribute должно быть :digits цифры.',
    'digits_between'       => ':attribute Должно быть между :min и :max цифры.',
    'dimensions'           => ':attribute Имеет недопустимые размеры изображения.',
    'distinct'             => ':attribute Поле имеет двойное значение.',
    'email'                => ':attribute Адрес эл. почты должен быть действительным.',
    'exists'               => 'выбранный :attribute является недействительным.',
    'file'                 => ':attribute Должен быть файл.',
    'filled'               => ':attribute Поле должно иметь значение.',
    'image'                => ':attribute Должно быть изображение.',
    'in'                   => 'выбранный :attribute является недействительным.',
    'in_array'             => ':attribute Поле не существует в :other.',
    'integer'              => ':attribute Должен быть целым числом.',
    'ip'                   => ':attribute Должен быть действительным IP-адресом.',
    'json'                 => ':attribute Должна быть действительной строкой JSON.',
    'max'                  => [
        'numeric' => ':attribute Может быть не больше :max.',
        'file'    => ':attribute Может быть не больше :max килобайт.',
        'string'  => ':attribute Может быть не больше :max символов.',
        'array'   => ':attribute Может быть не больше  :max значениями.',
    ],
    'mimes'                => ':attribute Должен быть файл типа: :values.',
    'mimetypes'            => ':attribute Должен быть файл типа: :values.',
    'min'                  => [
        'numeric' => ':attribute не должен быть меньше :min символов.',
        'file'    => ':attribute не должен быть меньше :min килобайтов.',
        'string'  => 'Пароль не должен быть меньше :min символов.',
        'array'   => ':attribute не должен быть меньше :min значения.',
    ],
    'not_in'               => 'выбранный :attribute является недействительным.',
    'numeric'              => ':attribute должен быть числом.',
    'present'              => ':attribute Поле должно присутствовать.',
    'regex'                => 'Поле :attribute не соответствует формату.',
    'required'             => 'Поле :attribute не заполнено.',
    'required_if'          => ':attribute Поле требуется, когда :other является :value.',
    'required_unless'      => ':attribute Поле требуется, если :other в :values.',
    'required_with'        => ':attribute Поле требуется, когда :values настоящее.',
    'required_with_all'    => ':attribute Поле требуется, когда :values настоящее.',
    'required_without'     => ':attribute Поле требуется, когда :values не настоящее.',
    'required_without_all' => ':attribute Поле требуется, если ни один из :values настоящее.',
    'same'                 => ':attribute и :other Должен соответствовать.',
    'size'                 => [
        'numeric' => ':attribute должно быть :size.',
        'file'    => ':attribute должно быть :size килобайт.',
        'string'  => ':attribute должно быть :size символов.',
        'array'   => ':attribute должен содержать :size Предметы.',
    ],
    'string'               => ':attribute Должен быть строкой.',
    'timezone'             => ':attribute Должна быть действительной зоной.',
    'unique'               => ':attribute уже был взят.',
    'uploaded'             => ':attribute Не удалось загрузить.',
    'url'                  => ':attribute Формат недействителен..',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
