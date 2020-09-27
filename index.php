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
<div class="container" >
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
include('aws/s3.php');
// include('MP3File.php');
// use MP3File;
// filesize("https://ia802900.us.archive.org/16/items/mythium/AC_ATI.mp3");exit;


// exit;
$arr_list = array();
$count = 1;
$result = listOfAllObjects();
// print_r($result);exit;
//  foreach ($result  as $object) {
// //     echo S3_URL.$object['Key'] . PHP_EOL;
// //     $mp3file = new MP3File(S3_URL.$object['Key'] . PHP_EOL);
// // // $duration1 = $mp3file->getDurationEstimate();//(faster) for CBR only
// // $duration2 = $mp3file->getDuration();//(slower) for VBR (or CBR)
// // // echo "duration: $duration1 seconds"."\n";
// // echo "estimate: $duration2 seconds"."\n";
// // echo MP3File::formatTime($duration2)."\n";


//         $arr_list[] = array(
//             'track' => $count++,
//             'name' => "nam111e",
//             'length' => 'duration2',
//             'file' => $variable = substr($object['Key'], 0, strpos($object['Key'], "."))

//             ); 
//             // echo S3_URL.$object['Key'] . PHP_EOL;

//     }
    $mediaPath = "https://archive.org/download/mythium/";

