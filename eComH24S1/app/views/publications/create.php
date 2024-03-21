<html>

<head>
    <title>Create Publication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="../css/styles.css" rel="stylesheet" type="text/css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script>
        function validateForm() {
            var status = document.querySelector('input[name="status"]:checked');
            if (!status) {
                alert('Please select a status.');
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>
</head>

<body>

<div class="publication-container">
    <h1 class="publication-title">Create New Publication</h1>
    <form action="/Publications/store" method="POST" onsubmit="return validateForm()">
        <label>Title:</label>
        <input type="text" name="title" required><br><br>

        <label>Content:</label><br>
        <textarea name="content" rows="5" required></textarea><br><br>

        <label>Status:</label><br>
        <input type="radio" name="status" value="public"> Public
        <input type="radio" name="status" value="private"> Private<br><br>

        <input type="submit" value="Submit">
    </form>
</div>

</html>