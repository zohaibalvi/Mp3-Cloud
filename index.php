<!DOCTYPE html>
<html>
<head>
    <title>MP3 APP</title>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script type="text/javascript" src="https://api.html5media.info/1.1.8/html5media.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/style.css" />

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container">
    <a class="btn btn-danger" href="login.php"> Login</a>

    <div class="column center">
        <h1>MP3 Player</h1>
    </div>
    <div class="column add-bottom">
        <div id="mainwrap">
            <div id="nowPlay">
                <span class="left" id="npAction">Paused...</span>
                <span class="right" id="npTitle"></span>
            </div>
            <div id="audiowrap">
                <div id="audio0">
                    <audio preload id="audio1" controls="controls">Play your favorite music</audio>
                </div>
                <div id="tracks">
                    <a id="btnPrev">&laquo;</a>
                    <a id="btnNext">&raquo;</a>
                </div>
            </div>
            <div id="plwrap">
                <ul id="plList"></ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<!-- https://codepen.io/craigstroman/pen/aOyRYx -->
<?php
// include('./global_constant.php');
// include('aws/s3.php');

include('./db/connection.php');

// exit;
$arr_list = array();
$count = 1;
  $sql = "SELECT * FROM upload_songs WHERE  is_active=0 ";
  $result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
 
 $arr_list[] = array(
            'track' => $count++,
            'name' => $row['song_title'],
            'length' => '5:01',
            'file' => $row['file_name'],

            ); 

  }
} else {
  echo "<b>No Songs uploaded yet!</b>";
}

// use MP3File;
// filesize("https://ia802900.us.archive.org/16/items/mythium/AC_ATI.mp3");exit;


// $result = '';
// listOfAllObjects();
// print_r($result);exit;
 // foreach ($songs  as $row) {
//     echo S3_URL.$object['Key'] . PHP_EOL;
//     $mp3file = new MP3File(S3_URL.$object['Key'] . PHP_EOL);
// // $duration1 = $mp3file->getDurationEstimate();//(faster) for CBR only
// $duration2 = $mp3file->getDuration();//(slower) for VBR (or CBR)
// // echo "duration: $duration1 seconds"."\n";
// echo "estimate: $duration2 seconds"."\n";
// echo MP3File::formatTime($duration2)."\n";


        // $arr_list[] = array(
        //     'track' => $count++,
        //     'name' => $row['song_title'],
        //     'length' => 'duration2',
        //     'file' => $row['file_name'],

        //     ); 
            // echo S3_URL.$object['Key'] . PHP_EOL;

    // }

    $mediaPath = "https://zohaib.s3.amazonaws.com/";

?>


<script type="text/javascript">
  // html5media enables <video> and <audio> tags in all major browsers
// External File: https://api.html5media.info/1.1.8/html5media.min.js


// Add user agent as an attribute on the <html> tag...
// Inspiration: https://css-tricks.com/ie-10-specific-styles/
var b = document.documentElement;
b.setAttribute('data-useragent', navigator.userAgent);
b.setAttribute('data-platform', navigator.platform);


// HTML5 audio player + playlist controls...
// Inspiration: http://jonhall.info/how_to/create_a_playlist_for_html5_audio
// Mythium Archive: https://archive.org/details/mythium/
jQuery(function ($) {
    var arr_list = <?php echo json_encode($arr_list) ?>; 
    var media_path = <?php echo json_encode($mediaPath)  ?>;
    // console.log(media_path );
    var supportsAudio = !!document.createElement('audio').canPlayType;
    if (supportsAudio) {
        var index = 0,
            playing = false,
            mediaPath = media_path,
            extension = '',
            tracks = arr_list,
         

            buildPlaylist = $.each(tracks, function(key, value) {
                var trackNumber = value.track,
                    trackName = value.name,
                    trackLength = value.length;
                if (trackNumber.toString().length === 1) {
                    trackNumber = '0' + trackNumber;
                } else {
                    trackNumber = '' + trackNumber;
                }
                $('#plList').append('<li><div class="plItem"><div class="plNum">' + trackNumber + '.</div><div class="plTitle">' + trackName + '</div><div class="plLength">' + trackLength + '</div></div></li>');
            }),
            trackCount = tracks.length,
            npAction = $('#npAction'),
            npTitle = $('#npTitle'),
            audio = $('#audio1').bind('play', function () {
                playing = true;
                npAction.text('Now Playing...');
            }).bind('pause', function () {
                playing = false;
                npAction.text('Paused...');
            }).bind('ended', function () {
                npAction.text('Paused...');
                if ((index + 1) < trackCount) {
                    index++;
                    loadTrack(index);
                    audio.play();
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }).get(0),
            btnPrev = $('#btnPrev').click(function () {
                if ((index - 1) > -1) {
                    index--;
                    loadTrack(index);
                    if (playing) {
                        audio.play();
                    }
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }),
            btnNext = $('#btnNext').click(function () {
                if ((index + 1) < trackCount) {
                    index++;
                    loadTrack(index);
                    if (playing) {
                        audio.play();
                    }
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }),
            li = $('#plList li').click(function () {
                var id = parseInt($(this).index());
                if (id !== index) {
                    playTrack(id);
                }
            }),
            loadTrack = function (id) {
                $('.plSel').removeClass('plSel');
                $('#plList li:eq(' + id + ')').addClass('plSel');
                npTitle.text(tracks[id].name);
                index = id;
                audio.src = mediaPath + tracks[id].file + extension;
                    console.log(tracks[id].file);
            },
            playTrack = function (id) {
                loadTrack(id);
                audio.play();
            };
        
        extension = audio.canPlayType('audio/mpeg') ? '.mp3' : audio.canPlayType('audio/ogg') ? '.ogg' : '';
        loadTrack(index);
    }
});
</script>
