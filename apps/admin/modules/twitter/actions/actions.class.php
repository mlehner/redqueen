<?php

/**
 * twitter actions.
 *
 * @package    hs
 * @subpackage twitter
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class twitterActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $config = Doctrine::getTable('Config')->find('twitter_access_token');
        if ($config)
        {
            $twitter = new Zend_Service_Twitter(array(
                'accessToken' => unserialize($config->getConfigValue()),
                'consumerKey' => sfConfig::get('app_twitter_consumer_key'),
                'consumerSecret' => sfConfig::get('app_twitter_consumer_secret')
            ));

            $response = $twitter->account->verifyCredentials();
            if (isset($response->getBody()->error))
                $this->validated = false;
            else
                $this->validated = true;
        }
    }

    public function executeAuth(sfWebRequest $request)
    {
        $consumer = $this->getConsumer();

        $token = $consumer->getRequestToken();

        $this->getUser()->setAttribute('twitter_request_token', $token);

        $consumer->redirect();
    }

    public function executeCallback(sfWebRequest $request)
    {
        if (!$this->getUser()->hasAttribute('twitter_request_token'))
            $this->redirect('twitter/index');
        
        $consumer = $this->getConsumer();

        $req_token = $this->getUser()->getAttribute('twitter_request_token');

        $access_token = $consumer->getAccessToken($request->getGetParameters(), $req_token);

        $config = Doctrine::getTable('Config')->find('twitter_access_token');
        if (!$config)
            $config = new Config();

        $config->setConfigKey('twitter_access_token');
        $config->setConfigValue(serialize($access_token));
        $config->save();

        $this->redirect('twitter/index');
    }

    private function getConsumer()
    {
        $config = array(
            'callbackUrl' => $this->generateUrl('', array('module' => 'twitter', 'action' => 'callback'), true),
            'siteUrl' => 'http://twitter.com/oauth',
            'consumerKey' => sfConfig::get('app_twitter_consumer_key'),
            'consumerSecret' => sfConfig::get('app_twitter_consumer_secret')
        );

        $consumer = new Zend_Oauth_Consumer($config);

        return $consumer;
    }
}
