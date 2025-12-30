var page = require('webpage').create();
page.open("4.html", function(status) {
  console.log("Status: " + status);
  if (status === "success") {
    page.render('test.pdf');
  }
  phantom.exit();
});