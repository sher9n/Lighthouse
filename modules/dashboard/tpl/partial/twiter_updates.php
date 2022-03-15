<?php
use Core\Utils;
if(isset($respose->data) && count($respose->data) > 0 ){
    $referenced_tweets = array();
    $ids = array();
    foreach ($respose->data as $index => $obj){
        if(isset($obj->referenced_tweets)) {
            $ref_id = $obj->referenced_tweets[0]->id;
            $referenced_tweets[$ref_id] = '';
            array_push($ids,$ref_id);
        }
    }

    $ids = implode(",",$ids);
    $idRespose = Utils::getTweetIdByIds($ids);
    if(isset($idRespose->data) && count($idRespose->data) > 0 ) {
        foreach ($idRespose->data as $index => $idObj){
            if(isset($referenced_tweets[$idObj->id]))
                $referenced_tweets[$idObj->id] = $idObj->text;
        }
    }

    foreach ($respose->data as $index => $obj){ ?>
        <div class="my-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="d-flex align-items-center w-70">
                            <div class="avator rounded-circle me-6">
                                <img src="<?php echo $c_logo; ?>" width="48" height="48" />
                            </div>
                            <div class="w-80">
                                <div class="fs-3 text-truncate"><?php echo $c_name; ?></div>
                                <div class="text-muted lh-1"><?php echo $type; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $text = '';
                if(isset($obj->referenced_tweets)) {
                    $text = $referenced_tweets[$obj->referenced_tweets[0]->id];
                    preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $text, $match);
                }
                else {
                    $text = $obj->text;
                    preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $text, $match);
                }

                $thum_view = false;
                if(count($match) > 0) {
                    $urls = $match[0];

                    if(count($urls) > 0 ){
                        $url = $urls[0];
                        $tags = get_meta_tags($url);

                        if(isset($tags['twitter:image']) && isset($tags['twitter:url'])) {
                            $image = $tags['twitter:image'];
                            $title = isset($tags['twitter:title'])?$tags['twitter:title']:'';
                            $des   = isset($tags['twitter:description'])?$tags['twitter:description']:$text;
                            $url   = $tags['twitter:url'];
                            $thum_view = true;
                            ?>
                            <div class="card-body border-top">
                                <div class="fs-5 "><?php echo $text; ?></div>
                                <div class="border rounded-3 p-12 mt-12 bg-light">
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo $image;?>" class="img-post img-fluid rounded-3 me-13" width="200" height="140" alt=""/>
                                        <div>
                                            <a class="text-muted text-decoration-none " href="<?php echo $url; ?>" target="_blank"><?php echo $url; ?></a>
                                            <div class="fs-4 mt-3"><?php echo $title; ?></div>
                                            <div class="text-muted mt-3"><?php echo $des; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
                if($thum_view != true) {
                ?>
                <div class="card-body border-top">
                    <div class="fs-5 "><?php echo nl2br($text); ?></div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php
    }
}
else{ ?>
    <div class="card shadow">
        <div class="card-body text-center">
            <img src="<?php echo app_cdn_path; ?>img/img-myactivity.png" class="img-fluid rounded mt-16" alt=""/>
            <div class="fs-1 fw-semibold mt-12">No contributions yet!</div>
            <div class="fs-5  mt-5 text-center">Post an article link or announcement <br>
                from a DAO to start contributing</div>
            <button type="button" class="btn btn-primary btn-lg px-25 text-uppercase mt-23 mb-18">Post Now</button>
        </div>
    </div>
<?php } ?>