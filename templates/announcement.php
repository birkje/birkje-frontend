<?php
    /**
     * Template: announcement
     * Authors: Birkje Team
     * Description: This template is used for accouncement pages.
     * 
     * ==== REQUIRED DATA ATTRIBUTES ====
     * - title;         The title of the page. " - Birkje" will be put behind the title.
     * - description;   The description of the page. Used for meta generation.
     * 
     * ==== OPTIONAL DATA ATTRIBUTES ====
     * - meta;          Additional meta tags to be included by the Meta Batch definition.
     * - head;          Additional head assets to be included by the Assets Batch function definition. (eg. styles)
     * - body;          Additional body assets to be included by the Assets Batch function definition. (eg. scripts)
     */

    use Library\Meta;
    use Library\Assets;

    $meta = new Meta;
    $meta->set('robots', 'index, nofollow');
    $meta->set('title', $data['title'] . ' - Birkje');
    $meta->set('description', $data['description']);
    if (isset($data['meta'])) $meta->batch($data['meta']);

    $assets = new Assets;
    $assets->registerHead('style', 'https://fonts.gstatic.com', array("rel" => "preconnect"));
    $assets->registerHead('style', 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    $assets->registerHead('style', 'css/template-announcement.css', array("origin" => "module:birkje-frontend"));

    if (isset($data['head'])) $assets->registerBatch('head', $data['head']);
    if (isset($data['body'])) $assets->registerBatch('body', $data['body']);
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <?php 
            echo $meta->generate(); 
            echo $assets->generateHead();
        ?>
    </head>
    <body>
        <div class="announcement-container">
            <div class="announcement">
                <?php echo $content; ?>
            </div>
        </div>
        
        <?php
            echo $assets->generateBody();
        ?>
    </body>
</html>