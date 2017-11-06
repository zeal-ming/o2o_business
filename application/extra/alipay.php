<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/10/31
 * Time: 上午8:49
 */

return [
    //应用对应APPID
    'app_id' => '2016090800466641',
    //公钥
    'alipay_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvv24iVyDjjitSlEBueqWtPhNit6w5wmxrrK6elVedjNES9Ht9mTCds/VC01u56FtYfX24lTWTP25zFnUueOng2AmzeEki6ueIt4ZnrtP7xPlvjTNA66NpodLlgSsZB7552R7EZhT3jY9rH1rGuVE43yRjoeAmCbQCPkQuYms7z09sz528Pl6BImtcOLzmitSKwF+T4HXuIYBUqizF2LNAP86Te1QWDdd/Tn77ziP3eEBLwFRDiS6bmoQG3BHC6vvRfzlcpYvhEbLYV5JB0wHnNQoEAOE8LTDT9/M2JLqUnWlVQZnjb8IfmZX598IaMTLiRwssA4g6/0cdYNrFhgjtwIDAQAB',
    //字符集
    'charset' => 'UTF-8',
    //加密成功
    'sign_type' => 'RSA2',
    //网关地址
    'gatewayUrl' => 'https://openapi.alipaydev.com/gateway.do',
    //私钥
    'merchant_private_key' => 'MIIEpAIBAAKCAQEAvv24iVyDjjitSlEBueqWtPhNit6w5wmxrrK6elVedjNES9Ht9mTCds/VC01u56FtYfX24lTWTP25zFnUueOng2AmzeEki6ueIt4ZnrtP7xPlvjTNA66NpodLlgSsZB7552R7EZhT3jY9rH1rGuVE43yRjoeAmCbQCPkQuYms7z09sz528Pl6BImtcOLzmitSKwF+T4HXuIYBUqizF2LNAP86Te1QWDdd/Tn77ziP3eEBLwFRDiS6bmoQG3BHC6vvRfzlcpYvhEbLYV5JB0wHnNQoEAOE8LTDT9/M2JLqUnWlVQZnjb8IfmZX598IaMTLiRwssA4g6/0cdYNrFhgjtwIDAQABAoIBAAinwucmtCeL1f6aMTPVt8K3xfvXH7k4rT63hs/ocoF0zVGKT/hslIuB26vJdI82t5hK50dWhOe0T+k84PETqhHAF8IYw+k4e9AktJCG+JZjFnRKPEhAbtbvJrPDvnRDGxwrZ5BikNpvJthcTrBHV5nfmVEWPvOmPqNJdkKSRK4Kyk1GbVXNt1abFHqUXtoIlTqSiuFRkVkUaU6pmYAoJ7IWIrxWfDMKISHJIhpWE2WJqClfP5Ww8kNs9Lw/Ezt94AKg538Xoz3PbK8I0D1T+65ZdcIZcRmInu+clO3c7l7P2qREe8ZgICJXCon755pIUzXw0qRmfjHZPkdZO0NDxLECgYEA9Qq/+SwhRuKzJaT8q8UZZ+i1uBTzfPN4QCibHc+DjGr6hBgG7uS5G+Y5r+9f9JlvuGu0bsCgLrzHMs17QetbPDZO8wCQtgSAFXmT06llNydPFvo3bFF1Fyn0AQk6GpaSIYppHadteyYYyYFXWSdUSSNUr3nsynBIhzI63SgmsWMCgYEAx4gxuZGNzQyZEOBXPtVKhdP8WXZWRSpEipimTp8hoqfKBzF8JEsgHj1r4NF1KQF20576DdYtfgsAdWv4KwDYPcrRGpzZUFhp6/8bX0nilwY6wdLOaAKR3L4C2ZAXdI+8xia/EtVCrr+i0FZ1noSBcoPFtwd8p04SAf2B6GRJXp0CgYEA2AnmPxS9MfXk5CeV7QsU3xu4Oted5GfzeP1T5PBzlnUq8RMN6ckVupc7/PUasFgmu32Z0ptZnlspdIzdQrzx7yAicvPoodFN66EIx+/tILczb5qjCoi2pvmB+vfbll1x8MhK7K4URCLOb7ns/NlD4keX/i2Mqt5b03Zhl2Iy2ukCgYBPQNJ3YdAQBRP7NxCQXYnXNEdEhZNor4w//Lf5/I0QnVLKnqYviEN+n2jtCGVf3zwCfF/YBR1Wtin9eeA9vH0nthpuVqSenC+eVFrb8230DL5j5Eal23dyVWquXeRjIQCbOCKm6VwuKuIRnHXle74q7RooQ+oITiMq9TWXR9Y4pQKBgQCZ5fiiyQdfKF/1JNEZGGl7ve2Hbyv7wiTTKT7jgElGVVPio43dtZvsekc5Y8enmct2DI7y03UtGM0kQlikKg5H1AqdUGMrhwcxWA76Dporctz83hia/yLO9RqUPZgO6RCCexpBJYtEOzrKIUijNl5rnJYwSnJEJ7O5XP5ps3lfsA==',
    //服务器回调地址
    'notify_url' => 'http://o2o.local/index/notify/index',
    //前端跳转地址
    'return_url' => 'http://o2o.local/index/order/finishPay'
];