// print_r($arr_list);
// LIST OF SONGS
$arr_list  = array ( 
  array (
    'track' => 1,
    'name' => 'All This Is - Joe L.\'s Studio',
    'length' => '2:30',
    'file' => 'pakistan',
  ),
  array (
    'track' => 2,
    'name' => 'The Forsaken - Broadwing Studio (Final Mix)',
    'length' => '8:31',
    'file' => 'BS_TF',
  ), 
  array (
    'track' => 3,
    'name' => 'All The King\'s Men - Broadwing Studio (Final Mix)',
    'length' => '5:02',
    'file' => 'BS_ATKM',
  ), 
  array (
    'track' => 4,
    'name' => 'The Forsaken - Broadwing Studio (First Mix)',
    'length' => '8:32',
    'file' => 'BSFM_TF',
  ), 
  array (
    'track' => 5,
    'name' => 'All The King\'s Men - Broadwing Studio (First Mix)',
    'length' => '5:05',
    'file' => 'BSFM_ATKM',
  ), 
  array (
    'track' => 6,
    'name' => 'All This Is - Alternate Cuts',
    'length' => '2:49',
    'file' => 'AC_ATI',
  ), 
  array (
    'track' => 7,
    'name' => 'All The King\'s Men (Take 1) - Alternate Cuts',
    'length' => '5:45',
    'file' => 'AC_ATKMTake_1',
  ), 
  array (
    'track' => 8,
    'name' => 'All The King\'s Men (Take 2) - Alternate Cuts',
    'length' => '5:27',
    'file' => 'AC_ATKMTake_2',
  ), 
  array (
    'track' => 9,
    'name' => 'Magus - Alternate Cuts',
    'length' => '5:46',
    'file' => 'AC_M',
  ), 
  array (
    'track' => 10,
    'name' => 'The State Of Wearing Address (fucked up) - Alternate Cuts',
    'length' => '5:25',
    'file' => 'AC_TSOWAfucked_up',
  ), 
  array (
    'track' => 11,
    'name' => 'Magus - Popeye\'s (New Years \'04 - \'05)',
    'length' => '5:54',
    'file' => 'PNY04-05_M',
  ), 
  array (
    'track' => 12,
    'name' => 'On The Waterfront - Popeye\'s (New Years \'04 - \'05)',
    'length' => '4:41',
    'file' => 'PNY04-05_OTW',
  ), 
  array (
    'track' => 13,
    'name' => 'Trance - Popeye\'s (New Years \'04 - \'05)',
    'length' => '13:17',
    'file' => 'PNY04-05_T',
  ), 
  array (
    'track' => 14,
    'name' => 'The Forsaken - Popeye\'s (New Years \'04 - \'05)',
    'length' => '8:13',
    'file' => 'PNY04-05_TF',
  ), 
  array (
    'track' => 15,
    'name' => 'The State Of Wearing Address - Popeye\'s (New Years \'04 - \'05)',
    'length' => '7:03',
    'file' => 'PNY04-05_TSOWA',
  ), 
  array (
    'track' => 16,
    'name' => 'Magus - Popeye\'s (Valentine\'s Day \'05)',
    'length' => '5:44',
    'file' => 'PVD_M',
  ), 
  array (
    'track' => 17,
    'name' => 'Trance - Popeye\'s (Valentine\'s Day \'05)',
    'length' => '10:47',
    'file' => 'PVD_T',
  ), 
  array (
    'track' => 18,
    'name' => 'The State Of Wearing Address - Popeye\'s (Valentine\'s Day \'05)',
    'length' => '5:37',
    'file' => 'PVD_TSOWA',
  ), 
  array (
    'track' => 19,
    'name' => 'All This Is - Smith St. Basement (01/08/04)',
    'length' => '2:49',
    'file' => 'SSB01_08_04_ATI',
  ), 
  array (
    'track' => 20,
    'name' => 'Magus - Smith St. Basement (01/08/04)',
    'length' => '5:46',
    'file' => 'SSB01_08_04_M',
  ), 
  array (
    'track' => 21,
    'name' => 'Beneath The Painted Eye - Smith St. Basement (06/06/03)',
    'length' => '13:08',
    'file' => 'SSB06_06_03_BTPE',
  ), 
  array (
    'track' => 22,
    'name' => 'Innocence - Smith St. Basement (06/06/03)',
    'length' => '5:16',
    'file' => 'SSB06_06_03_I',
  ), 
  array (
    'track' => 23,
    'name' => 'Magus - Smith St. Basement (06/06/03)',
    'length' => '5:47',
    'file' => 'SSB06_06_03_M',
  ), 
  array (
    'track' => 24,
    'name' => 'Madness Explored - Smith St. Basement (06/06/03)',
    'length' => '4:52',
    'file' => 'SSB06_06_03_ME',
  ), 
  array (
    'track' => 25,
    'name' => 'The Forsaken - Smith St. Basement (06/06/03)',
    'length' => '8:44',
    'file' => 'SSB06_06_03_TF',
  ), 
  array (
    'track' => 26,
    'name' => 'All This Is - Smith St. Basement (12/28/03)',
    'length' => '3:01',
    'file' => 'SSB12_28_03_ATI',
  ), 
  array (
    'track' => 27,
    'name' => 'Magus - Smith St. Basement (12/28/03)',
    'length' => '6:10',
    'file' => 'SSB12_28_03_M',
  ), 
  array (
    'track' => 28,
    'name' => 'Madness Explored - Smith St. Basement (12/28/03)',
    'length' => '5:06',
    'file' => 'SSB12_28_03_ME',
  ), 
  array (
    'track' => 29,
    'name' => 'Trance - Smith St. Basement (12/28/03)',
    'length' => '12:33',
    'file' => 'SSB12_28_03_T',
  ), 
  array (
    'track' => 30,
    'name' => 'The Forsaken - Smith St. Basement (12/28/03)',
    'length' => '8:57',
    'file' => 'SSB12_28_03_TF',
  ), 
  array (
    'track' => 31,
    'name' => 'All This Is (Take 1) - Smith St. Basement (Nov. \'03)',
    'length' => '4:55',
    'file' => 'SSB___11_03_ATITake_1',
  ), 
  array (
    'track' => 32,
    'name' => 'All This Is (Take 2) - Smith St. Basement (Nov. \'03)',
    'length' => '5:46',
    'file' => 'SSB___11_03_ATITake_2',
  ), 
  array (
    'track' => 33,
    'name' => 'Beneath The Painted Eye (Take 1) - Smith St. Basement (Nov. \'03)',
    'length' => '14:06',
    'file' => 'SSB___11_03_BTPETake_1',
  ), 
  array (
    'track' => 34,
    'name' => 'Beneath The Painted Eye (Take 2) - Smith St. Basement (Nov. \'03)',
    'length' => '13:26',
    'file' => 'SSB___11_03_BTPETake_2',
  ), 
  array (
    'track' => 35,
    'name' => 'The Forsaken (Take 1) - Smith St. Basement (Nov. \'03)',
    'length' => '8:38',
    'file' => 'SSB___11_03_TFTake_1',
  ), 
  array (
    'track' => 36,
    'name' => 'The Forsaken (Take 2) - Smith St. Basement (Nov. \'03)',
    'length' => '8:37',
    'file' => 'SSB___11_03_TFTake_2',
  ),
);

// print_r($arr_list);
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
