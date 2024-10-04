<?php include_once("../config/config.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .error-code {
            font-size: 72px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container error-container text-center">
    <h1 class="error-code text-danger">Error</h1>
    <p class="lead">Something went wrong. We can't seem to find the page you're looking for.</p>
    <a href="<?php echo BASE_URL ?>" class="btn btn-primary">Go Back Home</a>
</div>

</body>
</html>
