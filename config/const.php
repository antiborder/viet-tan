<?php

    return [
        'TIME_LIMIT' => 8,
        'SYNONYM_MAX' => 10,
        'ANTONYM_MAX' => 10,
        'MAX_LEVEL' => 14,
        'TAG_WORD_GUEST'=>100,
        'TAG_WORD_TRIAL'=>100,
        'KANJI_WORD_GUEST'=>100,
        'KANJI_WORD_TRIAL'=>100,
        'SAME_SYLLABLE_GUEST'=>100,
        'SAME_SYLLABLE_TRIAL'=>100,        
        'GUEST_LEVEL'=>100,
        'TRIAL_LEVEL'=>100,

        'CATEGORIES'=>[
            // 'LIST' => [
            //     'TIME',
            //     'BUSINESS',
            //     'EVENT',
            //     'STUDY',
            //     'NATION',
            //     'WORLD',
            //     'LANGUAGE',
            //     'NATURE',
            //     'FASHION',
            //     'PHYSICAL',
            //     'HUMAN',
            //     'NUMBER',
            //     'EATING',
            //     'OTHER'
            // ],

            'TIME' =>[
                'NAME' => '時・暦',
                'TAGS' => ['時','時間帯','年月','日','曜日・週','今','未来','過去','今','過去','未来','はじめ・おわり','季節'],
                'IMAGES' => ['time1.svg'],
                'KEYWORDS' => [],
            ],
            'BUSINESS' =>[
                'NAME' => 'ビジネス・お金',                
                'TAGS' => ['オフィス','会社','建物','店','商売','材質','金銭','買い物','つくる','建てる','渡す・送る','管理職','就職','施設','教育・教える','依頼','経理','農業'],
                'IMAGES' => ['business1.svg'],
                'KEYWORDS' => [],
            ],
            'EVENT' =>[
                'NAME' => '出来事・イベント',                
                'TAGS' => ['気候','災害','事件','犯罪','祝い・祭り','温度','季節'],
                'IMAGES' => ['event1.svg'],
                'KEYWORDS' => [],
            ],
            'STUDY' =>[
                'NAME' => '学問・芸術',                
                'TAGS' => ['家電','色','学校','可能性','IT','音楽','学ぶ','ネットワーク','スマホ','映画・劇','芸術','認める','表現する・説明する','調べる','拒否','宇宙','学問','教師','試験','教育・教える','間違う','考える・おもう','文学','知る・記憶','科学','電力'],
                'IMAGES' => ['study1.svg'],
                'KEYWORDS' => [],
            ],
            'NATION' =>[
                'NAME' => '国家・政治',                
                'TAGS' => ['国家','国名','戦','軍','裁判','法律','歴史','治安','約束・契約','議会・選挙','政府'],
                'IMAGES' => ['nation1.svg'],
                'KEYWORDS' => [],
            ],
            'WORLD' =>[
                'NAME' => '世界',                
                'TAGS' => ['世界','ベトナムの地名','地形','交通','位置','宗教','街','運転','土地・不動産','荷物','渡す・送る','旅行','飛行機・空港','国名','施設','移動手段','自動車','方角'],
                'IMAGES' => ['world1.svg'],
                'KEYWORDS' => [],
            ],
            'LANGUAGE' =>[
                'NAME' => '言語',                
                'TAGS' => ['疑問詞','文末詞','接続詞','接続副詞','南部方言','人称代名詞','代名詞','言う','変える・直す','文書','語学','言語','嘘・本当','あいづち','会話','逆接','原因・理由','記号','編集','もの・こと','文学','文法','順接'],
                'IMAGES' => ['language1.svg'],
                'KEYWORDS' => [],
            ],
            'NATURE' =>[
                'NAME' => '生物・自然',                
                'TAGS' => ['地形','十二支','植物','水の生物','虫','動物','宇宙','鳥','農業'],
                'IMAGES' => ['nature1.svg'],
                'KEYWORDS' => [],
            ],
            'FASHION' =>[
                'NAME' => 'ファッション・交際',                
                'TAGS' => ['色','恋愛','持つ・着る','衣服','美容','おしゃれ','嫌い・怒る','好き','外見','靴','外見'],
                'IMAGES' => ['fashion1.svg'],
                'KEYWORDS' => [],
            ],
            'PHYSICAL' =>[
                'NAME' => "人体・健康",                
                'TAGS' => ['家事','生活','洗う・掃除','睡眠','家具','家電','傷病','健康','運動','病院','渡す・送る','競技','味覚','人生','壊れる・腐る'],
                'IMAGES' => ["physical1.svg"],
                'KEYWORDS' => [],
            ],            
            'HUMAN' =>[
                'NAME' => '人間・心理',                
                'TAGS' => ['身体','性格','個性','家族','人称代名詞','意思・やりたい','親戚','グループ・仲間','こども','手・腕','認める','顔・頭','優しい・親しみやすい','慎重・臆病','楽しい・嬉しい','悲しい・辛い','恐れる・心配する','信じる','嫌い・怒る','教育・教える','知る・記憶'],
                'IMAGES' => ['human1.svg'],
                'KEYWORDS' => [],
            ],            
            'NUMBER' =>[
                'NAME' => '数・量',                
                'TAGS' => ['類似','大きさ','程度','類別詞','数字','数量','単位','異なる','はやい・おそい','数学','全部・各々'],
                'IMAGES' => ['number1.svg'],
                'KEYWORDS' => [],
            ],
            'EATING' =>[
                'NAME' => '飲食',                
                'TAGS' => ['飲食','調理法','食器','食べ物','飲み物','野菜','果物','調理器具','調味料','原料','菓子','壊れる・腐る'],
                'IMAGES' => ['eating1.svg'],
                'KEYWORDS' => [],
            ],
            'OTHER' =>[
                'NAME' => 'その他',                
                'TAGS' => ['感情','感覚','頻度','見る','一緒','必要・重要','進む・続ける','かんたん・難しい','状況','伝える'],
                'IMAGES' => ['other1.svg'],
                'KEYWORDS' => ['other1.svg'],
            ],            
            
        ],
    ];