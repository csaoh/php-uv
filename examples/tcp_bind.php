<?php
$tcp = uv_tcp_init();

uv_tcp_bind($tcp, uv_ip4_addr('0.0.0.0',9999));

uv_listen($tcp,100, function($server){
    $client = uv_tcp_init();
    uv_accept($server, $client);
    uv_read_start($client, function($buffer, $socket){
        var_dump($buffer);
        uv_close($socket);
    });
});

$c = uv_tcp_init();
uv_tcp_connect($c, uv_ip4_addr('0.0.0.0',9999), function($stat, $client){
    if ($stat == 0) {
        uv_write($client,"Hello",function($stat,$socket){
            uv_close($socket);
        });
    }
});

uv_run();
