document.addEventListener('DOMContentLoaded', () => {
    const players = document.querySelectorAll('.audio-player');
    players.forEach(player => {
        const source = player.querySelector('audio');
        const button_play = player.querySelector('.play');
        const button_pause = player.querySelector('.pause');
        const progress = player.querySelector('.progress');

        button_play.addEventListener('click', function(event) {
            event.preventDefault();
            source.play();
            this.disabled = true;
            button_pause.disabled = false;
        });

        button_pause.addEventListener('click', function(event) {
            event.preventDefault();
            source.pause();
            this.disabled = true;
            button_play.disabled = false;
        });

        source.addEventListener('timeupdate', function() {
            progress.style.width = (this.currentTime / this.duration) * 100 + '%';
        });
    });
});