<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use App\Service\CategoriesService;
use Cocur\Slugify\SlugifyInterface;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categories")
 */
class CategoriesController extends Controller
{
    const UPLOAD_PATH = '/upload/categories/';

    /**
     * @Route("/", name="categories_index", methods="GET")
     * @param CategoriesRepository $categoriesRepository
     * @return Response
     */
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('admin/categories/index.html.twig', ['categories' => $categoriesRepository->findByRootCategories()]);
    }

    /**
     * @Route("/list", name="categories_list", methods="GET")
     * @param CategoriesRepository $categoriesRepository
     * @return Response
     */
    public function list(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('admin/categories/list.html.twig', ['categories' => $categoriesRepository->findByActive()]);
    }

    /**
     * @Route("/add", name="categories_add", methods="GET|POST")
     * @param Request $request
     * @param SlugifyInterface $slug
     * @param CategoriesService $categoriesService
     * @return Response|JsonResponse
     */
    public function add(Request $request, SlugifyInterface $slug, CategoriesService $categoriesService): Response
    {
        $category = new Categories();
        $category->setCreateDate(new DateTime('now'));
        $category->setUpdateDate(new DateTime('now'));
        // @ToDo setUploadPath
        // @ToDo setImage

        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setPath($slug->slugify($category->getName()));
            $category->setFullPath($categoriesService->createFullPath($category));

            if (null === $category->getMetaTitle()) $category->setMetaTitle($category->getName());

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $category->setUploadPath(self::UPLOAD_PATH . $category->getId());
            /*$em->persist($category);
            $em->flush();*/

            return $this->redirectToRoute('categories_index');

        }

        return $this->render('admin/categories/add.html.twig', [
            'category' => $category,
            'categories' => $categoriesService->findByRootCategories(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categories_view", methods="GET")
     * @param Categories $category
     * @param CategoriesRepository $categoriesRepository
     * @return Response
     */
    public function view(Categories $category, CategoriesRepository $categoriesRepository): Response
    {
        $data = [
            'category' => $category,
            'categories' => $categoriesRepository->findByChildren($category)
        ];

        return $this->render('admin/categories/view.html.twig', $data);
    }

    /**
     * @Route("/{id}/edit", name="categories_edit", methods="GET|POST")
     * @param Request $request
     * @param Categories $category
     * @param CategoriesRepository $categoriesRepository
     * @return Response
     */
    public function edit(Request $request, Categories $category, CategoriesRepository $categoriesRepository): Response
    {
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        var_dump($form->get('fileLoad'));

        if ($form->isSubmitted() && $form->isValid()) {
            //$this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categories_edit', ['id' => $category->getId()]);
        }

        $parentCategory = $category->getParent();

        return $this->render('admin/categories/edit.html.twig', [
            'category' => $category,
            'parent' => null != $parentCategory ? $parentCategory->getParent() : null,
            'categories' => $categoriesRepository->findBy([
                'parent' => $parentCategory,
                'active' => true,
                'deleted' => false
            ]),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categories_delete", methods="DELETE")
     * @param Request $request
     * @param Categories $category
     * @return Response
     */
    public function delete(Request $request, Categories $category): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getid(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('categories_index');
    }
}
