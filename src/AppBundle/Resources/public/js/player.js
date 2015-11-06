var tag = document.createElement('script');
tag.src = "https://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;

function onYouTubePlayerAPIReady() {
    player = new YT.Player('ytplayer', {
        height: '390',
        width: '640',
        playerVars: { 'autoplay': 1, 'controls': 1,'autohide':1,'wmode':'opaque' },
        videoId: videoId,
        events: {
            'onStateChange': function (state) {
                if(state.data == 0) {
                    window.location.href = nextVideoUrl;
                }
            }
        }
    });
}