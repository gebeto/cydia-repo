<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'methods/compression.php';
$status = '';

if (isset($_GET['packages'])) {
    switch ($_GET['packages']) {
        case 'update':
            gzCompressFile('repofiles/Packages');
            bzCompressFile('repofiles/Packages');
            $status = 'UPDATED';
            break;
        case 'delete':
            try {
                unlink('repofiles/Packages.gz');
                unlink('repofiles/Packages.bz2');
                $status = 'DELETED';
            } catch (Exception $e) {}
            break;
        case 'update_db':
            // gzCompressFile('repofiles/Packages');
            gzCompressTweaks('repofiles/Packages');
            bzCompressTweaks('repofiles/Packages');
            $status = 'UPDATED DB';
            break;
        
        default:
            break;
    }
}

?>



<!DOCTYPE html>
<html>
<head>
    <title>Repo actions</title>
</head>
<body>
    <form>
        <h1><?=$_SERVER['REQUEST_URI']?></h1>
        <h2><?=$status?></h2>
        <select name="packages">
            <option value="update">Update</option>
            <option value="delete">Delete</option>
            <option></option>
            <option value="update_db">Update DB</option>
        </select>
        <button type="submit">Submit</button>
    </form>
</body>
</html>