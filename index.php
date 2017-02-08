<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?php echo $Site->title() ?>
    </title>

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo HTML_PATH_THEME_IMG.'favicon.ico' ?>">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo HTML_PATH_THEME_CSS.'normalize.css' ?>" \>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo HTML_PATH_THEME_CSS.'seht.css' ?>" \>

    <!-- script src="http://code.responsivevoice.org/responsivevoice.js">
    </script -->

    <script src="<?php echo HTML_PATH_THEME_JS.'responsivevoice.src.js' ?>">
    </script>

    <script type="text/javascript">

            function startSpeech() {
                var text = [];
                text = document.getElementsByTagName("inhalt");
                lies = text[0].textContent;
                responsiveVoice.speak(lies, "Deutsch Female",{
                    onstart: function(){
                        document.getElementById('speechIcon').src = document.getElementById('speechIcon').src.replace('sprich.svg', 'schweig.svg');
                    },
                    onend: function(){
                        document.getElementById('speechIcon').src = document.getElementById('speechIcon').src.replace('schweig.svg', 'sprich.svg');
                    }
                });
                
            }
        
            function stopSpeech() {
                responsiveVoice.cancel();
            }
            
            function toggleSpeech() {
                if ( !(responsiveVoice.isPlaying()) ) {
                    startSpeech();
                } else {
                    document.getElementById('speechIcon').src = document.getElementById('speechIcon').src.replace('schweig.svg', 'sprich.svg');
                    stopSpeech();
                }
            }


            function toggleFont() {
                var LISTE = document.getElementsByTagName("inhalt")[0].getElementsByTagName("*");
                // text = document.getElementsByTagName("inhalt")[0];
                tTpath=document.getElementById('fontIcon').src;
                if ( tTpath.endsWith("img/tT.svg") ) {
                    document.getElementById('fontIcon').src = tTpath.replace('tT.svg', 'Tt.svg');
                    originalSize = document.getElementsByTagName("html")[0].style.fontSize;
                    document.getElementsByTagName("html")[0].style.fontSize = "1.76rem";
                } else {
                    document.getElementById('fontIcon').src = tTpath.replace('Tt.svg', 'tT.svg');
                    document.getElementsByTagName("html")[0].style.fontSize = originalSize;
                }
            }

    </script>

</head>

<body>


<!-- top bar -->
    <div class="maxWidth">
        <div class="sehtrand" style="margin-top: 1rem;">
            <div style="float: right; padding: 0 0.6rem 0 0; " onclick="toggleSpeech()">
                <img id="speechIcon" src="<?php echo HTML_PATH_THEME.'img/sprich.svg' ?>" style="height: 3rem;" alt="speech icon" aria-hidden="true">
            </div>
            <div style="float: right; padding: 0 0.6rem 0 0;" onclick="toggleFont()">
                <img id="fontIcon" src="<?php echo HTML_PATH_THEME.'img/tT.svg' ?>" style="height: 3rem;" alt="font icon">
            </div>
            <div style="float: left; padding: 0 0.6rem 1.5rem 0.6rem;">
                    <a href="<?php echo HTML_PATH_ROOT; ?>" style="text-decoration: none;">
                        <img src="<?php echo HTML_PATH_THEME.'img/LOGO.svg' ?>" style="width: auto; height: 3rem;" alt="Logo SeHT Münster e.V.">
                    </a>
            </div>
        </div> 
    </div>
<!-- top bar -->

<?php 
    if($Url->whereAmI()=='post') {
        $Page=$Post;
    }
?>


<!-- navigation -->
    <div class="maxWidth">
        <div class="sehtrand"> 
            <?php
                $parents = $pagesParents[NO_PARENT_CHAR];
                foreach($parents as $Parent) {
                    if ( substr( $Parent->description(), 0, 3 ) == 'fa-' ) {
                        $icon = 'fa '.$Parent->description();
                    } else {
                        $icon = '';
                    }
                    if ( $Parent->title() == $Page->title() ) {
                        $button='sehtButton blau';
                    } else {
                        $button='sehtButton';
                    }
                    if ( substr( $Parent->description(),0,4 ) != 'hide' ) {
                        echo '<div style="float: left; margin: 0 0rem 0 0;">
                            <a class="'.$button.'" href="'.$Parent->permalink().'">
                                <i class="'.$icon.'" aria-hidden="true">
                                </i>
                                '.$Parent->title().'
                            </a>
                        </div>';
                    }
                }
            ?>
        </div> 
    </div>
