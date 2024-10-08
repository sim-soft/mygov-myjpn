<?php

return [
    'default' => [
        'actual_age' => '{year} years {month} months {day} days',
        'malaysia' => 'Malaysia',
    ],
    'exceptions' => [
        'invalid_characters' => 'The identity number contains invalid characters.',
        'invalid_length' => 'The identity number does not meet the expected length.',
        'invalid_birthdate' => 'The identity number contains an invalid birthdate.',
        'invalid_birthplace' => 'The identity number contains an unrecognized birthplace code.',
        'invalid_on_date' => 'Date provided should be greater than the birthdate.',
        'invalid_age_input' => 'Invalid age value',
    ],
    'age_groups' => [
        'children' => 'Children',
        'youth' => 'Youth',
        'adult' => 'Adult',
        'old_adult' => 'Old Adult',
        'senior_citizen' => 'Senior Citizen',
        'unknown_group' => 'Unknown Group',
    ],
    'pb_codes' => [
        '01' => 'Johor',
        '21' => 'Johor',
        '22' => 'Johor',
        '23' => 'Johor',
        '24' => 'Johor',
        '02' => 'Kedah',
        '25' => 'Kedah',
        '26' => 'Kedah',
        '27' => 'Kedah',
        '03' => 'Kelantan',
        '28' => 'Kelantan',
        '29' => 'Kelantan',
        '04' => 'Malacca',
        '30' => 'Malacca',
        '05' => 'Negeri Sembilan',
        '31' => 'Negeri Sembilan',
        '59' => 'Negeri Sembilan',
        '06' => 'Pahang',
        '32' => 'Pahang',
        '33' => 'Pahang',
        '07' => 'Penang',
        '34' => 'Penang',
        '35' => 'Penang',
        '08' => 'Perak',
        '36' => 'Perak',
        '37' => 'Perak',
        '38' => 'Perak',
        '39' => 'Perak',
        '09' => 'Perlis',
        '40' => 'Perlis',
        '10' => 'Selangor',
        '41' => 'Selangor',
        '42' => 'Selangor',
        '43' => 'Selangor',
        '44' => 'Selangor',
        '11' => 'Terengganu',
        '45' => 'Terengganu',
        '46' => 'Terengganu',
        '12' => 'Sabah',
        '47' => 'Sabah',
        '48' => 'Sabah',
        '49' => 'Sabah',
        '13' => 'Sarawak',
        '50' => 'Sarawak',
        '51' => 'Sarawak',
        '52' => 'Sarawak',
        '53' => 'Sarawak',
        '14' => 'Federal Territory (Kuala Lumpur)',
        '54' => 'Federal Territory (Kuala Lumpur)',
        '55' => 'Federal Territory (Kuala Lumpur)',
        '56' => 'Federal Territory (Kuala Lumpur)',
        '57' => 'Federal Territory (Kuala Lumpur)',
        '15' => 'Federal Territory (Labuan)',
        '58' => 'Federal Territory (Labuan)',
        '16' => 'Federal Territory (Putrajaya)',

        '82' => 'Unknown State',

        '60' => 'Brunei',
        '61' => 'Indonesia',
        '62' => implode(',', [
            'Cambodia',
            'Democratic Kampuchea',
            'Kampuchea',
        ]),
        '63' => 'Laos',
        '64' => implode(',', [
            'Burma',
            'Byelorussia',
            'Myanmar',
        ]),
        '65' => 'Philippines',
        '66' => 'Singapore',
        '67' => 'Thailand',
        '68' => 'Vietnam',
        '71' => 'Foreign-born',
        '72' => 'Foreign-born',
        '74' => 'China',
        '75' => 'India',
        '76' => 'Pakistan',
        '77' => implode(',',[
            'Arab Saudi',
            'Saudi Arabia',
        ]),
        '78' => 'Sri Lanka',
        '79' => 'Bangladesh',

        '83' => implode(',', [
            'American Samoa',
            'Asia Pacific',
            'Australia',
            'Christmas Island',
            'Cocos(Keeling) Islands',
            'Cook Islands',
            'Fiji',
            'French Polynesia',
            'Guam',
            'Heard and McDonald Islands',
            'Micronesia',
            'Marshall Islands',
            'New Zealand',
            'New Caledonia',
            'Niue',
            'Norfolk Islands',
            'Papua New Guinea',
            'Timor-Leste',
            'Tokelau',
            'United States Minor Outlying Islands',
            'Wallis and Futuna Islands',
        ]),
        '84' => implode(',', [
            'South America',
            'Anguilla',
            'Argentina',
            'Aruba',
            'Bolivia',
            'Brazil',
            'Chile',
            'Colombia',
            'Ecuador',
            'French Guiana',
            'Guyana',
            'Guadeloupe',
            'Paraguay',
            'Peru',
            'Suriname',
            'South Georgia & The South Sandwich Islands',
            'Uruguay',
            'Venezuela',
        ]),

        '85' => implode(',', [
            'South Africa',
            'Africa',
            'Algeria',
            'Angola',
            'Botswana',
            'Burundi',
            'Cameroon',
            'Central African Republic',
            'Chad',
            'Republic of the Congo (Brazzaville)',
            'Democratic Republic of the Congo (Kinshasa)',
            'Djibouti',
            'Egypt',
            'Eritrea',
            'Ethiopia',
            'Gabon',
            'Gambia',
            'Guinea',
            'Ghana',
            'Kenya',
            'Liberia',
            'Mali',
            'Mauritania',
            'Morocco',
            'Malawi',
            'Mozambique',
            'Mayotte',
            'Niger',
            'Nigeria',
            'Namibia',
            'Rwanda',
            'Reunion',
            'Senegal',
            'Sierra Leone',
            'Somalia',
            'Sudan',
            'Eswatini (formerly Swaziland)',
            'Tunisia',
            'Tanzania',
            'Tonga',
            'Togo',
            'Uganda',
            'Western Sahara',
            'Zaire',
            'Zambia',
            'Zimbabwe',
        ]),

        '86' => implode(',', [
            'Armenia',
            'Austria',
            'Belgium',
            'Cyprus',
            'Denmark',
            'Europe',
            'France',
            'Finland',
            'Faeroe Islands',
            'Finland, Metropolitan',
            'Greece',
            'Germany (Dem.Rep)',
            'Germany (Fed.Rep)',
            'Germany',
            'Holy See (Vatican City)',
            'Italy',
            'Luxembourg',
            'Malta',
            'Mediterranean',
            'Monaco',
            'Macedonia',
            'Netherlands',
            'Norway',
            'Portugal',
            'Rep. of Moldova',
            'Spain',
            'Switzerland',
            'Slovakia',
            'Slovenia',
            'Sweden',
            'UK-Dependent Territories City',
            'UK-National Overseas',
            'UK-Overseas Citizen',
            'UK-Protected Person',
            'UK-Subject',
        ]),
        '87' => implode(',', [
            'Britain',
            'Great Britain',
            'Ireland',
        ]),
        '88' => implode(',', [
            'Bahrain',
            'Iran',
            'Iraq',
            'Israel',
            'Jordan',
            'Kuwait',
            'Lebanon',
            'Oman',
            'Qatar',
            'Republic of Yemen',
            'Syria',
            'Turkey',
            'Middle East',
            'United Arab Emirates',
            'Yemen Arab Republic',
            'Yemen People\'s Democratic Republic',
        ]),
        '89' => implode(',', [
            'Japan',
            'South Korea',
            'North Korea',
            'Taiwan',
            'Far East',
        ]),
        '90' => implode(',', [
            'Bahamas',
            'Barbados',
            'Belize',
            'Caribbean',
            'Costa Rica',
            'Cuba',
            'Dominica',
            'Dominican Republic',
            'El Salvador',
            'Grenada',
            'Guatemala',
            'Haiti',
            'Honduras',
            'Jamaica',
            'Mexico',
            'Martinique',
            'Nicaragua',
            'Panama',
            'Puerto Rico',
            'ST. Kitts and Nevis',
            'ST. Vincent and The Grenadines',
            'ST. Lucia',
            'Trinidad & Tobago',
            'Turks and Caicos Islands',
            'Virgin Islands (USA)',
        ]),
        '91' => implode(',', [
            'North America',
            'Canada',
            'Greenland',
            'Netherlands Antilles',
            'St. Pierre and Miquelon',
            'United States of America',
        ]),
        '92' => implode(',', [
            'Albania',
            'Belarus',
            'Bosnia Herzegovina',
            'Bulgaria',
            'Croatia',
            'Czech Republic',
            'Czechoslovakia',
            'Estonia',
            'Georgia',
            'Hungary',
            'Latvia',
            'Lithuania',
            'Montenegro',
            'Poland',
            'Romania',
            'Russian Federation',
            'Republic of Kosovo',
            'Serbia',
            'U.S.S.R',
            'Ukraine',
        ]),
        '93' => implode(',', [
            'Afghanistan',
            'Andorra/Andora',
            'Antarctica',
            'Antigua & Barbuda',
            'Azerbaijan',
            'Benin',
            'Bermuda',
            'Bhutan',
            'Bora-Bora',
            'Bouvet Island',
            'British Indian Ocean Territory',
            'Burkina Faso/Burkina',
            'Cape Verde',
            'Cayman Islands',
            'Comoros',
            'Dahomey',
            'Equatorial Guinea',
            'Falkland Islands',
            'French Southern Territories',
            'Guinea-Bissau',
            'Gibraltar',
            'Hong Kong',
            'Iceland',
            'Ivory Coast',
            'Kiribati',
            'Kazakhstan',
            'Kyrgyzstan',
            'Libya',
            'Lesotho',
            'Liechtenstein',
            'Maldives',
            'Madagascar',
            'Mauritius',
            'Malagasy',
            'Mongolia',
            'Maghribi',
            'Montserrat',
            'Macau',
            'Nauru',
            'Nepal',
            'Northern Marianas Islands',
            'Outer Mongolia',
            'Palestine',
            'Pitcairn Islands',
            'Palau',
            'St. Lucia',
            'St. Vincent',
            'Seychelles',
            'Solomon Islands',
            'Samoa',
            'Sao Tome & Principe',
            'Western Samoa',
            'Swapo',
            'St. Helena',
            'San Marino',
            'Svalbard and Jan Mayen Islands',
            'Tuvalu',
            'Tajikistan',
            'Turkmenistan',
            'Upper Volta',
            'Uzbekistan',
            'Vanuatu',
            'Vatican City',
            'Virgin Islands (British)',
            'Western Samoa',
            'Yugoslavia',
        ]),
        '98' => implode(',', [
            'Stateless Person Article 1/1954',
            'Stateless', // no country
        ]),
        '99' => implode(',', [
            'Mecca',
            'Information Not Available',
            'Neutral Zone',
            'Refugee Article 1/1951',
            'Refugee',
            'UN Specialized Agency',
            'United Nations Organization',
            'Unspecified Nationality',
        ]),
    ]
];
