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


je travaille sur la creation d'une application gestionnaire electronique de donnees projet academique avec symfony 7 jai deja fait la partie authentification et login il manque principalement la creation d'un document  dans un doossieur et que quand un utilisateur ou administrateur voudrai supprimer un document , l'action ce produit et apparai comme supprimer mais un admin a access au document en question supprimer et peut egalement voir qui( quel utilisateur )a supprimer et donner l'heure a la quel l'action cest faites automatiquement  



[]comment upload un document de ma machine et garde son nom jusqu'a mon application symfony serve de gestionnaire de fichier

Créer un formulaire d’upload
Gérer l’upload dans un contrôleur
Sauvegarder le fichier avec son nom original
Stocker les infos en base de données (facultatif)
Afficher ou servir les fichiers via une route Symfony

[]The uploaded file was too large. Please try to upload a smaller file. comment configure la taille  maximum  d'un fichier upload  avec symfony (ce fait dans le mimines.types)


[] Add a Dashboard
You can implement this in EasyAdmin as follows:
[] Create dashboard layout (
    - Block 1: Sidenav
    - Block 2: Search
    - Block 3: container
)

 return parent::index();
 The name of the route associated to "App\Controller\Admin\DashboardController::index" cannot be determined. Clear the application cache to run the EasyAdmin cache warmer, which generates the needed data to find this route. 

 #[Route('/{id}', name: 'app_folder_show', methods: ['GET'])]
 public function show(Folder $folder): Response
    {
        return $this->render('folder/show.html.twig', [
            'folder' => $folder,
        ]);
    }

    app_folders_list


     $folderName = $folder->getName();

        $basePath = $this->getParameter('kernel.project_dir') . '/public/uploads/documents/';
        $folderPath = $basePath . $folderName;

        $file = [];
        if (is_dir($folderPath)) {
            $file = array_diff(scandir($folderPath), ['.', '..']);
        }

        public function show(Folder $folder): Response

        {% extends '/dashboard/layout.html.twig' %}


{% block title %}New File{% endblock %}

{% block container %}
    <h1>Create new File</h1>

    {{ include('file/_form.html.twig') }}

    <a href="{{ path('app_file_index') }}">back to list</a>
{% endblock %}

/all-files/all.html.twig

je travaille sur la creation d'une application gestionnaire electronique de donnees projet academique avec symfony 7 jai deja fait la partie authentification et login, creation d'un file et folder actuellement j'aimerais cree et separer les roles  un utilisateur et  administrateur  vu qu'ils n'ont pas les meme fonctionnalites exemple je voudrai supprimer un document (utilisateur) , l'action ce produit et apparai comme supprimer mais un admin a access au document en question supprimer et peut egalement voir qui( quel utilisateur )a supprimer et donner l'heure a la quel l'action cest faites automatiquement

{% extends '/dashboard/layout.html.twig' %}

{% block title %}Edit User{% endblock %}

{% block container %}
    <h1>Edit User</h1>

    {{ include('user/_form.html.twig', {'button_label': 'Update'}) }}

    <a href="{{ path('app_user_index') }}">back to list</a>

    {{ include('user/_delete_form.html.twig') }}
{% endblock %}

<div class="d-flex align-items-center">
				<div>
					<h5 class="mb-0">Recent Files</h5>
				</div>
				<div class="ms-auto"><a href="javascript:;" class="btn btn-sm btn-outline-secondary">View all</a>
				</div>
			</div>
			<div class="table-responsive mt-3">
				<table class="table table-striped table-hover table-sm mb-0">
					<thead>
						<tr>
							<th>Name <i class="bx bx-up-arrow-alt ms-2"></i>
							</th>
							<th>Members</th>
							<th>Last Modified</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class="d-flex align-items-center">
									<div><i class="bx bxs-file-pdf me-2 font-24 text-danger"></i>
									</div>
									<div class="font-weight-bold text-danger">Competitor Analysis Template</div>
								</div>
							</td>
							<td>Only you</td>
							<td>Sep 3, 2019</td>
							<td><i class="fa fa-ellipsis-h font-24"></i>
							</td>
						</tr>
						<tr>
							<td>
								<div class="d-flex align-items-center">
									<div><i class="bx bxs-file me-2 font-24 text-primary"></i>
									</div>
									<div class="font-weight-bold text-primary">How to Create a Case Study</div>
								</div>
							</td>
							<td>3 members</td>
							<td>Jun 12, 2019</td>
							<td><i class="fa fa-ellipsis-h font-24"></i>
							</td>
						</tr>
						<tr>
							<td>
								<div class="d-flex align-items-center">
									<div><i class="bx bxs-file me-2 font-24 text-primary"></i>
									</div>
									<div class="font-weight-bold text-primary">Landing Page Structure</div>
								</div>
							</td>
						<tr>
							<td>
								<div class="d-flex align-items-center">
									<div><i class="bx bxs-file-pdf me-2 font-24 text-danger"></i>
									</div>
									<div class="font-weight-bold text-danger">Meeting Report</div>
								</div>
							</td>
							<td>5 members</td>
							<td>Aug 28, 2019</td>
							<td><i class="fa fa-ellipsis-h font-24"></i>
							</td>
						</tr>
						<tr>
							<td>
								<div class="d-flex align-items-center">
									<div><i class="bx bxs-file me-2 font-24 text-primary"></i>
									</div>
									<div class="font-weight-bold text-primary">Project Documents</div>
								</div>
							</td>
							<td>Only you</td>
							<td>Aug 17, 2019</td>
							<td><i class="fa fa-ellipsis-h font-24"></i>
							</td>
						</tr>
						<tr>
							<td>
								<div class="d-flex align-items-center">
									<div><i class="bx bxs-file-doc me-2 font-24 text-success"></i>
									</div>
									<div class="font-weight-bold text-success">Review Checklist Template</div>
								</div>
							</td>
							<td>7 members</td>
							<td>Sep 8, 2019</td>
							<td><i class="fa fa-ellipsis-h font-24"></i>
							</td>
						</tr>
						<tr>
							<td>
								<div class="d-flex align-items-center">
									<div><i class="bx bxs-file me-2 font-24 text-primary"></i>
									</div>
									<div class="font-weight-bold text-primary">How to Create a Case Study</div>
								</div>
							</td>
							<td>3 members</td>
							<td>Jun 12, 2019</td>
							<td><i class="fa fa-ellipsis-h font-24"></i>
							</td>
						</tr>
						<tr>
							<td>
								<div class="d-flex align-items-center">
									<div><i class="bx bxs-file me-2 font-24 text-primary"></i>
									</div>
									<div class="font-weight-bold text-primary">Landing Page Structure</div>
								</div>
							</td>
							<td>10 members</td>
							<td>Jul 17, 2019</td>
							<td><i class="fa fa-ellipsis-h font-24"></i>
							</td>
						</tr>
						<tr>
							<td>
								<div class="d-flex align-items-center">
									<div><i class="bx bxs-file-doc me-2 font-24 text-success"></i>
									</div>
									<div class="font-weight-bold text-success">Review Checklist Template</div>
								</div>
							</td>
							<td>7 members</td>
							<td>Sep 8, 2019</td>
							<td><i class="fa fa-ellipsis-h font-24"></i>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
	</div>