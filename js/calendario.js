const MonthLabel = document.getElementById("monthName");
const PrevMonth = document.getElementById("changeMonthPrev");
const NextMonth = document.getElementById("changeMonthNext");
const CalendarContainer = document.getElementById("calendarContainer");
const today = new Date();
var currentMonth = today.getMonth();
var currentYear = today.getFullYear();
const daysInitials = ["L", "M", "M", "J", "V", "S", "D"];
const months = [
  "Enero",
  "Febrero",
  "Marzo",
  "Abril",
  "Mayo",
  "Junio",
  "Julio",
  "Agosto",
  "Septiembre",
  "Octubre",
  "Noviembre",
  "Diciembre",
];

var ventana = document.getElementById("eventsContainer");

var DATOS_VENCIMIENTOS = [];

function drawMonth(month, year) {
  daysInMonth = new Date(year, month + 1, 0).getDate();
  daysInPrevMonth = new Date(year, month, 0).getDate();
  firstDayIndex = new Date(year, month, 1).getDay();
  firstDayIndex = firstDayIndex == 0 ? 7 : firstDayIndex; // if sunday, set to 7
  monthName = months[month];

  /*
    if (year == today.getFullYear()) {
        MonthLabel.innerHTML = monthName;
    }
    else{
        MonthLabel.innerHTML = monthName+" "+year;
    }
    */
  MonthLabel.innerHTML = monthName + " " + year;
  CalendarContainer.innerHTML = "";

  //draw days of the week
  for (var i = 0; i < 7; i++) {
    var day = document.createElement("div");
    day.classList = ["calendar-day"];
    day.innerHTML = daysInitials[i];
    CalendarContainer.appendChild(day);
  }
  //draw days of prev month
  for (var i = 0; i < firstDayIndex - 1; i++) {
    var day = document.createElement("div");
    day.classList = ["calendar-number old"];
    day.innerHTML = daysInPrevMonth - firstDayIndex + i + 1;
    if (
      day.innerHTML == today.getDate() &&
      month == today.getMonth() + 1 &&
      year == today.getFullYear()
    ) {
      day.classList.add("calendar-number--current");
    }
    CalendarContainer.appendChild(day);
  }

  //draw days of current month
  for (var i = 1; i <= daysInMonth; i++) {
    var day = document.createElement("div");
    day.classList = ["calendar-number now"];
    //detect current day
    if (
      i == today.getDate() &&
      month == today.getMonth() &&
      year == today.getFullYear()
    ) {
      day.classList.add("calendar-number--current");
    }
    day.innerHTML = i;
    CalendarContainer.appendChild(day);
  }

  //draw days of next month
  for (var i = 0; i <= 42 - firstDayIndex - daysInMonth; i++) {
    var day = document.createElement("div");
    day.classList = ["calendar-number old"];
    day.innerHTML = i + 1;
    if (
      day.innerHTML == today.getDate() &&
      month == today.getMonth() - 1 &&
      year == today.getFullYear()
    ) {
      day.classList.add("calendar-number--current");
    }
    if (day.innerHTML) CalendarContainer.appendChild(day);
  }
}

PrevMonth.addEventListener("click", (e) => {
  currentMonth--;
  if (currentMonth < 0) {
    currentMonth = 11;
    currentYear--;
  }
  drawMonth(currentMonth, currentYear);
  //console.log("mes: "+currentMonth);
  ventana.innerHTML = "";
  DATOS_VENCIMIENTOS = [];
  traerVencimientos(currentMonth, currentYear);
});

NextMonth.addEventListener("click", (e) => {
  currentMonth++;
  if (currentMonth > 11) {
    currentMonth = 0;
    currentYear++;
  }
  drawMonth(currentMonth, currentYear);
  //console.log("mes: "+currentMonth);
  ventana.innerHTML = "";
  DATOS_VENCIMIENTOS = [];
  traerVencimientos(currentMonth, currentYear);
});

function getVencimientos(mes, anio) {
  return $.ajax({
    url: "api/getForMonth.php",
    type: "POST",
    data: { mes: mes, anio: anio },
  });
}

