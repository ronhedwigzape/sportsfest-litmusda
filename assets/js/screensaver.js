// initialize screensaver variables
let idleTime = null;
let forced = false;

// initialize screensaver
const screensaver = document.getElementById("screensaver");
screensaver.style.display = "none";

// set idle time for 2 and a half minutes
const startIdleTime = () => {
    idleTime = setTimeout(() => {
        // show styles for screen saver
        screensaver.style.display = "block";
    }, 150000);
}

// clear idle time
const clearIdleTime = () => {
    clearTimeout(idleTime);
    screensaver.style.display = "none";
    // starts idle time again after idle time is cleared
    startIdleTime();
}

// force screensaver
const forceScreensaver = () => {
    screensaver.style.display = "block";
    forced = true;
    setTimeout(() => {
        forced = false;
    }, 2400);
}

// starts idle time for screensaver
startIdleTime();

// event handlers for screensaver
window.addEventListener('mousemove', function() {
    if(!forced)
        clearIdleTime();
});
window.addEventListener('keypress', function() {
    if(!forced)
        clearIdleTime();
});