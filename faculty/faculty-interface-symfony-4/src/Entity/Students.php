<?php

namespace App\Entity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Students
 *
 * @ORM\Table(name="students")
 * @ORM\Entity
 */
class Students implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="idnum", type="string", length=10, nullable=false)
     */
    private $idnum;

    /**
     * @var string
     *
     * @ORM\Column(name="fname", type="string", length=50, nullable=false)
     */
    private $fname;

    /**
     * @var string
     *
     * @ORM\Column(name="mname", type="string", length=50, nullable=false)
     */
    private $mname;

    /**
     * @var string
     *
     * @ORM\Column(name="lname", type="string", length=50, nullable=false)
     */
    private $lname;

    /**
     * @var string
     *
     * @ORM\Column(name="entlev", type="string", length=20, nullable=false)
     */
    private $entlev;

    /**
     * @var string
     *
     * @ORM\Column(name="academic_year", type="string", length=50, nullable=false)
     */
    private $academicYear;

    /**
     * @var string
     *
     * @ORM\Column(name="term", type="string", length=20, nullable=false)
     */
    private $term;

    /**
     * @var string
     *
     * @ORM\Column(name="program", type="string", length=50, nullable=false)
     */
    private $program;

    /**
     * @var string
     *
     * @ORM\Column(name="class", type="string", length=20, nullable=false)
     */
    private $class;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=10, nullable=false)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="cnum", type="string", length=20, nullable=false)
     */
    private $cnum;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="prevschool", type="string", length=80, nullable=false)
     */
    private $prevschool;

    /**
     * @var string
     *
     * @ORM\Column(name="hea", type="string", length=50, nullable=false)
     */
    private $hea;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=50, nullable=false)
     */
    private $img;

    /**
     * @var string
     *
     * @ORM\Column(name="g_moral", type="string", length=50, nullable=false)
     */
    private $gMoral;

    /**
     * @var string
     *
     * @ORM\Column(name="NSO", type="string", length=50, nullable=false)
     */
    private $nso;

    /**
     * @var string
     *
     * @ORM\Column(name="reg_date", type="string", length=30, nullable=false)
     */
    private $regDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $proofpayment = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reviewcenter;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $extrafees = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $balance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdnum(): ?string
    {
        return $this->idnum;
    }

    public function setIdnum(string $idnum): self
    {
        $this->idnum = $idnum;

        return $this;
    }

    public function getFname(): ?string
    {
        return $this->fname;
    }

    public function setFname(string $fname): self
    {
        $this->fname = $fname;

        return $this;
    }

    public function getMname(): ?string
    {
        return $this->mname;
    }

    public function setMname(string $mname): self
    {
        $this->mname = $mname;

        return $this;
    }

    public function getLname(): ?string
    {
        return $this->lname;
    }

    public function setLname(string $lname): self
    {
        $this->lname = $lname;

        return $this;
    }

    public function getEntlev(): ?string
    {
        return $this->entlev;
    }

    public function setEntlev(string $entlev): self
    {
        $this->entlev = $entlev;

        return $this;
    }

    public function getAcademicYear(): ?string
    {
        return $this->academicYear;
    }

    public function setAcademicYear(string $academicYear): self
    {
        $this->academicYear = $academicYear;

        return $this;
    }

    public function getTerm(): ?string
    {
        return $this->term;
    }

    public function setTerm(string $term): self
    {
        $this->term = $term;

        return $this;
    }

    public function getProgram(): ?string
    {
        return $this->program;
    }

    public function setProgram(string $program): self
    {
        $this->program = $program;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCnum(): ?string
    {
        return $this->cnum;
    }

    public function setCnum(string $cnum): self
    {
        $this->cnum = $cnum;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPrevschool(): ?string
    {
        return $this->prevschool;
    }

    public function setPrevschool(string $prevschool): self
    {
        $this->prevschool = $prevschool;

        return $this;
    }

    public function getHea(): ?string
    {
        return $this->hea;
    }

    public function setHea(string $hea): self
    {
        $this->hea = $hea;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }
    public function getFullname(): ?string
    {
        return $this->fname ." ". $this->mname ." ". $this->lname;
    }

    public function getGMoral(): ?string
    {
        return $this->gMoral;
    }

    public function setGMoral(string $gMoral): self
    {
        $this->gMoral = $gMoral;

        return $this;
    }

    public function getNso(): ?string
    {
        return $this->nso;
    }

    public function setNso(string $nso): self
    {
        $this->nso = $nso;

        return $this;
    }

    public function getRegDate(): ?string
    {
        return $this->regDate;
    }

    public function setRegDate(string $regDate): self
    {
        $this->regDate = $regDate;

        return $this;
    }

    public function getRoles(){
        
        // guarantee every user at least has ROLE_USER
       

        return array('ROLE_USER','STUDENT');
    }
    public function getPassword(){
         

        return $this->password;
    }
    public function getSalt(){

    }
    public function eraseCredentials(){

    }
    public function getUsername(){
        return $this->email;   
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getProofpayment(): ?array
    {
        return $this->proofpayment;
    }

    public function setProofpayment(?array $proofpayment): self
    {
        $this->proofpayment = $proofpayment;

        return $this;
    }

    public function getReviewcenter(): ?string
    {
        return $this->reviewcenter;
    }

    public function setReviewcenter(?string $reviewcenter): self
    {
        $this->reviewcenter = $reviewcenter;

        return $this;
    }

    public function getExtrafees(): ?array
    {
        return $this->extrafees;
    }

    public function setExtrafees(?array $extrafees): self
    {
        $this->extrafees = $extrafees;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getBalance(): ?string
    {
        return $this->balance;
    }

    public function setBalance(?string $balance): self
    {
        $this->balance = $balance;

        return $this;
    }
}
