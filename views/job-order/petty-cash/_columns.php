<?php

return [
    'id',
    [
        'attribute' => 'vendor_id',
        'value' => 'vendor.nama',
    ],
    [
        'attribute' => 'jenis_biaya_id',
        'value' => 'jenisBiaya.name',
    ],
    [
        'attribute' => 'mata_uang_id',
        'value' => 'mataUang.nama',
    ],
    [
        'attribute' => 'nominal',
        'format' => ['decimal', 2],
        'contentOptions' => ['class' => 'text-end'],
    ]
];