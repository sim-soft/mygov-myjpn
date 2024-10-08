<?php

return [
    'default' => [
        'actual_age' => '{year}年 {month}个月 {day}天',
        'malaysia' => '马来西亚',
    ],
    'exceptions' => [
        'invalid_characters' => '身份证号码包含了无效字符。',
        'invalid_length' => '身份证号码的长度不符合标准。',
        'invalid_birthdate' => '无法识别身份证号码的出生日期。',
        'invalid_birthplace' => '无法识别身份证号码的出生地代码。',
        'invalid_on_date' => '所提供的日期必须大于出生日期。',
        'invalid_age_input' => '提供的年龄值无法使用。',
    ],
    'age_groups' => [
        'children' => '儿童',
        'youth' => '青年',
        'adult' => '成人',
        'old_adult' => '中年人',
        'senior_citizen' => '老年人',
        'unknown_group' => '未知群体',
    ],
    'pb_codes' => [
        '01' => '柔佛',
        '21' => '柔佛',
        '22' => '柔佛',
        '23' => '柔佛',
        '24' => '柔佛',
        '02' => '吉打',
        '25' => '吉打',
        '26' => '吉打',
        '27' => '吉打',
        '03' => '吉兰丹',
        '28' => '吉兰丹',
        '29' => '吉兰丹',
        '04' => '马六甲',
        '30' => '马六甲',
        '05' => '森美兰',
        '31' => '森美兰',
        '59' => '森美兰',
        '06' => '彭亨',
        '32' => '彭亨',
        '33' => '彭亨',
        '07' => '槟城',
        '34' => '槟城',
        '35' => '槟城',
        '08' => '霹雳',
        '36' => '霹雳',
        '37' => '霹雳',
        '38' => '霹雳',
        '39' => '霹雳',
        '09' => '玻璃市',
        '40' => '玻璃市',
        '10' => '雪兰莪',
        '41' => '雪兰莪',
        '42' => '雪兰莪',
        '43' => '雪兰莪',
        '44' => '雪兰莪',
        '11' => '登嘉楼',
        '45' => '登嘉楼',
        '46' => '登嘉楼',
        '12' => '沙巴',
        '47' => '沙巴',
        '48' => '沙巴',
        '49' => '沙巴',
        '13' => '砂拉越',
        '50' => '砂拉越',
        '51' => '砂拉越',
        '52' => '砂拉越',
        '53' => '砂拉越',
        '14' => '联邦直辖区 (吉隆坡)',
        '54' => '联邦直辖区 (吉隆坡)',
        '55' => '联邦直辖区 (吉隆坡)',
        '56' => '联邦直辖区 (吉隆坡)',
        '57' => '联邦直辖区 (吉隆坡)',
        '15' => '联邦直辖区 (纳闽)',
        '58' => '联邦直辖区 (纳闽)',
        '16' => '联邦直辖区 (布城)',

        '82' => '未知州属',

        '60' => '文莱 (Brunei)',
        '61' => '印度尼西亚 (Indonesia)',
        '62' => implode(',', [
            '柬埔寨 (Cambodia)',
            '柬埔寨民主政府 (Democratic Kampuchea)',
            '柬埔寨 (Kampuchea)',
        ]),
        '63' => '老挝 (Laos)',
        '64' => implode(',', [
            '缅甸 (Burma)',
            '白俄罗斯 (Byelorussia)',
            '缅甸 (Myanmar)',
        ]),
        '65' => '菲律宾 (Philippines)',
        '66' => '新加坡 (Singapore)',
        '67' => '泰国 (Thailand)',
        '68' => '越南 (Vietnam)',
        '71' => '出生于外国',
        '72' => '出生于外国',
        '74' => '中国 (China)',
        '75' => '印度 (India)',
        '76' => '巴基斯坦 (Pakistan)',
        '77' => implode(',', [
            '沙特阿拉伯 (Arab Saudi)',
            '沙特阿拉伯 (Saudi Arabia)',
        ]),
        '78' => '斯里兰卡 (Sri Lanka)',
        '79' => '孟加拉国 (Bangladesh)',

        '83' => implode(',', [
            '美属萨摩亚 (American Samoa)',
            '亚太地区 (Asia Pacific)',
            '澳大利亚 (Australia)',
            '圣诞岛 (Christmas Island)',
            '科科斯（基林）群岛 (Cocos(Keeling) Islands)',
            '库克群岛 (Cook Islands)',
            '斐济 (Fiji)',
            '法属波利尼西亚 (French Polynesia)',
            '关岛 (Guam)',
            '赫德岛和麦克唐纳群岛 (Heard and McDonald Islands)',
            '密克罗尼西亚 (Micronesia)',
            '马绍尔群岛 (Marshall Islands)',
            '新西兰 (New Zealand)',
            '新喀里多尼亚 (New Caledonia)',
            '纽埃 (Niue)',
            '诺福克群岛 (Norfolk Islands)',
            '巴布亚新几内亚 (Papua New Guinea)',
            '东帝汶 (Timor-Leste)',
            '托克劳 (Tokelau)',
            '美国本土外小岛屿 (United States Minor Outlying Islands)',
            '瓦利斯和富图纳群岛 (Wallis and Futuna Islands)',
        ]),
        '84' => implode(',', [
            '南美洲 (South America)',
            '安圭拉 (Anguilla)',
            '阿根廷 (Argentina)',
            '阿鲁巴 (Aruba)',
            '玻利维亚 (Bolivia)',
            '巴西 (Brazil)',
            '智利 (Chile)',
            '哥伦比亚 (Colombia)',
            '厄瓜多尔 (Ecuador)',
            '法属圭亚那 (French Guiana)',
            '圭亚那 (Guyana)',
            '瓜德罗普 (Guadeloupe)',
            '巴拉圭 (Paraguay)',
            '秘鲁 (Peru)',
            '苏里南 (Suriname)',
            '南乔治亚岛和南桑威奇群岛 (South Georgia & The South Sandwich Islands)',
            '乌拉圭 (Uruguay)',
            '委内瑞拉 (Venezuela)',
        ]),

        '85' => implode(',', [
            '南非 (South Africa)',
            '非洲 (Africa)',
            '阿尔及利亚 (Algeria)',
            '安哥拉 (Angola)',
            '博茨瓦纳 (Botswana)',
            '布隆迪 (Burundi)',
            '喀麦隆 (Cameroon)',
            '中非共和国 (Central African Republic)',
            '乍得 (Chad)',
            '刚果（布拉柴维尔） (Republic of the Congo (Brazzaville))',
            '刚果（金沙萨） (Democratic Republic of the Congo (Kinshasa))',
            '吉布提 (Djibouti)',
            '埃及 (Egypt)',
            '厄立特里亚 (Eritrea)',
            '埃塞俄比亚 (Ethiopia)',
            '加蓬 (Gabon)',
            '冈比亚 (Gambia)',
            '几内亚 (Guinea)',
            '加纳 (Ghana)',
            '肯尼亚 (Kenya)',
            '利比里亚 (Liberia)',
            '马里 (Mali)',
            '毛里塔尼亚 (Mauritania)',
            '摩洛哥 (Morocco)',
            '马拉维 (Malawi)',
            '莫桑比克 (Mozambique)',
            '马约特 (Mayotte)',
            '尼日尔 (Niger)',
            '尼日利亚 (Nigeria)',
            '纳米比亚 (Namibia)',
            '卢旺达 (Rwanda)',
            '留尼汪 (Reunion)',
            '塞内加尔 (Senegal)',
            '塞拉利昂 (Sierra Leone)',
            '索马里 (Somalia)',
            '苏丹 (Sudan)',
            '斯威士兰 (Eswatini)',
            '突尼斯 (Tunisia)',
            '坦桑尼亚 (Tanzania)',
            '汤加 (Tonga)',
            '多哥 (Togo)',
            '乌干达 (Uganda)',
            '西撒哈拉 (Western Sahara)',
            '扎伊尔 (Zaire)',
            '赞比亚 (Zambia)',
            '津巴布韦 (Zimbabwe)',
        ]),

        '86' => implode(',', [
            '亚美尼亚 (Armenia)',
            '奥地利 (Austria)',
            '比利时 (Belgium)',
            '塞浦路斯 (Cyprus)',
            '丹麦 (Denmark)',
            '欧洲 (Europe)',
            '法国 (France)',
            '芬兰 (Finland)',
            '法罗群岛 (Faroe Islands)',
            '芬兰，大都会 (Finland, Metropolitan)',
            '希腊 (Greece)',
            '德国（民主共和国） (Germany (Dem.Rep))',
            '德国（联邦共和国） (Germany (Fed.Rep))',
            '德国 (Germany)',
            '梵蒂冈 (梵蒂冈城) (Holy See (Vatican City))',
            '意大利 (Italy)',
            '卢森堡 (Luxembourg)',
            '马耳他 (Malta)',
            '地中海 (Mediterranean)',
            '摩纳哥 (Monaco)',
            '马其顿 (Macedonia)',
            '荷兰 (Netherlands)',
            '挪威 (Norway)',
            '葡萄牙 (Portugal)',
            '摩尔多瓦共和国 (Rep. of Moldova)',
            '西班牙 (Spain)',
            '瑞士 (Switzerland)',
            '斯洛伐克 (Slovakia)',
            '斯洛文尼亚 (Slovenia)',
            '瑞典 (Sweden)',
            '英国依赖领地城市 (UK-Dependent Territories City)',
            '英国国民海外 (UK-National Overseas)',
            '英国海外公民 (UK-Overseas Citizen)',
            '英国受保护人 (UK-Protected Person)',
            '英国人 (UK-Subject)',
        ]),
        '87' => implode(',', [
            '英国 (Britain)',
            '大不列颠 (Great Britain)',
            '爱尔兰 (Ireland)',
        ]),
        '88' => implode(',', [
            '巴林 (Bahrain)',
            '伊朗 (Iran)',
            '伊拉克 (Iraq)',
            '以色列 (Israel)',
            '约旦 (Jordan)',
            '科威特 (Kuwait)',
            '黎巴嫩 (Lebanon)',
            '阿曼 (Oman)',
            '卡塔尔 (Qatar)',
            '也门共和国 (Republic of Yemen)',
            '叙利亚 (Syria)',
            '土耳其 (Turkey)',
            '中东 (Middle East)',
            '阿拉伯联合酋长国 (United Arab Emirates)',
            '也门阿拉伯共和国 (Yemen Arab Republic)',
            '也门人民民主共和国 (Yemen People\'s Democratic Republic)',
        ]),
        '89' => implode(',', [
            '日本 (Japan)',
            '韩国 (South Korea)',
            '朝鲜 (North Korea)',
            '台湾 (Taiwan)',
            '远东 (Far East)',
        ]),
        '90' => implode(',', [
            '巴哈马 (Bahamas)',
            '巴巴多斯 (Barbados)',
            '伯利兹 (Belize)',
            '加勒比 (Caribbean)',
            '哥斯达黎加 (Costa Rica)',
            '古巴 (Cuba)',
            '多米尼克 (Dominica)',
            '多米尼加共和国 (Dominican Republic)',
            '萨尔瓦多 (El Salvador)',
            '格林纳达 (Grenada)',
            '危地马拉 (Guatemala)',
            '海地 (Haiti)',
            '洪都拉斯 (Honduras)',
            '牙买加 (Jamaica)',
            '墨西哥 (Mexico)',
            '马提尼克 (Martinique)',
            '尼加拉瓜 (Nicaragua)',
            '巴拿马 (Panama)',
            '波多黎各 (Puerto Rico)',
            '圣基茨和尼维斯 (ST. Kitts and Nevis)',
            '圣文森特和格林纳丁斯 (ST. Vincent and The Grenadines)',
            '圣卢西亚 (ST. Lucia)',
            '特立尼达和多巴哥 (Trinidad & Tobago)',
            '特克斯和凯科斯群岛 (Turks and Caicos Islands)',
            '维尔京群岛 (美国) (Virgin Islands (USA))',
        ]),
        '91' => implode(',', [
            '北美洲 (North America)',
            '加拿大 (Canada)',
            '格陵兰 (Greenland)',
            '荷兰属地 (Netherlands Antilles)',
            '圣皮埃尔和密克隆群岛 (St. Pierre and Miquelon)',
            '美利坚合众国 (United States of America)',
        ]),
        '92' => implode(',', [
            '阿尔巴尼亚 (Albania)',
            '白俄罗斯 (Belarus)',
            '波斯尼亚和黑塞哥维那 (Bosnia Herzegovina)',
            '保加利亚 (Bulgaria)',
            '克罗地亚 (Croatia)',
            '捷克共和国 (Czech Republic)',
            '捷克斯洛伐克 (Czechoslovakia)',
            '爱沙尼亚 (Estonia)',
            '格鲁吉亚 (Georgia)',
            '匈牙利 (Hungary)',
            '拉脱维亚 (Latvia)',
            '立陶宛 (Lithuania)',
            '黑山 (Montenegro)',
            '波兰 (Poland)',
            '罗马尼亚 (Romania)',
            '俄罗斯联邦 (Russian Federation)',
            '科索沃共和国 (Republic of Kosovo)',
            '塞尔维亚 (Serbia)',
            '苏联 (U.S.S.R)',
            '乌克兰 (Ukraine)',
        ]),
        '93' => implode(',', [
            '阿富汗 (Afghanistan)',
            '安道尔/安道拉 (Andorra/Andora)',
            '南极洲 (Antarctica)',
            '安提瓜和巴布达 (Antigua & Barbuda)',
            '阿塞拜疆 (Azerbaijan)',
            '贝宁 (Benin)',
            '百慕大 (Bermuda)',
            '不丹 (Bhutan)',
            '波拉波拉 (Bora-Bora)',
            '布韦岛 (Bouvet Island)',
            '英属印度洋领地 (British Indian Ocean Territory)',
            '布基纳法索/布基纳 (Burkina Faso/Burkina)',
            '佛得角 (Cape Verde)',
            '开曼群岛 (Cayman Islands)',
            '科摩罗 (Comoros)',
            '达荷美 (Dahomey)',
            '赤道几内亚 (Equatorial Guinea)',
            '福克兰群岛 (Falkland Islands)',
            '法属南部领地 (French Southern Territories)',
            '几内亚比绍 (Guinea-Bissau)',
            '直布罗陀 (Gibraltar)',
            '香港 (Hong Kong)',
            '冰岛 (Iceland)',
            '科特迪瓦 (Ivory Coast)',
            '基里巴斯 (Kiribati)',
            '哈萨克斯坦 (Kazakhstan)',
            '吉尔吉斯斯坦 (Kyrgyzstan)',
            '利比亚 (Libya)',
            '莱索托 (Lesotho)',
            '列支敦士登 (Liechtenstein)',
            '马尔代夫 (Maldives)',
            '马达加斯加 (Madagascar)',
            '毛里求斯 (Mauritius)',
            '马尔加什 (Malagasy)',
            '蒙古 (Mongolia)',
            '马格里布 (Maghribi)',
            '蒙特塞拉特 (Montserrat)',
            '澳门 (Macau)',
            '瑙鲁 (Nauru)',
            '尼泊尔 (Nepal)',
            '北马里亚纳群岛 (Northern Marianas Islands)',
            '外蒙古 (Outer Mongolia)',
            '巴勒斯坦 (Palestine)',
            '皮特凯恩群岛 (Pitcairn Islands)',
            '帕劳 (Palau)',
            '圣卢西亚 (St. Lucia)',
            '圣文森特 (St. Vincent)',
            '塞舌尔 (Seychelles)',
            '所罗门群岛 (Solomon Islands)',
            '萨摩亚 (Samoa)',
            '圣多美和普林西比 (Sao Tome & Principe)',
            '西萨摩亚 (Western Samoa)',
            '斯瓦波 (Swapo)',
            '圣赫勒拿 (St. Helena)',
            '圣马力诺 (San Marino)',
            '斯瓦尔巴群岛和扬马延岛 (Svalbard and Jan Mayen Islands)',
            '图瓦卢 (Tuvalu)',
            '塔吉克斯坦 (Tajikistan)',
            '土库曼斯坦 (Turkmenistan)',
            '上伏尔塔 (Upper Volta)',
            '乌兹别克斯坦 (Uzbekistan)',
            '瓦努阿图 (Vanuatu)',
            '梵蒂冈城 (Vatican City)',
            '英属维尔京群岛 (Virgin Islands (British))',
            '西萨摩亚 (Western Samoa)',
            '南斯拉夫 (Yugoslavia)',
        ]),
        '98' => implode(',', [
            '无国籍人士第1/1954条款 (Stateless Person Article 1/1954)',
            '无国籍 (Stateless)',
        ]),
        '99' => implode(',', [
            '麦加 (Mecca)',
            '信息不可用 (Information Not Available)',
            '中立区 (Neutral Zone)',
            '1951年难民条约 (Refugee Article 1/1951)',
            '难民 (Refugee)',
            '联合国专门机构 (UN Specialized Agency)',
            '联合国组织 (United Nations Organization)',
            '未指明国籍 (Unspecified Nationality)',
        ]),
    ]
];
