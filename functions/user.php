<?php

function saveUser(array $user): array
{
    $handle = fopen(__DIR__ . '/../data/users.csv', 'a');

    $user['id'] = getNewID();

    fputcsv($handle, [
        $user['id'],
        $user['name'],
        $user['email'],
        password_hash($user['password'], PASSWORD_DEFAULT),
        $user['date'],
        $user['gender'],
        $user['phone'],
        $user['addressPost'],
        $user['addressLine1'],
        $user['addressLine2'],
        $user['salary'],
        implode('/', $user['like']),
    ]);

    fclose($handle);

    return $user;
}

function getUsers():array {

    $handle = fopen(__DIR__ . '/../data/users.csv', 'r');
    $users =[];

    while (!feof($handle)) { //read until the end of the file
        $row = fgetcsv($handle); //read one roll

        // 空行対策
        if ($row === false || is_null($row[0])) {
        break;
        };

        $user = [
            'id' => $row[0],
            'name' => $row[1],
            'email' => $row[2],
            'password' => $row[3],
            'date' => $row[4],
            'gender' => $row[5],
            'phone' => $row[6],
            'addressPost' => $row[7],
            'addressLine1' => $row[8],
            'addressLine2' => $row[9],
            'salary' => $row[10],
            'like' => explode('/', $row[11]),

        ];

        $users[] = $user;

    }

    fclose($handle);

    return $users;

}

function getNewID() :int
{
    $maxId = 0;
    $users = getUsers(); //use to get the value in {id} only

    foreach($users as $user) {
        $id = intval($user['id']);
        if(($id) > $maxId) {
            $maxId = $id;
        }
    }

    return $maxId + 1;
}

function login(string $email, string $password): ?array

{
    $users = getUsers();

    foreach($users as $user) {

        if ($user['email'] === $email && password_verify($password, $user['password'])) {
            return $user;
        }
    }

    return null;
}

function getUser(string|int $id): ?array //maybe cannot find the correct data

{

    $users = getUsers();

    foreach ($users as $user) {
        if (intval($user['id']) === intval($id)) {
            return $user;
        }
    }

    return null;
}

function getEmail(string $email): ?string

{
    $users = getUsers();

    $sameEmail = '';
    foreach($users as $user) {

        if ($user['email'] === $email) {
            $sameEmail= '入力したメールは登録済みです';
            return $sameEmail;
        }
    }

    return null;

}

function editUser(array $user): void
{
    $users = getUsers();

    $handle = fopen(__DIR__ . '/../data/users.csv', 'w');

    foreach ($users as $u) {
        if (intval($user['id']) === intval($u['id'])) {
            $u = [
                $user['id'],
                $user['name'],
                $user['email'],
                password_hash($user['password'], PASSWORD_DEFAULT),
                $user['date'],
                $user['gender'],
                $user['phone'],
                $user['addressPost'],
                $user['addressLine1'],
                $user['addressLine2'],
                $user['salary'],
                implode('/', $user['like']),

            ];
        }

        fputcsv($handle, $u);
    }
}
