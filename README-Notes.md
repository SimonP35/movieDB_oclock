# Doctrine

## Lecture

Via le *Repository* de l'entité.

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