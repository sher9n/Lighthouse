<main>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                foreach ($__page->coins as $c){ ?>
                    <pre>
                        <?php print_r($c); ?>
                    </pre>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</main>
<?php include_once app_root . '/templates/foot.php'; ?>
