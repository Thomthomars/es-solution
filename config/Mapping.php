<?php
/**
 * Created by PhpStorm.
 * User=> guivarch
 * Date=> 25/09/15
 * Time=> 15=>52
 */

/**
 * Created by guivarch on 26/08/15.
 */

$params = [
  "index" => 'elasticsearch_index_es_solution_content',
  "body" => [
  "mappings" => [
    "content" => [
      "properties"=> [
        "author"=> [
        "type"=> "integer"
        ],
        "changed"=> [
        "type"=> "date",
        "format"=> "date_time"
        ],
        "search_api_language" => [
        "type"=> "string",
        "index"=> "not_analyzed"
        ],
        "status"=> [
        "type"=> "integer"
        ],
        "title" => [
        "type"=> "string",
        "boost"=> 5.0
        ],
        "type"=> [
        "type"=> "string",
        "index"=> "not_analyzed"
        ],
        "url"=> [
        "type"=> "string",
        "index"=> "not_analyzed"
        ],
        "vid"=> [
        "type"=> "integer"
        ]
      ]
    ]
  ],
  "settings" =>[
    "number_of_shards" => 5,
    "number_of_replicas" => 1,
    "analysis"=> [
      "analyzer"=> [
        "french"=> [
        "tokenizer"=> "standard",
        "filter"=> ["french_elision","lowercase","french_stop","french_stemmer"]
        ],
        "Custom_analyzer"=>[
        "type"=> "custom",
        "tokenizer"=>"nGram",
        "filter"=>["french_stop","asciifolding", "lowercase", "snowball", "french_elision", "worddelimiter", "stopwords"]
        ],
        "Custom_search_analyzer"=>[
        "type"=>"custom",
        "tokenizer"=>"standard",
        "filter"=>["french_stop", "asciifolding", "lowercase", "snowball", "french_elision", "worddelimiter", "stopwords"]
        ]
      ],
      "filter"=> [
        "french_elision"=> [
        "type"=>"elision",
        "articles"=>["l", "m", "t", "qu", "n", "s","j", "d", "c", "jusqu", "quoiqu","lorsqu", "puisqu", " "],
        "ignore_case"=> true
        ],
        "french_stop"=> [
        "type"=>"stop",
        "stopwords"=>  "_french_",
        "ignore_case"=> true
        ],
        "french_stemmer"=> [
        "type"=>       "stemmer",
        "language"=>   "light_french"
        ],
        "snowball"=>[
        "type"=> "snowball",
        "language"=> "French"
        ],
        "stopwords"=>[
        "type"=> "elision",
        "stopword"=> "_french_",
        "ignore_case"=> true
        ],
        "worddelimiter"=>[
        "type"=> "word_delimiter"
        ]
      ]
    ]
  ]
]
];

