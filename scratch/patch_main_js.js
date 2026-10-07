const fs = require('fs');
const filePath = 'public/assets/scripts/main.js';
let content = fs.readFileSync(filePath, 'utf8');

const target = 'var e=function(){document.body.clientWidth<1250?(0,r.A)(".app-container").addClass("closed-sidebar-mobile closed-sidebar"):(0,r.A)(".app-container").removeClass("closed-sidebar-mobile closed-sidebar")};';
const replacement = 'var e=function(){if(document.body.clientWidth<1250){(0,r.A)(".app-container").addClass("closed-sidebar-mobile closed-sidebar");}else{(0,r.A)(".app-container").removeClass("closed-sidebar-mobile");if(localStorage.getItem("sidebar_closed")==="true"){(0,r.A)(".app-container").addClass("closed-sidebar");}else{(0,r.A)(".app-container").removeClass("closed-sidebar");}}};';

if (content.includes(target)) {
    fs.writeFileSync(filePath, content.replace(target, replacement), 'utf8');
    console.log('SUCCESS: main.js patched successfully');
} else {
    console.log('Target string not found in main.js');
}
