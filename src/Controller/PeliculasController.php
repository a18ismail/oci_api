<?php

namespace App\Controller;

use App\Entity\Pelicula;
use App\Repository\PeliculaRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PeliculasController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class PeliculasController extends AbstractController
{

    private $peliculaRepository;

    public function __construct(PeliculaRepository $repository)
    {
        $this->peliculaRepository = $repository;
    }

    /**
     * @Route("pelicula", name="afegir_pelicula", methods={"POST"} )
     */
    public function afegirPelicula(Request $request)
    {

        $data = json_decode($request->getContent(), true);

        $nom = $data['nom'];
        $genere = $data['genere'];
        $descripcio = $data['descripcio'];

        if ( empty($nom) || empty($genere) || empty($descripcio) ){
            throw new NotFoundHttpException('Falten dades!');
        }else{
            $this->peliculaRepository->guardarPelicula($nom, $genere, $descripcio);

            return new JsonResponse( ['status' => 'Pelicula guardada correctament!'], Response::HTTP_CREATED);

        }

    }

    /**
     * @Route("pelicula/{id}", name="conseguir_pelicula", methods={"GET"} )
     */
    public function conseguirPelicula(Request $request, $id)
    {
        $pelicula = $this->peliculaRepository->findOneBy(['id' => $id]);

        $result = [
            'id' => $pelicula->getId(),
            'nom' => $pelicula->getNom(),
            'genere' => $pelicula->getGenere(),
            'descripcio' => $pelicula->getDescripcio()
        ];

        return new JsonResponse($result, Response::HTTP_OK);

    }

    /**
     * @Route("getAll", name="conseguir_pelicules", methods={"GET"} )
     */
    public function conseguirPelicules(Request $request)
    {
        $pelicules = $this->peliculaRepository->findAll();

        $result = [];

        foreach ($pelicules as $pelicula){
            $result[] = [
                'id' => $pelicula->getId(),
                'nom' => $pelicula->getNom(),
                'genere' => $pelicula->getGenere(),
                'descripcio' => $pelicula->getDescripcio()
            ];
        }

        return new JsonResponse($result, Response::HTTP_OK);

    }

    /**
     * @Route("pelicula/{id}", name="actualitzar_pelicula", methods={"PUT"} )
     */
    public function actualitzarPelicula(Request $request, $id)
    {
        $pelicula = $this->peliculaRepository->findOneBy(['id' => $id]);

        $data = json_decode($request->getContent(), true);

        empty( $data['nom'] ) ? true : $pelicula->setNom( $data['nom'] );
        empty( $data['genere'] ) ? true : $pelicula->setGenere( $data['genere'] );
        empty( $data['descripcio'] ) ? true : $pelicula->setDescripcio( $data['descripcio'] );

        $this->peliculaRepository->actualitzar($pelicula);

        return new JsonResponse( ['status' => 'Pelicula actualitzada correctament!'], Response::HTTP_CREATED);

    }

    /**
     * @Route("pelicula/{id}", name="eliminar_pelicula", methods={"DELETE"} )
     */
    public function eliminarPelicula(Request $request, $id)
    {
        $pelicula = $this->peliculaRepository->findOneBy(['id' => $id]);

        $this->peliculaRepository->eliminar($pelicula);

        return new JsonResponse( ['status' => 'Pelicula actualitzada correctament!'], Response::HTTP_CREATED);

    }


}