<!-- navigation end -->
    
    
<!-- image // banner -->
    <?php
        if($Page->coverImage()) {
            $imgsrc=$Page->coverImage();
        } else {
            $imgsrc=HTML_PATH_THEME.'img/banner.png';
        }
        echo '
            <div class="maxWidth">
                <div class="sehtrand">
                    <div class="desktop" style="background-color: grey; clear: left">
                        <img class="desktop" src="'.$imgsrc.'" alt="Cover Image" style="max-height: 25rem; display: block; margin: 0 auto;" aria-hidden="true">
                    </div>
                </div>
            </div>';
    ?>
<!-- image // banner end -->


    
    
<!-- sub navigation -->
    <div class="maxWidth">
        <div class="sehtrand"> 
            <div class="blau" style="overflow: auto; clear: left">
                <?php
                    if( $Url->whereAmI()=='page' && $Page->description() != 'hide' ) {
                        // check if page has childs or is child
                        if ( array_key_exists( $Page->key() , $pagesParents ) || $Page->parentKey() ) {
                            // get children if Parent or siblings if child
                            if ($Page->parentKey()) {
                                $ParentKey = $Page->parentKey();
                                $children = $pagesParents[$Page->parentKey()];
                            } else {
                                $ParentKey = $Page->key();
                                $children = $pagesParents[$Page->key()];
                            }
                            foreach( $children as $Child ) {
                                if ( substr( $Child->description(), 0, 3 ) == 'fa-' ) {
                                    $icon = 'fa '.$Child->description();
                                } else {
                                    $icon = '';
                                }
                                if ( $Child->title() == $Page->title() ) {
                                    $button='sehtButton grau';
                                } else {
                                    $button='sehtButton blau';
                                }
                                if ( substr( $Child->description(),0,4 ) != 'hide' ) {
                                    echo '
                                        <div style="float: left; margin: 0 0rem 0 0;">
                                            <a class="'.$button.'" href="'.$Child->permalink().'">
                                                <i class="fa '.$icon.'" aria-hidden="true">
                                                </i>
                                                '.$Child->title().'
                                            </a>
                                        </div>';
                                }
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
<!-- sub navigation end -->


<!-- content -->
    <div class="maxWidth" style="clear: both;">
        <div class="sehtrand"> 


                <div class="sehtLinks">
                    <inhalt>
                        <?php echo $Page->content(); ?>
                    </inhalt>
                </div>
                <div class="sehtRechts">
                    <p style="margin-left: 1rem;">
                        <hr>
                        <em>SeHT Münster e.V.</em><br>
                        - Alte Dechanei -<br>
                        Dechaneistr. 14<br>
                        48145 Münster
                        <hr>
                        <i class="fa fa-mobile" aria-hidden="true"></i> 0251/136920<br>
                        <a href="mailto: info@seht-muenster.de" style="text-decoration: none;" target="_blank"><i class="fa fa-envelope-o" aria-hidden="true"></i> info@seht-muenster.de</a>
                        <hr>
                    </p>
                </div>

        </div> <!-- margins -->
    </div>
<!-- content end -->

<!-- footer -->
    <div class="footer">
        <div class="maxWidth">
            <div class="sehtrand"> 
                <div class="blau sehtHeight" style="overflow: auto; clear: left;">
                    <div class="sehtrand"> 
                        <a href="<?php echo $Site->url() ?>kontakt/impressum" style="text-decoration: none;"><b style="color: white;">Impressum</b></a>  <span style="color: rgb(188,188,188)">SeHT Münster e.V. <i class="fa fa-copyright" aria-hidden="true"></i>  2017</span>
                        <a href="<?php echo $Site->url() ?>admin" class="desktop" style="float: right;">
                            <i class="fa fa-key"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- footer end -->

</body>
</html>
