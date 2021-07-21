# Doctrine

## Lecture

Via le *Repository* de l'entité.

Ecriture 1 : classique
```php
$movieRepository = $this->getDoctrine()->getRepository(Movie::class);
$movie = $movieRepository->find($id);
```

Ecriture 2 : Injection du Repository dans la méthode
```php
    /**
     * Affiche un article
     *
     * @Route("/post/read/{id}", name="post_read", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function read(PostRepository $postRepository, $id)
    {
        $post = $postRepository->find($id);
```

Ecriture 3 : Usage du ParamConverter
```php
    /**
     * Supprimer un article
     * 
     * ParamConverter => si $post = null, alors notre contrôleur est exécuté
     * 
     * @Route("/post/delete/{id<\d+>}", name="post_delete", methods={"GET"})
     */
    public function delete(Post $post, EntityManagerInterface $entityManager)
    {
```

### Regénérer une classe de Repository

Si classe manquante, l'ajouter dans le @Entity, puis exécuter la commande suivante + FQCN complet à l'invite.

```php
@ORM\Entity(repositoryClass=PostRepository::class)
```
```
bin/console make:entity --regenerate
```

## Ecriture(s)

Ajout, modification, suppression via le *Manager*.

## Active Record VS Data Mapper

```php
// AR
// L'objet "peut tout faire"
$movie->save();
$movie->findAll();
$movie->find(1);
// Update/Delete
$movie->find(1);
$movie->title = 'new title';
$movie->save();
// Ou
$movie->delete();
// DM
// L'objet est manipulé par
// Le manager
$manager->persist($movie);
$manager->flush();
// Le Repository
$movieRepository->findAll();
$movieRepository->find(1);
// Update
$movie = $movieRepository->find(1);
$movie->setTitle('new title');
$manager->flush();
// Delete
$movie = $movieRepository->find(1);
$manager->remove($movie);
$manager->flush();
```

## Si une classe de Repository est manquante

On serait bloqués pour : 

- Pour "injecter" MovieRepository dans une méthode de contrôleur.
- Créer des requêtes custom.

Solution : 

- On indique la classe de Repository au niveau du @ORM\Entity, par ex.
  - `@ORM\Entity(repositoryClass=MovieRepository::class)`
  - + un `use App\Repository\MovieRepository;`
- Puis on exécute la commande `make:entity --regenerate`
  - FQCN complet à saisir par ex. : `App\Entity\Movie`

PS : on pourrait écrire directement :
- `@ORM\Entity(repositoryClass='App\Repository\MovieRepository')`
- + la commande make:entity
## Relations

### ManyToOne (1N)

- On identifie sur le MCD où va aller la clé étrangère (du côté du "1" sur la relation 1N).
- C'est donc cette éntité qui va "détenir la relation".
- Pour Doctrine, c'est la `ManyToOne` qui détient la relation, donc la `ManyToOne` est l'entité qui détient la clé étrangère.
