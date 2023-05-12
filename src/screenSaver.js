// initialize screensaver variables
let idleTime = null;

// initialize screensaver
document.getElementById("screenSaver").style.display = "none";

// set idle time for 2 and a half minutes
const startIdleTime = () => {
    idleTime = setTimeout(() => {
        // show styles for screen saver
        document.getElementById("screenSaver").style.display = "block";
    }, 600000);
}

// clear idle time
const clearIdleTime = () => {
    clearTimeout(idleTime);
    document.getElementById("screenSaver").style.display = "none";
    // starts idle time again after idle time is cleared
    startIdleTime();
}

// starts idle time for screensaver
startIdleTime();

// event handlers for screensaver
window.addEventListener('mousemove', clearIdleTime);
window.addEventListener('keypress', clearIdleTime);
window.addEventListener('click', clearIdleTime);