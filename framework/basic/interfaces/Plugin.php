<?php

namespace pwf\basic\interfaces;

interface Plugin extends Component
{

    /**
     * Plugin registration
     *
     * @param Application $app
     * @return Plugin
     */
    public function register(Application $app);

    /**
     * Plugin removement
     *
     * @return Plugin
     */
    public function unregister();
}