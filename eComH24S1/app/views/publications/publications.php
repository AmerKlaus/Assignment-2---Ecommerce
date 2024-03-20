<!-- Inside publications.php -->
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

   
<?php foreach ($publications as $publication): ?>
    <div>
        <?php if (isset($publication['publication_title'])): ?>
            <h2><a href="/Publications/content/<?php echo $publication['publication_id']; ?>">
                <?php echo $publication['publication_title']; ?>
            </a></h2>
            <?php if (isset($publication['publication_text'])): ?>
                <p><?php echo $publication['publication_text']; ?></p>
            <?php endif; ?>

            <!-- Add comment form -->
            <form action="/Publications/addComment/<?php echo $publication['publication_id']; ?>" method="post">
                <label for="comment_text">Add a Comment:</label><br>
                <textarea id="comment_text" name="comment_text"></textarea><br>
                <input type="submit" value="Submit">
            </form>

            <!-- Display comments associated with this publication -->
            <?php if (isset($comment)): // Check for $comment instead of $commentModel ?>
                <?php $comments = $comment->getCommentsByPublicationId($publication['publication_id']); ?>
                <?php if (!empty($comments)): ?>
                    <ul>
                        <?php foreach ($comments as $comment): ?>
                            <li><a href='/Comment/view/<?php echo $comment->publication_comment_id; ?>'>View Comment</a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No comments yet.</p>
                <?php endif; ?>
            <?php endif; ?>

        <?php endif; ?>
    </div>
<?php endforeach; ?>


    <a href="/Publications/create">POST</a>
</body>

</html>
