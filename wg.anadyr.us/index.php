<?php
ini_set('display_errors', true);
function getPrivateKey(): string {
    return trim(exec("/usr/bin/sudo /usr/bin/wg genkey"));
}
function getPublicKey(string $privateKey): string {
    $descriptorspec = array(
        0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
        1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
        2 => array("file", "/tmp/error-output.txt", "a") // stderr is a file to write to
    );

    $process = proc_open('/usr/bin/sudo /usr/bin/wg pubkey', $descriptorspec, $pipes);

    if (is_resource($process)) {
        fwrite($pipes[0], $privateKey);
        fclose($pipes[0]);

        $res = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        proc_close($process);

        return trim($res);
    } else throw new Exception("Could not create child process");
}



if (isset($_POST["ip"])) {
    $private = getPrivateKey();
    $public = getPublicKey($private);
    $res = exec("/usr/bin/sudo /usr/bin/wg set wg0 peer $public allowed-ips 10.1{$_POST['ip']}/32");
    $res = exec("/usr/bin/sudo /usr/bin/wg-quick down wg0");
    $res = exec("/usr/bin/sudo /usr/bin/wg-quick up wg0");
    ?>
<pre>[Interface]
PrivateKey = <?=$private?>

Address = 10.1<?=$_POST["ip"]?>/16

[Peer]
PublicKey = aFRj3n7mVPl9POcNNIJSjN2JcRHp5ixqlcBizzTELGk
AllowedIPs = 10.1.0.1/16
Endpoint = anadyr.us:51820
</pre>
    <?php die();
}
$clients = [];
exec("/usr/bin/sudo /usr/bin/wg show wg0 allowed-ips", $clients);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wireguard Autoconfig</title>
</head>
<body>
    <form method="POST">
        <label for="ip">10.1</label>
        <input id="ip" type="text" name="ip" value=".0." required />
        <input type="submit" value="Create client">
    </form>
<table>
    <thead>
    <tr>
        <th>Key</th>
        <th>Address</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($clients as $client) {
        $arr = explode("\t", $client);
        echo "<tr><td>{$arr[0]}</td><td>{$arr[1]}</td></tr>";
    } ?>
    </tbody>
</table>
</body>
</html>
