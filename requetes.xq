(: Q1 - Liste complète des membres :)
<membres>
{
  for $m in //membre
  let $cat := //categorie[@id = $m/@categorieRef]
  return
    <membre id="{$m/@id}">
      <nomComplet>{$m/prenom/text()} {$m/nom/text()}</nomComplet>
      <email>{$m/email/text()}</email>
      <categorie>{$cat/@libelle/string()}</categorie>
    </membre>
}
</membres>
,

(: Q2 - Liste des concours triés par date :)
<concours>
{
  for $c in //concours
  let $cat := //categorie[@id = $c/@categorieRef]
  order by $c/@date
  return
    <concours>
      <titre>{$c/titre/text()}</titre>
      <date>{$c/@date/string()}</date>
      <coefficient>{$c/@coefficient/string()}</coefficient>
      <categorie>{$cat/@libelle/string()}</categorie>
    </concours>
}
</concours>
,

(: Q3 - Calcul des scores :)
<resultats>
{
  for $c in //concours
  let $coef := number($c/@coefficient)
  return
    <concours titre="{$c/titre/text()}">
    {
      for $p in $c/participants/participant
      let $ref := string($p/@membreRef)
      let $membre := //membre[@id = $ref]
      let $cx := number($p/complexite)
      let $tx := number($p/tempsExecution)
      let $score := ($cx + $tx) * $coef
      return
        <participant>
          <nom>{$membre/prenom/text()} {$membre/nom/text()}</nom>
          <complexite>{$p/complexite/text()}</complexite>
          <tempsExecution>{$p/tempsExecution/text()}</tempsExecution>
          <score>{round($score * 100) div 100}</score>
        </participant>
    }
    </concours>
}
</resultats>
,

(: Q4 - Vainqueur de chaque concours :)
<vainqueurs>
{
  for $c in //concours
  let $coef := number($c/@coefficient)
  let $scores :=
    for $p in $c/participants/participant
    return (number($p/complexite) + number($p/tempsExecution)) * $coef
  let $maxScore := max($scores)
  return
    <concours titre="{$c/titre/text()}">
    {
      for $p in $c/participants/participant
      let $ref := string($p/@membreRef)
      let $membre := //membre[@id = $ref]
      let $score := (number($p/complexite) + number($p/tempsExecution)) * $coef
      where $score = $maxScore
      return
        <vainqueur>
          <nom>{$membre/prenom/text()} {$membre/nom/text()}</nom>
          <score>{$score}</score>
        </vainqueur>
    }
    </concours>
}
</vainqueurs>
,

(: Q5 - Membres d'une catégorie triés alphabétiquement :)
let $categorie := "Intelligence Artificielle"
return
<membres>
{
  for $m in //membre
  let $cat := //categorie[@id = string($m/@categorieRef)]
  where string($cat/@libelle) = $categorie
  order by $m/nom, $m/prenom
  return
    <membre id="{$m/@id}">
      <nomComplet>{$m/prenom/text()} {$m/nom/text()}</nomComplet>
      <email>{$m/email/text()}</email>
    </membre>
}
</membres>