<?php

namespace Framework;

interface RoutesInterface
{
    public function getControllerAndMethod($route, $method);
}
