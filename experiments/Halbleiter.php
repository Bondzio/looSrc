<?php include '../php/header.inc.php';?>
<?php include '../php/postheader.inc.php';?>
<!-- content here-->
<h1>hi</h1>
<?php include '../php/prefooterscripts.inc.php';?>
<script>
  $(document).ready( function() {
    n = 100; //Gitterweite
    plusrumpf = []; minusrumpf=[]; e = []; l= [];
    for(var i = 0; i<=n/2-1; i++) {
      plusrumpf[i] = 20;
      minusrumpf[i] = 0;
      e[i] = 10;
      l[i] = 0;
    }
    for(var i = n/2; i<=n-1; i++) {
      plusrumpf[i] = 0;
      minusrumpf[i] = 20;
      e[i] = 0;
      l[i] = 10;
    }
    k=0.001;
    function step() {
      var Phi = [];
      for(var i = 0; i<=n-1; i++) {
        Phi[i]=0;
        for(var j = 0; j<=n-1; j++) {
          if(i!=j) {
            Phi[i] += (plusrumpf[j] + l[j] - minusrumpf[j] - e[j]) / abs(i-j);
            //log(i,j,sign(i-j) , (plusrumpf[j] + l[j] - minusrumpf[j] - e[j]) , ((i-j)*(i-j)))
          }
          else {
            Phi[i] += (plusrumpf[j] + l[j] - minusrumpf[j] - e[j]) / 0.5;
          }
        }
      }
      //log(Phi);
      var eprov = e.map(function(el) {return el;});
      var lprov = l.map(function(el) {return el;});
      for(var i = 1; i<=n-1; i++) {
        lprov[i] += - k * max( Phi[i]-Phi[i-1], 0) * l[i] + k * max(-Phi[i]+Phi[i-1], 0) * l[i-1];
        eprov[i] += - k * max(-Phi[i]+Phi[i-1], 0) * e[i] + k * max( Phi[i]-Phi[i-1], 0) * e[i-1];
      }
      for(var i = 0; i<=n-2; i++) {
        lprov[i] += - k * max(-Phi[i+1]+Phi[i], 0) * l[i] + k * max(Phi[i+1]-Phi[i], 0) * l[i+1];
        eprov[i] += - k * max( Phi[i+1]-Phi[i], 0) * e[i] + k * max(-Phi[i+1]+Phi[i], 0) * e[i+1];
      }
      e = eprov.map(function(el) {return el;});
      l = lprov.map(function(el) {return el;});
      
    }
    step();
    for(var i=0; i<500; i++) {step();}
    log(l);
  })
</script>
<?php include '../php/footer.inc.php';?>
