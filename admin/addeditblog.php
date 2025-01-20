<?php
// Add Blog Section
if (isset($_POST['add_blog'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $datetime = date('Y-m-d H:i:s');

    // Handle file upload for blog image
    $image = $_FILES['image']['name'];
    $target = "uploads/blogs/" . basename($image);

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'your_database');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO blogs (title, description, datetime, image, comments) VALUES ('$title', '$description', '$datetime', '$image', '[]')";

    if ($conn->query($sql) === TRUE) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            echo "Blog added successfully!";
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

// Edit Blog Section
if (isset($_POST['edit_blog'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Handle file upload for blog image
    $image = $_FILES['image']['name'];
    $target = "uploads/blogs/" . basename($image);

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'your_database');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (!empty($image)) {
        $sql = "UPDATE blogs SET title='$title', description='$description', image='$image' WHERE id=$id";
    } else {
        $sql = "UPDATE blogs SET title='$title', description='$description' WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
        if (!empty($image) && move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            echo "Blog updated successfully!";
        } else {
            echo "Blog updated successfully without changing the image.";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

// Add Comment Section
if (isset($_POST['add_comment'])) {
    $blog_id = $_POST['blog_id'];
    $comment = $_POST['comment'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'your_database');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve current comments
    $result = $conn->query("SELECT comments FROM blogs WHERE id=$blog_id");
    $row = $result->fetch_assoc();
    $comments = $row['comments'] ? json_decode($row['comments'], true) : [];

    // Add the new comment
    $comments[] = $comment;

    // Update the comments field in the database
    $comments_json = json_encode($comments);
    $sql = "UPDATE blogs SET comments='$comments_json' WHERE id=$blog_id";

    if ($conn->query($sql) === TRUE) {
        echo "Comment added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!-- Add/Edit Blog Form -->
<div class="blog-section">
    <h2>Add/Edit Blog</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo isset($blog) ? $blog['id'] : ''; ?>">

        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required value="<?php echo isset($blog) ? $blog['title'] : ''; ?>">

        <label for="description">Description:</label>
        <textarea name="description" id="description" required><?php echo isset($blog) ? $blog['description'] : ''; ?></textarea>

        <label for="image">Image:</label>
        <input type="file" name="image" id="image">

        <button type="submit" name="<?php echo isset($blog) ? 'edit_blog' : 'add_blog'; ?>">
            <?php echo isset($blog) ? 'Update Blog' : 'Add Blog'; ?>
        </button>
    </form>
</div>

<!-- Add Comment Form -->
<div class="comment-section">
    <h2>Add Comment</h2>
    <form method="POST">
        <input type="hidden" name="blog_id" value="<?php echo isset($blog) ? $blog['id'] : ''; ?>">

        <label for="comment">Comment:</label>
        <textarea name="comment" id="comment" required></textarea>

        <button type="submit" name="add_comment">Add Comment</button>
    </form>
</div>