<?php
require 'vendor/parsedown/Parsedown.php';
$Parsedown = new Parsedown();
$postParam = $_GET['post'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dev Blog</title>
    <style>
        :root { --bg: #f4f7f6; --card: #ffffff; --text: #2d3436; --primary: #0984e3; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: var(--bg); color: var(--text); line-height: 1.6; margin: 0; }
        .container { max-width: 800px; margin: 0 auto; padding: 40px 20px; }
        header { background: #2d3436; color: white; padding: 1rem 0; text-align: center; margin-bottom: 40px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        header a { color: white; text-decoration: none; font-weight: bold; font-size: 1.5rem; }
        
        /* Card Styling for Home */
        .post-card { background: var(--card); padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px; transition: transform 0.2s; }
        .post-card:hover { transform: translateY(-3px); }
        .post-card h2 { margin-top: 0; color: var(--primary); text-transform: capitalize; }
        .post-card .date { font-size: 0.85rem; color: #636e72; margin-bottom: 10px; display: block; }
        .btn { display: inline-block; background: var(--primary); color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-size: 0.9rem; }
        
        /* Article Styling */
        article { background: var(--card); padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        article h1 { border-bottom: 3px solid var(--primary); padding-bottom: 10px; }
        article img { max-width: 100%; border-radius: 5px; }
        pre { background: #2d3436; color: #fab1a0; padding: 15px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>

<header>
    <a href="index.php">MY_BLOG.exe</a>
</header>

<div class="container">
    <?php if ($postParam): ?>
        <article>
            <?php
            $path = "posts/" . basename($postParam) . ".md";
            if (file_exists($path)) {
                echo $Parsedown->text(file_get_contents($path));
            } else {
                echo "<h1>404: Post Not Found</h1><a href='index.php'>Go Home</a>";
            }
            ?>
        </article>
    <?php else: ?>
        <?php
        $files = glob("posts/*.md");
        // Sort files by last modified time (newest first)
        usort($files, function($a, $b) { return filemtime($b) - filemtime($a); });

        foreach ($files as $file):
            $slug = basename($file, ".md");
            $title = str_replace('-', ' ', $slug);
            $date = date("F d, Y", filemtime($file));
        ?>
            <div class="post-card">
                <span class="date"><?= $date ?></span>
                <h2><?= $title ?></h2>
                <p>Click below to read this entry...</p>
                <a href="?post=<?= $slug ?>" class="btn">Read Post</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>