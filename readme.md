[] Create a user 
[] registration form (user) { email, password, message}
[] Authentification 
[] Adminstrator registration

[] Add Folder
    [] Create Entity
    [] Create Controller
    [] Create View

[] Add a file ( entity, controller, crud)
[]Formulaire (src/form/FileType)
Masquer les documents sensibles pour les utilisateurs non administrateurs
(Dans la base de données, tu peux ajouter un champ archived pour chaque document. Les administrateurs auront accès à tous les documents, mais les utilisateurs normaux ne verront que ceux qui ne sont pas archivés.) Ce faisant dans 
Entity/File.php, FileController.php et a caque fois qu'on modify quelquechose dans entite on creer et applique la migrations

Ces fonctionnalites
creation et enregistrement
suppression en indiquant juste pour admin (qui et a quel heure le file a ete supprimer en utilisant 
deleteAt et deletedBy)


[] Add a Dashboard
You can implement this in EasyAdmin as follows:






je travaille sur la creation d'une application gestionnaire electronique de donnees projet academique avec symfony 7 jai deja fait la partie authentification et login il manque principalement la creation d'un document  dans un doossieur et que quand un utilisateur ou administrateur voudrai supprimer un document , l'action ce produit et apparai comme supprimer mais un admin a access au document en question supprimer et peut egalement voir qui( quel utilisateur )a supprimer et donner l'heure a la quel l'action cest faites automatiquement  



[]comment upload un document de ma machine et garde son nom jusqu'a mon application symfony serve de gestionnaire de fichier

Créer un formulaire d’upload
Gérer l’upload dans un contrôleur
Sauvegarder le fichier avec son nom original
Stocker les infos en base de données (facultatif)
Afficher ou servir les fichiers via une route Symfony

[]The uploaded file was too large. Please try to upload a smaller file. comment configure la taille  maximum  d'un fichier upload  avec symfony
