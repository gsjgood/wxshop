<?php
return[ 
	//应用ID,您的APPID。
	'app_id' => "2016092500595663",

	//商户私钥，您的原始格式RSA私钥
	'merchant_private_key' => "MIIEowIBAAKCAQEAqfucOQ+LXHS82iCGp7tY5sDpJ4xlXQ7rkj8qtrlX0xQbpSa7mG9spoyLHO4xeKD+O9rUk51mvqi8iOW1VttylXUvdowBDSIuxveuhRlUuO9XAmQ4evYue+s0rCltmhfIr6hOZr6Sz+nPrT4eXeQDDR+JYeRZ+k4lyj3qZRJsByxz5CoDCd48LIvqY3ZAaGALuMecWR7cqoNnfoqJghj60ZfnJz2K0VY+HLup5ZXr8KUJVYec9e6nGh/vC+yBlZ5A8zDHeIXFQaVfOqTaoAGJqx4ZHT2V0eEkwf1qkMebQ7tRfamBapoNGWs3fpJ/Qxw91mdJVKWnjn67f9AUth/rUwIDAQABAoIBAQCS+2NJn9xUlQjb4HYvQXuNBNBXBzp67jTan84ydC+x8Fg7RTO/itG7bhm4aWrTsPpFDWL1RYybXlKwWVilg1ogTFU/P66FCcLC/1aj9pRg2Ww2QCzqfkcRlf9Uwvnn3ZsF8RXiF/Xg3H9cgTNG4quUxGlKAWegXcSljUZKIVTSGcAmdkN960PHqmSaLdZbmoSd4ZwhKp5LeHlbu4X40tXbBiuY1yLEqbgyj/VJZ8VFmikaWOX8Z47aeM+Rd0bGTFGitDlM8vrSfVuwDFO3T6mQ3im3QL+EKBqkQT4tRMk76cxUrBswj18ihie8kKHjQXsaA3OAB/dFnnSUnNTDZ88xAoGBANdkMH6wNEd2C4pJckKoTy3NNNJhHIXEsRGvzRv17m4qiWL+OKagrCuOnlq9/R8t7+7jiMKKKnZgiwCFiaIpdkyK6ER0nLSxDU+e4uTUpiGsi7NE6FTQkQd7wcpXVS7ePdO2uh45oFr+8e41lyN6J7vkqp7cLanFLlX5XwRlakEZAoGBAMoHyk9KtlJRzCVDfQi+Z23xsGMl2n0kZN5sd7c+asQ+vUfMQRabGkFWMS/MHjcpxXeFURLyU1V+DoO2fSUsi5eWRGH/Eik8sLwK57tQHU9MsYwv+Dxl0troHdzmj43j6ByAHzbmLDdCtHkN0czkx+/MNBLZTrNMwoUyX9ZCo8FLAoGACcwX3JtdNWbsLXUbymZne5ja7zrVlkwVFc3eUYhFOSOcLjGMGCA01KJfF5eOvO1U/ZPB879fIRVRHUv1r7edFuw2lm6Ldjibd2Stw2TczalQjW3z92+pOSLq9K42RLR9MXUdUCSk4563GHO9lTKIPiavkBxJw3AhpG18YfHO/HkCgYBDPVyED2Wm+DptnIycwGJEIVCHby3MwLQhoxAlGM0IC6mLn9t53p1aaYltUw4rZeem4+Qb3jMGHTJPfAkiujSrewO/adltiBl6PFbr7LoUjn35Hm4MDAele+OUhdf5bYTvF2VMLEdDDRxrvcG549r3YItkSpb67e0/z4g+E2fVCQKBgGofIrT5RlZwzVT0gCkHEo5blq/vcHXeO/FyZshdkgNtGbo8bbMonFwr2CMi6o2Nbcy5A8WRkV/f7NJH2eI9TNpMd32tjRmcl4DcYnIy/OcWa3BreIq4s1Cwzkw1XQOmrViB+uxxGNSt3gA6quBibDFrp5G5Tdxq1r86VyXz9xHK",
	
	//异步通知地址
	'notify_url' => "http://wxshop.com/alipay/notify",
	
	//同步跳转
	'return_url' => "http://wxshop.com/alipay/return",

	//编码格式
	'charset' => "UTF-8",

	//签名方式
	'sign_type'=>"RSA2",

	//支付宝网关
	'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

	//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
	'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqfucOQ+LXHS82iCGp7tY5sDpJ4xlXQ7rkj8qtrlX0xQbpSa7mG9spoyLHO4xeKD+O9rUk51mvqi8iOW1VttylXUvdowBDSIuxveuhRlUuO9XAmQ4evYue+s0rCltmhfIr6hOZr6Sz+nPrT4eXeQDDR+JYeRZ+k4lyj3qZRJsByxz5CoDCd48LIvqY3ZAaGALuMecWR7cqoNnfoqJghj60ZfnJz2K0VY+HLup5ZXr8KUJVYec9e6nGh/vC+yBlZ5A8zDHeIXFQaVfOqTaoAGJqx4ZHT2V0eEkwf1qkMebQ7tRfamBapoNGWs3fpJ/Qxw91mdJVKWnjn67f9AUth/rUwIDAQAB",
	
	//标识沙箱环境
	"mode"=>'dev'
];