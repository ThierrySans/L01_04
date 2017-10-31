var id = 0;

function addOneQ() {
  id += 1;
  var qsFields = document.getElementById("qsFields");
  var br = document.createElement("br");
  var textarea = document.createElement("textarea");
  var para = document.createElement("p");
  var node = document.createTextNode("Question" + id);
  textarea.type = "text";
  textarea.name = "Question" + id;
  textarea.id = "text" + id;
  textarea.rows = 5;
  textarea.cols = 100;
  para.id = "para" + id;
  para.appendChild(node);
  br.id = "br" + id;

  qsFields.appendChild(para);
  qsFields.appendChild(textarea);
  qsFields.appendChild(br);
}

function addFiveQ() {
  var qsFields = document.getElementById("qsFields");
  var br = document.createElement("br");
  var i;
  for (i = 1; i <= 5 ;i++) {
    addOneQ();
  }
}

function submit() {
  if (id === 0) {
    alert("Please add some questions");
  } else {
    var qsContents = document.getElementById("qsContents");
    var br = document.createElement("br");
    var i;
    for (i = 0; i < id; i++) {
      var q = document.getElementById("text" + (i + 1)).value;
      if (q === "") {
        alert("Please fill all questions");
        break;
      }
      var para = document.createElement("p");
      var node = document.createTextNode("Content for Question" + (i + 1) + " is: " + q);
      para.appendChild(node);

      qsContents.appendChild(para);
      qsContents.appendChild(br);
    }
  }
}

function deleteAllQ() {
  var i;
  for (i = 0; i < id; i++) {
    var qsFields = document.getElementById("para" + (i + 1));
    var textarea = document.getElementById("text" + (i + 1));
    var br = document.getElementById("br" + (i + 1));
    if (qsFields != null && textarea != null) {
      qsFields.outerHTML = "";
      textarea.outerHTML = "";
      br.outerHTML = "";
    }

    delete qsFields;
    delete textarea;
    delete br;
  }
  id = 0;
}
