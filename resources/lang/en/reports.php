<?php

return [
    'create_general_report'       => 'Create general report',
    'invalid_last_date'           => 'Invalid end date',
    'choose_last_date'            => 'Choose end date',
    'choose_period_input'         => 'Choose period input',
    'invalid_period_input'        => 'Invalid period input',
    'choose_start_time'           => 'Choose start time',
    'choose_end_time'             => 'Choose end time',
    'choose_days'                 => 'Choose days',
    'invalid_start_time'          => 'Invalid start time',
    'invalid_end_time'            => 'Invalid end time',
    'days'                        => 'days',
    'first_movement'              => 'First movement',
    'course_number'               => 'Course N',
    'motion_hours'                => 'Motion hours',
    'stop_hours'                  => 'Stop hours',
    'parametric_report'           => 'Parametric report',
    'canbus_report'               => 'CANBUS report',
    'fuel_report'                 => 'Fuel report',
    'poi_report'                  => 'POI report',
    'trip_report'                 => 'Trip report',
    'general_report'              => 'General report',
    'make_parametric_report'      => 'Create a parametric report',
    'make_canbus_report'          => 'Create a CANBUS report',
    'make_fuel_report'            => 'Create a fuel report',
    'create_poi_report'           => 'Create a POI report',
    'tookoff'                     => 'Took off',
    'arrivedat'                   => 'Arrived at',
    'list_tracked_objects_status' => 'List of tracked objects statuses',
    'parametric'                  => [
        'parameters'            => 'Parameters',
        'no_parameters'         => 'No reports available',
        'get_report'            => 'Get parametric report',
        'no_device_attached'    => 'No device attached'
    ],
    'fuel' => [
        'distance' => 'Distance',
        'used_fuel' => 'Used fuel',
        'average_expense' => 'Average expense',
        'expense_mark' => 'Expense mark',
        'end_mileage' => 'End mileage',
        'fuel_level' => 'Fuel level',
    ],
    'validation'                  => [
        'invalid_parameters'              => 'Invalid parameters selected',
        'invalid_start_date'              => 'Invalid start date',
        'invalid_end_date'                => 'Invalid end date',
        'invalid_start_time'              => 'Invalid start time',
        'invalid_end_time'                => 'Invalid end time',
        'invalid_driver_information'      => 'Invalid driver information',
        'invalid_tracked_object'          => 'Invalid tracked object',
        'choose_tracked_object_or_driver' => 'Choose tracked object or driver',
        'invalid_date'                    => 'Invalid date',
    ],
    'canbus'                      => [
        'vehicle_identification_number'                   => [
            'value' => 'Vehicle Identification Number', 'units' => [

            ], 'measurement_unit' => '',
        ],
        'ignition_key'                                    => [
            'value' => 'Ignition key', 'units' => [
                'ignition_off' => 'Ignition on', 'ignition_on' => 'Ignition off', 'engine_on' => 'Engine on',
            ], 'measurement_unit' => '',
        ],
        'total_distance'                                  => [
            'value' => 'Total distance', 'units' => [

            ], 'measurement_unit' => 'Kilometers',
        ],
        'total_fuel_used'                                 => [
            'value' => 'Total fuel used', 'units' => [

            ], 'measurement_unit' => 'Litres',
        ],
        'engine_rpm'                                      => [
            'value' => 'Engine RPM', 'units' => [

            ], 'measurement_unit' => 'RPM',
        ],
        'vehicle_speed'                                   => [
            'value' => 'Vehicle Speed', 'units' => [

            ], 'measurement_unit' => 'Km/h',
        ],
        'engine_coolant_temperature'                      => [
            'value' => 'Engine coolant temperature', 'units' => [

            ], 'measurement_unit' => 'Celsius',
        ],
        'fuel_consumption'                                => [
            'value' => 'Fuel consumption', 'units' => [

            ], 'measurement_unit' => 'L/100km',
        ],
        'range'                                           => [
            'value' => 'Range', 'units' => [

            ], 'measurement_unit' => '',
        ],
        'accelerator_pedal_pressure'                      => [
            'value' => 'Accelerator pedal pressure', 'units' => [

            ], 'measurement_unit' => '%',
        ],
        'total_engine_hours'                              => [
            'value' => 'Total engine hours', 'units' => [

            ], 'measurement_unit' => 'h',
        ],
        'total_driving_time'                              => [
            'value' => 'Total driving time', 'units' => [

            ], 'measurement_unit' => 'h',
        ],
        'total_engine_idle_time'                          => [
            'value' => 'Total engine idle time', 'units' => [

            ], 'measurement_unit' => 'h',
        ],
        'total_idle_fuel_used'                            => [
            'value' => 'Total idle fuel used', 'units' => [

            ], 'measurement_unit' => 'l`',
        ],
        'axle_weight'                                     => [
            'value' => 'Axle weight', 'units' => [

            ], 'measurement_unit' => 'kg',
        ],
        'tachograph_driver_one_validity_mark'             => [
            'value' => 'Tachograph driver one validity mark', 'units' => [

            ], 'measurement_unit' => '',
        ],
        'tachograph_driver_two_validity_mark'             => [
            'value' => 'Tachograph driver two validity mark', 'units' => [

            ], 'measurement_unit' => '',
        ],
        'tachograph_driver_one_reserved'                  => [
            'values' => [

            ], 'measurement_unit' => '',
        ],
        'tachograph_driver_two_reserved'                  => [
            'value' => '', 'units' => [

            ], 'measurement_unit' => '',
        ],
        'tachograph_driver_one_driver_time_related_state' => [
            'value' => 'Tachograph driver one time related state', 'units' => [
                'normal_no_limits_reached' => 'normal/no limits reached',
                '15_minut_before_41_h'     => '15 min before 41 h',
                '41_h_reached'             => '41 h reached',
                '15_min_before_9_h'        => '15 min before 9h',
                '9_h_reached'              => '9 h reached',
                '15_minut_before_16_h'     => '15 minutes before 16 h',
                '16_h_reached'             => '16 h reached',
                'other_limit'              => 'other limit',
            ], 'measurement_unit' => '',
        ],
        'tachograph_driver_two_driver_time_related_state' => [
            'value' => 'Tachograph driver two time related state', 'units' => [
                'normal_no_limits_reached' => 'normal/no limits reached',
                '15_minut_before_41_h'     => '15 min before 41 h',
                '41_h_reached'             => '41 h reached',
                '15_min_before_9_h'        => '15 min before 9h',
                '9_h_reached'              => '9 h reached',
                '15_minut_before_16_h'     => '15 minutes before 16 h',
                '16_h_reached'             => '16 h reached',
                'other_limit'              => 'other limit',
            ], 'measurement_unit' => '',
        ],
        'tachograph_driver_one_driver_work_state'         => [
            'value' => 'Tachograph driver one time work state', 'units' => [
                'normal_no_limits_reached'     => 'Normal, no limits reached',
                'rest_sleeping'                => 'Rest, sleeping',
                'driver_available_short_break' => 'Driver available, short break',
                'driver_behind_wheel'          => 'Driver behind wheel',
            ], 'measurement_unit' => '',
        ],
        'tachograph_driver_two_driver_work_state'         => [
            'value' => 'Tachograph driver two time work state', 'units' => [
                'normal_no_limits_reached'     => 'Normal, no limits reached',
                'rest_sleeping'                => 'Rest, sleeping',
                'driver_available_short_break' => 'Driver available, short break',
                'driver_behind_wheel'          => 'Driver behind wheel',
            ], 'measurement_unit' => '',
        ],
        'detailed_fuel_low'                               => [
            'value' => 'Detailed: low fuel report', 'units' => [
                0 => 'Нормално', 1 => 'Ниско',

            ], 'measurement_unit' => '',
        ],
        'detailed_driver_seatbelt'                        => [
            'value' => 'Detailed: driver seatbelt report', 'units' => [
                0 => 'Detached', 1 => 'Attached',

            ], 'measurement_unit' => '',
        ],
        'detailed_air_conditioning'                       => [
            'value' => 'Detailed: air conditioning report', 'units' => [
                0 => 'Off', 1 => 'On',

            ], 'measurement_unit' => '',
        ],
        'detailed_cruise_control'                         => [
            'value' => 'Detailed: cruise control report', 'units' => [
                0 => 'Off', 1 => 'On',

            ], 'measurement_unit' => '',
        ],
        'detailed_brake_pedal'                            => [
            'value' => 'Detailed: brake pedal report', 'units' => [
                0 => 'Released', 1 => 'Pressed',

            ], 'measurement_unit' => '',
        ],
        'detailed_clutch_pedal'                           => [
            'value' => 'Detailed: clutch pedal report', 'units' => [
                0 => 'Released', 1 => 'Pressed',

            ], 'measurement_unit' => '',
        ],
        'detailed_handbrake'                              => [
            'value' => 'Detailed: handbrake report', 'units' => [
                0 => 'Released', 1 => 'Pressed',

            ], 'measurement_unit' => '',
        ],
        'detailed_central_lock'                           => [
            'value' => 'Detailed: central lock report', 'units' => [
                0 => 'Off', 1 => 'On',

            ], 'measurement_unit' => '',
        ],
        'detailed_reverse_gear'                           => [
            'value' => 'Detailed: reverse gear report', 'units' => [
                0 => 'Off', 1 => 'On',
            ], 'measurement_unit' => '',
        ],
        'detailed_running_lights'                         => [
            'value' => 'Detailed: running lights report', 'units' => [
                0 => 'Off', 1 => 'On',
            ], 'measurement_unit' => '',
        ],
        'detailed_low_beams'                              => [
            'value' => 'Detailed: low beams report', 'units' => [
                0 => 'Off', 1 => 'On',
            ], 'measurement_unit' => '',
        ],
        'detailed_high_beams'                             => [
            'value' => 'Detailed: high beams report', 'units' => [
                0 => 'Off', 1 => 'On',
            ], 'measurement_unit' => '',
        ],
        'detailed_rear_fog_lights'                        => [
            'value' => 'Detailed: rear fog lights report', 'units' => [
                0 => 'Off', 1 => 'On',
            ], 'measurement_unit' => '',
        ],
        'detailed_front_fog_lights'                       => [
            'value' => 'Detailed: front fog lights report', 'units' => [
                0 => 'Off', 1 => 'On',
            ], 'measurement_unit' => '',
        ],
        'detailed_doors'                                  => [
            'value' => 'Detailed: doors report', 'units' => [
                0 => 'Off', 1 => 'On',
            ], 'measurement_unit' => '',
        ],
        'detailed_trunk'                                  => [
            'value' => 'Detailed: trunk report', 'units' => [
                0 => 'Off', 1 => 'On',
            ], 'measurement_unit' => '',
        ],
        'lights_running_lights'                           => [
            'value' => 'Lights: running lights', 'units' => [
                0 => 'Off', 1 => 'On',
            ], 'measurement_unit' => '',
        ],
        'lights_low_beam'                                 => [
            'value' => 'Lights: low beam', 'units' => [
                0 => 'Off', 1 => 'On',

            ], 'measurement_unit' => '',
        ],
        'lights_high_beam'                                => [
            'value' => 'Lights: high beam', 'units' => [
                0 => 'Off', 1 => 'On',

            ], 'measurement_unit' => '',
        ],
        'lights_front_fog_light'                          => [
            'value' => 'Lights: front fog light', 'units' => [
                0 => 'Off', 1 => 'On',

            ], 'measurement_unit' => '',
        ],
        'lights_rear_fog_light'                           => [
            'value' => 'Lights: rear fog light', 'units' => [
                0 => 'Off', 1 => 'On',

            ], 'measurement_unit' => '',
        ],
        'lights_hazard_lights'                            => [
            'value' => 'Lights: hazard lights', 'units' => [
                0 => 'Off', 1 => 'On',

            ], 'measurement_unit' => '',
        ],
        'lights_reserved_one'                             => [
            'values' => [

            ], 'measurement_unit' => '',
        ],
        'lights_reserved_two'                             => [
            'value' => '', 'units' => [

            ], 'measurement_unit' => '',
        ],
        'doors_driver_door'                               => [
            'value' => 'Doors: driver door', 'units' => [
                0 => 'Closed', 0 => 'Open',
            ], 'measurement_unit' => '',
        ],
        'doors_passenger_door'                            => [
            'value' => 'Doors: passenger door', 'units' => [
                0 => 'Closed', 0 => 'Open',

            ], 'measurement_unit' => '',
        ],
        'doors_rear_left_door'                            => [
            'value' => 'Doors: rear left door', 'units' => [
                0 => 'Closed', 0 => 'Open',

            ], 'measurement_unit' => '',
        ],
        'doors_rear_right_door'                           => [
            'value' => 'Doors: rear right door', 'units' => [
                0 => 'Closed', 0 => 'Open',

            ], 'measurement_unit' => '',
        ],
        'doors_trunk'                                     => [
            'value' => 'Doors: trunk', 'units' => [
                0 => 'Closed', 0 => 'Open',

            ], 'measurement_unit' => '',
        ],
        'doors_hood'                                      => [
            'value' => 'Doors: hood', 'units' => [
                0 => 'Closed', 0 => 'Open',

            ], 'measurement_unit' => '',
        ],
        'doors_reserved_one'                              => [
            'values' => [

            ], 'measurement_unit' => '',
        ],
        'doors_reserved_two'                              => [
            'value' => '', 'units' => [
                0 => 'Closed', 0 => 'Open',

            ], 'measurement_unit' => '',
        ],
        'total_vehicle_overspeed_time'                    => [
            'value' => 'Total vehicle overspeed time', 'units' => [

            ], 'measurement_unit' => 'h',
        ],
        'total_engine_overspeed_time'                     => [
            'value' => 'Total engine overspeed time', 'units' => [

            ], 'measurement_unit' => 'h',
        ],
        'fuel_level_litres'                     => [
            'value' => 'Fuel level in litres',
            'units' => [

            ], 'measurement_unit' => 'litres',
        ],
        'fuel_level_percentage'                     => [
            'value' => 'Fuel level in percentage',
            'units' => [

            ], 'measurement_unit' => '%',
        ],
    ],
    'poi_report_validation'       => [
        'choose_poi'  => "Choose point of interest",
        'invalid_poi' => "Invalid point of interest",
    ],
    'report_of'                   => "Report for",
    'get_in'                      => "Got in",
    'get_out'                     => "Got out",
    'still_in'                    => "Still in the POI",
    'results'                     => "Results"
];
