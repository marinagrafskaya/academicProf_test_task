let inputuserssearch = document.querySelector('.input-users-search');
let tabledata1 = document.querySelectorAll('.table-data-search-name')
let tabledata2 = document.querySelectorAll('.table-data-search-time')
let tabledata3 = document.querySelectorAll('.table-data-search-question')
let tabledata4 = document.querySelectorAll('.table-data-search-e-score')
let nameFilter = document.getElementById('nameFilter');
let timeFilter = document.getElementById('timeFilter');
let questionCountFilter = document.getElementById('questionCountFilter');
let minScoreFilter = document.getElementById('minScoreFilter');
let table_update = document.querySelector('.table_update');

inputuserssearch.oninput = function () {
  let val = this.value.trim().toLowerCase();
  if (nameFilter.checked == true) {
    filter(tabledata1, val)
  }
  if (timeFilter.checked) {
    filter(tabledata2, val)
  }
  if (questionCountFilter.checked) {
    filter(tabledata3, val)
  }
  if (minScoreFilter.checked) {
    filter(tabledata4, val)
  }
}

function filter(tabledata, val) {
  if (val != '') {
    tabledata.forEach(function (elem) {
      if (elem.innerText.toLowerCase().search(val) == -1) {
        elem.parentElement.classList.add('none');
      } else {
        elem.parentElement.classList.remove('none');
      }
    });
  } else {
    tabledata.forEach(function (elem) {
      elem.parentElement.classList.remove('none');
    });
  }
}

nameFilter.oninput = function () {
  timeFilter.checked = false;
  questionCountFilter.checked = false;
  minScoreFilter.checked = false;
  if ((nameFilter.checked == false) && (timeFilter.checked == false) && (questionCountFilter.checked == false) && (minScoreFilter.checked == false)) {
    nameFilter.checked = true;
}
}
timeFilter.oninput  = function () {
  nameFilter.checked = false;
  questionCountFilter.checked = false;
  minScoreFilter.checked = false;
  if ((timeFilter.checked == false) && (questionCountFilter.checked == false) && (minScoreFilter.checked == false)) {
    nameFilter.checked = true;
  }
}
questionCountFilter.oninput  = function () {
  nameFilter.checked = false;
  timeFilter.checked = false;
  minScoreFilter.checked = false;
  if ((timeFilter.checked == false) && (questionCountFilter.checked == false) && (minScoreFilter.checked == false)) {
    nameFilter.checked = true;
  }
}
minScoreFilter.oninput  = function () {
  nameFilter.checked = false;
  timeFilter.checked = false;
  questionCountFilter.checked = false;
  if ((timeFilter.checked == false) && (questionCountFilter.checked == false) && (minScoreFilter.checked == false)) {
    nameFilter.checked = true;
  }
}

document.addEventListener("DOMContentLoaded", function () {
  nameFilter.checked = true;
  timeFilter.checked = false;
  questionCountFilter.checked = false;
  minScoreFilter.checked = false;
});

table_update.onclick = function() {
  window.location.reload();
}