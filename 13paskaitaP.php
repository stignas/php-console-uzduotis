<?php
const DATA_FILE = './files/vehicles_database.json';

function main(): void
{
    echo '[C]reate, [R]ead, [U]pdate, [D]elete, E[x]it' . PHP_EOL;
    $actionInput = readline('Choose action: ');

    switch (strtolower($actionInput)) {
        case 'c':
            create();
            break;
        case 'r':
            read();
            break;
        case 'u':
            update();
            break;
        case 'd':
            delete();
            break;
        case 'x':
            exit();
        default:
            echo 'No action chosen.';
    }
}

function create(): void
{
    $dataArray = json_decode(file_get_contents(DATA_FILE), true);
    $newVehicle = [];
    echo 'Add new vehicle' . PHP_EOL;
    foreach ($dataArray[0] as $key => $value) {
        $input = readline("Vehicle $key: ");
        $newVehicle[$key] = $input;
    }
    $dataArray[] = $newVehicle;
    file_put_contents(DATA_FILE, json_encode($dataArray, JSON_PRETTY_PRINT));
    main();
}

function read(): void
{
    $dataArray = json_decode(file_get_contents(DATA_FILE), true);
    foreach ($dataArray as $i => $vehicle) {
        echo "id: " . $i + 1 . PHP_EOL;
        foreach ($vehicle as $key => $value) {
            echo $key . ': ' . $value . PHP_EOL;
        }
        echo '--------------' . PHP_EOL;
    }
    main();
}

function update(): void
{
    $dataArray = json_decode(file_get_contents(DATA_FILE), true);
    $size = count($dataArray);
    $input = readline("Enter Id (1-$size): ");
    if ($input > $size) {
        echo "Vehicle $input does not exist!";
    } else {
        echo "id: $input" . PHP_EOL;
        foreach ($dataArray[$input - 1] as $key => $value) {
            echo $key . ': ' . $value . PHP_EOL;
        }
    }
    main();
}

function delete(): void
{
    $dataArray = json_decode(file_get_contents(DATA_FILE), true);
    $size = count($dataArray);
    $input = readline("Enter Id (1-$size) of vehicle to delete: ");
    if ($input > $size) {
        echo "Vehicle $input does not exist!";
    } else {
        unset($dataArray[$input - 1]);
    }
    file_put_contents(DATA_FILE, json_encode(array_values($dataArray), JSON_PRETTY_PRINT));
    main();
}

main();

