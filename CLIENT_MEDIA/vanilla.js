document.addEventListener('DOMContentLoaded', () => {
    
    const playButton = document.getElementById("playButton");
    const nameInput = document.querySelector('[name="name"]');
    const levelSelect = document.querySelector('[name="level"]');
    const errorMessage = document.getElementById("error-message");

    function validateForm() {
        const nameValid = nameInput.value.trim() !== "";
        const levelValid = levelSelect.value !== "";

        if (nameValid && levelValid) {
            playButton.disabled = false;
            errorMessage.classList.add("hide");
        }else{
            playButton.disabled = true;

            if (nameInput.value.trim() !== "") {
                errorMessage.classList.remove("hide");
            }
        }
    }

    nameInput.addEventListener('input', validateForm);
    levelSelect.addEventListener("change", validateForm);
    validateForm();
});

function play() {
    const nameInput = document.querySelector('[name="name"]');
    const levelSelect = document.querySelector('[name="level"]');
    const errorMessage = document.getElementById("error-message");

    const name = nameInput.value.trim();
    const level = levelSelect.value;

    if (name && level) {
        document.querySelector(".container").classList.add("hide");
        document.querySelector(".game").classList.remove("hide");
        showCountDown(() => {
            startGame(name,level);
        })
    }else{
        errorMessage.classList.remove("hide");
    }

}

function showCountDown(callback) {
    const countdownOverlay = document.getElementById("countdown");
    const countdownNumber = document.getElementById("countdown-number");

    let counter = 3;

    countdownNumber.textContent = counter;
    countdownOverlay.classList.remove("hide");

    const interval = setInterval(() => {
        counter--;
        if (counter > 0) {
            countdownNumber.textContent = counter;
        }else{
            clearInterval(interval);
            countdownOverlay.classList.add("hide");
            if (typeof callback === "function") {
                callback(); // Ini yang menjalankan startGame()
            }
        }
    }, 1000)
}

function startGame(name, level) {
    console.log(`Game dimulai! Player: ${name}, Level: ${level}`);
    document.querySelector(".game").classList.remove("hide");

    document.getElementById("player-name").textContent = name;

    const heartsElement = document.getElementById("hearts");
    heartsElement.textContent = "❤️❤️❤️";

    document.getElementById("score-wall").textContent = "0";
    document.getElementById("score-wall-crack").textContent = "0";
    document.getElementById("score-ice").textContent = "0";

}



function showInstruction() {
  document.querySelector(".intructionBoard").classList.remove("hide");
}
