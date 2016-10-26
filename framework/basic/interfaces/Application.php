<?php

namespace pwf\basic\interfaces;

interface Application
{
    //<editor-fold desc="Constants" defaultstate="collapsed">
    /**
     * Name of component block
     */
    const COMPONENT_CONFIG_BLOCK = 'components';

    /**
     * Event name on application is started
     */
    const EVENT_APPLICATION_RUN = 'run';

    /**
     * Event name on application is stopped
     */
    const EVENT_APPLICATION_FINISH = 'finish';

    /**
     * Event name on before handler started
     */
    const EVENT_BEFORE_HANDLER = 'beforeHandler';

    /**
     * Event name on after handler started
     */
    const EVENT_AFTER_HANDLER = 'afterHandler';

    //</editor-fold>

    /**
     * Application start
     */
    public function run();
}