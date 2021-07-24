FORM TWIG

{{ form_start(form, {attr: {novalidate: 'novalidate'}}) }}
{{ form_row(form.title) }}
{{ form_row(form.releaseDate) }}
{{ form_row(form.duration) }}
{{ form_row(form.poster) }}

<button class="btn btn-success" type="submit">
	{% if editMode %}
		Enregistrer les modifications
	{% else %}
		Ajouter
	{% endif %}
</button>

{{ form_end(form) }}

CONTROLLER 

/**
     * Ajouter/modifier un film
     *
     * @Route("/back/movie/add", name="back_movie_add", methods={"GET", "POST"})
     * @Route("/back/movie/edit/{id<\d+>}", name="back_movie_edit", methods={"GET", "POST"})
     */
    public function form(Request $request, Movie $movie = null)
    {
        if (!$movie) {
            $movie = new Movie();
        }

        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$movie->getId()) {
                $movie->setCreatedAt(new DateTime());
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            return $this->redirectToRoute('back_movie_browse');
        }

        return $this->render('back/movie/add_movie.html.twig', [
            'form' => $form->createView(),
            'editMode' => $movie->getId() !== null,
        ]);
    }
