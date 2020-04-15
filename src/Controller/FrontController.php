<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
   
    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('front/about.html.twig');
    }
    
    /**
     * @Route("/blog/single", name="blog-single")
     */
    public function blogSingle()
    {
        return $this->render('front/blog-single.html.twig');
    }

     /**
     * @Route("/blog", name="blog")
     */
    public function blog()
    {
        return $this->render('front/blog.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('front/contact.html.twig');
    }

    /**
     * @Route("/course/single", name="course-single")
     */
    public function courseSingle()
    {
        return $this->render('front/course-single.html.twig');
    }

    /**
     * @Route("/courses", name="courses")
     */
    public function courses()
    {
        return $this->render('front/courses.html.twig');
    }
    
    /**
     * @Route("/event/single", name="event-single")
     */
    public function eventSingle()
    {
        return $this->render('front/event-single.html.twig');
    }
    
    /**
     * @Route("/events", name="events")
     */
    public function events()
    {
        return $this->render('front/events.html.twig');
    }

    /**
     * @Route("/notice", name="notice")
     */
    public function notice()
    {
        return $this->render('front/notice.html.twig');
    }
    
    /**
     * @Route("/notice/single", name="notice-single")
     */
    public function noticeSingle()
    {
        return $this->render('front/notice-single.html.twig');
    }
    
    /**
     * @Route("/research", name="research")
     */
    public function research()
    {
        return $this->render('front/research.html.twig');
    }
    
    /**
     * @Route("/scholarship", name="scholarship")
     */
    public function scholarship()
    {
        return $this->render('front/scholarship.html.twig');
    }

    /**
     * @Route("/teacher/single", name="teacher-single")
     */
    public function teacherSingle()
    {
        return $this->render('front/teacher-single.html.twig');
    }

    /**
     * @Route("/teacher", name="teacher")
     */
    public function teacher()
    {
        return $this->render('front/teacher.html.twig');
    }

}

