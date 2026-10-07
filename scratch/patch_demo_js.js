const fs = require('fs');
const filePath = 'public/assets/scripts/demo.js';
let content = fs.readFileSync(filePath, 'utf8');

const target = 'r(".close-sidebar-btn").click(function(){var e=r(this).attr("data-class");r(".app-container").toggleClass(e);var t=r(this);t.hasClass("is-active")?t.removeClass("is-active"):t.addClass("is-active")})';
const replacement = 'r(".close-sidebar-btn").click(function(){var e=r(this).attr("data-class");r(".app-container").toggleClass(e);var t=r(this);t.hasClass("is-active")?t.removeClass("is-active"):t.addClass("is-active");try{localStorage.setItem("sidebar_closed",r(".app-container").hasClass("closed-sidebar")?"true":"false");}catch(err){}})';

if (content.includes(target)) {
    fs.writeFileSync(filePath, content.replace(target, replacement), 'utf8');
    console.log('SUCCESS: demo.js patched successfully');
} else {
    console.log('Target string not found in demo.js');
}
