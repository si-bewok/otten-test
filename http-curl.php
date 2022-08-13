<?php 

$url = 'https://gist.githubusercontent.com/nubors/eecf5b8dc838d4e6cc9de9f7b5db236f/raw/d34e1823906d3ab36ccc2e687fcafedf3eacfac9/jne-awb.html';
$file = fopen('data.html', 'w');

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_FILE, $file);
curl_exec($curl);
curl_close($curl);
fclose($file);

$DOM = new DOMDocument();
$DOM->loadHTMLFile('data.html', LIBXML_NOERROR);

$head = $DOM->getElementsByTagName('thead');
$body = $DOM->getElementsByTagName('tbody');

foreach ($head as $a) {
    $header = $a->getElementsByTagName('td');
    foreach ($header as $b) {
        $headerName[] = trim($b->textContent);
    }
}

foreach ($body as $a) {
    $body = $a->getElementsByTagName('td');

    foreach ($body as $b) {
        $bodyName[] = trim($b->textContent);
    }
}

for ($i = 9; $i < count($bodyName); $i++) {
    $history[] = $bodyName[$i];
}

for ($i = 0; $i < count($history); $i++) {
    if ($i % 2 == 0) {
        $time[] = $history[$i];
    } else {
        $desc[] = $history[$i];
    }
}

$histories = [];
for ($i = 0; $i < count($time); $i++) {
    $histories[] = [
        'description' => $desc[$i],
        'createdAt' => $time[$i],
        'formatted' => [
            'createdAt' => $time[$i]
        ]
    ];
}

$response = [
    'status' => [
        'code' => '060101',
        'message' => 'Delivery tracking detail fetched successfully.'
    ], 
    'data' => [
        'receivedBy' => $bodyName[6],
        'histories' => array_values($histories)
    ]
];

print_r(json_encode($response));


