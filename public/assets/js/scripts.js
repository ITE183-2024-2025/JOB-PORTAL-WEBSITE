// Change mode
function darkmode(doWhat) {
    if (doWhat) {
        document.documentElement.style.setProperty('--white', 'rgb(8, 3, 18)');
        document.documentElement.style.setProperty('--grey-white', 'rgb(2, 1, 7)');
        document.documentElement.style.setProperty('--lightgrey', 'rgb(4, 5, 13)');
        document.documentElement.style.setProperty('--trcol', 'rgb(3, 2, 9)');
        document.documentElement.style.setProperty('--trhover', 'rgb(3, 4, 21)');
        document.documentElement.style.setProperty('--boxs', 'rgba(93, 43, 221, 0.1)');
    } else {
        document.documentElement.style.setProperty('--white', 'white');
        document.documentElement.style.setProperty('--grey-white', 'rgb(255, 255, 255)');
        document.documentElement.style.setProperty('--lightgrey', 'lightgrey');
        document.documentElement.style.setProperty('--trcol', 'rgb(236, 235, 235)');
        document.documentElement.style.setProperty('--boxs', 'rgba(0, 0, 0, 0.1)');
        document.documentElement.style.setProperty('--trhover', 'rgb(225, 225, 225)');
    }
}

// Slide functionality
var show = 0;
var show2 = 0;
var show3 = 0;
var items = document.querySelectorAll('.slide');
var items2 = document.querySelectorAll('.slide2');
var items3 = document.querySelectorAll('.slide3');

const slide = () => {
    if (show < items.length) {
        items[show].style.animation = "slide-in2 1s ease-out";
        items.forEach(item => item.style.display = "none");
        items[show].style.display = "block";
        show++;
    } else {
        show = 0;
    }
};

const slide2 = () => {
    if (show2 < items2.length) {
        items2[show2].style.animation = "slide-in 1s ease-in";
        items2.forEach(item => item.style.display = "none");
        items2[show2].style.display = "flex";
        show2++;
    } else {
        show2 = 0;
    }
};

const slide3 = () => {
    if (show3 < items3.length) {
        items3[show3].style.animation = "slide-in 1s ease-in";
        items3.forEach(item => item.style.display = "none");
        items3[show3].style.display = "flex";
        show3++;
    } else {
        show3 = 0;
    }
};

setInterval(() => {
    slide();
    slide2();
    slide3();
}, 2000);

// Menu profile
const show_pro = (doWhat) => {
    if (doWhat == "show") {
        document.querySelector(".menu2").style.display = "block";
        document.querySelector(".menu2").style.animation = "slide-in 1s ease-out";
    } else {
        document.querySelector(".menu2").style.animation = "slide-in2 1s ease-out";
        document.querySelector(".menu2").style.display = "none";
    }
};

// Menu one
function short_menu(doWhat) {
    if (doWhat == "show") {
        document.getElementById("short_menu").style.display = "block";
        document.getElementById("short_menu").style.animation = "slide-in 1s ease-out";
        document.getElementById("short_menu_btn").style.display = "none";
    } else {
        document.getElementById("short_menu").style.display = "none";
        document.getElementById("short_menu_btn").style.display = "inline-block";
    }
}

// Small screen menu toggle
function show_menu(doWhat) {
    if (doWhat == "show") {
        document.getElementById("show").style.display = "none";
        document.getElementById("hide").style.display = "block";
        var all = document.querySelectorAll('.big');
        all.forEach(element => element.style.display = "inline-block");
        document.querySelector('.side-bar').style.minWidth = "270px";
        document.querySelector('.side-bar').style.animation = "slide-in 1s ease-out";
        document.querySelector('.side-bar').style.maxWidth = "270px";
        document.querySelector('.profile').style.padding = "7px";
        document.querySelector('.head').style.padding = "12px";
        document.querySelector('.tr-small').style.marginTop = "0px";
        document.querySelector('.top-float.tr-small').style.float = "right";
        document.querySelector('.top-float.tr-small').style.width = "fit-content";
        document.querySelector('.head').style.boxShadow = "2px 0px 10px 2px var(--boxs)";
        var all3 = document.querySelectorAll('.menu');
        all3.forEach(item => item.style.boxShadow = "2px 0px 10px 2px var(--boxs)");

        var all2 = document.querySelectorAll('.menu .link');
        all2.forEach(items => items.style.fontSize = "16px");
        all2.forEach(items => items.style.margin = "0px auto");
    } else {
        document.querySelector('.side-bar').style.animation = "slide-in 1s ease-out";
        var all2 = document.querySelectorAll('.menu .link');
        all2.forEach(items => items.style.fontSize = "20px");
        var all3 = document.querySelectorAll('.menu');
        all3.forEach(item => item.style.boxShadow = "none");
        document.querySelector('.head').style.boxShadow = "none";

        document.querySelector('.top-float.tr-small').style.float = "none";
        document.querySelector('.top-float.tr-small').style.width = "100%";

        var all1 = document.querySelectorAll('.tr-small');
        all1.forEach(items => items.style.marginTop = "10px");

        document.querySelector('.profile').style.padding = "0px";
        document.querySelector('.head').style.padding = "5px";
        document.getElementById("show").style.display = "block";
        document.getElementById("hide").style.display = "none";
        var all = document.querySelectorAll('.big');
        all.forEach(element => element.style.display = "none");
        document.querySelector('.side-bar').style.minWidth = "70px";
        document.querySelector('.side-bar').style.maxWidth = "70px";
    }
}
