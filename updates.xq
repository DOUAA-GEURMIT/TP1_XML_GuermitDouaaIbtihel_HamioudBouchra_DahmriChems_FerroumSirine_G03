(: UPDATE 1 - Insertion d'un nouveau membre :)
insert node
  <membre id="M009" categorieRef="C2">
    <nom>Zerrouk</nom>
    <prenom>Lyna</prenom>
    <email>l.zerrouk@club.dz</email>
  </membre>
into doc("clubinfotechdb/club.xml")//membres

(: UPDATE 2 - Modification du coefficient de CO2 :)
replace value of node
  doc("clubinfotechdb/club.xml")//concours[@id="CO2"]/@coefficient
with "2.0"

(: UPDATE 3 - Suppression d'un participant de CO1 :)
delete node
  doc("clubinfotechdb/club.xml")//concours[@id="CO1"]
    /participants/participant[@membreRef="M003"]