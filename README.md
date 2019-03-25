# hello-sequence
基于snowflake算法的发号器

- 安装依赖
`pecl install apcu && pecl install swoole && composer install`

- 启动服务
`php start.php`

- 获取id

`
$redis = new Predis\Client([
    'scheme' => 'tcp',
    'host' => '0.0.0.0',
    'port' => 9999,
]);
`

`
$id = $redis->executeRaw(['sequence']);
`
