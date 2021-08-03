<?php

namespace App\Command;

use App\Repository\MovieRepository;
use App\Service\OmdbApi;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Récupère les posters des films
 * Soit un film si titre donné à la commande
 * Soit tous les films de la BDD
 */
class MoviePosterCommand extends Command
{
    // Nom de la commande. Bonne pratique, on la préfixe avec "app:"
    protected static $defaultName = 'app:movie:poster';
    // Description de la commande
    protected static $defaultDescription = 'Fetch movie posters from OMDB API';

    // Les services nécessaires à notre commande...
    private $mr;
    private $em;
    private $omdbApi;

    /**
     * ... qu'on récupère en injection de dépendances ici
     */
    public function __construct(MovieRepository $mr, EntityManagerInterface $em, OmdbApi $omdbApi)
    {
        $this->mr = $mr;
        $this->em = $em;
        $this->omdbApi = $omdbApi;

        // En PHP on doit appeler le constructeur de la classe parent
        // si on en a un dans l'enfant et que le parent aussi !
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // Message d'aide supplémentaire
            // Argument = valeur à transmettre à la commande
            ->addArgument('title', InputArgument::OPTIONAL, 'Movie title to fetch')
            // "Flag/Modifieur/Option" qui change le comportement de la commande
            ->addOption('dump', 'd', InputOption::VALUE_NONE, 'Dump title movies')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Permet des "fioritures graphiques" dans le terminal
        $io = new SymfonyStyle($input, $output);

        // On récupère l'argument "title" si présent
        $title = $input->getArgument('title');

        if ($title) {
            // Si un titre est présent, on ne traite que ce film
            $io->note(sprintf('Movie to fetch: %s', $title));
            $movie = $this->mr->findOneBy(['title' => $title]);
            $movies = [$movie]; // Pour simplifier le foreach suivant et éviter une condition

        } else {
            // Sinon on traite tous les films
            $io->note(sprintf('Fetching all movies'));
            $movies = $this->mr->findAll();
        }


        foreach ($movies as $movie) {

            if ($input->getOption('dump')) {
                $io->info('Fetching ' . $movie);
            }

            $moviePoster = $this->omdbApi->fetchPoster($movie);

            if ($moviePoster === 'http://lorempixel.com/300/400/') {
                $io->warning('Poster not found :scream:');
            }

            $movie->setPoster($moviePoster);
        }

        $this->em->flush($movies);

        // La logique métier / L'objectif de la commande

        // On récupère les films concernés
        // On boucle dessus, on va chercher les données associées sur OMDB API
            // => conversion à faire JSON => Array
            // On met à jour l'URL du poster dans le film
        // On flush

        $io->success('All movies fetched!');

        // Indique que la commande a fonctionné comme attendu
        return Command::SUCCESS;
    }
}
