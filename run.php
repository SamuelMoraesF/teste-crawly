<?php

require_once __DIR__ . '/vendor/autoload.php';

use Project\RemoteServer;

$answer = (new RemoteServer('http://applicant-test.us-east-1.elasticbeanstalk.com'))
    ->getAnswer();

print "A resposta é: {$answer}\n";