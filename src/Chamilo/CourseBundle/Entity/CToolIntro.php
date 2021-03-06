<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * CToolIntro
 * @GRID\Source(columns="iid, tool, introText", filterable=false)
 *
 * @ORM\Table(
 *  name="c_tool_intro",
 *  indexes={
 *      @ORM\Index(name="course", columns={"c_id"})
 *  }
 * )
 * @ORM\Entity
 */
class CToolIntro
{
    /**
     * @var integer
     *
     * @ORM\Column(name="iid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $iid;

    /**
     * @var integer
     *
     * @ORM\Column(name="c_id", type="integer")
     */
    private $cId;

    /**
     * @var integer
     *
     * @ORM\Column(name="tool", type="string", nullable=false)
     */
    private $tool;

    /**
     * @var string
     * @GRID\Column(type="text")
     * @ORM\Column(name="intro_text", type="text", nullable=false)
     */
    private $introText;

    /**
     * @var integer
     *
     * @ORM\Column(name="session_id", type="integer")
     */
    private $sessionId;

    public function getId()
    {
        return $this->iid;
    }


    /**
     * Set introText
     *
     * @param string $introText
     * @return CToolIntro
     */
    public function setIntroText($introText)
    {
        $this->introText = $introText;

        return $this;
    }

    /**
     * Get introText
     *
     * @return string
     */
    public function getIntroText()
    {
        return $this->introText;
    }

    /**
     * Set cId
     *
     * @param integer $cId
     * @return CToolIntro
     */
    public function setCId($cId)
    {
        $this->cId = $cId;

        return $this;
    }

    /**
     * Get cId
     *
     * @return integer
     */
    public function getCId()
    {
        return $this->cId;
    }

    /**
     * Set sessionId
     *
     * @param integer $sessionId
     * @return CToolIntro
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get sessionId
     *
     * @return integer
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @return string
     */
    public function getTool()
    {
        return $this->tool;
    }

    /**
     * @param string $tool
     */
    public function setTool($tool)
    {
        $this->tool = $tool;

        return $this;
    }
}
