<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'firebase' => [
        'database_url' => env('FIREBASE_DATABASE_URL', ''),
        'project_id' => env('FIREBASE_PROJECT_ID', 'sira-75fcb'),
        'private_key_id' => env('FIREBASE_PRIVATE_KEY_ID', 'e7297f3b497aba170b74205d1a063dd968e25c9a'),
        // replacement needed to get a multiline private key from .env 
        'private_key' => str_replace("\\n", "\n", env('FIREBASE_PRIVATE_KEY', '-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCX0L3/F6crz08l\nFgVq1LyunxLqJC7Mia3EYgujVLD5ciuC5yVjguCAPcaU1TEqgSaSCR8YN9gD5M2L\nwXGE8cMhBvE9jh07PLbc0Gr/1HvuVUUGFwsKJaGmizh8bYt8IX7RSxjMWkqQNSzY\neQijof10i3mSk6aLuorqvpAnFMyPHQkkG8Vb16V/GzqaE/snGjeI0r9ftKDL/fHD\nb+pgxLJatdSPYfDHkzH/Yd4rRBCxMXrc4HH21uWO1SDiXMDigpOiWVKoeN/T2rw1\nSq7d6GCpSkl0/d82zIWS71chWE4jbG10cXJIWetgsFyZeZyS/9OFmpZgplQVxJEI\nGX5GK0apAgMBAAECggEABz1JL3a8HjQyuiTXLvV5u+VSXGpLoFhOZNIna5X4dySx\nG3sUnC6xBZyB3DYLCVOtowLJV055FWfIlMoC36E8ZKuf6bIIWyX1iF5t7nN+UhVX\nMcemhfODxl0sMo7HZddzudztZU1G8ffUgswevoLVLcS65Y5MlQGDv1bv/n/Dk21v\nCeh9IqoGBtsuf/HmRL2cWioUXz44LyK5Wz/Va4f3wxQzkQ62IZRQS3iaPqWpMmIg\nUYf/vF1tCvJAxAe6H+h6gH0Ag1jswSyYJUUvXWQs2L44sUSGv+kdsLBK2qe6GnDD\njSWCGQOZC5TUlc1RfU4bXROo8TUFzLz9vXUQJxsVKwKBgQDPWayOn9KpfYUeGfnm\nv+doC5cxdPgiyu7+uvs9rkZTqdzx+hxELNSJdi+LZcfsbX21WfW+8UXCgivqQq9l\n3LdYJyGus02AaJhyePk1UcootkQyTpV43UdRkkasB7rqNyvIoxxbY5LLnMO6a/Sz\nGquWWhltABg2GJcZ4aTRwtGCmwKBgQC7b2kGjjcyWnmd0jeGSBuUbss0P1x+OIXW\nPerdbzkIFqhdjuai+51QufHdh5r7ZgoUlolxjhRqDbAhq80gSq0tOxA9KnlqlCWv\n2sOH/8sU/d89isOLDZT2sOpY+GQxKZPGc4+4lGOQfm3a/TXk5mNyodRp5YjOQ4Fx\nwvw/tx2eCwKBgFP6fr/ZDSomMzbo0GTbjm5+W0Llm+YDiN5UfpMRtVwHLPw4DyCx\ng3cVDdaIZ3tjMQm1IKmv8FACBqU/UuiPhxZF6wdliVsbgbrDMjOdJ6Jrh51UZIdq\nH4tzEfp0uwhHRg1huodtAbRDjqY/OQEdKSeg4DFcW3H1baVG1Uk7fT1HAoGAA+AS\n0NLh60WZnBy7jygwgcoko2jn9agfhEV1dKyXBkbJpl2NATOolgGyMX1bQ/VhIfnW\nz6U7YNH1oUyXCiLhH71H4aveJMj5WoBwaIBuZ3m0QuZ6koZuXQddYQeJssaESqcb\nApr20Ab9KHjxw1DMH5Oe+62GPZWBuKNqabrUfu8CgYAB+CagqByLXqhbyFjy2875\nhuey/igT7WrAaeSpgd7ZZwIkuuBwzP/o9LGMgMasM96dEvfwDCWqybHTjgwdR7pU\n3ruh7ZNqRbNGowO8UN9qCMYAVwSOtqpzpfMB4DUfjTFl0Sd/d3K/Yps/eszuzjMw\nzXtFaDBiHbDrTk4alZaeoQ==\n-----END PRIVATE KEY-----\n')),
        'client_email' => env('FIREBASE_CLIENT_EMAIL', 'firebase-adminsdk-cydgo@sira-75fcb.iam.gserviceaccount.com'),
        'client_id' => env('FIREBASE_CLIENT_ID', '110622021626171834267'),
        'client_x509_cert_url' => env('FIREBASE_CLIENT_x509_CERT_URL', ''),
    ]

];
