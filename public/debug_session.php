<!DOCTYPE html>
<html>

<head>
    <title>Session Debug</title>
</head>

<body>
    <h2>Session & Auth Debug</h2>
    <?php
    session_start();
    echo "<p><strong>Session ID:</strong> " . session_id() . "</p>";
    echo "<p><strong>Session Data:</strong></p>";
    echo "<pre>" . print_r($_SESSION, true) . "</pre>";
    ?>
</body>

</html>