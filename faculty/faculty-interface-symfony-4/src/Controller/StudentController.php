<?php

namespace App\Controller;

use App\Entity\FacultyLoads;
use App\Entity\Faculty;
use App\Entity\CourseEnrolled;
use App\Entity\Students;
use App\Entity\Activities;
use App\Entity\Studentrecords;
use App\Entity\ActivitiesSubmitted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Filesystem\Filesystem;
use \Datetime;
class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="student")
     */
    public function index(): Response
    {
        $user = $this->getUser()->getFullname();
        
        $all = $this->getDoctrine()
            ->getRepository(FacultyLoads::class)
            ->findClass($user);

        return $this->render('student/index.html.twig', [
            'all' => $all,
        ]);
    }
   
    public function submitActivity(ManagerRegistry $doctrine,Request $request){
        $entityManager = $doctrine->getManager();
        $correctAnswers = $request->request->get("correctanswers");
        $score = $request->request->get("score");
        $activityID = $request->request->get("activityid");
        $studentID = $request->request->get("studentid");
        $programClass = $request->request->get("programclass");
        $course = $request->request->get("course");
        $files = $request->files->all();
        $tempArr = array();
        if(isset($files)){

            if (!file_exists($this->getParameter('kernel.project_dir') ."/data/submittedactivities/$studentID")) {
                mkdir($this->getParameter('kernel.project_dir') ."/data/submittedactivities/$studentID", 0777, true);
            }
            $index = 0;
            
            foreach ($files as $file) {
                $filename = $request->request->get('filename'.$index);
                
                $target = $this->getParameter('kernel.project_dir') ."/data/submittedactivities/$studentID/$filename";
                array_push($tempArr,$filename);
                move_uploaded_file($file, $target);    
            
                $index++;
            }
            
            
        }
        
        $subactivity = new ActivitiesSubmitted();
        $subactivity->setScore($score);
        $subactivity->setActivityid($activityID);
        $subactivity->setStudentid($studentID);
        $subactivity->setProgramClass($programClass);
        $subactivity->setCourse($course);
        $subactivity->setFile(json_encode($tempArr));
        $subactivity->setCorrectanswers(json_decode($correctAnswers));
        $subactivity->setTimestamp(new DateTime(date("Y-m-d H:i:s")));
        $subactivity->setIsvalid(true);
        
        
        $entityManager->persist($subactivity);

        
        $entityManager->flush();

        $response = new Response("Successful");
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }

    public function retake(ManagerRegistry $doctrine,Request $request){

        $userID = $this->getUser()->getIdnum();
        $id = $request->get('id');
        $entityManager = $doctrine->getManager();
        
        
        
       
        $oldact = $entityManager->getRepository(ActivitiesSubmitted::class)->findBy(array('activityid'=>$id,'studentid'=>$userID,'isvalid'=>true));
        
        
        if($oldact!=null){
            $oldact[0]->setIsvalid(false);
            $entityManager->persist($oldact[0]);
        }

        
        $entityManager->flush();
        

        return $this->redirectToRoute("showClassroomActivities", ['id' =>$id]);
        
    }

    public function showClassroomActivity(ManagerRegistry $doctrine,Request $request){

        $userID = $this->getUser()->getIdnum();
        
        $id = $request->get('id');

        

        $entityManager = $doctrine->getManager();
        $activity = $entityManager->getRepository(Activities::class)->find($id);
        $allact = $entityManager->getRepository(ActivitiesSubmitted::class)->findBy(array('activityid'=>$activity->getId(),'studentid'=>$userID));
        $subactivity = $entityManager->getRepository(ActivitiesSubmitted::class)->findBy(array('activityid'=>$activity->getId(),'isvalid'=>true,'studentid'=>$userID));
        $activity->setFile(json_decode($activity->getFile()));
        
        
        if($subactivity!=null){
            
            $count = $activity->getMaxattempt() - count($allact);

            
            return $this->render('student/success.html.twig', [
                'activity'=>$activity,
                'userID'=> $userID,
                'id'=>$id,
                'quizquestions'=>$activity->getQuestions(),
                'allSubmission'=>$subactivity[0],
                'submissioncount'=>$count
            ]);    
        }
        if($allact!=null){
            $count = $activity->getMaxattempt() - count($allact);
            
            return $this->render('student/showactivity.html.twig', [
                'activity'=>$activity,
                'userID'=> $userID,
                'id'=>$id,
                'submissioncount'=>$count,
                'quizquestions'=>$activity->getQuestions(),
                'allSubmission'=>$subactivity
            ]);
        }
        return $this->render('student/showactivity.html.twig', [
            'activity'=>$activity,
            'userID'=> $userID,
            'id'=>$id,
            'submissioncount'=>$activity->getMaxattempt(),
            'quizquestions'=>$activity->getQuestions(),
            'allSubmission'=>$subactivity
        ]);
    }

    
    public function uploadReceipt(ManagerRegistry $doctrine,Request $request){

        $entityManager = $doctrine->getManager();
        $id = $request->request->get("id");
        $courseID = $request->request->get("courseid");
        $student = $entityManager->getRepository(Students::class)->find($id);

        if (!$student) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }
        $files = $request->files->all();

        $payments = $student->getProofpayment();
        if($payments==null){
            $payments = array();
        }

        
        if(isset($files)){

            if (!file_exists($this->getParameter('kernel.project_dir') ."/data/payments/$id")) {
                mkdir($this->getParameter('kernel.project_dir') ."/data/payments/$id", 0777, true);
            }
            $index = 0;
            
            foreach ($files as $file) {
                $filename = $request->request->get('filename'.$index);
                
                $target = $this->getParameter('kernel.project_dir') ."/data/payments/$id/$filename";
                array_push($payments,array('filename'=>$filename,'status'=>'pending','courseid'=>$courseID));
                move_uploaded_file($file, $target);    
            
                $index++;
            }
            
            
        }
        
        $student->setProofpayment($payments);
        $entityManager->flush();

        
        $response = new Response("Successful");
        $response->headers->set('Content-Type', 'text/html');
        
        return $response;
    }
    public function showUploadPayment(ManagerRegistry $doctrine,Request $request){
        $entityManager = $doctrine->getManager();
        $payments = $this->getUser()->getProofpayment();
        $extrafess = $this->getUser()->getExtrafees();
        $id = $this->getUser()->getId();
        $allenrolledcourses = $entityManager->getRepository(CourseEnrolled::class)->findBy(array('idnum'=>$this->getUser()->getIdnum()));
        $allTerm = $entityManager->getRepository(Studentrecords::class)->findBy(array('idnum'=>$this->getUser()->getIdnum()));
        $balance = $this->getUser()->getBalance();
        return $this->render('student/uploadpayment.html.twig', [
            'balance'=>$balance,
            'payments'=>$payments,
            'id'=>$id,
            'all'=>$allenrolledcourses,
            'allterm'=>$allTerm,
            'extrafess'=> $extrafess
        ]);
    }

    public function removeStudentRecepit(ManagerRegistry $doctrine,Request $request){
        $entityManager = $doctrine->getManager();
        $id = $request->request->get('id');
        $filename = $request->request->get("filename");
        $curStudent = 
            $doctrine->getRepository(Students::class)
            ->find($id);
        
        $array = $curStudent->getProofpayment();
        $index = $this->getFilename($array,$filename);
        if($index !== FALSE){
            unset($array[$index]);
        }
        
        $curStudent->setProofpayment($array);
        $entityManager->flush();
        $target = $this->getParameter('kernel.project_dir') ."/data/payments/$id/$filename";
        $filesystem = new Filesystem();
        $filesystem->remove($target);
        
        $response = new Response("Successful");
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    public function getFilename($files, $filename) {
        foreach($files as $index => $file) {
            if($file['filename'] == $filename) return $index;
        }
        return FALSE;
    }
    /**
     * @Route("/student/mystudent/{id}", name="view")
     */
    public function view(int $id, Request $request): Response
    {
        $course = $this->getDoctrine()
            ->getRepository(FacultyLoads::class)
            ->find($id);

        $search1 = $request->get('course');
        $search2 = $request->get('class');
        $temp = array();
        $students = $this->getDoctrine()
            ->getRepository(CourseEnrolled::class)
            ->findStudent($search1, $search2);
        foreach($students as $student){
            $found = $this->getDoctrine()->getRepository(Students::class)->findBy(array('idnum'=>$student->getIdnum()));
            array_push($temp,array('fullname'=>$student->getFullname(),'program'=>trim($found[0]->getProgram()),'Midterm'=>$student->getMidterm(),'Final'=>$student->getFinal(),'Grade'=>$student->getGrade(),'Remarks'=>$student->getRemarks(),'id'=>$student->getId(),'course'=>$student->getCourse()));

        }
        
        
        return $this->render('student/view.html.twig', [
            'course' => $course,
            'students' => $temp
        ]);
    }
}
