<?php
/**
 *
 * Action for MANY-MANY relations
 * Author: terrasoff
 * Email: terrasoff@terrasoff.ru
 * Skype: tarasov.konstantin
 */

class MapRelatedAction extends CAction
{
    /**
     * Name of owner Class
     * @var string
     */
    public $ownerClass = null;

    /**
     * Name of related Class
     * @var string
     */
    public $relatedClass = null;

    /**
     * Redirect to model's view in case of success
     * @var string
     */
    public $modelViewUrl = null;

    /**
     * Overwice redirect to this url
     * @var string
     */
    public $returnUrl = null;

    /**
     * @var array text messages in case of success/error
     * @link see description in MapRelatedController
     */
    public $messages;


}