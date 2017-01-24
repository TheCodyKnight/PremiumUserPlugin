<?php

class Shopware_Plugins_Frontend_PremiumUserPlugin_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
    public function getVersion()
    {
        return '1.0.0';
    }

    public function getLabel()
    {
        return 'Premium User Plugin';
    }

    public function install()
    {
        $this->subscribeEvent(
            'Enlight_Controller_Action_PostDispatchSecure_Frontend',
            'onFrontendPostDispatch'
        );

        $this->subscribeEvent(
            'Theme_Compiler_Collect_Plugin_Less',
            'onCollectLessFiles'
        );

        $this->createConfig();
        $this->createCustomergroup();

        return true;
    }

    private function createCustomergroup()
    {
        $sql = "SELECT id FROM s_core_customergroups WHERE groupkey = 'P'";
        $customerGroupExists = Shopware()->Db()->fetchOne($sql);

        if (!$customerGroupExists)
        {
            $data = array (
                'groupkey' => 'P',
                'description' => 'Premium Users',
                'tax' => '1',
                'taxinput' => '0',
                'mode' => '0',
                'discount' => '10',
                'minimumorder' => '0',
                'minimumordersurcharge' => '0');

            Shopware()->Db()->insert('s_core_customergroups', $data);

            // TBD: set discount for Premium Users in config!
        }
    }

    private function createConfig()
    {
        $this->Form()->setElement(
            'select',
            'font-size',
            array(
                'label' => 'Font size',
                'store' => array(
                    array(12, '12px'),
                    array(18, '18px'),
                    array(25, '25px')
                ),
                'value' => 12
            )
        );

        $this->Form()->setElement('boolean', 'italic', array(
            'value' => true,
            'label' => 'Italic'
        ));
    }

    public function onCollectLessFiles()
    {
        error_log("collecting less");

        return new \Shopware\Components\Theme\LessDefinition(
            [],
            [__DIR__ . 'Views/frontend/_public/src/less']
        );
    }

    public function onFrontendPostDispatch(Enlight_Event_EventArgs $args)
    {
        /** @var \Enlight_Controller_Action $controller */
        $controller = $args->get('subject');
        $view = $controller->View();

        $view->addTemplateDir(
            __DIR__ . '/Views'
        );

        $view->assign('fontSize', $this->Config()->get('font-size'));
        $view->assign('italic', $this->Config()->get('italic'));

        // display most recently ordered item




    }

}
