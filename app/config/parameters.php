<?php
    $db = parse_url(getenv('DB_URL'));

    $container->setParameter('database_driver', 'pdo_mysql');
    $container->setParameter('database_host', $db['host']);
    $container->setParameter('database_port', $db['port']);
    $container->setParameter('database_name', getenv('DB_NAME'));
    $container->setParameter('database_user', getenv('DB_USERNAME'));
    $container->setParameter('database_password', getenv('DB_PASSWORD'));
    $container->setParameter('secret', getenv('SECRET'));
    $container->setParameter('locale', 'es');
    $container->setParameter('mailer_transport', smtp);
    $container->setParameter('mailer_host', localhost);
    $container->setParameter('mailer_user', sysga);
    $container->setParameter('mailer_password', sysga);
