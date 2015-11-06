function invokePlayerHandler(command) {
    switch(command) {
        case 'pause':
            player.pauseVideo();
            break;

        case 'play':
            player.playVideo();
            break;

        case 'mute':
            if(player.isMuted()) {
                player.unMute();
            } else {
                player.mute();
            }
            break;

        case 'next':
            break;

        case 'previous':
            break;

        default:
            break;
    }
}