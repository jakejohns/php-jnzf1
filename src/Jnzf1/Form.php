<?php
/**
 * Jnzf1 Base Form
 *
 * PHP version 5
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category  Jnzf1
 * @package   Form
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2013 Jake Johns
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @link      http://jakejohns.net
 */


namespace Jnzf1;

/**
 * Jnzf1_Form_Base
 *
 * Base form for Jnzf1
 *
 * @category Jnzf1
 * @package  Form
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 * @see      Twitter_Bootstrap_Form_Horizontal
 */
class Form extends \Twitter_Bootstrap_Form_Horizontal
{

    protected $wysiwyg;


    /**
     * __construct
     *
     * @param mixed $options configure form
     *
     * @access public
     * @return void
     */
    public function __construct($options = null)
    {

        $this->_addClassNames('well');

        $this->addPrefixPath(
            'ZendX_JQuery_Form_Decorator',
            'ZendX/JQuery/Form/Decorator',
            'decorator'
        )->addPrefixPath(
            'ZendX_JQuery_Form_Element',
            'ZendX/JQuery/Form/Element',
            'element'
        )->addPrefixPath(
            'Jnzf1\Form',
            APPLICATION_PATH . '/../vendor/jnj/jnzf1/src/Jnzf1/Form/'
        )->addPrefixPath(
            'Jnzf1\Validate',
            APPLICATION_PATH . '/../vendor/jnj/jnzf1/src/Jnzf1/Validate/'
        )->addElementPrefixPath(
            'ZendX_JQuery_Form_Decorator',
            'ZendX/JQuery/Form/Decorator',
            'decorator'
        )->addElementPrefixPath(
            'Jnzf1\\',
            APPLICATION_PATH . '/../vendor/jnj/jnzf1/src/Jnzf1/'
        )->addDisplayGroupPrefixPath(
            'ZendX_JQuery_Form_Decorator',
            'ZendX/JQuery/Form/Decorator'
        );


        if (isset($options['labelColSize'])) {
            $labelColSize = $options['labelColSize'];
            unset($options['labelColSize']);
        } else {
            $labelColSize = 2;
        }

        if (isset($options['fieldColSize'])) {
            $fieldColSize = $options['fieldColSize'];
            unset($options['fieldColSize']);
        } else {
            $fieldColSize = 8;
        }

        $this->setLabelColSize($labelColSize);
        $this->setFieldColSize($fieldColSize);
        parent::__construct($options);
    }

    /**
     * Set the view object
     *
     * Ensures that the view object has the jQuery view helper path set.
     *
     * @param Zend_View_Interface $view the view rendering
     *
     * @return ZendX_JQuery_Form
     */
    public function setView(\Zend_View_Interface $view = null)
    {
        $zxjqPath =  $view->getPluginLoader('helper')
            ->getPaths('ZendX_JQuery_View_Helper');
        if (null !== $view) {
            if (false === $zxjqPath) {
                $view->addHelperPath(
                    'ZendX/JQuery/View/Helper',
                    'ZendX_JQuery_View_Helper'
                );
            }
        }
        return parent::setView($view);
    }

    /**
    * bind
    *
    * @param mixed $entity DESCRIPTION
    *
    * @return mixed
    *
    * @access public
    */
    public function bind($entity)
    {
        return $this->setDefaults($entity->toArray());
    }


    /**
    * registerWysiwyg
    *
    * Summaries for methods should use 3rd person declarative rather
    * than 2nd person imperative, beginning with a verb phrase.
    *
    * @param mixed $wid DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function registerWysiwyg($wid)
    {
        $this->wysiwyg[] = $wid;
        return $this;
    }

    /**
    * renderWysiwyg
    *
    * @param Zend_View_Interface $view DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function renderWysiwyg(\Zend_View_Interface $view = null)
    {

        $script = '
            var opts = {
                toolbar  : "redheadToolbar",
                fmAllow : true,

                fmOpen : function(callback) {
                    $("<div />").dialogelfinder({
                        url: "/wysiwyg",
                        commandsOptions: {
                            getfile: {
                                // destroy elFinder after file selection
                                oncomplete: "destroy" 
                            }
                        },
                        // pass callback to file manager
                        getFileCallback: callback 
                    });
                }
            };
            ';

        foreach ($this->wysiwyg as $wysiwyg) {
            $script .= sprintf(
                '$("#%s").elrte(opts);'
                . "\n"
                . '$("#%1$s").removeAttr("required");',
                $wysiwyg
            );
        }

        $return =  parent::render($view);
        $view = $this->getView();
        $view->jQuery()
            ->addJavascriptFile(
                '//code.jquery.com/jquery-migrate-1.2.1.min.js'
            )
            ->addJavascriptFile(
                '/js/vendor/wysiwyg/elrte/js/elrte.min.js'
            )
            ->addJavascriptFile(
                '/js/vendor/wysiwyg/elrte/js/i18n/elrte.en.js'
            )
            ->addJavascriptFile(
                '/js/el-rte_config.js'
            )
            ->addStylesheet(
                '/js/vendor/wysiwyg/elrte/css/elrte.min.css'
            )
            ->addJavascriptFile(
                '/js/vendor/wysiwyg/elfinder/js/elfinder.min.js'
            )
            ->addStylesheet(
                '/js/vendor/wysiwyg/elfinder/css/elfinder.min.css'
            )
            ->addStylesheet(
                '/js/vendor/wysiwyg/elfinder/css/theme.css'
            )
            ->addStylesheet(
                '/css/elfinder-bootstrap-fix.css'
            )
            ->addOnload($script);
        return $return;
    }


    /**
    * render
    *
    * adds wysiwyg
    *
    * @param Zend_View_Interface $view view object
    *
    * @return string
    *
    * @access public
    */
    public function render(\Zend_View_Interface $view = null)
    {
        $return =  parent::render($view);
        $view = $this->getView();
        if ($this->wysiwyg) {
            $this->renderWysiwyg($view);
        } 
        return $return;
    }

    /**
    * create
    *
    * turnkey
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function create()
    {
        return $this;
    }

    /**
    * update
    *
    * turnkey
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function update()
    {
        return $this;
    }

    /**
    * addCaptcha
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function addCaptcha()
    {
        $this->addElement(
            'captcha', 'captcha', array(
                'label' => "Please verify you're a human",
                'description' => 'Enter the letters that appear above',
                'ignore' => true,
                'captcha' => array(
                    'captcha' => 'Figlet',
                    'wordLen' => 6,
                    'timeout' => 300,
                ),
            )
        );
    }


}

