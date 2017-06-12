<?php

return [
    'create_general_report'       => 'Изготвяне на обща справка',
    'invalid_last_date'           => 'Невалидна крайна дата',
    'choose_last_date'            => 'Изберете крайна дата',
    'invalid_period_input'        => 'Невалиден интервал от време',
    'choose_period_input'         => 'Изберете интервал от време',
    'choose_start_time'           => 'Избери стартово време',
    'choose_end_time'             => 'Избери крайно време',
    'choose_days'                 => 'Избери дни от седмицата',
    'invalid_start_time'          => 'Невалидно стартово време',
    'invalid_end_time'            => 'Невалидно крайно време',
    'days'                        => 'дни',
    'first_movement'              => 'Първо движение',
    'course_number'               => 'Курс №',
    'motion_hours'                => 'Работа в движение',
    'stop_hours'                  => 'Работа на място',
    'tookoff'                     => 'Потеглил',
    'parametric_report'           => 'Справка по параметри',
    'canbus_report'               => 'Справка по CANBUS',
    'fuel_report'                 => 'Справка по гориво',
    'trip_report'                 => 'Справка пътен лист',
    'general_report'              => 'Обща справка',
    'poi_report'                  => 'Справка по статичен обект',
    'make_parametric_report'      => 'Изготви справка по проследяван обект и параметри',
    'make_canbus_report'          => 'Изготви справка по CANBUS',
    'make_fuel_report'            => 'Изготви справка по гориво',
    'create_poi_report'           => 'Изготви справка по статичен обект',
    'arrivedat'                   => 'Пристигнал',
    'list_tracked_objects_status' => 'Списък със статусите на проследявани обекти',
    'parametric'                  => [
        'parameters'            => 'Параметри',
        'no_parameters'         => 'Няма налични справки',
        'get_report'            => 'Направи справка',
        'no_device_attached'    => 'Не е свързано устройство'
    ],
    'fuel' => [
        'distance' => 'Пробег',
        'used_fuel' => 'Изразходено гориво',
        'average_expense' => 'Среден разход',
        'expense_mark' => 'Оценка на разход',
        'end_mileage' => 'Краен километраж',
        'fuel_level' => 'Ниво на гориво',
    ],
    'validation'                  => [
        'invalid_parameters'              => 'Невалидни параметри',
        'invalid_start_date'              => 'Невалидна начална дата',
        'invalid_end_date'                => 'Невалидна крайна дата',
        'invalid_start_time'              => 'Невалидно време за начало',
        'invalid_end_time'                => 'Невалидно време за край',
        'invalid_driver_information'      => 'Невалидна информация за шофьор',
        'choose_tracked_object_or_driver' => 'Избери проследяван обект или шофьор',
        'invalid_tracked_object'          => 'Невалиден проследяван обект',
        'invalid_date'                    => 'Невалидна дата',
    ],
    'canbus'                      => [
        'vehicle_identification_number'                   => [
            'value' => 'Идентификационен номер на превозното средство',
            'units' => [

            ], 'measurement_unit' => '',
        ],
        'ignition_key'                                    => [
            'value' => 'Запален',
            'units' => [
                'ignition_off' => 'Изгасена', 'ignition_on' => 'Контакт', 'engine_on' => 'Запалена',
            ], 'measurement_unit' => '',
        ],
        'total_distance'                                  => [
            'value' => 'Общо дистанция',
            'units' => [

            ], 'measurement_unit' => 'Километра',
        ],
        'total_fuel_used'                                 => [
            'value' => 'Общо използвано гориво',
            'units' => [

            ], 'measurement_unit' => 'Литра',
        ],
        'engine_rpm'                                      => [
            'value' => 'Обороти на двигателя на минута',
            'units' => [

            ], 'measurement_unit' => 'Оборота на минута',
        ],
        'vehicle_speed'                                   => [
            'value' => 'Скорост двигател',
            'units' => [

            ], 'measurement_unit' => 'Км/ч',
        ],
        'engine_coolant_temperature'                      => [
            'value' => 'Температура охлаждаща течност',
            'units' => [

            ], 'measurement_unit' => 'Целзий',
        ],
        'fuel_consumption'                                => [
            'value' => 'Консумация на гориво',
            'units' => [

            ], 'measurement_unit' => 'Литра на 100км',
        ],
        'range'                                           => [
            'value' => 'Разстояние',
            'units' => [

            ], 'measurement_unit' => '',
        ],
        'accelerator_pedal_pressure'                      => [
            'value' => 'Налягане в/у педала за ускорение',
            'units' => [

            ], 'measurement_unit' => '%',
        ],
        'total_engine_hours'                              => [
            'value' => 'Общо часове работа на двигателя',
            'units' => [

            ], 'measurement_unit' => 'ч',
        ],
        'total_driving_time'                              => [
            'value' => 'Общо часове изминати в път',
            'units' => [

            ], 'measurement_unit' => 'ч',
        ],
        'total_engine_idle_time'                          => [
            'value' => 'Общо часове на двигателя в покой',
            'units' => [

            ], 'measurement_unit' => 'ч',
        ],
        'total_idle_fuel_used'                            => [
            'value' => 'Общо гориво, изразходвано в покой',
            'units' => [

            ], 'measurement_unit' => 'л',
        ],
        'axle_weight'                                     => [
            'value' => 'Тегло върху остта',
            'units' => [

            ], 'measurement_unit' => 'кг',
        ],
        'tachograph_driver_one_validity_mark'             => [
            'value' => 'Tachograph driver one validity mark',
            'units' => [

            ], 'measurement_unit' => '',
        ],
        'tachograph_driver_two_validity_mark'             => [
            'value' => 'Tachograph driver two validity mark',
            'units' => [

            ], 'measurement_unit' => '',
        ],
        'tachograph_driver_one_reserved'                  => [
            'value' => '',
            'units' => [

            ], 'measurement_unit' => '',
        ],
        'tachograph_driver_two_reserved'                  => [
            'value' => '',
            'units' => [

            ], 'measurement_unit' => '',
        ],
        'tachograph_driver_one_driver_time_related_state' => [
            'value' => 'Шофьор 1: време тахограф',
            'units' => [
                'normal_no_limits_reached' => 'Няма достигнати ограничения',
                '15_minut_before_41_h'     => '15 мин преди настъпване на 41 ч',
                '41_h_reached'             => 'Настъпили 41 ч',
                '15_min_before_9_h'        => '15 мин преди настъпване на 9 ч',
                '9_h_reached'              => 'Настъпили 9 ч',
                '15_minut_before_16_h'     => '15 минути преди настъпване на 16 ч',
                '16_h_reached'             => 'Настъпили 16 ч',
            ], 'measurement_unit' => '',
        ],
        'tachograph_driver_two_driver_time_related_state' => [
            'value' => 'Шофьор 2: време тахограф',
            'units' => [
                'normal_no_limits_reached' => 'Няма достигнати ограничения',
                '15_minut_before_41_h'     => '15 мин преди настъпване на 41 ч',
                '41_h_reached'             => 'Настъпили 41 ч',
                '15_min_before_9_h'        => '15 мин преди настъпване на 9 ч',
                '9_h_reached'              => 'Настъпили 9 ч',
                '15_minut_before_16_h'     => '15 минути преди настъпване на 16 ч',
                '16_h_reached'             => 'Настъпили 16 ч',
            ], 'measurement_unit' => '',
        ],
        'tachograph_driver_one_driver_work_state'         => [
            'value' => 'Шофьор 1: работно състояние',
            'units' => [
                'normal_no_limits_reached'     => 'Няма достигнати ограничения',
                'rest_sleeping'                => 'Почивка, спи',
                'driver_available_short_break' => 'Шофьор налице, кратка почивка',
                'driver_behind_wheel'          => 'Шофьорът управлява',
            ], 'measurement_unit' => '',
        ],
        'tachograph_driver_two_driver_work_state'         => [
            'value' => 'Шофьор 2: работно състояние',
            'units' => [
                'normal_no_limits_reached'     => 'Няма достигнати ограничения',
                'rest_sleeping'                => 'Почивка, спи',
                'driver_available_short_break' => 'Шофьор налице, кратка почивка',
                'driver_behind_wheel'          => 'Шофьорът управлява',
            ], 'measurement_unit' => '',
        ],
        'detailed_fuel_low'                               => [
            'value' => 'Детайлна справка: ниско ниво на гориво',
            'units' => [
                0 => 'Нормално', 1 => 'Ниско',
            ], 'measurement_unit' => '',
        ],
        'detailed_driver_seatbelt'                        => [
            'value' => 'Детайлна справка: колан на водача',
            'units' => [
                0 => 'Разкачен', 1 => 'Сложен',

            ], 'measurement_unit' => '',
        ],
        'detailed_air_conditioning'                       => [
            'value' => 'Детайлна справка: климатик',
            'units' => [
                0 => 'Спрян', 1 => 'Пуснат',

            ], 'measurement_unit' => '',
        ],
        'detailed_cruise_control'                         => [
            'value' => 'Детайлна справка: автопилот',
            'units' => [
                0 => 'Спрян', 1 => 'Пуснат',

            ], 'measurement_unit' => '',
        ],
        'detailed_brake_pedal'                            => [
            'value' => 'Детайлна справка: спирачка',
            'units' => [
                0 => 'Свободен', 1 => 'Натисната',

            ], 'measurement_unit' => '',
        ],
        'detailed_clutch_pedal'                           => [
            'value' => 'Детайлна справка: съединител',
            'units' => [
                0 => 'Свободен', 1 => 'Натиснат',

            ], 'measurement_unit' => '',
        ],
        'detailed_handbrake'                              => [
            'value' => 'Детайлна справка: ръчна спирачка',
            'units' => [
                0 => 'Свободна', 1 => 'Използвана',

            ], 'measurement_unit' => '',
        ],
        'detailed_central_lock'                           => [
            'value' => 'Детайлна справка: централно заключване',
            'units' => [
                0 => 'Отключено', 1 => 'Заключено',

            ], 'measurement_unit' => '',
        ],
        'detailed_reverse_gear'                           => [
            'value' => 'Детайлна справка: задна скорост',
            'units' => [
                0 => 'Неактивна', 1 => 'Активна',

            ], 'measurement_unit' => '',
        ],
        'detailed_running_lights'                         => [
            'value' => 'Детайлна справка: пуснати светлини',
            'units' => [
                0 => 'спрени', 1 => 'Пуснати',

            ], 'measurement_unit' => '',
        ],
        'detailed_low_beams'                              => [
            'value' => 'Детайлна справка: къси фарове',
            'units' => [
                0 => 'Спрени', 1 => 'Пуснати',

            ], 'measurement_unit' => '',
        ],
        'detailed_high_beams'                             => [
            'value' => 'Детайлна справка: дълги фарове',
            'units' => [
                0 => 'Спрени', 1 => 'Пуснати',

            ], 'measurement_unit' => '',
        ],
        'detailed_rear_fog_lights'                        => [
            'value' => 'Детайлна справка: задни фарове за мъгла',
            'units' => [
                0 => 'Спрени', 1 => 'Пуснати',

            ], 'measurement_unit' => '',
        ],
        'detailed_front_fog_lights'                       => [
            'value' => 'Детайлна справка: предни фарове за мъгла',
            'units' => [
                0 => 'Спрени', 1 => 'Пуснати',
            ], 'measurement_unit' => '',
        ],
        'detailed_doors'                                  => [
            'value' => 'Детайлна справка: отворени врати',
            'units' => [
                0 => 'Затворени', 1 => 'Отворени',

            ], 'measurement_unit' => '',
        ],
        'detailed_trunk'                                  => [
            'value' => 'Детайлна справка: отворен багажник',
            'units' => [
                0 => 'Затворен', 1 => 'Отворен',

            ], 'measurement_unit' => '',
        ],
        'lights_running_lights'                           => [
            'value' => 'Фарове: пуснати фарове',
            'units' => [
                0 => 'Спрени', 1 => 'Пуснати',

            ], 'measurement_unit' => '',
        ],
        'lights_low_beam'                                 => [
            'value' => 'Фарове: къси фарове',
            'units' => [
                0 => 'Спрени', 1 => 'Пуснати',

            ], 'measurement_unit' => '',
        ],
        'lights_high_beam'                                => [
            'value' => 'Фарове: дълги фарове',
            'units' => [
                0 => 'Спрени', 1 => 'Пуснати',

            ], 'measurement_unit' => '',
        ],
        'lights_front_fog_light'                          => [
            'value' => 'Фарове: предни фарове за мъгла',
            'units' => [
                0 => 'Спрени', 1 => 'Пуснати',

            ], 'measurement_unit' => '',
        ],
        'lights_rear_fog_light'                           => [
            'value' => 'Фарове: задни фарове за мъгла',
            'units' => [
                0 => 'Спрени', 1 => 'Пуснати',

            ], 'measurement_unit' => '',
        ],
        'lights_hazard_lights'                            => [
            'value' => 'Фарове: hazard lights',
            'units' => [
                0 => 'Спрени', 1 => 'Пуснати',

            ], 'measurement_unit' => '',
        ],
        'lights_reserved_one'                             => [
            'value' => '',
            'units' => [

            ], 'measurement_unit' => '',
        ],
        'lights_reserved_two'                             => [
            'value' => '',
            'units' => [

            ], 'measurement_unit' => '',
        ],
        'doors_driver_door'                               => [
            'value' => 'Врати: врата шофьор',
            'units' => [
                0 => 'Затворена', 1 => 'Отворена',
            ], 'measurement_unit' => '',
        ],
        'doors_passenger_door'                            => [
            'value' => 'Врати: врата пътник',
            'units' => [
                0 => 'Затворена', 1 => 'Отворена',
            ], 'measurement_unit' => '',
        ],
        'doors_rear_left_door'                            => [
            'value' => 'Врати: задна лява врата',
            'units' => [
                0 => 'Затворена', 1 => 'Отворена',
            ], 'measurement_unit' => '',
        ],
        'doors_rear_right_door'                           => [
            'value' => 'Врати: задна дясна врата',
            'units' => [
                0 => 'Затворена', 1 => 'Отворена',

            ], 'measurement_unit' => '',
        ],
        'doors_trunk'                                     => [
            'value' => 'Врати: багажник',
            'units' => [
                0 => 'Затворена', 1 => 'Отворена',

            ], 'measurement_unit' => '',
        ],
        'doors_hood'                                      => [
            'value' => 'Врати: покрив',
            'units' => [
                0 => 'Затворена', 1 => 'Отворена',

            ], 'measurement_unit' => '',
        ],
        'doors_reserved_one'                              => [
            'value' => '',
            'units' => [

            ], 'measurement_unit' => '',
        ],
        'doors_reserved_two'                              => [
            'value' => '',
            'units' => [

            ], 'measurement_unit' => '',
        ],
        'total_vehicle_overspeed_time'                    => [
            'value' => 'Общо време на превозното средство в превишена скорост',
            'units' => [

            ], 'measurement_unit' => 'ч',
        ],
        'total_engine_overspeed_time'                     => [
            'value' => 'Общо време на двигателя в превишена скорост',
            'units' => [

            ], 'measurement_unit' => 'ч',
        ],
        'fuel_level_litres'                     => [
            'value' => 'Ниво на гориво в литри',
            'units' => [

            ], 'measurement_unit' => 'литри',
        ],
        'fuel_level_percentage'                     => [
            'value' => 'Ниво на гориво в проценти',
            'units' => [

            ], 'measurement_unit' => '%',
        ],
    ],
    'poi_report_validation'       => [
        'choose_poi'  => "Изберете статичен обект",
        'invalid_poi' => "Невалиден статичен обект",
    ],
    'report_of'                   => "Справка за",
    'get_in'                      => "Влязъл",
    'get_out'                     => "Излязъл",
    'still_in'                    => "В зоната на обекта",
    'results'                     => "Резултати"
];
