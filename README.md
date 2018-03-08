# ProjetWebservice

Le   but   de   ce   TP   est   de   recréer   de   manière   très   simplifiée   un   navigateur   web.

Le   projet   se   composera   de   2   éléments:

- une   interface   cliente   qui   fera   office   de   navigateur.   Dans   ce   navigateur,   on   aura   :
    - un   champ   de   saisie   pour   l’url   que   l’on   souhaite   appeler,
    - une   liste   déroulante   pour   sélectionner   le   content-type,
    - une   liste   déroulante   pour   la   méthode   utilisée   (GET,   POST,   etc   ...)
    - une   liste   déroulante   pour   indiquer   la   langue   utilisée,
    - un   champ   texte   pour   envoyer   des   paramètres
    - un   bouton   pour   envoyer   notre   demande,
    - un   champ   pour   afficher   le   résultat   (entêtes   de   retour   et   données)
- un   serveur   qui   devra:
    - interpréter   la   demande   reçue,
    - renvoyer   le   bon   contenu   en   fonction   des   entêtes   utilisés,
    - indiquer   le   succès   ou   l’échec   de   l’opération   (les   codes   HTTP   vu   en   cours)

En   résumé   il   vous   est   demandé   de   reproduire   la   fenêtre   de   débogage   des   requêtes   HTTP   que   vous   pouvez   lancer depuis   n’importe   quel   navigateur   en   appuyant   sur   F12.

Votre   interface   cliente   pourrait   en   théorie   fonctionner   en   indiquant   n’importe   quelle   url.

Je   vous   demanderai   de   développer   pour   la   partie   serveur   plusieurs   webservices:

- le   webservice   article:
    - un   article   est   composé   d’un   identifiant   généré   à   la   création,   d’un   libellé,   d’un   prix   et   de   l’identifiant d’une   catégorie
    - le   webservice   GET   /articles   renverra   la   liste   des   articles,
    - le   webservices   GET   /article/:id   renverra   un   article   en   particulier   (où   :id   est   l’identifiant   de   l’article),
    - le   webservice   POST   /article   créera   un   article,
    - le   webservice   DELETE   /article/:id   supprimera   un   article
- le   webservice   catégorie:
    - une   catégorie   est   composée   d’un   identifiant   (généré   à   la   création),   et   d’un   libellé,
    - le   webservice   GET   /categories   renverra   la   liste   des   catégories,
    - le   webservices   GET   /catégorie/:id   renverra   une   catégorie   en   particulier   (où   :id   est   l’identifiant   de   la
        catégorie),
    - le   webservice   POST   /categorie   créera   une   catégorie,
    - le   webservice   DELETE   /categorie/:id   supprimera   une   catégorie

Bien   entendu,   l’appel   à   un   webservice   inexistant   ou   avec   la   mauvaise   méthode   devra   renvoyer   le   code   http correspondant.