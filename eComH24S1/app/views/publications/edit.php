<!-- edit.php -->
<html>

<head>
    <title>Edit Publication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="../css/styles.css" rel="stylesheet" type="text/css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</head>

<body>

<div class="publication-container">
    <h1 class="publication-title">Edit Publication</h1>
    <form action="/Publications/update/<?php echo $publication_id; ?>" method="POST">
        <label>Title:</label>
        <input type="text" name="title" id="title" value="<?php echo $publication->publication_title; ?>"
            required><br><br>

        <label>Content:</label><br>
        <textarea name="content" id="content" rows="5"
            required><?php echo $publication->publication_text; ?></textarea><br><br>

        <label>Status:</label><br>
        <input type="radio" name="status" value="public"> Public
        <input type="radio" name="status" value="private"> Private<br><br>

        <input type="submit" value="Save Changes">
    </form>
</div>


</body>

</html>