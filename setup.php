<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройка базы данных</title>
</head>
<body>
    <h3>Настройка...</h3>
    <?php
    require_once 'functions.php';

    createTable('members','id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50), doljnost VARCHAR(30), login VARCHAR(20), pass VARCHAR(255), dateReg TIMESTAMP, verify boolean not null default 0, INDEX(login(6))');

    createTable('rooms','id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(40), address VARCHAR(40), VCh VARCHAR(20), categor VARCHAR(10), plan VARCHAR(90), placeOfIntellegent VARCHAR(50), audioSystem BOOL, aboutRoom VARCHAR(500), INDEX(name(6))');

    createTable('controlpoints','id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, place VARCHAR(40), roomId INT UNSIGNED, integrIndexArticul VARCHAR(10), W VARCHAR(10), normW VARCHAR(10), sootvetW BOOL, sootvetQ BOOL, FOREIGN KEY (roomid) REFERENCES rooms(id)'); 
    
    createTable('onecontrolpoint','id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, cpid INT UNSIGNED, numOct INT UNSIGNED, shum VARCHAR(10), lvlSignal VARCHAR(10), signalShum VARCHAR(10), rez VARCHAR(10), otvet VARCHAR(10), sootvet BOOL, spectrIndexArticul VARCHAR(10), FOREIGN KEY (cpid) REFERENCES controlpoints(id)');

    createTable('szi','id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(40), price VARCHAR(20), type VARCHAR(40), img VARCHAR(20), INDEX(name(6))');
    
    createTable('roomszi','id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, roomid INT UNSIGNED, sziid INT UNSIGNED, FOREIGN KEY (roomid) REFERENCES rooms(id), FOREIGN KEY (sziid) REFERENCES szi(id)');

    createTable('addroom','id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, userid INT UNSIGNED, roomid INT UNSIGNED, date TIMESTAMP, FOREIGN KEY (roomid) REFERENCES rooms(id), FOREIGN KEY (userid) REFERENCES members(id)');

    ?>
    <br>...завершена.
</body>
</html>