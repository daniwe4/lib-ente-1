<?php

require_once("./Services/Repository/classes/class.ilObjectPluginGUI.php");
require_once("./Services/Form/classes/class.ilPropertyFormGUI.php");
require_once("./Services/Form/classes/class.ilTextInputGUI.php");


/**
 * Plugin object GUI class. Baseclass for all GUI action in ILIAS
 *
 * @ilCtrl_isCalledBy ilObjComponentHandlerExampleGUI: ilRepositoryGUI, ilAdministrationGUI, ilObjPluginDispatchGUI
 * @ilCtrl_Calls ilObjComponentHandlerExampleGUI: ilPermissionGUI, ilInfoScreenGUI, ilObjectCopyGUI, ilCommonActionDispatcherGUI
 */
class ilObjComponentHandlerExampleGUI  extends ilObjectPluginGUI {
    const VALUES_FIELD_NAME = "values";
    const SAVE_CMD = "saveForm";

    /**
     * @var \ilTemplate
     */
    protected $ilTemplate;

    /**
     * @var \ilCtrl
     */
    protected $ilCtrl;

    /**
     * @var \ILIAS\UI\Factory
     */
    protected $ui_factory;

    /**
     * @var \ILIAS\UI\Renderer
     */
    protected $ui_renderer;

	/**
	 * Called after parent constructor. It's possible to define some plugin special values
	 */
	protected function afterConstructor() {
        global $DIC;
        $this->ilTemplate = $DIC->ui()->mainTemplate();
        $this->ilCtrl = $DIC->ctrl();
        $this->ui_factory = $DIC->ui()->factory();
        $this->ui_renderer= $DIC->ui()->renderer(); 
	}

	/**
	* Get type.  Same value as choosen in plugin.php
	*/
	final function getType() {
		return "xleh";
	}

	/**
	* Handles all commmands of this class, centralizes permission checks
	*/
	function performCommand($cmd) {
		switch ($cmd) {
            case "showContent":
                $this->ilTemplate->setContent($this->showContent());
                break;
			default:
                throw new \InvalidArgumentException("Unknown Command: '$cmd'");
		}
	}

    /**
     * Show the edit form.
     *
     * @return string
     */
    public function showContent() {
        $items = [];
        foreach ($this->object->getProvidedStrings() as $title => $strings) {
            $items[$title] = implode(", ", $strings);
        }
        $listing = $this->ui_factory->listing()->descriptive($items);
        return $this->ui_renderer->render($listing);
    }

	/**
	* After object has been created -> jump to this command
	*/
	function getAfterCreationCmd() {
		return "showContent";
	}

	/**
	* Get standard command
	*/
	function getStandardCmd() {
		return "showContent";
	}
}