<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Club\UserBundle\Entity\Group;
use Club\UserBundle\Form\GroupForm;

class GroupController extends Controller
{
  /**
   * @Route("/group", name="admin_group")
   * @Template()
   */
  public function indexAction()
  {
    $dql = "SELECT g FROM Club\UserBundle\Entity\Group g ORDER BY g.group_name";
    $em = $this->get('doctrine.orm.entity_manager');

    $query = $em->createQuery($dql);
    $groups = $query->getResult();

    return $this->render('ClubUserBundle:Group:index.html.twig',array(
      'page' => array('header' => 'User'),
      'groups' => $groups
    ));
  }

  /**
   * @Route("/group/new", name="admin_group_new")
   * @Template()
   */
  public function newAction()
  {
    $group = new Group();
    $form = GroupForm::create($this->get('form.context'),'group');

    $form->bind($this->get('request'),$group);
    if ($form->isValid()) {
      $group->setGroupType('static');
      $group->setIsActive(true);
      $em = $this->get('doctrine.orm.entity_manager');
      $em->persist($group);
      $em->flush();

      $this->get('session')->setFlash('notice','Your changes were saved!');

      return new RedirectResponse($this->generateUrl('group'));
    }

    return array(
      'page' => array('header' => 'Group'),
      'form' => $form
    );
  }

  /**
   * @Route("/group/edit/{id}", name="admin_group_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $group = $em->find('Club\UserBundle\Entity\Group',$id);

    $form = GroupForm::create($this->get('form.context'),'group');

    $form->bind($this->get('request'),$group);
    if ($form->isValid()) {
      $group->setGroupType('static');
      $group->setIsActive(true);
      $em->persist($group);
      $em->flush();

      $this->get('session')->setFlash('notice','Your changes were saved!');

      return new RedirectResponse($this->generateUrl('group'));
    }

    return array(
      'group' => $group,
      'page' => array('header' => 'Group'),
      'form' => $form
    );
  }

  /**
   * @Route("/group/delete/{id}", name="admin_group_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $group = $em->find('ClubUserBundle:Group',$id);

    $em->remove($group);
    $em->flush();

    $this->get('session')->setFlash('notify',sprintf('Group %s deleted.',$group->getGroupName()));

    return new RedirectResponse($this->generateUrl('group'));
  }

  /**
   * @Route("/group/batch", name="admin_group_batch")
   */
  public function batchAction()
  {
  }
}
