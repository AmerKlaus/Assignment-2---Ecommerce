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
                <?php if (isset($publication['publication_title'])): ?>
                    <h2><a href="/Publications/content/<?php echo $publication['publication_id']; ?>">
                            <?php echo $publication['publication_title']; ?>
                        </a></h2>
                    <?php
                    // Check if $commentModel is set before using it
                    if (isset($commentModel)) {
                        // Fetch and display comments associated with this publication
                        $comments = $commentModel->getCommentsByPublicationId($publication['publication_id']);
                        if (!empty($comments)) {
                            echo "<ul>";
                            foreach ($comments as $comment) {
                                echo "<li><a href='/Comment/view/{$comment->publication_comment_id}'>View Comment</a></li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "<p>No comments yet.</p>";
                        }
                    } else {
                        echo "<p>Comments feature not available.</p>";
                    }
                    ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="/Publications/create">POST</a>
</body>

</html>
