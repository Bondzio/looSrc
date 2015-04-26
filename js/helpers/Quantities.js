function Quantities() {
  
}

Quantities.prototype.quantities = [
  {
    q: [
      ["Strecke", "s"],
      ["Radius", "r"],
      ["Abstand", "r"],
      ["Durchmesser", "d"],
      ["Höhe", "h"],
      ["Länge", "l"],
      ["Breite", "b"],
      ["Auslenkung", "y"],
      ["Wellenlänge", "lamda"]
    ],
    dim: {"m": 1},
    units: [["m", 1], ["dm", 0.1], ["cm", 0.01], ["mm", 0.001], ["um", 1e-6], ["nm", 1e-9], ["pm", 1e-12], ["fm", 1-15], ["km", 1000], ["AE", 1.5e11], ["LJ", 300000000*31536000]]
  },
  {
    q: [
      ["Masse", "m"],
      ["Masse", "M"],
    ],
    dim: {"kg": 1},
    units: [["kg", 1], ["g", 1e-3], ["mg", 1e-6], ["ug", 1e-9], ["ng", 1e-12], ["t", 1000], ["u", 1.67e-27]]
  },
  {
    q: [
      ["Zeit", "t"],
      ["Periodendauer", "T"],
      ["Umlaufzeit", "T"]
    ],
    dim: {"s": 1},
    units: [["s", 1], ["ms", 1e-3], ["us", 1e-6], ["ns", 1e-9], ["min", 60], ["h", 3600], ["d", 86400], ["y", 31536000]]
  },
  {
    q: [
      ["Geschwindigkeit", "v"],
      ["Geschwindigkeit", "u"],
      ["Ausbreitungsgeschwindigkeit", "c"]
    ],
    dim: {"m": 1, "s": -1},
    units: [["m/s", 1], ["km/h", 1/3.6], ["km/s", 1000]]
  },
  {
      q: [
      ["Beschleunigung", "a"],
      ["Fallbeschleunigung", "g"],
      ["Ortsfaktor", "g"]
    ],
    dim: {"m": 1, "s": -2},
    units: [["m/s^2", 1], ["N/kg", 1]]
  },
  {
    q: [
      ["Kraft", "F"],
    ],
    dim: {"m": 1, "kg": 1, "s": -2},
    units: [["N", 1], ["kN", 1000]]
  },
  {
    q: [
      ["Arbeit", "W"],
      ["Energie", "E"],
      ["Wärme", "Q"],
    ],
    dim: {"m": 2, "kg": 1, "s": -2},
    units: [["J", 1], ["kJ", 1000], ["MJ", 1e6], ["GJ", 1e9], ["TJ", 1e12], ["PJ", 1e15], ["EJ", 1e18], ["kWh", 3.6e6], ["MWh", 3.6e9], ["GWh", 3.6e12], ["eV", 1.6e-19], ["keV", 1.6E-16], ["MeV", 1.6e13], ["kcal", 4182]]
  },
  {
    q: [
      ["Leistung", "P"],
      ["Energieflussrate", "P"],
    ],
    dim: {"m": 2, "kg": 1, "s": -3},
    units: [["W", 1], ["mW", 1e-3], ["kW", 1000], ["MW", 1e6], ["GW", 1e9], ["TW", 1e12]]
  },
  {
    q: [
      ["Ladung", "Q"],
      ["Ladung", "q"],
    ],
    dim: {"C": 1},
    units: [["C", 1], ["mC", 1e-3], ["uC", 1e-6], ["nC", 1e-9], ["As", 1], ["Ah", 3600], ["mAh", 3.6]]
  },
];

Quantities.prototype.findQuantity = function(unit, symbol) {
  var unitMatch = this.quantities.filter(function(q) {return q.units.filter(function(u) {return u[0] == unit;}).length >0;});
  var match = unitMatch.filter(function(q) {return q.q.filter(function(q) {return q[1] == symbol;}).length >0;});
  var possibilities = match.map(function(q) {
    var names = q.q.filter(function(el) {return el[1] == symbol;}).map(function(el) {return el[0];});
    var factor = q.units.filter(function(u) {return u[0] == unit;}).map(function(el) {return el[1];})[0];
    return {names: names, factor: factor};
  });
  if(possibilities.length > 1) {
    log("Nicht Eindeutige Kombination:", symbol, unit);
  }
  return possibilities[0];
}