$(document).on("click", ".calendar-number--notification", function (e) {
  ventana.innerHTML = "";

  var number = this.innerHTML;

  var colores = [
    "54478C",
    "2C699A",
    "048BA8",
    "0DB39E",
    "16DB93",
    "83E377",
    "B9E769",
    "EFEA5A",
    "F1C453",
    "F29E4C",
    "F72585",
    "B5179E",
    "7209B7",
    "560BAD",
    "480CA8",
    "3A0CA3",
    "3F37C9",
    "4361EE",
    "4895EF",
    "4CC9F0",
    "F94144",
    "F3722C",
    "F8961E",
    "F9844A",
    "F9C74F",
    "90BE6D",
    "43AA8B",
    "4D908E",
    "577590",
    "277DA1",
    "FABC2A",
    "FFCAB1",
    "F38D68",
    "EE6C4D",
    "F76F8E",
    "F2BAC9",
    "7FD8BE",
    "A1FCDF",
    "3B5249",
    "519872",
    "264653",
    "2A9D8F",
    "E9C46A",
    "F4A261",
    "E76F51",
    "EC8C74",
    "F0A390",
    "F3B5A6",
    "1b998b",
    "ba324f",
  ];

  for (var i = 0; i < DATOS_VENCIMIENTOS.length; i++) {
    fecha = new Date(DATOS_VENCIMIENTOS[i].fechaLimite + "T00:00:00");
    fechaLimite = fecha.getDate();
    if (fechaLimite == number) {
      //console.log(DATOS_VENCIMIENTOS[i]);
      //ventana.innerHTML = DATOS_VENCIMIENTOS[i].obraSocial + " - " + DATOS_VENCIMIENTOS[i].periodo;
      var color = colores[DATOS_VENCIMIENTOS[i].idObraSocial % colores.length];
      if (color == undefined) {
        color = colores[0];
      }
      var primeraLetra = DATOS_VENCIMIENTOS[i].obraSocial.charAt(0);
      var newDiv = document.createElement("div");
      newDiv.classList = ["event"];
      var body = document.createElement("div");
      body.classList = ["card-os-body"];
      var button = document.createElement("button");
      button.classList = ["card-os-icon"];
      button.style.backgroundColor = "#" + color;
      var icon = document.createElement("i");
      icon.classList = ["fa-solid fa-" + primeraLetra.toLowerCase()];
      var title = document.createElement("h6");
      title.classList = ["card-os-title bold"];

      title.innerHTML =
        DATOS_VENCIMIENTOS[i].obraSocial +
        " - " +
        DATOS_VENCIMIENTOS[i].periodo;

      button.appendChild(icon);
      body.appendChild(button);
      body.appendChild(title);
      newDiv.appendChild(body);
      ventana.appendChild(newDiv);
    }
  }

  x = e.pageX;
  y = e.pageY;

  ventana.style.top = `${y}px`;
  ventana.style.left = `${x}px`;
  ventana.style.display = "block";
});

function traerVencimientos(mes, anio) {
  var vencimientos = getVencimientos(mes, anio).then(function (data) {
    datos = JSON.parse(data);
    CalendarContainer.querySelectorAll("div.now");

    for (const item of document.querySelectorAll("div.now")) {
      for (var i = 0; i < datos.length; i++) {
        //console.log(datos[i].fechaLimite);
        fecha = new Date(datos[i].fechaLimite + "T00:00:00");
        fechaLimite = fecha.getDate();
        //console.log(datos[i].fechaLimite);

        if (item.innerHTML == fechaLimite) {
          item.classList.add("calendar-number--notification");

          DATOS_VENCIMIENTOS.push(datos[i]);
        }
      }
    }
  });
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function (event) {
  if (
    !event.target.matches(
      ".events-container, .event, .event-title, .calendar-number--notification"
    )
  ) {
    events = document.getElementsByClassName("events-container");
    for (i = 0; i < events.length; i++) {
      events[i].style.display = "none";
    }
  }
};

window.onload = function () {
  drawMonth(currentMonth, currentYear);

  traerVencimientos(currentMonth, currentYear);
};
