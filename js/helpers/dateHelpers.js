function getDateFromDOb(DOb) {
  return DOb.getFullYear() +"-"+("0"+(DOb.getMonth()+1)).slice(-2) +"-"+("0"+DOb.getDate()).slice(-2) +" "+("0"+DOb.getHours()).slice(-2) +":"+("0"+DOb.getMinutes()).slice(-2);
}

