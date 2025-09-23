document.addEventListener("DOMContentLoaded", () => {
    const audio = document.getElementById("radioPlayer");
    const playBtn = document.getElementById("playBtn");
    const playIcon = document.getElementById("playIcon");

    let isPlaying = false;

    playBtn.addEventListener("click", () => {
        if (!isPlaying) {
            audio.play()
                .then(() => {
                    isPlaying = true;
                    playIcon.classList.remove("fa-play");
                    playIcon.classList.add("fa-pause");
                })
                .catch(err => console.log("Error al reproducir:", err));
        } else {
            audio.pause();
            isPlaying = false;
            playIcon.classList.remove("fa-pause");
            playIcon.classList.add("fa-play");
        }
    });
});