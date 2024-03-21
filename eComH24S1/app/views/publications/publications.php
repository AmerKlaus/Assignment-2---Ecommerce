<!DOCTYPE html>
<html>

<head>
    <title>All Publications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="../css/styles.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h1>All Publications</h1>

        <!-- Search Form -->
        <form action="/Publications/index" method="GET">
            <input type="text" name="q" placeholder="Search publications">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <!-- Display Search Results -->
        <?php foreach ($publications as $publication): ?>
            <div>
                <?php if (isset ($publication['publication_title'])): ?>
                    <h2><a href="/Publications/content/<?php echo $publication['publication_id']; ?>">
                            <?php echo $publication['publication_title']; ?>
                        </a></h2>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>

        <a href="/Publications/create" class="btn btn-primary">POST</a>
    </div>
</body>

</html>