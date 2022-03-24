<?php
return array(
	"siteUrl"=>"http://127.0.0.1:8090/",
	"database"=>[
			"type"=>"mysql",
			"dbName"=>"store",
			"serverName"=>"127.0.0.1",
			"port"=>3306,
			"user"=>"root",
			"password"=>"",
			"options"=>[],
			"cache"=>false
			],
	"sessionName"=>"s623c6a49d8f3a",
	"namespaces"=>[],
	"templateEngine"=>"Ubiquity\\views\\engine\\Twig",
	"templateEngineOptions"=>[
			"cache"=>false
			],
	"test"=>false,
	"debug"=>true,
	"logger"=>function (){return new \Ubiquity\log\libraries\UMonolog("eval",\Monolog\Logger::INFO);},
	"di"=>[
			"@exec"=>[
					"jquery"=>function ($controller){
						return \Ajax\php\ubiquity\JsUtils::diSemantic($controller);
					}
					]
			],
	"cache"=>[
			"directory"=>"cache/",
			"system"=>"Ubiquity\\cache\\system\\ArrayCache",
			"params"=>[]
			],
	"mvcNS"=>[
			"models"=>"models",
			"controllers"=>"controllers",
			"rest"=>""
			],
	"onError"=>function ($code, $message = NULL, $controllerInstance = NULL){
				switch ($code) {
					case 404:
					case 500:
						throw new \Exception($message);
						break;
				}
			}
	);