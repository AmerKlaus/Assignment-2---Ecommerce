<!DOCTYPE html>
<html>

<head>
    <title>All Publications</title>
    <link href="../css/styles.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h1>All Publications</h1>

        <div class="publication-container">
            <?php if (!empty ($publications)): ?>
                <?php foreach ($publications as $publication): ?>
                    <div>
                        <?php if (isset ($publication['publication_title'])): ?>
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
                                <a class="btn btn-primary"
                                    href="/Publications/edit/<?php echo $publication['publication_id']; ?>">Edit</a>
                                <a class="btn btn-danger"
                                    href="/Publications/delete/<?php echo $publication['publication_id']; ?>">Delete</a>
                            </p>
                        <?php endif; ?>

                        <h2>Comments</h2>
                        <?php if (!empty ($comments)): ?>
                            <?php foreach ($comments as $comment): ?>
                                <div>
                                    <p>
                                        <?php echo $comment['comment_text']; ?>
                                    </p>
                                    <p>
                                        <?php echo $comment['timestamp']; ?>
                                    </p>
                                    <?php $profile = new \app\models\Profile();
                                    if ($comment['profile_id'] == $profile->getForUser($_SESSION['user_id'])): ?>
                                        <a href="/Publications/editComment/<?php echo $comment['publication_comment_id']; ?>">Edit</a>
                                        <a href="/Publications/deleteComment/<?php echo $comment['publication_comment_id']; ?>">Delete</a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <h2>Add Comment</h2>
                        <form action='/Publications/addComment/<?php echo $publication['publication_id']; ?>' method="POST">
                            <textarea name="comment_text" id="comment_text" rows="4" cols="50" required></textarea><br><br>
                            <input type="submit" value="Add Comment">
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No publications found.</p>
            <?php endif; ?>

        </div>

        <a href="/Publications/index">Back To Main</a>
    </div>
</body>

</html>