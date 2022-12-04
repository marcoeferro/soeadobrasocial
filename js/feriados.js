const fecha = new Date();
const anio= fecha.getFullYear();
const mes= fecha.getMonth();
const dia= fecha.getDate();
const finde=fecha.getDay();
//console.log(dia);
$.ajax({
    type: "GET",
    url: "https://nolaborables.com.ar/api/v2/feriados/"+anio+"",
    datatype: "json", 
    //data:{},       
    success: function (data) {
      //console.log(dato=JSON.parse(JSON.stringify(data)));
      //console.log(data[0]["mes"]);
      let feriado = false;
      data.forEach(element => {
        //console.log(element["mes"],element["dia"]);
        if(element["mes"] == (mes+1) && element["dia"]== dia ){
          feriado=true;
        }
      });
      if(finde == 6 || finde == 7 ){
        feriado = true;
      }
      if(feriado){
        document.getElementById("feriado").style.display = "block";
      }else{
        document.getElementById("feriado").style.display = "none";
      }
    }
  });
  //console.log(document.getElementById("feriado").style.display = "none");