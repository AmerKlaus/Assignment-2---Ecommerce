<!-- publications.php -->
<html>

<head>
    <title>All Publications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</head>

<body>
    <h1>All Publications</h1>

    <div>
        <?php foreach ($publications as $publication): ?>
            <div>
                <?php if (isset ($publication['publication_title'], $publication['publication_text'], $publication['timestamp'])): ?>
                    <h2>
                        <?php echo $publication['publication_title']; ?>
                    </h2>
                    <p>
                        <?php echo $publication['publication_text']; ?>
                    </p>
                    <p>
                        <?php echo $publication['timestamp']; ?>
                    </p>

                    <p>
                        <a href="/Publications/edit/<?php echo $publication['publication_id']; ?>">Edit</a>
                        <a href="/Publications/delete/<?php echo $publication['publication_id']; ?>">Delete</a>
                    </p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="/Publications/create">POST</a>
</body>

</html>