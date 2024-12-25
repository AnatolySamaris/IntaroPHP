<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }


    #[Route('/books', name: 'app_book', methods: ['get'])]
    public function index(BookRepository $repository) : Response
    {
        $books = $repository->getSortedByReadAt();

        return $this->render('book/index.html.twig', [
            'books' => $books
        ]);
    }

    #[Route('/books/add', name: 'app_book_add',)] //methods: ['get', 'post'])]
    public function add(
        Request $request,
        #[Autowire('%cover_dir%')] string $coverDir,
        #[Autowire('%file_dir%')] string $fileDir) : Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form['cover']->getData() && $form['file']->getData()) {
                $cover = $form['cover']->getData();
                $file = $form['file']->getData();
                $cover_filename = bin2hex(random_bytes(6)).'.'.$cover->guessExtension();
                $file_filename = bin2hex(random_bytes(6)).'.'.$file->guessExtension();
                $cover->move($coverDir, $cover_filename);
                $file->move($fileDir, $file_filename);
                $book->setCover($cover_filename);
                $book->setFile($file_filename);
                $this->entityManager->persist($book);
                $this->entityManager->flush();
            }
            return $this->redirectToRoute('app_book');
        }
        return $this->render('book/add.html.twig', [
            'book_form' => $form
        ]);
    }

    #[Route('/books/{id}', name: 'app_book_show', methods: ['get'])]
    public function show(Request $request, int $id, BookRepository $repository) : Response 
    {
        return $this->render('book/show.html.twig', [
            'book' => $repository->find($id)
        ]);
    }

    #[Route('/books/edit/{id}', name: 'app_book_edit')]
    public function edit(
        int $id,
        Request $request,
        BookRepository $repository,
        #[Autowire('%cover_dir%')] string $coverDir,
        #[Autowire('%file_dir%')] string $fileDir) : Response
    {
        $book = $repository->find($id);
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form['cover']->getData() && $form['file']->getData()) {
                $cover = $form['cover']->getData();
                $file = $form['file']->getData();
                $cover_filename = bin2hex(random_bytes(6)).'.'.$cover->guessExtension();
                $file_filename = bin2hex(random_bytes(6)).'.'.$file->guessExtension();
                $cover->move($coverDir, $cover_filename);
                $file->move($fileDir, $file_filename);
                $book->setCover($cover_filename);
                $book->setFile($file_filename);
                $this->entityManager->persist($book);
                $this->entityManager->flush();
            }
            return $this->redirectToRoute('app_book');
        }
        return $this->render('book/edit.html.twig', [
            'book_form' => $form
        ]);
    }

    #[Route('/books/{id}', name: 'app_book_edit2')]
    public function edit2(int $id, BookRepository $repository) : Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $repository->find($id)
        ]);
    }

    #[Route('/books/delete/{id}', name: 'app_book_delete', )]
    public function delete(int $id, BookRepository $repository) : Response
    {
        $book = $repository->find($id);
        $this->entityManager->remove($book);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_book');
    }
}
