document.addEventListener('DOMContentLoaded', () => {
    const players = document.querySelectorAll('.audio-player');
    
    players.forEach(player => {
        const source = player.querySelector('audio');
        const button_play = player.querySelector('.play');
        const button_pause = player.querySelector('.pause');
        const progress = player.querySelector('.progress');
        const timeline = player.querySelector('.timeline');

        const setProgressPosition = (percent) => {
            progress.style.width = percent + '%';
        };

        const calculatePercent = (actual, total) => {
            return (actual / total) * 100;
        };

        button_play.addEventListener('click', (event) => {
            event.preventDefault();
            source.play();
            button_play.disabled = true;
            button_pause.disabled = false;
        });

        button_pause.addEventListener('click', (event) => {
            event.preventDefault();
            source.pause();
            button_pause.disabled = true;
            button_play.disabled = false;
        });

        timeline.addEventListener('click', (event) => {
            const percent = calculatePercent(event.offsetX, timeline.offsetWidth);
            setProgressPosition(percent);
            source.currentTime = source.duration * (percent / 100);
        });

        source.addEventListener('timeupdate', () => {
            setProgressPosition(calculatePercent(source.currentTime, source.duration));
        });
    });
});